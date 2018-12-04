<?php
try {
    //date_started sin convertir: 2018-02-10T12:59
    //date_started debe tener el siguiente formato: 02/10/2018 19:43  || mes/dia/año hora:min       
    $t_started = date("m/d/Y H:i", strtotime('04/12/2018 10:50'));

    //date_due debe tener el siguiente formato: 2018-02-10 15:53  || año-mes-dia hora:min
    //$t_due = ($this->date_due);
    // $t_due = str_replace('/', '-', $t_due);
    //$t_due = str_replace('T', ' ', $t_due);

    $task = new stdClass();
    $detalleTask = new stdClass();

    $detalleTask->owner_id = '14';
    $detalleTask->creator_id = '14';
    $detalleTask->description = 'Prueba de concepto OPCon';
    $detalleTask->category_id = 0;
    $detalleTask->score = 0;
    $detalleTask->title =  'OpCon';
    $detalleTask->project_id = '15';
    $detalleTask->color_id = "yellow";
    //$detalleTask->date_due = $t_due;
    //$detalleTask->date_started = $t_started;
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
        echo "cURL Error #:" . $err;
    } else {
        echo "Resumen de tarea: ".$response;
    }
    //
    // if (($this->subTask) == "1"){
    //     foreach (($this->subtask_des) as $subT) {
    //         $this->crearSubTarea($subT->title);
    //     }
    // }

    // if ($this->mifile == "1"){
    //     foreach (($this->objFile) as $value2) {
    //         $this->addFilesToTask(($this->project_id), $this->id, $value2[0],$value2[1]);
    //     }
    // }
}
catch (Exception $e){
    header('HTTP/1.1 500 Internal Server XXX');
    header('Content-Type: application/json; charset=UTF-8');
    die(json_encode(array('message' => 'ERROR:' . $e, 'code' => 666)));
}

?>