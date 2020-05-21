<?php 

if (!isset($_SESSION))
    session_start();
require_once('Globals.php');
require_once("conexion.php");
require_once("Log.php");
require_once("Sesion.php");

if(isset($_POST["action"])){
    $usuario= new Usuario();   
    switch($_POST["action"]){       
        case "Login":
            $usuario->usuario= $_POST["username"];
            $usuario->contrasena= $_POST["password"];
            $usuario->local= $_POST["local"];
            if(!filter_var($usuario->local, FILTER_VALIDATE_BOOLEAN))//Factur4sFT$019$
                $usuario->LDAPCheck();
            else $usuario->loginLocal();
            break;      
    }
}

class Usuario{
  
    public $usuario;
    public $contrasena;
    public $rol;
    public $nombre;
    public $email;
    public $is_active;
    public $sesion; 
    private $sessiondata = array(); // devuelve el estado del login.

    function __construct(){
        require_once("conexion.php");
        require_once("Log.php");
    }

    function KanboardUser(){    // valida rol en bd y administra accesos a elementos de la web
        try {
          $sql='SELECT id, name, email, role, is_active FROM users where username=:usuario';
          $param= array(':usuario'=>explode('@',$this->usuario)[0]);
            $data = DATA::Ejecutar($sql,$param);
            if (count($data)) {
                $this->id= $data[0]['id'];
                $this->nombre= $data[0]['name'];
                $this->email= $data[0]['email'];
                $this->rol= $data[0]['role'];
                $this->is_active= $data[0]['is_active'];        
                //
                $this::setSesion();    
            }else {        
                $this->rol= -1; // Rol 
                $this->id= "";
                $this->nombre= "";
                $this->email= "";
                /******************************* agrega nuevo usuario al KB con rol de usuario ********************************/

                /******************************* ********************************************* ********************************/
                $this::setSesion();    
            }     
        }catch(Exception $e) {     
            error_log($e->getMessage()); 
            $sessiondata['status']='error'; 
            echo json_encode($sessiondata);
        }           
    }    

    function setSesion(){
        $sesion = new Sesion();
        $sesion->Inicio($this->usuario, $this->rol, $this->id, $this->nombre);
        //
        if(isset($_SESSION['url'])){
            $sessiondata['status']='OK';
            $sessiondata['url']= $_SESSION['url'];            
            unset($_SESSION['url']);
            echo json_encode($sessiondata);
        }
        else {
            $sessiondata['status']='OK';
            $sessiondata['url']= 'MiCuenta.php';
            echo json_encode($sessiondata);
        }
    }

    function LDAPCheck(){
        try {
            $LDAP_servicio = DATA::getLDAP_Param();
            $LDAP_connect = ldap_connect($LDAP_servicio["LDAP_server"], $LDAP_servicio["LDAP_port"]);
            $LDAP_bind = @ldap_bind($LDAP_connect, $LDAP_servicio["LDAP_user"], $LDAP_servicio["LDAP_passwd"]);
            if ($LDAP_bind) {
                $LDAP_filter="(mail=$this->usuario)";
                $search_result=ldap_search($LDAP_connect,$LDAP_servicio["LDAP_base_dn"],$LDAP_filter);
                $LDAP_user_data = ldap_get_entries($LDAP_connect, $search_result);  
                if($LDAP_user_data["count"] < 1){
                    error_log("debug: codigo99 -> Usuario no encontrado en el LDAP");
                    @ldap_close($LDAP_connect);
                    $sessiondata['status']='badUsername';
                    echo json_encode($sessiondata);
                    return false;
                }       
                $this->dn = $LDAP_user_data[0]["dn"];
                $this->email= $LDAP_user_data[0]["mail"][0];
                $this->nombre = $LDAP_user_data[0]["cn"][0];
                $this->usuario = $LDAP_user_data[0]["samaccountname"][0];
                //
                @ldap_close($LDAP_connect);
                
                $LDAP_connect = ldap_connect($LDAP_servicio["LDAP_server"], $LDAP_servicio["LDAP_port"]);
                $LDAP_bind = @ldap_bind($LDAP_connect, $this->dn, $this->contrasena);
                error_log("debug: ".$this->dn . "  " . $this->contrasena);
                @ldap_close($LDAP_connect);
                if ($LDAP_bind) {
                    $this::KanboardUser();
                    return true;
                }                    
                else
                  $sessiondata['status']='nologin';
                  echo json_encode($sessiondata);
                  return false; 
            }else {
                $sessiondata['status']='nologin';
                echo json_encode($sessiondata);
                return false;  
            }
        }catch(Exception $e) {   
            error_log($e->getMessage());
            $sessiondata['status']='error'; 
            $sessiondata['errmsg']=$e->getMessage(); 
            echo json_encode($sessiondata);
        }
    }

    function wasLDAPCheck(){
        //error_reporting(0);
        ini_set('error_reporting', .0);
        $adServer = "10.129.20.138";
        $ldapport = 389;
        $ldap = ldap_connect($adServer, $ldapport);        
        $ldapUser = $this->usuario;
        $ldapPasswd = $this->contrasena;
        //$ldaprdn =  $ldapUser;
        $ldaprdn = 'icetel' . "\\" . $ldapUser;
        //ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        //ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
        $bind = @ldap_bind($ldap, $ldaprdn, $ldapPasswd);
        if ($bind) {
            $filter="(sAMAccountName=$ldapUser)";
            $result = ldap_search($ldap,"dc=icetel,dc=ice",$filter);
            //ldap_sort($ldap,$result,"sn");
            $info = ldap_get_entries($ldap, $result);
            for ($i=0; $i<$info["count"]; $i++)
            {
                if($info['count'] > 1)
                    break;
                // busca rol definido por la aplicacion.
                $this::KanboardUser();
                log::Add('INFO', 'Inicio de sesiÃ³n: '. $this->usuario);
                return true;  
            }
            @ldap_close($ldap);
        } else {
            //log::Add('INFO', 'Inicio de sesion Invalido: '. $this->usuario);
            return false;  
        }
    }
	
    function Validar(){    
        $sql='SELECT usuario, idrol FROM usuario where contrasena=:contrasena  AND usuario=:usuario';
        $param= array(':usuario'=>$this->usuario, ':contrasena'=>$this->contrasena);        
        $data = DATA::Ejecutar($sql,$param);
        if (count($data) ) {
            $this->idrol= $data[0]['idrol'];
            log::Add('INFO', 'Inicio de sesión: '. $this->usuario);
            return true;
        }else {        
            return false;           
        }        
    }

    function loginLocal(){
        $sql='SELECT password  FROM users where username=:username';
        $param= array(':username'=>$this->usuario);
        $data = DATA::Ejecutar($sql,$param);
        if (count($data) ) {
            // check password.
            if(password_verify($this->contrasena, $data[0]['password'])){
                $this::KanboardUser();
                return true;  
            }else {        
                $sessiondata['status']='nologin';
                echo json_encode($sessiondata);
                return false;
            }        
        }else {        
            $sessiondata['status']='nologin';
            echo json_encode($sessiondata);
            return false;
        }        
    }

    function Cargar(){    
        $sql='SELECT nombre FROM usuario WHERE usuario=:usuario';
        $param= array(':usuario'=>$_SESSION['username']);        
        $data = DATA::Ejecutar($sql,$param);
        if (count($data) ) {
            $this->nombre= $data[0]['nombre'];
            return true;
        }else {        
            return false;           
        }        
    }
}
?>
