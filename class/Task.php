<?php
if (!isset($_SESSION))
    session_start();
require_once('Globals.php');
Globals::ConfiguracionIni();

if(isset($_POST["action"])){
    $task= new Task();
    switch($_POST["action"]){
        case "serverDatetime":
            $date = date_create(); 
            echo $date->format("c");
            exit;
            break;
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
        case "LoadTaskByName": 
            echo json_encode($task->LoadTaskByName());
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
        case "DeleteSubTask":
            $task->id=$_POST["idSubTask"];
            $task->DeleteSubTask();
            break;
            
    }
}

class Task{
    public $id='';
    public $send_id=123;   // definir que es este dato.
    public $title;
    public $description;
    public $project_id='18'; //17 des-cer; 18 prd.
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
        require_once("conexion.php");
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

            $param= array(':project_id'=>$this->project_id);
            $data= DATA::Ejecutar($sql,$param);
            return $data;
        }     
        catch(Exception $e) {            
            error_log($e->getMessage());
            header('HTTP/1.0 400 Bad error');
            die(json_encode(array(
                'code' => $e->getCode() ,
                'msg' => 'Error al cargar'))
            );
        }
    }

    function LoadTask(){
        try {            
            $sql='SELECT  id, title, date_started, position FROM (
                SELECT group_id FROM group_has_users WHERE user_id = :userid) as GU
                INNER JOIN 
                (SELECT group_id, user_id FROM group_has_users) as U
                ON GU.group_id = U.group_id
                INNER JOIN
                (SELECT t.id, t.title, t.creator_id, t.date_started, c.position 
                FROM kanboard.tasks as t
                    INNER JOIN columns as c ON t.column_id = c.id where t.is_active =1
                    order by t.id desc
                ) AS T
                ON T.creator_id = user_id GROUP BY id ORDER BY date_started asc;'; 
            $param= array(':userid'=>$_SESSION["userid"]);
            $data= DATA::Ejecutar($sql,$param);
            return $data;
        }     
        catch(Exception $e) {            
            error_log($e->getMessage());
            header('HTTP/1.0 400 Bad error');
            die(json_encode(array(
                'code' => $e->getCode() ,
                'msg' => 'Error al cargar'))
            );
        }
    }

    function LoadTaskByName(){
        try {            
            $sql='SELECT  id, title, date_creation, position FROM (
                SELECT group_id FROM group_has_users WHERE user_id = :userid) as GU
                INNER JOIN 
                (SELECT group_id, user_id FROM group_has_users) as U
                ON GU.group_id = U.group_id
                INNER JOIN
                (SELECT t.id, t.title, t.creator_id, t.date_creation, c.position 
                FROM kanboard.tasks as t
                    INNER JOIN columns as c ON t.column_id = c.id where c.project_id = :project_id
                    order by t.id desc
                ) AS T
                ON T.creator_id = user_id GROUP BY id;'; 
            $param= array(':project_id'=>18, ':userid'=>$_SESSION["userid"]);
            $data= DATA::Ejecutar($sql,$param);
            return $data;
        }     
        catch(Exception $e) {            
            error_log($e->getMessage());
            header('HTTP/1.0 400 Bad error');
            die(json_encode(array(
                'code' => $e->getCode() ,
                'msg' => 'Error al cargar'))
            );
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
            error_log($e->getMessage());
            header('HTTP/1.0 400 Bad error');
            die(json_encode(array(
                'code' => $e->getCode() ,
                'msg' => 'Error al cargar'))
            );
        }
    }

    function LoadTaskFiles(){
        try {
            $sql='SELECT id, name, date 
                FROM task_has_files
                where TASK_ID= :taskId
                ORDER BY name ';
            $param= array(':taskId'=>$this->id);
            $data= DATA::Ejecutar($sql,$param);
            return $data;
        }     
        catch(Exception $e) {
            error_log($e->getMessage());
            header('HTTP/1.0 400 Bad error');
            die(json_encode(array(
                'code' => $e->getCode() ,
                'msg' => 'Error al cargar'))
            );
        }
    }

    function DeleteAttachment(){
        try {
            $curl = curl_init();  
            $task = new stdClass();         
            $task->jsonrpc = "2.0";
            $task->method = "removeTaskFile";
            $task->id = $this->idFile;
            $task->params = array($this->idFile);
            
            curl_setopt_array($curl, array(
                CURLOPT_URL => Globals::$jsonrpcURL,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS =>  json_encode($task),
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
            error_log($e->getMessage());
            header('HTTP/1.0 400 Bad error');
            die(json_encode(array(
                'code' => $e->getCode() ,
                'msg' => 'Error al cargar'))
            );
        }
    }

    // descarga adjunto.
    function DownloadTaskFile(){
        try {
            $curl = curl_init();     
                        
            $task = new stdClass();         
            $task->jsonrpc = "2.0";
            $task->method = "downloadTaskFile";
            $task->id = $this->idFile;
            $task->params = array($this->idFile);

            curl_setopt_array($curl, array(
                CURLOPT_URL => Globals::$jsonrpcURL,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($task),
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
            error_log($e->getMessage());
            header('HTTP/1.0 400 Bad error');
            die(json_encode(array(
                'code' => $e->getCode() ,
                'msg' => 'Error al cargar'))
            );
        }
    }

    function LoadTasksByUser(){
        try {
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
            error_log($e->getMessage());
            header('HTTP/1.0 400 Bad error');
            die(json_encode(array(
                'code' => $e->getCode() ,
                'msg' => 'Error al cargar'))
            );
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
            error_log($e->getMessage());
            header('HTTP/1.0 400 Bad error');
            die(json_encode(array(
                'code' => $e->getCode() ,
                'msg' => 'Error al cargar'))
            );
        }
    }

    function Update(){
        try{
            // valida la sesión del usuario antes del insert.
            require_once("Sesion.php");
            $sesion = new Sesion();
            $sesion->isLogin();
            $t_started = date("Y-m-d H:i", strtotime($this->date_started));
            $t_due = date("Y-m-d H:i", strtotime($this->date_due));

            $task = new stdClass();
            $detalleTask = new stdClass();

            $detalleTask->id = $this->id;
            $detalleTask->owner_id = $this->creator_id;
            $detalleTask->creator_id = $this->creator_id;
            $detalleTask->description = $this->description;
            $detalleTask->category_id = 0;
            $detalleTask->score = 0;
            $detalleTask->title =  $this->title;
            $detalleTask->project_id = $this->project_id;
            $detalleTask->color_id = "yellow";
            $detalleTask->date_due = $t_due;
            $detalleTask->date_started = $t_started;
            $detalleTask->recurrence_status = 0;
            $detalleTask->recurrence_trigger = 0;
            $detalleTask->recurrence_factor = 0;
            $detalleTask->recurrence_timeframe = 0;
            $detalleTask->recurrence_basedate = 0;

            $task->jsonrpc = "2.0";
            $task->method = "updateTask";
            $task->id = "10";
            $task->params = $detalleTask;
            
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => Globals::$jsonrpcURL,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($task),
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
            echo $response;
        }
        catch(Exception $e){}
    }

    function Insert(){
        try {
            // valida la sesión del usuario antes del insert.
            require_once("Sesion.php");
            $sesion = new Sesion();
            $sesion->isLogin();
            if($this->date_started == "")
                $t_started = null;
            else $t_started = date("Y-m-d H:i", strtotime($this->date_started));
            if($this->date_due == "")
                $t_due = null;
            else $t_due = date("Y-m-d H:i", strtotime($this->date_due));
            $task = new stdClass();
            $detalleTask = new stdClass();
            //
            $detalleTask->owner_id = $this->creator_id;
            $detalleTask->creator_id = $this->creator_id;
            $detalleTask->description = $this->description;
            $detalleTask->category_id = 0;
            $detalleTask->score = 0;
            $detalleTask->title =  $this->title;
            $detalleTask->project_id = $this->project_id;
            $detalleTask->color_id = "yellow";
            $detalleTask->date_due = $t_due;
            $detalleTask->date_started = $t_started;
            $detalleTask->recurrence_status = 0;
            $detalleTask->recurrence_trigger = 0;
            $detalleTask->recurrence_factor = 0;
            $detalleTask->recurrence_timeframe = 0;
            $detalleTask->recurrence_basedate = 0;

            $task->jsonrpc = "2.0";
            $task->method = "createTask";
            $task->id = "10";
            $task->params = $detalleTask;


            $curl = curl_init();
            
            curl_setopt_array($curl, array(
            CURLOPT_URL => Globals::$jsonrpcURL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($task),
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic ". Globals::$token ."=",
                "cache-control: no-cache",
                "content-type: application/json",
                "Postman-Token: ". Globals::$postmantoken
            ),        
            
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            $this->id =json_decode($response)->result;
            curl_close($curl);
            //
            if ($err) {
                return $err;
            } 
            //
            if (($this->subTask) == "1"){
                foreach (($this->subtask_des) as $subT) {
                    if($subT->title!=='')
                        $this->crearSubTarea($subT->title);
                }
            }
            //
            if ($this->mifile == "1"){
                foreach (($this->objFile) as $value2) {

                    $this->addFilesToTask(($this->project_id), $this->id, $value2[0],$value2[1]);
                }
            }
            echo $response;
            
        }
        catch (Exception $e){
            header('HTTP/1.1 500 Internal Server XXX');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => 'ERROR:' . $e, 'code' => 666)));
        }
    
    }

    function crearSubTarea($title_subTask){
        $task = new stdClass();
        $detalleTask = new stdClass();

        $detalleTask->task_id = $this->id;        
        $detalleTask->title = $title_subTask;

        $task->jsonrpc = "2.0";
        $task->method = "createSubtask";
        $task->id = "10";
        $task->params = $detalleTask;
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => Globals::$jsonrpcURL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($task),
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
            echo $err;
        }       
    }

    function actualizarSubTarea($id_subTask, $title_subTask){


        $task = new stdClass();
        $detalleTask = new stdClass();

        $detalleTask->id = $id_subTask;        
        $detalleTask->task_id = $this->id;
        $detalleTask->title = $title_subTask;

        $task->jsonrpc = "2.0";
        $task->method = "updateSubtask";
        $task->id = "10";
        $task->params = $detalleTask;
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => Globals::$jsonrpcURL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($task),
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

    function DeleteSubTask(){

        $task = new stdClass();
        $detalleTask = new stdClass();

        $detalleTask->subtask_id = $this->id;        

        $task->jsonrpc = "2.0";
        $task->method = "removeSubtask";
        $task->id = "10";
        $task->params = $detalleTask;
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => Globals::$jsonrpcURL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($task),
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

        $task = new stdClass();
        $detalleTask = new stdClass();

        $detalleTask->subtask_id = $this->id;        

        $task->jsonrpc = "2.0";
        $task->method = "createTaskFile";
        $task->id = "10";
        $task->params = array($id_project, $id_task, $name, $image_file_base64);     
    
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
            CURLOPT_POSTFIELDS => json_encode($task),
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
            echo $err;
        }
    }
}
?>




