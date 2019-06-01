<?php 
class Usuario{
	public $usuario;
	public $contrasena;
    public $idrol;
    public $nombre;
    public $email;
    public $dn;
	
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
        $LDAP_servicio = DATA::getLDAP_Param();
        $LDAP_connect = ldap_connect($LDAP_servicio["LDAP_server"], $LDAP_servicio["LDAP_port"]);
        $LDAP_bind = @ldap_bind($LDAP_connect, $LDAP_servicio["LDAP_user"], $LDAP_servicio["LDAP_passwd"]);
        if ($LDAP_bind) {
            $LDAP_filter="(mail=$this->usuario)";
            $search_result=ldap_search($LDAP_connect,$LDAP_servicio["LDAP_base_dn"],$LDAP_filter);
            $LDAP_user_data = ldap_get_entries($LDAP_connect, $search_result);  
            if($LDAP_user_data["count"] < 1){
                @ldap_close($LDAP_connect);
                return false;
            }       
            $this->dn = $LDAP_user_data[0]["dn"];
            $this->email= $LDAP_user_data[0]["mail"][0];
            $this->nombre = $LDAP_user_data[0]["cn"][0];
            $this->usuario = $LDAP_user_data[0]["samaccountname"][0];
            $this::BuscaRol();
            @ldap_close($LDAP_connect);
            
            $LDAP_connect = ldap_connect($LDAP_servicio["LDAP_server"], $LDAP_servicio["LDAP_port"]);
            $LDAP_bind = @ldap_bind($LDAP_connect, $this->dn, $this->contrasena);
            @ldap_close($LDAP_connect);
            if ($LDAP_bind) 
                return true;
            else
                return false;  
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
