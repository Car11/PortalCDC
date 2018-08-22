<?php
   try {
        echo "Ejecutando...";
        //date_started debe tener el siguiente formato: 02/10/2018 19:43  || mes/dia/año hora:min       
        $t_started = date("m/d/Y H:i");
        //date_due debe tener el siguiente formato: 2018-02-10 15:53  || año-mes-dia hora:min
        $t_due = (date("m/d/Y H:i"));
        $t_due = str_replace('T', ' ', $t_due);
        //
        $cadenaRapida = "{\"jsonrpc\": \"2.0\",\"method\": \"createTask\",\"id\": \"10\",\"params\": { \"owner_id\": \"13\", \"creator_id\":\"13\", \"description\": \"" . $_GET["description"] . "\", \"category_id\": 0, \"score\": 0, \"title\": \"" . $_GET["title"] . "\", \"project_id\": \"18\", \"color_id\": \"red\", \"date_due\": \"" . $t_due . "\", \"date_started\":\"" . $t_started . "\", \"recurrence_status\": 0, \"recurrence_trigger\": 0, \"recurrence_factor\": 0,\"recurrence_timeframe\": 0, \"recurrence_basedate\": 0 } }";
        //
        $curl = curl_init();
        //
        curl_setopt_array($curl, array(
            CURLOPT_URL => http://10.129.20.177/kanboard/jsonrpc.php,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $cadenaRapida,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic anNvbnJwYzo2ZmZhNWVmMzczM2U5YzBiOGJhMDA2ZmI5ODkzMzFhOTRiOWU4NzRkYTk5OWYwZjhkNzJmMTljMzNkZjg=",
                "cache-control: no-cache",
                "content-type: application/json",
                "Postman-Token: 1ec2b092-199a-ee41-b698-37096a6c36f7"
            ),        
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        //
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo "Tarea ok: ".$response;
        }
    }
    catch (Exception $e){
        header('HTTP/1.1 500 Internal Server XXX');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'ERROR:' . $e, 'code' => 666)));
    }
?>
    
