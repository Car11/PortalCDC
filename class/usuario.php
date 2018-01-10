<?php 
//session_start();

class Usuario{
  
public $usuario;
public $contrasena;
public $rol;
public $nombre;
public $email;
public $is_active;


    function __construct(){
        require_once("Conexion.php");
        require_once("Log.php");
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
    

    function LDAPCheck (){
        //error_reporting(0);
        ini_set('error_reporting', .0);
        $adServer = "icetel.ice";
        $ldapport = 3268;
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
            log::Add('INFO', 'Inicio de sesiÃ³n InvÃ¡lida: '. $this->usuario);
            return false;  
        }
    }

    function wasLDAPCheck (){
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
            log::Add('INFO', 'Inicio de sesiÃ³n InvÃ¡lida: '. $this->usuario);
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
