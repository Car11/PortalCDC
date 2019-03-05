<?php
/*if (!isset($_SESSION))
	session_start();
require_once('Globals.php');
require_once("Conexion.php");
require_once("Log.php");
*/

if(isset($_POST["action"])){
    $sesion= new Sesion();
    switch($_POST["action"]){       
        case "logout":
            $sesion->Fin();
            break;      
    }
}

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
			// prueba sin login
			//$this->Fin();
		} else {
			unset($this->username);
			unset($this->rol);
			unset($this->userid);
			unset($this->name);
			$this->estado = false;
		}
	}

	public function isLogin(){
		if(!isset($_SESSION["username"])){
			$this->Fin();     
			//
			// header("Location: http://operacionesti/Login.php");
			error_log("[WARNING]  (-666): Tiempo de sesion vencido");
			//header("Location: localhost/PortalCDC/Login.php");
			header('HTTP/1.0 400 Bad error');
            die(json_encode(array(
                'code' => -666,
                'msg' => 'Sesión Inválida'))
            );			
			exit();  
		}
	}
		
	public function Inicio($username, $rol, $userid, $name){
        $this->username = $_SESSION["username"] = $username;
		$this->rol = $_SESSION["rol"] = $rol;
		$this->userid = $_SESSION["userid"] = $userid;
		$this->name = $_SESSION["name"] = $name;
        $this->estado = true;	
	}
	
	public function Fin(){ 
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
