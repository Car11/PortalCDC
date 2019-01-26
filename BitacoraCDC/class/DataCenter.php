<?php

if(isset($_POST["action"])){
    $opt= $_POST["action"];
    unset($_POST['action']);

    // Classes        
    require_once("Conexion.php");
    // if (!isset($_SESSION)) {
    //     session_start();
    // }
    $dataCenter= new DataCenter();

    switch($opt){
        case "SeleccionarDataCenter":
            $dataCenter->SeleccionarDataCenter();
            break;
        case "Default":
            $dataCenter->DataCenterporDefecto();
            break;
    }  
}

class DataCenter{
    public $id = null;
    public $nombre = null;


    function __construct(){   
        if(isset($_POST["id"])){
            $this->id= $_POST["id"];
        }
        if(isset($_POST["obj"])){
            $obj= json_decode($_POST["obj"],true);
            // $this->consecutivo= $obj["consecutivo"] ?? null;
        }    
    }

    //CONSULTA TODOS LOS DATA CENTERS
    function SeleccionarDataCenter(){
        try {
            $sql='SELECT id,nombre FROM datacenter order by nombre asc';         
            $data = DATA::Ejecutar($sql);
            if ($data) {
                $this->id= $data[0]['id'];
                $this->nombre= $data[0]['nombre'];
            }
            
        //    $z = ' [{"id":"01", "text":"cero uno"},
        //         {"id":"02", "text":"cero dos"},
        //         {"id":"03", "text":"cero tres"}] ';
                
            // echo ($z);	
            echo json_encode($data);			
        }catch(Exception $e) {
            error_log($e->getMessage());
            exit;
        }
    }

    //CONSULTA EL DATACENTER POR DEFECTO SAN PEDRO
    function DataCenterporDefecto(){
        try {
            $sql="SELECT id,nombre FROM datacenter WHERE nombre =:sanpedro";   
            $param= array(':sanpedro'=>"SAN PEDRO");      
            $data = DATA::Ejecutar($sql,$param);
            if (count($data)) {
                $this->id= $data[0]['id'];
                $this->nombre= $data[0]['nombre'];
            }
            echo json_encode($data);			
        }catch(Exception $e) {
            error_log($e->getMessage());
            exit;
        }
    }

    //CONSULTA EL DATACENTER POR SALA
    function DataCenterporSala($idsala){
        try {
            $sql="SELECT d.id, d.nombre 
                FROM controlaccesocdc_dbp.sala s inner join controlaccesocdc_dbp.datacenter d on s.iddatacenter=d.id
                where s.id=:idsala";   
            $param= array(':idsala'=>$idsala);      
            $data = DATA::Ejecutar($sql,$param);
            if (count($data)) {
                $this->id= $data[0]['id'];
                $this->nombre= $data[0]['nombre'];
            }
            return $data;
        }catch(Exception $e) {
            error_log($e->getMessage());
            exit;
        }
    }

}
    


?>