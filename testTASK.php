<?php
include_once('class/Globals.php');
    $id='';
    $send_id=123;
    $title="Miercoles";
    $description="Iniciando mañana";
    $project_id = 11;
    $column_id = 42;   

    //
    // Funciones de Mantenimiento.
    //
            
            $curl = curl_init();
            
            $data = "{ \"jsonrpc\": \"2.0\", \"method\": \"createTask\", \"id\": " . $send_id . ", \"params\": { \"owner_id\": 1, \"creator_id\": 0, 
                \"date_due\": \"\", \"description\": \"" . $description . "\", \"category_id\": 0, \"score\": 0, \"title\": \"" . $title .  "\", \"project_id\": " . $project_id . 
                ", \"color_id\": \"green\", \"column_id\": " . $column_id . ", \"recurrence_status\": 0, \"recurrence_trigger\": 0, \"recurrence_factor\": 0, \"recurrence_timeframe\": 0, \"recurrence_basedate\": 0 } }";
            
            $data2 = array('jsonrpc' => '2.0',
                'method'=> 'createTask',
                'id'=>$send_id,
                'params'=> $params=array(
                    'owner_id'=>'1',
                    'creator_id'=>0,
                    'date_due'=>'',
                    'description'=>$description,
                    'category_id'=>0,
                    'score'=>0,
                    'title'=>$title,
                    'project_id'=>$project_id,
                    'color_id'=>'green',
                    'column_id'=> $column_id,
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
                $id= (int)explode(":",$response)[1]; // id task
                //echo json_encode($this);
            }
        

        ?>