<?php

if(isset($_POST["action"])){
    $ldapp= new LDAPP();
    switch($_POST["action"]){       
        case "Connect":
            $ldapp->username= $_POST["username"];
            $ldapp->password= $_POST["password"];
            $ldapp->ambiente= $_POST["ambiente"];
            $ldapp->Connect();
            break;    
        // case "LoadPlantilla":
        //     $ldapp->username= $_POST["username"];
        //     $ldapp->password= $_POST["password"];
        //     //$ldapp->ambiente= $_POST["ambiente"];
        //     $ldapp->LoadPlantilla();
        //     break;    
        case "getGroupsByAppName":
            $ldapp->username= $_POST["username"];
            $ldapp->password= $_POST["password"];
            $ldapp->ambiente= $_POST["ambiente"];
            $app= $_POST["app"];
            echo json_encode($ldapp->getGroupsByAppName($app));
            break;    
        case "getMembershipByUser":
            //$ldapp->username= $_POST["username"];
            //$ldapp->password= $_POST["password"];
            //$ldapp->ambiente= $_POST["ambiente"];            
            echo json_encode($ldapp->getMembershipByUser($_POST["uids"]));
            break;    
        case "getRamas":           
            $ldapp->username= $_POST["username"];
            $ldapp->password= $_POST["password"];
            $ldapp->ambiente= $_POST["ambiente"];
            echo json_encode($ldapp->getRamas());
            break;    
        case "getApps":          
            $ldapp->username= $_POST["username"];
            $ldapp->password= $_POST["password"];
            $ldapp->ambiente= $_POST["ambiente"]; 
            echo json_encode($ldapp->getApps());
            break;    
    }
}

class LDAPP{
  
    public $username;
    public $password;
    public $uid;
    public $ambiente;
    public $fulldn;
    public $dn;
    public $email;
    public $givenname;
    public $sn;
    public $ou;
    public $uniqueidentifier;
    // 
    private $ldapconn;
    private $ldapbind;

    function __construct(){
        if (!isset($_SESSION))
            session_start();
        require_once('Globals.php');
        require_once("Conexion.php");
        require_once("Log.php");
        // carga configuración de conexión.
        Globals::ConfiguracionLdap();
    }

    function LoadPlantilla(){
        try {
            $adServer = "10.129.20.138";
            $ldapport = 389;
            $this->ldapconn = ldap_connect($adServer, $ldapport) or die(json_encode(array(
                'ide' => 'Could not connect to LDAP server',
                'error' => 01))
            );
            if($this->ldapconn){
                ldap_set_option($this->ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
                ldap_set_option($this->ldapconn, LDAP_OPT_REFERRALS, 0);
                // binding to ldap server with standard user            
                $userconn = 'cn=usersdutiles,cn=directoryServer,ou=grupos,o=grupoice,o=ice'; 
                $pwconn= 'ldaputil71';
                $ldapbind = ldap_bind($this->ldapconn, $userconn, $pwconn);
                if ($ldapbind) {
                    $dn = "o=grupoice,o=ice";
                    $filter="(|(cn=*$this->username*))";
                    $search=ldap_search($this->ldapconn, $dn, $filter);
                    $first = ldap_first_entry($this->ldapconn, $search);
                    $info = ldap_get_entries($this->ldapconn, $search);
                    // full dn
                    $dn = ldap_get_dn($this->ldapconn, $first);
                    $_SESSION["FULLDN"]= $dn;
                    $attrs = ldap_get_attributes($this->ldapconn, $first);
                    $info = ldap_get_entries($this->ldapconn, $search);
                    // APPS
                    $dn=""; 
                    $filter = "objectClass=applicationEntity";
                    $dn = "ou=grupos,o=grupoice,o=ice";
                    //
                    $result=ldap_list($this->ldapconn, $dn, $filter) or die(json_encode(array(
                        'ide' => 'No se encontraron aplicaciones',
                        'error' => 02))
                    );
                    
                    //die("No se encontraron aplicaciones."); 
                    $info = ldap_get_entries($this->ldapconn, $result);
                    array_shift($info); 
                    echo json_encode($info);                            
                }
                else header("Status: 500 Not Found");; // error ajax
            }  else header("Status: 500 LDAP Server Not Found");; // error ajax

        }
        catch(Exception $e){

        }
    }    

    function KanboardUser(){    // valida rol en bd y administra accesos a elementos de la web
        $sql='SELECT id, name, email, role, is_active FROM users where username=:usuario';
        $param= array(':usuario'=>$this->usuario);        
        $data = DATA::Ejecutar($sql,$param);
        if (count($data) ) {
            $this->id= $data[0]['id'];
            $this->nombre= $data[0]['name'];
            $this->email= $data[0]['email'];
            $this->rol= $data[0]['role'];
            $this->is_active= $data[0]['is_active'];
        }else {        
            $this->rol= -1; // Rol 
        }        
    }
   
    function Connect(){
        try{
            // Conexión
            $this->ldapconn = ldap_connect(Globals::$adServer, Globals::$ldapport) or die(json_encode(array(
                'iderr' => 01,
                'error' => 'No es posible conectar.'))
            );
            // Standard Login
            if($this->ldapconn){
                ldap_set_option($this->ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
                ldap_set_option($this->ldapconn, LDAP_OPT_REFERRALS, 0);
                // binding to ldap server with standard user      
                $this->ldapbind = ldap_bind($this->ldapconn, $this->username, $this->password);
                $this->ldapbind = ldap_bind($this->ldapconn, Globals::$userconn, Globals::$pwconn);
                if ($this->ldapbind) {
                    return true;
                }
                else die(json_encode(array(
                    'id' => 01,
                    'mensaje' => 'No es posible conectar.'))
                );
            }
        }
        catch(Exception $e){
            //header('Content-Type: application/json; charset=UTF-8');
            header('HTTP/1.1 500 Internal Server Error');
            die(json_encode(array(
                'iderr' => $e->getCode(),
                'detalle'=> $e->getMessage(),
                'error' => 'No es posible conectar.'))
            );
        }
    }

    function getApps(){
        try{
            $this->Connect();
            //
            if ($this->ldapbind) {
                $dn = "o=grupoice,o=ice";
                $filter="(|(cn=*$this->username*))";
                //
                $search=ldap_search($this->ldapconn, $dn, $filter);
                $first = ldap_first_entry($this->ldapconn, $search);
                //$info = ldap_get_entries($this->ldapconn, $search);
                // full dn
                $dn = ldap_get_dn($this->ldapconn, $first);
                $_SESSION["FULLDN"]= $dn;
                //$attrs = ldap_get_attributes($this->ldapconn, $first);
                $info = ldap_get_entries($this->ldapconn, $search);
                // APPS
                $dn=""; 
                $filter = "objectClass=applicationEntity";
                switch ($this->ambiente){
                    case 'Desarrollo':
                        $dn = "o=des,o=ice";
                        //$filter = "objectClass=organizationalUnit";
                        break;
                    case 'Producción':
                        $dn = "ou=grupos,o=grupoice,o=ice";
                        //$filter = "objectClass=applicationEntity";
                        break;
                }          
                //
                $result=ldap_list($this->ldapconn, $dn, $filter) or die(json_encode(array('id' => 03, 'mensaje' => 'No se encontraron aplicaciones.')));
                $info = ldap_get_entries($this->ldapconn, $result);
                // 
                if(isset($info)){
                    array_shift($info); 
                    return $info;
                } 
            }
        }
        catch(Exception $e){
            //header('Content-Type: application/json; charset=UTF-8');
            header('HTTP/1.1 500 Internal Server Error');
            die(json_encode(array(
                'iderr' => $e->getCode(),
                'detalle'=> $e->getMessage(),
                'error' => 'No es posible conectar.'))
            );
        }
    }

    function getRamas(){
        try{
            $this->Connect();
            //
            if ($this->ldapbind) {
                $basedn = "o=grupoice,o=ice";
                $filter="objectClass=organizationalUnit";
                $attrs = array("ou");
                $search=ldap_search($this->ldapconn, $basedn, $filter, $attrs);
                //$first = ldap_first_entry($this->ldapconn, $search);
                $info = ldap_get_entries($this->ldapconn, $search);
                // full dn
                //$dn = ldap_get_dn($this->ldapconn, $first);
                //member of
                /*$attrs = array("description");
                $filter =  "(&(member=*$uids[0]*))";                
                $result = ldap_search($this->ldapconn,$basedn,$filter, $attrs);
                $entries = ldap_get_entries($this->ldapconn, $result);*/
                //
                if(isset($info)){
                    array_shift($info); 
                    return $info;    
                }
            }   
        }
        catch(Exception $e){
            //header('Content-Type: application/json; charset=UTF-8');
            header('HTTP/1.1 500 Internal Server Error');
            die(json_encode(array(
                'iderr' => $e->getCode(),
                'detalle'=> $e->getMessage(),
                'error' => 'No es posible conectar.'))
            );
        }     
    }
      
    function getGroupsByAppName($app){
        try{
            $this->Connect();
            //            
            if ($this->ldapbind) {
                $dn=""; 
                $filter = "objectClass=groupOfNames";
                switch ($this->ambiente){
                    case 'Desarrollo':
                        $dn = "cn=$app,o=des,o=ice";
                        //$filter = "objectClass=organizationalUnit";
                        break;
                    case 'Producción':
                        $dn = "cn=$app,ou=grupos,o=grupoice,o=ice";
                        //$filter = "objectClass=applicationEntity";
                        break;
                }
                //                
                $result=ldap_list($this->ldapconn, $dn, $filter) or die(json_encode(array(
                    'iderr' => 03,
                    'error' => 'No se encontraron Grupos.'))
                );
                //
                $info = ldap_get_entries($this->ldapconn, $result);
                //
                if(isset($info)){
                    array_shift($info); 
                    return $info;    
                }
            }        
        } 
        catch(Exception $e){
            //header('Content-Type: application/json; charset=UTF-8');
            header('HTTP/1.1 500 Internal Server Error');
            die(json_encode(array(
                'iderr' => $e->getCode(),
                'detalle'=> $e->getMessage(),
                'error' => 'No es posible conectar.'))
            );
        }           
    }

    function getMembershipByUser($uids){
        error_reporting(1);
        ini_set('error_reporting', 1);
        $adServer = "10.129.20.138";
        $ldapport = 389;
        $this->ldapconn = ldap_connect($adServer, $ldapport) or die("Could not connect to LDAP server.");
        if($this->ldapconn){
            ldap_set_option($this->ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($this->ldapconn, LDAP_OPT_REFERRALS, 0);
            // binding to ldap server with standard user            
            $userconn = 'cn=usersdutiles,cn=directoryServer,ou=grupos,o=grupoice,o=ice'; 
            $pwconn= 'ldaputil71';
            $ldapbind = ldap_bind($this->ldapconn, $userconn, $pwconn);
            if ($ldapbind) { 
                $basedn = "o=grupoice,o=ice";
                $filter="(|(cn=*$uids[0]*))";
                $search=ldap_search($this->ldapconn, $basedn, $filter);
                $first = ldap_first_entry($this->ldapconn, $search);
                $info = ldap_get_entries($this->ldapconn, $search);
                // full dn
                $dn = ldap_get_dn($this->ldapconn, $first);
                //member of
                $attrs = array("description");
                $filter =  "(&(member=*cavale*))"; //(&(member=*cavale*))";                
                $result = ldap_search($this->ldapconn,$basedn,$filter, $attrs);
                $entries = ldap_get_entries($this->ldapconn, $result);
                //
                if(isset($entries)){
                    array_shift($entries); 
                    return $entries;
                } else echo "No hay Datos";
            }
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
