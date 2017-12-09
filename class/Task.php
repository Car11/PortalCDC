<?php
if (!isset($_SESSION))
    session_start();
require_once('Globals.php');
require_once("Conexion.php");
require_once("Log.php");

function __construct(){
    require_once("Conexion.php");
    require_once("Log.php");
}

Globals::ConfiguracionIni();

if(isset($_POST["action"])){
    $task= new Task();
    switch($_POST["action"]){       
        case "LoadAll":
            //echo json_encode($visitante->CargarTodos());
            break;
        case "Load":
            $task->id=$_POST["id"];
            echo json_encode($task->Load());
            break;
        case "LoadTaskFiles":
            $task->id=$_POST["id"];
            echo json_encode($task->LoadTaskFiles());
            break;
        case "LoadTasksByUser": 
            echo json_encode($task->LoadTasksByUser());
            break;        
        case "Insert":
            $task->title= $_POST["title"];
            $task->description= $_POST["description"];
            $task->project_id= $_POST["project_id"];
            $task->Insert();
            break;
        case "Update":
            /*$visitante->ID= $_POST["idvisitante"];
            $visitante->cedula= $_POST["cedula"];
            $visitante->nombre= $_POST["nombre"];
            $visitante->empresa= $_POST["empresa"];
            $visitante->permisoanual= $_POST["permiso"];
            $visitante->Modificar();*/
            break;
        case "Delete":
            /*$visitante->ID= $_POST["idvisitante"];            
            $visitante->Eliminar();*/
            break;        
    }
}
class Task{
    public $id='';
    public $send_id=123;   // definir que es este dato.
    public $title;
    public $description;
    public $project_id;
    public $date_completed;
    public $owner_id;
    public $date_creation;
    public $date_modification;
    public $position;
    public $column_id = 42;    // definir como se van a manejar las columnas del proyecto.

    function __construct(){
        require_once("Conexion.php");
        require_once("Log.php");
    }

    //
    // Funciones de Mantenimiento.
    //
    function Insert(){
        try {

            $curl = curl_init();            
            $data = "{ \"jsonrpc\": \"2.0\", \"method\": \"createTask\", \"id\": " . $this->send_id . ", \"params\": { \"owner_id\": 0, \"creator_id\": ". $_SESSION["userid"] . ", 
                \"date_due\": \"\", \"description\": \"" . $this->description . "\", \"category_id\": 0, \"score\": 0, \"title\": \"" . $this->title .  "\", \"project_id\": " . $this->project_id . 
                ", \"color_id\": \"green\", \"column_id\": " . $this->column_id . ", \"recurrence_status\": 0, \"recurrence_trigger\": 0, \"recurrence_factor\": 0, \"recurrence_timeframe\": 0, \"recurrence_basedate\": 0 } }";            

            /*$data2 = array('jsonrpc' => '2.0',
                'method'=> 'createTask',
                'id'=>$this->send_id,
                'params'=> $params=array(
                    'owner_id'=>$_SESSION["userid"],
                    'creator_id'=>$_SESSION["userid"],
                    'date_due'=>'',
                    'description'=>$this->description,
                    'category_id'=>0,
                    'score'=>0,
                    'title'=>$this->title,
                    'project_id'=>$this->project_id,
                    'color_id'=>'green',
                    'column_id'=> $this->column_id,
                    'recurrence_status'=>0,
                    'recurrence_trigger'=>0,
                    'recurrence_factor'=>0,
                    'recurrence_timeframe'=>0,
                    'recurrence_basedate'=>0
                )
            );*/

            //echo $cadenaRapida; 
            curl_setopt_array($curl, array(
              CURLOPT_URL => Globals::$jsonrpcURL,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS =>  $data,
              CURLOPT_HTTPHEADER => array(
                "authorization: Basic ". Globals::$token ."=",
                "cache-control: no-cache",
                "content-type: application/json",
                "postman-token: ". Globals::$postmantoken
              ),
            ));
            
            $response = curl_exec($curl);
            $err = curl_error($curl);
            
            curl_close($curl);
            
            if ($err) {
                echo "Error #:" . $err;
            } else {
                $response= explode(",",$response)[1];
                $this->id= (int)explode(":",$response)[1]; // id task
                echo json_encode($this);
            }
        }     
        catch(Exception $e) {            
            //log::AddD('FATAL', 'Ha ocurrido un error al realizar el insert', $e->getMessage());
            //$_SESSION['errmsg']= $e->getMessage();
            header('Location: ../Error.php');            
            exit;
        }
    }

    function Load(){
        try {
            $sql='SELECT title, description, date_creation, project_id, column_id, owner_id, date_started
                FROM tasks t 
                where id=:id';
            $param= array(':id'=>$this->id);
            $data= DATA::Ejecutar($sql,$param);
            return $data;
                        
        }     
        catch(Exception $e) {            
            //log::AddD('FATAL', 'Ha ocurrido un error al realizar la carga de datos', $e->getMessage());
            //$_SESSION['errmsg']= $e->getMessage();
            header('Location: ../Error.php');            
            exit;
        }
    }

    // lista de archivos adjuntos.
    /*function LoadTaskFiles(){
        try {
            $curl = curl_init();            
            $data = "{ \"jsonrpc\": \"2.0\", \"method\": \"getAllTaskFiles\", \"id\": " . $this->id . ", \"params\": { \"task_id\": ". $this->id ." } }";
            //
            curl_setopt_array($curl, array(
                CURLOPT_URL => Globals::$jsonrpcURL,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS =>  $data,
                CURLOPT_HTTPHEADER => array(
                    "authorization: Basic ". Globals::$token ."=",
                    "cache-control: no-cache",
                    "content-type: application/json",
                    "postman-token: ". Globals::$postmantoken
                ),
                ));
                
                $response = curl_exec($curl);
                $err = curl_error($curl);
                
                curl_close($curl);
                
                if ($err) {
                    echo "Error #:" . $err;
                } else {
                    $response= explode(",",$response)[1];
                    $this->id= (int)explode(":",$response)[1]; // id task
                    // echo json_encode($this);
                }                        
        }     
        catch(Exception $e) {            
            //log::AddD('FATAL', 'Ha ocurrido un error al realizar la carga de datos', $e->getMessage());
            //$_SESSION['errmsg']= $e->getMessage();
            header('Location: ../Error.php');            
            exit;
        }
    }*/

    function LoadTaskFiles(){
        try {
            $sql='SELECT id, name, date 
                FROM task_has_files
                where TASK_ID= :taskId AND IS_IMAGE=0              
                ORDER BY name ';
            $param= array(':taskId'=>$this->id);
            $data= DATA::Ejecutar($sql,$param);
            return $data;
        }     
        catch(Exception $e) {            
            //log::AddD('FATAL', 'Ha ocurrido un error al realizar la carga de datos', $e->getMessage());
            //$_SESSION['errmsg']= $e->getMessage();
            header('Location: ../Error.php');            
            exit;
        }
    }

    // descarga adjunto.
    function DownloadTaskFile($file_id){
        try {
            /*$curl = curl_init();            
            $data = "{ \"jsonrpc\": \"2.0\", \"method\": \"getTaskFile\", \"id\": " . $this->id . ", \"params\": { \"owner_id\": 0, \"creator_id\": ". $_SESSION["userid"] . ", 
                \"date_due\": \"\", \"description\": \"" . $this->description . "\", \"category_id\": 0, \"score\": 0, \"title\": \"" . $this->title .  "\", \"project_id\": " . $this->project_id . 
                ", \"color_id\": \"green\", \"column_id\": " . $this->column_id . ", \"recurrence_status\": 0, \"recurrence_trigger\": 0, \"recurrence_factor\": 0, \"recurrence_timeframe\": 0, \"recurrence_basedate\": 0 } }";            

                {
                    "jsonrpc": "2.0",
                    "method": "getTaskFile",
                    "id": 318676852,
                    "params": [
                        "1"
                    ]
                }*/
        }     
        catch(Exception $e) {            
            //log::AddD('FATAL', 'Ha ocurrido un error al realizar la carga de datos', $e->getMessage());
            //$_SESSION['errmsg']= $e->getMessage();
            header('Location: ../Error.php');            
            exit;
        }
    }

    function LoadTasksByUser(){
        try {
            $sql='SELECT id, title, description, owner_id, position, date_creation, date_modification 
                FROM tasks
                where creator_id=:userid                
                ORDER BY id desc';
            $param= array(':userid'=>$_SESSION["userid"]);
            $data= DATA::Ejecutar($sql,$param);
            return $data;
        }     
        catch(Exception $e) {            
            //log::AddD('FATAL', 'Ha ocurrido un error al realizar la carga de datos', $e->getMessage());
            //$_SESSION['errmsg']= $e->getMessage();
            header('Location: ../Error.php');            
            exit;
        }
    }
}

?>