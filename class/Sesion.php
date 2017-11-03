<?php
class Sesion{
	public $estado=false;
	public $username;
	public $userid;
	public $rol;
	
	function __construct(){
        if (!isset($_SESSION))
			//session_start();
		$this->Verifica();
		/*if($this->login){
            return true;
		} else {
            return false;
		}*/
	}
	
	private function Verifica(){
		if(isset($_SESSION["username"])){
			$this->username = $_SESSION["username"];            
			$this->rol = $_SESSION["rol"];            
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
