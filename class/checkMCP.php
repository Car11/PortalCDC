<?php
$url = "http://spe-soportedes:88/alertas_mcp";

$c = curl_init($url);
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($c);
curl_close($c);
 
// $response = '[{"activo":true,"criticidad":1,"objeto":"671","objeto2":"(EMCUSER) (EMCUSER)WRITEVOLUME01/CYCLE01","server":"AMIGHETI","tipo":"WAITING"}]';
$response = json_decode($response);

$MCP_task= new MCP_Task();

foreach ($response as $alert) {
    $MCP_task= new MCP_Task();
    // {"activo":true,
    // "criticidad":1,
    // "objeto":"187",
    // "objeto2":"(EMCUSER) WFL/TIMEFINDER/RESPALDO/SISIRH",
    // "server":"AMIGHETI",
    // "tipo":"WAITING"}
    
    $MCP_task->id = $alert->objeto;
    $MCP_task->title = $alert->server . " " . $alert->objeto . " " . $alert->objeto2;
    $MCP_task->project_id = 18;
    $MCP_task->validar();
}

class MCP_task{
 
    public $id;
    public $title;
    public $detail;
    public $project_id = 18; //Proyecto de Operaciones
    
    function __construct(){
        require_once("conexion.php");
        require_once("Globals.php");
        Globals::ConfiguracionIni();
    }

    function validar(){   
        $sql='SELECT t.id FROM tasks t
                INNER JOIN columns c
                ON c.id = t.column_id
                where t.title = :title
                AND t.is_active = 1
                AND c.title <> "Finalizado";';
        $param= array(':title'=>$this->title);  
        $data = DATA::Ejecutar($sql,$param);
        if ($data)
            return false;
        else        
            $this->create();
    }

    function create(){
        
        $task = new stdClass();
        $detalleTask = new stdClass();
    
        $detalleTask->title =  $this->title;
        $detalleTask->project_id = $this->project_id;
        $detalleTask->description = $this->detail;
        $detalleTask->tags = ["BOOT_GITEL"];
    
        $task->jsonrpc = "2.0";
        $task->method = "createTask";
        $task->id = $this->id;
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
            )       
        ));
        $kb_response = curl_exec($curl);
        $err = curl_error($curl);
        if($kb_response)
            $this->id = json_decode($kb_response)->result;
    
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
            return false;
        } else 
            {
            echo "Resumen de tarea: \r\n".$response;
        
        }
    }

}


?>