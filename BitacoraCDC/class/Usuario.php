<?php 
//session_start();
class Usuario{
	public $usuario;
	public $contrasena;
    public $idrol;
    public $nombre;
    public $email;
	
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
            // log::Add('INFO', 'Inicio de sesión: '. $this->usuario);
            return true;
        }else {
            return false;           
        }        
    }

    function BuscaRol(){    
        $sql='SELECT idrol FROM usuario where usuario=:usuario';
        $param= array(':usuario'=>$this->usuario);        
        $data = DATA::Ejecutar($sql,$param);
        //
        if (count($data) ) {
            $this->idrol= $data[0]['idrol'];
        }else {
            // Rol tramitante (2) por defecto si no existe en BD. Registra nuevo usuario tipo 2= TRAMITANTE.
            $this::AddUser(); 
            $this->idrol= 2; 
        }        
    }

    function AddUser(){
        $sql="INSERT INTO usuario (nombre, usuario, contrasena, idrol, email)
        VALUES (:nombre,:usuario, 'LDAP', '2' , :email)";
        $param= array(':nombre'=>utf8_encode($this->nombre), ':usuario'=>$this->usuario, ':email'=>$this->email);
        $data = DATA::Ejecutar($sql, $param);        
    }

    function ValidarUsuarioLDAP (){
        $ldapServicio = DATA::getLDAP_Param();
        //Busca el usuario desde una cuenta de Servicio ICE 
        $domainName = "icetel.ice";
        $ldapport = 3268;
        $ldap = ldap_connect($domainName, $ldapport);
        $ldapMail = $this->usuario;  
        $baseDN = "dc=ice";
        $bind = @ldap_bind($ldap, $ldapServicio["LDAPuser"], $ldapServicio["LDAPpasswd"]);
        if ($bind) {
            //Filta por correo
            $filter="(mail=$ldapMail)";
            $search_result=ldap_search($ldap,$baseDN,$filter);
            $userData = ldap_get_entries($ldap, $search_result);
            //Obtiene Dominio y Usuario de dominio para crear el DN
            foreach (  (ldap_explode_dn ($userData[0]["dn"], 0) ) as $key=> $dn) {
                // code to be executed;
                if ( isset(explode ("=",$dn)[1])   ){
                    switch ( explode ("=",$dn)[1] ) {
                        case "sabana":
                            $userDomainName = "sabana";
                            break;
                        case "icetel":
                            $userDomainName = "icetel";
                            break;
                    }

                }
                
                
                // $res = ldap_search($ldap_conn, $dn, $filter);
                // // $first = ldap_first_entry($ldap_conn, $res);
                // $data = ldap_get_dn($ldap, $userData);
            }
            // $userDomainName = explode ("=",ldap_explode_dn ($userData[0]["dn"], 0)[3])[1];
            $userLDAPUser = $userData[0]["samaccountname"][0];
            $userLDAPDN = $userDomainName  . "\\" .  $userLDAPUser;
            //Cierra la Sesion
            //%VaL32310%
            @ldap_close($ldap);
            /////////// Valida Usuario y password:
            $userLDAP = ldap_connect($userDomainName . ".ice", $ldapport);
            $userBind = @ldap_bind($userLDAP, $userLDAPDN, $this->contrasena);
            if ($userBind) {
                $filter="(mail=$ldapMail)";//mail
                $result = ldap_search($userLDAP,$baseDN,$filter);
                $info = ldap_get_entries($userLDAP, $result);
                for ($i=0; $i<$info["count"]; $i++)
                {
                    if($info['count'] > 1)
                        break;
                
                    $this->email= $info[$i]["mail"][0];
                    $this->nombre = $info[$i]["sn"][0] . ' ' . $info[$i]["givenname"][0];
                    $this->usuario = $userLDAPUser;
                    $this::BuscaRol();
                    return true;  
                }
            }
            @ldap_close($ldap);
        } else {
            error_log("Falla el Bind: " . ldap_error($ldap));
            return false;  
        }
    }

    
    function Cargar(){
        $sql='SELECT nombre, contrasena, idrol, email FROM usuario WHERE usuario=:usuario';
        $param= array(':usuario'=>$_SESSION['username']);        
        $data = DATA::Ejecutar($sql,$param);
        if (count($data) ) {
            $this->nombre= $data[0]['nombre'];
            $this->contrasena= $data[0]['contrasena'];
            $this->idrol= $data[0]['idrol'];
            $this->email= $data[0]['email'];
            return true;
        }else {        
            return false;           
        }        
    }

    function CargarTramitanteForm($idformulario){
        $sql='SELECT idtramitante , email , u.nombre
            FROM formulario f inner join usuario u on u.id=f.idtramitante
            WHERE f.id=:idformulario';
        $param= array(':idformulario'=>$idformulario);        
        $data = DATA::Ejecutar($sql,$param);
        if (count($data) ) {
            $this->id= $data[0]['idtramitante'];
            $this->nombre= $data[0]['nombre'];
            $this->email= $data[0]['email'];
            return true;
        }else {
            return false;           
        }        
    }
}
?>
