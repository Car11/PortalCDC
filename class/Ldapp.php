<?php
if (!isset($_SESSION))
    session_start();
require_once('Globals.php');
require_once("Conexion.php");
require_once("Log.php");


//Globals::ConfiguracionIni();

if(isset($_POST["action"])){
    $ldapp= new LDAPP();
    switch($_POST["action"]){       
        case "Connect":
            $ldapp->username= $_POST["username"];
            $ldapp->password= $_POST["password"];
            $ldapp->ambiente= $_POST["ambiente"];
            $ldapp->Connect();
            break;    
        case "LoadPlantilla":
            $ldapp->username= $_POST["username"];
            $ldapp->password= $_POST["password"];
            //$ldapp->ambiente= $_POST["ambiente"];
            $ldapp->LoadPlantilla();
            break;    
        case "getGroupsByAppName":
            $ldapp->username= $_POST["username"];
            $ldapp->password= $_POST["password"];
            $ldapp->ambiente= $_POST["ambiente"];
            $app= $_POST["app"];
            $ldapp->getGroupsByAppName($app);
            break;    
        case "getMembershipByUser":
            //$ldapp->username= $_POST["username"];
            //$ldapp->password= $_POST["password"];
            //$ldapp->ambiente= $_POST["ambiente"];            
            echo json_encode($ldapp->getMembershipByUser($_POST["uids"]));
            break;    
        case "getRamas":           
            echo json_encode($ldapp->getRamas());
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

    function __construct(){
        require_once("Conexion.php");
        require_once("Log.php");
    }

    function LoadPlantilla(){
        try {
            $adServer = "10.129.20.138";
            $ldapport = 389;
            $ldapconn = ldap_connect($adServer, $ldapport) or die("Could not connect to LDAP server.");
            if($ldapconn){
                ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
                ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
                // binding to ldap server with standard user            
                $userconn = 'cn=usersdutiles,cn=directoryServer,ou=grupos,o=grupoice,o=ice'; 
                $pwconn= 'ldaputil71';
                $ldapbind = ldap_bind($ldapconn, $userconn, $pwconn);
                if ($ldapbind) {
                    $dn = "o=grupoice,o=ice";
                    $filter="(|(cn=*$this->username*))";
                    $sr=ldap_search($ldapconn, $dn, $filter);
                    $first = ldap_first_entry($ldapconn, $sr);
                    $info = ldap_get_entries($ldapconn, $sr);
                    // full dn
                    $dn = ldap_get_dn($ldapconn, $first);
                    $_SESSION["FULLDN"]= $dn;
                    $attrs = ldap_get_attributes($ldapconn, $first);
                    $info = ldap_get_entries($ldapconn, $sr);
                    // APPS
                    $dn=""; 
                    $filter = "objectClass=applicationEntity";
                    $dn = "ou=grupos,o=grupoice,o=ice";
                    //
                    $result=ldap_list($ldapconn, $dn, $filter) or die("No se encontraron aplicaciones."); 
                    $info = ldap_get_entries($ldapconn, $result);
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
        //error_reporting(1);
        //ini_set('error_reporting', 1);
        $adServer = "10.129.20.138";
        $ldapport = 389;
        $ldapconn = ldap_connect($adServer, $ldapport) or die("Could not connect to LDAP server.");
        if($ldapconn){
            ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
            // binding to ldap server with standard user            
            $userconn = 'cn=usersdutiles,cn=directoryServer,ou=grupos,o=grupoice,o=ice'; 
            $pwconn= 'ldaputil71';
            $ldapbind = ldap_bind($ldapconn, $userconn, $pwconn);
            if ($ldapbind) {
                $dn = "o=grupoice,o=ice";
                $filter="(|(cn=*$this->username*))";
                $sr=ldap_search($ldapconn, $dn, $filter);
                $first = ldap_first_entry($ldapconn, $sr);
                $info = ldap_get_entries($ldapconn, $sr);
                // full dn
                $dn = ldap_get_dn($ldapconn, $first);
                $_SESSION["FULLDN"]= $dn;
                $attrs = ldap_get_attributes($ldapconn, $first);
                $info = ldap_get_entries($ldapconn, $sr);
                // membresías
                // RAMA
                // APPS-PRD
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
                $result=ldap_list($ldapconn, $dn, $filter) or die("No se encontraron aplicaciones."); 
                $info = ldap_get_entries($ldapconn, $result);
                array_shift($info); 
                echo json_encode($info);                            
            }
            else header("Status: 500 Not Found");; // error ajax
        }  else header("Status: 500 LDAP Server Not Found");; // error ajax
    }
      
    function getGroupsByAppName($app){
        error_reporting(1);
        ini_set('error_reporting', 1);
        $adServer = "10.129.20.138";
        $ldapport = 389;
        $ldapconn = ldap_connect($adServer, $ldapport) or die("Could not connect to LDAP server.");
        if($ldapconn){
            ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
            // binding to ldap server with standard user            
            $userconn = 'cn=usersdutiles,cn=directoryServer,ou=grupos,o=grupoice,o=ice'; 
            $pwconn= 'ldaputil71';
            $ldapbind = ldap_bind($ldapconn, $userconn, $pwconn);
            if ($ldapbind) {
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
                $result=ldap_list($ldapconn, $dn, $filter) or die("No se encontraron Grupos."); 
                $info = ldap_get_entries($ldapconn, $result);
                array_shift($info); 
                echo json_encode($info);

            }
        }        
    }

    function getMembershipByUser($uids){
        error_reporting(1);
        ini_set('error_reporting', 1);
        $adServer = "10.129.20.138";
        $ldapport = 389;
        $ldapconn = ldap_connect($adServer, $ldapport) or die("Could not connect to LDAP server.");
        if($ldapconn){
            ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
            // binding to ldap server with standard user            
            $userconn = 'cn=usersdutiles,cn=directoryServer,ou=grupos,o=grupoice,o=ice'; 
            $pwconn= 'ldaputil71';
            $ldapbind = ldap_bind($ldapconn, $userconn, $pwconn);
            if ($ldapbind) { 
                $basedn = "o=grupoice,o=ice";
                $filter="(|(cn=*$uids[0]*))";
                $sr=ldap_search($ldapconn, $basedn, $filter);
                $first = ldap_first_entry($ldapconn, $sr);
                $info = ldap_get_entries($ldapconn, $sr);
                // full dn
                $dn = ldap_get_dn($ldapconn, $first);
                //member of
                $attrs = array("description");
                $filter =  "(&(member=*cavale*))"; //(&(member=*cavale*))";                
                $result = ldap_search($ldapconn,$basedn,$filter, $attrs);
                $entries = ldap_get_entries($ldapconn, $result);
                //
                if(isset($entries)){
                    array_shift($entries); 
                    return $entries;
                } else echo "No hay Datos";
            }
        }        
    }

    function getRamas(){
        $adServer = "10.129.20.138";
        $ldapport = 389;
        $ldapconn = ldap_connect($adServer, $ldapport) or die("Could not connect to LDAP server.");
        if($ldapconn){
            ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
            // binding to ldap server with standard user            
            $userconn = 'cn=usersdutiles,cn=directoryServer,ou=grupos,o=grupoice,o=ice'; 
            $pwconn= 'ldaputil71';
            $ldapbind = ldap_bind($ldapconn, $userconn, $pwconn);
            if ($ldapbind) { 
                $basedn = "o=grupoice,o=ice";
                $filter="objectClass=organizationalUnit";
                $attrs = array("ou");
                $sr=ldap_search($ldapconn, $basedn, $filter, $attrs);
                //$first = ldap_first_entry($ldapconn, $sr);
                $info = ldap_get_entries($ldapconn, $sr);
                // full dn
                //$dn = ldap_get_dn($ldapconn, $first);
                //member of
                /*$attrs = array("description");
                $filter =  "(&(member=*$uids[0]*))";                
                $result = ldap_search($ldapconn,$basedn,$filter, $attrs);
                $entries = ldap_get_entries($ldapconn, $result);*/
                //
                if(isset($info)){
                    array_shift($info); 
                    return $info;
                } else echo "No Hay Datos.";
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
