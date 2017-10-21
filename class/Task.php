<?php
if (!isset($_SESSION))
    session_start();
require_once('Globals.php');
Globals::ConfiguracionIni();
if(isset($_POST["action"])){
    $task= new Task();
    switch($_POST["action"]){       
        case "LoadAll":
            //echo json_encode($visitante->CargarTodos());
            break;
        case "Load": // carga visitante por cedula
            //echo json_encode($visitante->Cargar($_POST["cedula"]));
            break;        
        case "Insert":
            $task->title= $_POST["title"];
            $task->description= $_POST["description"];
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
    public $send_id=123;
    public $title;
    public $description;
    public $project_id = 11;
    public $column_id = 42;   

    //
    // Funciones de Mantenimiento.
    //
    function Insert(){
        try {
            $curl = curl_init();
            
            $data = "{ \"jsonrpc\": \"2.0\", \"method\": \"createTask\", \"id\": " . $this->send_id . ", \"params\": { \"owner_id\": 1, \"creator_id\": 0, 
                \"date_due\": \"\", \"description\": \"" . $this->description . "\", \"category_id\": 0, \"score\": 0, \"title\": \"" . $this->title .  "\", \"project_id\": " . $this->project_id . 
                ", \"color_id\": \"green\", \"column_id\": " . $this->column_id . ", \"recurrence_status\": 0, \"recurrence_trigger\": 0, \"recurrence_factor\": 0, \"recurrence_timeframe\": 0, \"recurrence_basedate\": 0 } }";
            
            $data2 = array('jsonrpc' => '2.0',
                'method'=> 'createTask',
                'id'=>$this->send_id,
                'params'=> $params=array(
                    'owner_id'=>'1',
                    'creator_id'=>0,
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
            log::AddD('FATAL', 'Ha ocurrido un error al realizar la Entrada del Visitante', $e->getMessage());
            header('Location: ../Error.php?w=conectar&id='.$e->getMessage());
            exit;
        }
    }
}

?>