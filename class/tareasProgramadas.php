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
        case "create":
            $tareasProgramadas->create();
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

    function create(){
        try {
            $file = 0;
            $subTask = 0;

            if (sizeof($this->file) > 0){
                $file = 1;
            }
            if (sizeof($this->sub_task) > 0){
                $subTask = 1;
            }
            $sql = "INSERT INTO scheduled_task (user_id, min, hour, dom, year, dow,  
                        title,  detail, file, sub_task,  project_id, column_id)
                    VALUES ( :user_id, :min, :hour, :dom, :year, :dow, :title, 
                        :detail, :file, :sub_task, :project_id, :column_id);";

            $param= array(':user_id'=>$this->user_id, ':min'=>$this->min, ':hour'=>$this->hour, 
                        ':dom'=>$this->dom, ':year'=>$this->year, ':dow'=>$this->dow, ':title'=>$this->title, 
                        ':detail'=>$this->detail, ':file'=>$file, ':sub_task'=>$subTask, 
                        ':project_id'=>$this->project_id, ':column_id'=>$this->column_id );            
            $data = DATA::Ejecutar($sql,$param, false);
            // if($data){        
                if ($subTask == 1){

                    $sql='select last_insert_id() id_task;';
                    $last_id = DATA::Ejecutar($sql);
                    $id_task = $last_id[0]["id_task"];

                    foreach ($this->sub_task as $value) {
                        $sql='insert into scheduled_sub_task (id_scheduled_task, title) values (:id_scheduled_task, :subtask_des);';
                        $param= array(':id_scheduled_task'=>$id_task, ':subtask_des'=> $value);
                        $data = DATA::Ejecutar($sql,$param, false);  
                    }
                }   
                        
                if ($file == 1){
                    foreach ($this->file as $value) {
                        $sql='insert into scheduled_task_has_files (scheduled_task_id, name, image_file_base64) VALUES (:id_task, :nombre, :base64);';
                        $param= array(':id_task'=>$id_task, ':nombre'=>$value["name"], ':base64'=>$value["base64Str"]);
                        $data = DATA::Ejecutar($sql,$param);  
                    }
                }        
                return true;
            // }
            // return false;
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

