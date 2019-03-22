<?php

//ACTION
if(isset($_POST["action"])){
    $opt= $_POST["action"];
    unset($_POST['action']);
    // Classes
    require_once("conexion.php");
    
    // Session
    if (!isset($_SESSION))
        session_start();
    // Instance
    $tareasProgramadas= new TareasProgramadas();
    switch($opt){
        case "cargar_todas":
            echo json_encode($tareasProgramadas->cargar_todas());
            break;
    }
}

class TareasProgramadas {
    //TareasProgramadas
    public $id;         
    public $user_id;    
    public $min;        
    public $hour;       
    public $dom;        
    public $year;       
    public $dow;        
    public $title;      
    public $detail;     
    public $file;       
    public $sub_task;   
    public $project_id; 
    public $column_id;  
    
    function __construct(){
        // if(isset($_POST["id"])){
        //     $this->id= $_POST["id"];
        // }
        if(isset($_POST["obj"])){
            $obj= json_decode($_POST["obj"],true);
            
            
            $this->id = $obj["id"] ?? null; 
            $this->user_id = $obj["user_id"] ?? null;
            $this->min = $obj["min"] ?? null;
            $this->hour = $obj["hour"] ?? null;
            $this->dom = $obj["dom"] ?? null;
            $this->year = $obj["year"] ?? null;
            $this->dow = $obj["dow"] ?? null;
            $this->title = $obj["title"] ?? null;
            $this->detail = $obj["detail"] ?? null;
            $this->file = $obj["file"] ?? null;
            $this->sub_task = $obj["sub_task"] ?? null;
            $this->project_id = $obj["project_id"] ?? null;
            $this->column_id = $obj["column_id"] ?? null;

        }
    }


    function cargar_todas(){
        try {
            $sql='SELECT id, user_id, min, hour, dom, year, dow, title, detail, file, sub_task
                FROM kanboard.scheduled_task;';
            // $param= array(':idEntidad'=>$_SESSION["userSession"]->idEntidad, ':fechaInicial'=>$this->fechaInicial, ':fechaFinal'=>$this->fechaFinal);            
            $data= DATA::Ejecutar($sql);
            if($data){                
                return $data;
            }
            return false;
        }     
        catch(Exception $e) {
            error_log("[ERROR]  (".$e->getCode()."): ". $e->getMessage());
            if (!headers_sent()) {
                    header('HTTP/1.0 400 Error al leer');
                }
            die(json_encode(array(
                'code' => $e->getCode() ,
                'msg' => 'Error al cargar la lista'))
            );
        }
    }
};


 

?>