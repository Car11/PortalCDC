<?php
if(isset($_POST["action"])){
    $opt= $_POST["action"];
    unset($_POST['action']);

    // Classes        
    require_once("Conexion.php");
    // if (!isset($_SESSION)) {
    //     session_start();
    // }
    $sala= new Sala();

    switch($opt){
        case "Cargar":
            if(isset($_POST["iddatacenter"])){
                $sala->idDataCenter= $_POST["iddatacenter"];
            }
            $sala->Disponibles();
            break;
        case "CargarporDataCenter":
            $sala->DisponiblesDataCenter();           
            break;
    }  
}

class Sala{
    
    public $idDataCenter = null;

    function __construct(){   
    //error_reporting(E_ALL);
    //Always in development, disabled in production
    //ini_set('display_errors', 1);
    }

    function Disponibles(){
        try {
            $sql='SELECT id,nombre FROM sala WHERE iddatacenter = :iddatacenter order by nombre asc';
            $param= array(':iddatacenter'=>$this->idDataCenter);  
            $data = DATA::Ejecutar($sql,$param);
            if (count($data)) {
                $this->id= $data[0]['id'];
                $this->nombre= $data[0]['nombre'];
            }
            echo json_encode($data);
        }     
        catch(Exception $e) {
            error_log($e->getMessage());
            exit;
        }
    }

    function DisponiblesDataCenter(){
        try {
            $sql='SELECT id,nombre FROM sala WHERE iddatacenter = (SELECT id FROM datacenter WHERE nombre=:nombredatacenter) order by nombre asc';
            $param= array(':nombredatacenter'=>$_POST["nombredatacenter"]);  
            $data = DATA::Ejecutar($sql,$param);
            if (count($data)) {
                $this->id= $data[0]['id'];
                $this->nombre= $data[0]['nombre'];
            }
            echo json_encode($data);
        }     
        catch(Exception $e) {
            error_log($e->getMessage());
            exit;
        }
    }

}
    


?>