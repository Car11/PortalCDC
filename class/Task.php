<?php
if (!isset($_SESSION))
    session_start();
require_once('Globals.php');
// require_once("Conexion.php");
// require_once("Log.php");

// function __construct(){
//     require_once("Conexion.php");
//     require_once("Log.php");
// }

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
        case "LoadColumns": 
            echo json_encode($task->LoadColumns());
            break;
        case "LoadTask": 
            echo json_encode($task->LoadTask());
            break;
        case "LoadTaskFiles":
            $task->id=$_POST["id"];
            echo json_encode($task->LoadTaskFiles());
            break;
        case "LoadTasksByUser": 
            echo json_encode($task->LoadTasksByUser());
            break;       
        case "DownloadTaskFile": 
            $task->idFile=$_POST["idFile"];
            echo json_encode($task->DownloadTaskFile());
            break;       
        case "Insert":
            $task->title= $_POST["title"];
            $task->description= $_POST["description"];
            $task->project_id= $_POST["projectid"];
            $task->subTask= $_POST["subTask"];
            $task->date_started= $_POST["date_started"];
            $task->date_due= $_POST["date_due"];
            $task->mifile= $_POST["mifile"];
            $task->subtask_des= json_decode($_POST["subtask_des"]);
            $task->objFile= json_decode($_POST["objFile"]);
            $task->creator_id= $_SESSION["userid"];
            $task->Insert();
            break;
        case "Update":
            $task->id= $_POST["id"];
            $task->title= $_POST["title"];
            $task->description= $_POST["description"];
            $task->project_id= $_POST["projectid"];
            $task->subTask= $_POST["subTask"];
            $task->date_started= $_POST["date_started"];
            $task->date_due= $_POST["date_due"];
            $task->mifile= $_POST["mifile"];
            $task->subtask_des= json_decode($_POST["subtask_des"]);
            $task->objFile= json_decode($_POST["objFile"]);
            $task->creator_id= $_SESSION["userid"];
            $task->Update();
            break;
        case "DeleteAttachment":
            $task->idFile= $_POST["idFile"];
            $task->DeleteAttachment();
            break;
        case "Delete":
            /*$visitante->ID= $_POST["idvisitante"];            
            $visitante->Eliminar();*/
            break;    
        case "LoadSubTasksByTask":
            $task->id=$_POST["id"];
            echo json_encode($task->LoadSubTasksByTask());
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
    public $creator_id;
    public $date_started;
    public $subtask_des;
    public $date_due;
    public $mifile;
    public $objFile;
    public $subTask;

    // public  $title_subTask = "0";
    // public $id_scheduled_task = "0";
    //public $column_id = 42;    // definir como se van a manejar las columnas del proyecto.

    public $idFile='';

    function __construct(){
        require_once("Conexion.php");
        require_once("Log.php");
    }

    //
    // Funciones de Mantenimiento.
    //
    function LoadColumns(){
        try {
            $sql='SELECT position, title
            FROM columns 
            WHERE project_id = :project_id
            ORDER BY position ASC;';   

            $param= array(':project_id'=>17);
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

    function LoadTask(){
        try {
            $sql='SELECT t.id, t.title, t.date_creation, c.position
            FROM kanboard.tasks as t
            INNER JOIN columns as c ON t.column_id = c.id
            where c.project_id = :project_id and 
            t.is_active =1 and
            creator_id = :userid
            order by t.id desc;';   
            $param= array(':project_id'=>17, ':userid'=>$_SESSION["userid"]);
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

    function Load(){
        try {
            $sql='SELECT title, description, date_creation, project_id, column_id, owner_id, date_started, date_due
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

    function LoadTaskFiles(){
        try {
                $sql='SELECT id, name, date 
                FROM task_has_files
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

    function DeleteAttachment(){
        try {
            $curl = curl_init();            
            $data = "{ \"jsonrpc\": \"2.0\", \"method\": \"removeTaskFile\", \"id\": " . $this->idFile . ", \"params\": [". $this->idFile . "] }";
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
            //    
            $response = curl_exec($curl);
            $err = curl_error($curl);            
            curl_close($curl);        
            //
            if ($err) {
                echo "Error #:" . $err;
            } else {
                return $response= explode("result\":\"",$response)[1];                    
            }     
        }     
        catch(Exception $e) {            
            //log::AddD('FATAL', 'Ha ocurrido un error al realizar la carga de datos', $e->getMessage());
            //$_SESSION['errmsg']= $e->getMessage();
            //header('Location: ../Error.php');            
            //exit;
        }
    }

    // descarga adjunto.
    function DownloadTaskFile(){
        try {
            $curl = curl_init();            
            $data = "{ \"jsonrpc\": \"2.0\", \"method\": \"downloadTaskFile\", \"id\": " . $this->idFile . ", \"params\": [". $this->idFile . "] }";
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
            //    
            $response = curl_exec($curl);
            $err = curl_error($curl);            
            curl_close($curl);            
            if ($err) {
                echo "Error #:" . $err;
            } else {
                return $response= explode("result\":\"",$response)[1];                    
            }                        
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
            // $sql='SELECT id, title, description, owner_id, position, date_creation, date_modification 
            //     FROM tasks
            //     where creator_id=:userid                
            //     ORDER BY id desc';

            $sql='SELECT t.id, t.title, t.description, C.title as position, t.date_creation 
                FROM tasks as t            
                INNER JOIN columns as C on t.column_id = C.id
                where creator_id=:userid 
                ORDER BY id desc;';   

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

    function LoadSubTasksByTask(){
        try {
            $sql='SELECT id, title, status, position FROM subtasks 
                WHERE task_id= :taskId
                ORDER BY position';
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

    function Update(){
        try{
            $t_started = date("m/d/Y H:i", strtotime($this->date_started));
            $t_due = ($this->date_due);
            $t_due = str_replace('T', ' ', $t_due);
            //
            $cadenaRapida = "{\"jsonrpc\": \"2.0\",\"method\": \"updateTask\",\"id\": \"10\",\"params\": { \"id\": ". $this->id .", \"owner_id\": ".$this->creator_id.", \"creator_id\":".$this->creator_id.", \"description\": \"" . $this->description . "\", \"category_id\": 0, \"score\": 0, \"title\": \"" . $this->title . "\", \"project_id\": ".$this->project_id.", \"color_id\": \"yellow\", \"date_due\": \"" . $t_due . "\", \"date_started\":\"" . $t_started . "\", \"recurrence_status\": 0, \"recurrence_trigger\": 0, \"recurrence_factor\": 0,\"recurrence_timeframe\": 0, \"recurrence_basedate\": 0 } }";
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => Globals::$jsonrpcURL,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $cadenaRapida,
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Basic ". Globals::$token ."=",
                    "cache-control: no-cache",
                    "content-type: application/json",
                    "Postman-Token: ". Globals::$postmantoken
                ),        
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);            
            //ARCHIVOS
            if ($this->mifile == "1"){
                foreach (($this->objFile) as $value2) {
                    $this->addFilesToTask(($this->project_id), $this->id, $value2[0],$value2[1]);
                }
            }
            //SUB-TAREAS
            foreach (($this->subtask_des) as $subT) {
                if($subT->id=="new")
                    $this->crearSubTarea($subT->title);
                else $this->actualizarSubTarea($subT->id, $subT->title);
            }
        }
        catch(Exception $e){}
    }

    function Insert(){
        try {
            $curl = curl_init();
            //date_started sin convertir: 2018-02-10T12:59
            //date_started debe tener el siguiente formato: 02/10/2018 19:43  || mes/dia/año hora:min       
            $t_started = date("m/d/Y H:i", strtotime($this->date_started));

            //date_due debe tener el siguiente formato: 2018-02-10 15:53  || año-mes-dia hora:min
            $t_due = ($this->date_due);
            // $t_due = str_replace('/', '-', $t_due);
            $t_due = str_replace('T', ' ', $t_due);

            //$fecha =date("c");
            $cadenaRapida = "{\"jsonrpc\": \"2.0\",\"method\": \"createTask\",\"id\": \"10\",\"params\": { \"owner_id\": ".$this->creator_id.", \"creator_id\":".$this->creator_id.", \"description\": \"" . $this->description . "\", \"category_id\": 0, \"score\": 0, \"title\": \"" . $this->title . "\", \"project_id\": ".$this->project_id.", \"color_id\": \"yellow\", \"date_due\": \"" . $t_due . "\", \"date_started\":\"" . $t_started . "\", \"recurrence_status\": 0, \"recurrence_trigger\": 0, \"recurrence_factor\": 0,\"recurrence_timeframe\": 0, \"recurrence_basedate\": 0 } }";

            // CURLOPT_URL => $Globals::$jsonrpcURL,
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => Globals::$jsonrpcURL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $cadenaRapida,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic ". Globals::$token ."=",
                "cache-control: no-cache",
                "content-type: application/json",
                "Postman-Token: ". Globals::$postmantoken
            ),        
            // "Authorization: Basic anNvbnJwYzo2ZmZhNWVmMzczM2U5YzBiOGJhMDA2ZmI5ODkzMzFhOTRiOWU4NzRkYTk5OWYwZjhkNzJmMTljMzNkZjg=",
            //   "Postman-Token: 1ec2b092-199a-ee41-b698-37096a6c36f7"
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            $this->id =json_decode($response)->result;
            curl_close($curl);
            //
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                echo "Resumen de tarea: ".$response;
            }
            //
            if (($this->subTask) == "1"){
                foreach (($this->subtask_des) as $subT) {
                    $this->crearSubTarea($subT->title);
                }
            }
        
            if ($this->mifile == "1"){
                foreach (($this->objFile) as $value2) {
                    $this->addFilesToTask(($this->project_id), $this->id, $value2[0],$value2[1]);
                }
            }
        }
        catch (Exception $e){
            header('HTTP/1.1 500 Internal Server XXX');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => 'ERROR:' . $e, 'code' => 666)));
        }
    
    }

    function crearSubTarea($title_subTask){
    //$this->id_scheduled_task, $title_subTask
        $cadenaRapida = "{ \"jsonrpc\": \"2.0\", \"method\": \"createSubtask\", \"id\": 2041554661, \"params\": { \"task_id\":" . $this->id . ", \"title\": \"" . $title_subTask . "\" } }";
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => Globals::$jsonrpcURL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $cadenaRapida,
        CURLOPT_HTTPHEADER => array(
            "Authorization: Basic ". Globals::$token ."=",
            "cache-control: no-cache",
            "content-type: application/json",
            "Postman-Token: ". Globals::$postmantoken
        ),      
        ));
    
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
    
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }       
    }

    function actualizarSubTarea($id_subTask, $title_subTask){
        //$this->id_scheduled_task, $title_subTask
            $cadenaRapida = "{ \"jsonrpc\": \"2.0\", \"method\": \"updateSubtask\", \"id\": 2041554661, \"params\": {  \"id\":" . $id_subTask . ", \"task_id\":" . $this->id . ", \"title\": \"" . $title_subTask . "\" } }";
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => Globals::$jsonrpcURL,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $cadenaRapida,
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Basic ". Globals::$token ."=",
                    "cache-control: no-cache",
                    "content-type: application/json",
                    "Postman-Token: ". Globals::$postmantoken
                ),
            ));
        
            $response = curl_exec($curl);
            $err = curl_error($curl);
    
            curl_close($curl);
        
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                echo $response;
            }       
        }
    
    function addFilesToTask($id_project, $id_task, $name,$image_file_base64){
    
        // $cadenaRapida = "{ \"jsonrpc\": \"2.0\", \"method\": \"createSubtask\", \"id\": 2041554661, \"params\": { \"task_id\":" . $id_scheduled_task . ", \"title\": \"" . $title . "\" } }";
        $cadenaRapida = "{ \"jsonrpc\": \"2.0\", \"method\": \"createTaskFile\", \"id\": 94500810, \"params\": [" . $id_project . ", " . $id_task . ", \"" . $name . "\", \"" . $image_file_base64 . "\"]}";
        $curl = curl_init();
        // echo "El id del project es: ".$id_project;
        curl_setopt_array($curl, array(
            CURLOPT_URL => Globals::$jsonrpcURL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $cadenaRapida,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic ". Globals::$token ."=",
                "cache-control: no-cache",
                "content-type: application/json",
                "Postman-Token: ". Globals::$postmantoken
            ),      
        ));
    
        $response = curl_exec($curl);
        $err = curl_error($curl);
    
        curl_close($curl);
    
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }


}

?>




