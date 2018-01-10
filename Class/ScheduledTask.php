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
    $ScheduledTask= new ScheduledTask();
    switch($_POST["action"]){       
        case "LoadAll":
            //echo json_encode($visitante->CargarTodos());
            break;
        case "Load": // carga visitante por cedula
            //echo json_encode($visitante->Cargar($_POST["cedula"]));
            break; 
        case "LoadScheduledTask": 
            echo json_encode($ScheduledTask->LoadScheduledTask());
            break;        
        case "Insert":
            $ScheduledTask->projectid= $_POST["projectid"];
            $ScheduledTask->title= $_POST["title"];
            $ScheduledTask->description= $_POST["description"];
            $ScheduledTask->minute= $_POST["minute"];
            $ScheduledTask->hour= $_POST["hour"];
            $ScheduledTask->dom= $_POST["dom"];
            $ScheduledTask->year= $_POST["year"];
            $ScheduledTask->dow= $_POST["dow"];
            $ScheduledTask->subTask= $_POST["subTask"];
            $ScheduledTask->subtask_des= $_POST["subtask_des"];
            // $ScheduledTask->file= $_POST["file"];
            // $ScheduledTask->objFile= json_decode($_POST['objFile']);
            $ScheduledTask->Insert();
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
            $ScheduledTask->id= $_POST["idScheduledTask"];            
            $ScheduledTask->Delete();
            break;     
            case "GetByUserID":
            echo json_encode($ScheduledTask->GetByUserID());
            break;   
        // case "Insert_Sub_Task_Image":
        //     $ScheduledTask->Insert_Sub_Task_Image();
        //     break;    
    }
}
    
class ScheduledTask{
    public $id='';
    public $send_id=123;
    public $title;
    public $description;
    public $minute;
    public $hour;
    public $dom;
    public $year;
    public $dow;
    public $subTask;
    public $subtask_des;
    public $project_id;
    public $column_id; 
    public $idTask;  
    // $file $objFile no sirven estando aqui Preguntar
    // public $file;  
    // public $objFile;  

    //
    // Funciones de Mantenimiento.
    //

    function GetByUserID(){
        try {
           /* $sql='SELECT p.id, p.name, u.role
                FROM kanboard.projects p INNER JOIN kanboard.project_has_users u on p.id=u.project_id
                    INNER JOIN kanboard.project_has_group g on p.id=g.project_id
                where u.user_id=:userid';*/
            


            $sql= 'SELECT distinct(p.id), p.name
                FROM kanboard.projects p  
                INNER JOIN  kanboard.project_has_users u on p.id=u.project_id             
                LEFT JOIN  kanboard.project_has_groups g on p.id=g.project_id             
                INNER JOIN  kanboard.group_has_users  gu  on u.user_id=gu.user_id
                WHERE p.id is not null or g.project_id is not null or gu.user_id is not null or u.project_id is not null AND u.user_id=:userid';
            $param= array(':userid'=>$_SESSION["userid"]);
            $data= DATA::Ejecutar($sql,$param);
            return $data;
        }     
        catch(Exception $e) {
            //log::AddD('FATAL', 'Ha ocurrido un error al realizar el GetByUserID', $e->getMessage());
            //$_SESSION['errmsg']= $e->getMessage();
            header('Location: ../Error.php');       
            exit;
        }
    }
    
    function Insert(){
        try {     
            $file= $_POST["file"];
            echo $file;

            $sql='INSERT INTO scheduled_task (user_id, min, hour, dom, year, dow, title, detail, file, sub_task, project_id, column_id) VALUES (:user_id, :min, :hour, :dom, :year, :dow, :title, :description, :file, :subTask, :projectid, (Select id from columns where title="En Espera" and project_id=:projectid))';
            $param= array(':user_id'=>$_SESSION["userid"],':min'=>$this->minute, ':hour'=>$this->hour, ':dom'=>$this->dom, ':year'=>$this->year, ':dow'=>$this->dow, ':title'=>$this->title, ':description'=>$this->description, ':file'=>$file, ':subTask'=>$this->subTask, ':projectid'=>$this->projectid);        
            $data = DATA::Ejecutar($sql,$param);

            $data_sub_Task = json_decode($_POST['subtask_des']);

            $objFile= json_decode($_POST['objFile']);
            //echo var_dump($data2);
            // if (count($data) ) {
            //     $this->idrol= $data[0]['idrol'];
            //     // log::Add('INFO', 'Inicio de sesión: '. $this->usuario);
            //     return true;
            // }else {        
            //     return false;           
            // }  
            // $sql2='UPDATE scheduled_sub_task SET title=":esuno" WHERE id=12;';
            // $param= array(':esuno'=>$this->subTask);
            // $last_id = DATA::Ejecutar($sql2,$param);
           
            if ($subTask == '1'){
                $sql='select last_insert_id();';
                $last_id = DATA::Ejecutar($sql);
                $id_task = $last_id[0]["last_insert_id()"];

                foreach($data_sub_Task as $var1)
                {
                    ///echo $var1 ." ";
                    $sql='insert into kanboard.scheduled_sub_task (id_scheduled_task, title) values (:id_scheduled_task, :subtask_des);';
                    $param= array(':id_scheduled_task'=>$id_task, ':subtask_des'=> $var1);
                    $data = DATA::Ejecutar($sql,$param);  
                }                                     
            }

            if ($file == '1'){  
                //saco el numero de elementos
                $longitud = count($objFile)-1; 
                echo "Longitud: ".$longitud;  
                for ($i=0; $i<=$longitud; $i++){ 
                  
                    //echo $img_data;
                    $sql='insert into scheduled_task_has_files (scheduled_task_id, name, image_file_base64) VALUES (:id_task, :nombre, :base64);';
                    $param= array(':id_task'=>$id_task, ':nombre'=>$objFile[$i][0], ':base64'=>$objFile[$i][1]);
                    $data = DATA::Ejecutar($sql,$param);  
                }
            }elseif ($file == '0') {
                echo "sin archivos";
            }
        }     
        catch(Exception $e) {
            log::AddD('FATAL', 'Ha ocurrido un error al realizar la Entrada del Visitante', $e->getMessage());
            header('Location: ../Error.php?w=conectar&id='.$e->getMessage());
            exit;
        }

    }

    //Carga en $data el resultado de las tareas programadas asignadas al usuario logeado
    function LoadScheduledTask(){
        try {
            $sql='SELECT ST.id, US.username, ST.min, ST.hour, ST.dom, ST.year, ST.dow, ST.title, ST.detail 
            FROM scheduled_task as ST
            inner Join users as US on ST.user_id = US.id';
            //$sql='SELECT id, user_id, min, hour, dom, year, dow, title, detail 
                // FROM kanboard.scheduled_task
                // where user_id = :userid';
            //$param= array(':userid'=>$_SESSION["username"]);
            //$param= array(':userid'=>7);
            //$param= array(':userid'=>$_SESSION["userid"]);
            $data= DATA::Ejecutar($sql);
            //$data= DATA::Ejecutar($sql);
            return $data;
        }     
        catch(Exception $e) {            
            //log::AddD('FATAL', 'Ha ocurrido un error al realizar la carga de datos', $e->getMessage());
            //$_SESSION['errmsg']= $e->getMessage();
            header('Location: ../Error.php');            
            exit;
        }
    }


function Delete(){
    try {
        $sql='delete from kanboard.scheduled_sub_task where id_scheduled_task = :id_scheduled_task';
        $param= array(':id_scheduled_task'=>$id);
        $data= DATA::Ejecutar($sql);
        return $data;
    }     
    catch(Exception $e) {            
        //log::AddD('FATAL', 'Ha ocurrido un error al realizar la carga de datos', $e->getMessage());
        //$_SESSION['errmsg']= $e->getMessage();
        header('Location: ../Error.php');            
        exit;
    }
}


function Insert_Sub_Task_Image(){
    try {
        $curl = curl_init();
        
        //$data2 = "{ \"jsonrpc\": \"2.0\", \"method\": \"createTaskFile\", \"id\": " . $this->send_id . ", \"params\": {11, 1784, "My file", cGxhaW4gdGV4dCBmaWxl} }";
        
        $data = array('jsonrpc' => '2.0',
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
        );
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


}

?>