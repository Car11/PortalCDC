<?php 
//session_start();
class Usuario{
	public $usuario;
	public $contrasena;
    public $idrol;
    public $nombre;
	
	function __construct(){
        require_once("Conexion.php");
        require_once("Log.php");
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

    function BuscaRol(){    // valida rol en bd y administra accesos a elementos de la web
        $sql='SELECT idrol FROM usuario where usuario=:usuario';
        $param= array(':usuario'=>$this->usuario);        
        $data = DATA::Ejecutar($sql,$param);
        if (count($data) ) {
            $this->idrol= $data[0]['idrol'];
        }else {        
            $this->idrol= 2; // Rol 
        }        
    }

    function ValidarUsuarioLDAP (){
        error_reporting(0);
        $adServer = "icetel.ice";
        $ldapport = 3268;
        $ldap = ldap_connect($adServer, $ldapport);        
        $ldapUser = $this->usuario;
        $ldapPasswd = $this->contrasena;
        $ldaprdn = 'icetel' . "\\" . $ldapUser;
        //ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        //ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
        $bind = @ldap_bind($ldap, $ldaprdn, $ldapPasswd);
        if ($bind) {
            $filter="(sAMAccountName=$ldapUser)";
            $result = ldap_search($ldap,"dc=icetel,dc=ice",$filter);
            ldap_sort($ldap,$result,"sn");
            $info = ldap_get_entries($ldap, $result);
            for ($i=0; $i<$info["count"]; $i++)
            {
                if($info['count'] > 1)
                    break;
                $this::BuscaRol();
                log::Add('INFO', 'Inicio de sesión: '. $this->usuario);
                return true;  
            }
            @ldap_close($ldap);
        } else {
            log::Add('INFO', 'Inicio de sesión Inválida: '. $this->usuario);
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