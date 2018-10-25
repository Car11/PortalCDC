<?php
/*if (!isset($_SESSION))
	session_start();
require_once('globals.php');
require_once("conexion.php");
require_once("Log.php");


if(isset($_POST["action"])){
    $usuario= new LDAPP();
    switch($_POST["action"]){       
        case "Login":
            $ldapp->username= $_POST["username"];
            $ldapp->password= $_POST["password"];
            $ldapp->Connect();
            break;      
    }
}*/

class Sesion{
	public $estado=false;
	public $username;
	public $userid;
	public $rol;
	public $name;
	
	function __construct(){
        if (!isset($_SESSION))
			session_start();
		$this->Verifica();
	}
	
	private function Verifica(){		
		if(isset($_SESSION["username"])){
			$this->username = $_SESSION["username"];
			$this->rol = $_SESSION["rol"];
			$this->userid = $_SESSION["userid"];
			$this->name = $_SESSION["name"];
			$this->estado = true;	        
		} else {
			unset($this->username);
			unset($this->rol);
			unset($this->userid);
			unset($this->name);
			$this->estado = false;            
		}
	}
		
	public function Inicio($username, $rol, $userid, $name){
        $this->username = $_SESSION["username"] = $username;
		$this->rol = $_SESSION["rol"] = $rol;
		$this->userid = $_SESSION["userid"] = $userid;
		$this->name = $_SESSION["name"] = $name;
        $this->estado = true;	
	}
	
	public function Fin(){  /******************* PROBAR EL FINAL DEL LOGIN ****************************/
		unset($_SESSION["username"]);
		unset($this->username);
		unset($_SESSION["rol"]);
		unset($this->rol);
		unset($_SESSION["userid"]);
		unset($this->userid);
		unset($_SESSION["name"]);
		unset($this->name);
		$this->estado = false;
	}
}

?>
