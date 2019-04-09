<?php
 try{
            //date_started sin convertir: 2018-02-10T12:59
            //date_started debe tener el siguiente formato: 02/10/2018 19:43  || mes/dia/año hora:min       
            //$t_started = date("m/d/Y H:i", strtotime($this->date_started));

            //date_due debe tener el siguiente formato: 2018-02-10 15:53  || año-mes-dia hora:min
            //$t_due = ($this->date_due);
            // $t_due = str_replace('/', '-', $t_due);
            //$t_due = str_replace('T', ' ', $t_due);
            error_log("[NAGIOS] iniciando");
            $task = new stdClass();
            $detalleTask = new stdClass();

            $detalleTask->owner_id = 14;
            $detalleTask->creator_id = 14;
            $detalleTask->description = 'prueba de ejecución NAGIOS';
            $detalleTask->category_id = 0;
            $detalleTask->score = 0;
            $detalleTask->title =  'Hello NAGIOS!';
            $detalleTask->project_id = 18;
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
                "Authorization: Basic anNvbnJwYzo2ZmZhNWVmMzczM2U5YzBiOGJhMDA2ZmI5ODkzMzFhOTRiOWU4NzRkYTk5OWYwZjhkNzJmMTljMzNkZjg=",
                "cache-control: no-cache",
                "content-type: application/json",
                "Postman-Token: 1ec2b092-199a-ee41-b698-37096a6c36f7"
            ),        
            
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            $this->id =json_decode($response)->result;
            curl_close($curl);
            //
            if ($err) {
                echo "cURL Error #:" . $err;
                error_log("[NAGIOS] ".$err);
            } else {
                echo "Resumen de tarea: ".$response;
                error_log("[NAGIOS] ok");
                error_log("[NAGIOS] ".$response);
            }
        }
        catch (Exception $e){
            error_log("[NAGIOS] exception: ". $e->getMessage() );
            /*header('HTTP/1.1 500 Internal Server XXX');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode(array('message' => 'ERROR:' . $e, 'code' => 666)));*/
        }
?>