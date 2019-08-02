<?php

    $cronTask= new CronTask();

    $cronTask->checkTask();

    class CronTask {
        public $id;  
        public $id_scheduled_task;       
        public $user_id;    
        public $min;        
        public $hour;       
        public $dom;        
        public $year;       
        public $dow;        
        public $title;      
        public $detail;     
        public $file;       
        public $sub_task;   
        public $project_id; 
        public $column_id;  
        public $user_OperTI = 13;
        
        function __construct(){

            require_once("conexion.php");
            require_once("Globals.php");
            Globals::ConfiguracionIni();

            $this->id = $obj["id"] ?? null; 
            $this->user_id = $obj["user_id"] ?? null;
            $this->min = $obj["min"] ?? null;
            $this->hour = $obj["hour"] ?? null;
            $this->dom = $obj["dom"] ?? null;
            $this->year = $obj["year"] ?? null;
            $this->dow = $obj["dow"] ?? null;
            $this->title = $obj["title"] ?? null;
            $this->detail = $obj["detail"] ?? null;
            $this->file = $obj["file"] ?? null;
            $this->sub_task = $obj["sub_task"] ?? null;
            $this->project_id = $obj["project_id"] ?? null;
            $this->column_id = $obj["column_id"] ?? null;

        }
    

        function checkTask(){
            try {
                $sql = "SELECT * FROM scheduled_task WHERE (scheduled_task.min = (select Date_format(now(),'%i')) or 
                        scheduled_task.min = 't') and (scheduled_task.hour = (select Date_format(now(),'%H')) or 
                        scheduled_task.hour = 't') and (scheduled_task.dom = (select Date_format(now(),'%d')) or 
                        scheduled_task.dom = 't') and (scheduled_task.year = (select Date_format(now(),'%Y')) or 
                        scheduled_task.year = 't') and (scheduled_task.dow = (select Date_format(now(),'%w')) or 
                        scheduled_task.dow = 't');";

                $param= array(':project_id'=>$this->project_id);
                $data= DATA::Ejecutar($sql,$param);
                if ($data){
                    $this->imprimeTabla($data);

                    foreach ($data as $task) {        
                        $this->id_scheduled_task = $task["id"] ?? null; 
                        $this->user_id = $task["user_id"] ?? null;
                        $this->min = $task["min"] ?? null;
                        $this->hour = $task["hour"] ?? null;
                        $this->dom = $task["dom"] ?? null;
                        $this->year = $task["year"] ?? null;
                        $this->dow = $task["dow"] ?? null;
                        $this->title = $task["title"] ?? null;
                        $this->detail = $task["detail"] ?? null;
                        $this->file = $task["file"] ?? null;
                        $this->sub_task = $task["sub_task"] ?? null;
                        $this->project_id = $task["project_id"] ?? null;
                        $this->column_id = $task["column_id"] ?? null;

                        $this->create();
                    }
                }
                
            }     
            catch(Exception $e) {
                error_log("[ERROR]  (".$e->getCode()."): ". $e->getMessage());
                if (!headers_sent()) {
                        header('HTTP/1.0 400 Error al leer');
                    }
                die(json_encode(array(
                    'code' => $e->getCode() ,
                    'msg' => 'Error al cargar la lista'))
                );
            }
        }

        function create(){
            $t_started = new DateTime();
            //
            $task = new stdClass();
            $detalleTask = new stdClass();

            $detalleTask->title =  $this->title;
            $detalleTask->project_id = $this->project_id;
            //optional
            $detalleTask->owner_id = $this->user_OperTI;
            $detalleTask->creator_id =  $this->user_id;
            $detalleTask->description = $this->detail;
            $detalleTask->color_id = "green";
            $detalleTask->date_started = $t_started->format("Y-m-d H:i");
            // date("Y-m-d H:i", strtotime($this->date_started));

            $task->jsonrpc = "2.0";
            $task->method = "createTask";
            $task->id = $this->id_scheduled_task;
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
            $response = curl_exec($curl);
            $err = curl_error($curl);

            $this->id = json_decode($response)->result;

            curl_close($curl);
            if ($err) {
                echo "cURL Error #:" . $err;
                return false;
            } else 
                {
                echo "Resumen de tarea: \r\n".$response;
            
            }

            if (sizeof($this->sub_task) > 0){
                $this->crearSubTarea();
            }

            if (sizeof($this->file) > 0){
                $this->addFilesToTask();
            }
            
           
        }


        function crearSubTarea(){      
            $sql = "SELECT * FROM scheduled_sub_task WHERE id_scheduled_task = :id;";

            $param= array(':id'=>$this->id_scheduled_task);
            $data= DATA::Ejecutar($sql,$param);
            if ($data){

                foreach ($data as $subTask) {        
                    
                    $objSubTask = new stdClass();
                    $detalleSubTask = new stdClass();
        
                    $detalleSubTask->task_id = $this->id;
                    $detalleSubTask->title = $subTask["title"];
            
                    $objSubTask->jsonrpc = "2.0";
                    $objSubTask->method = "createSubtask";
                    $objSubTask->id = $this->id;
                    $objSubTask->params = $detalleSubTask;
            
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => Globals::$jsonrpcURL,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => json_encode($objSubTask),
                        CURLOPT_HTTPHEADER => array(
                            "Authorization: Basic ". Globals::$token ."=",
                            "cache-control: no-cache",
                            "content-type: application/json",
                            "Postman-Token: ". Globals::$postmantoken
                        )       
                    ));
            
                    $response = curl_exec($curl);
                    $err = curl_error($curl);
            
                    curl_close($curl);
            
                    if ($err) {
                        echo "cURL Error #:" . $err;
                    } else {
                        echo "<br>";
                        echo "SubTarea: ";
                        echo $response;
                    }

                }
            }
    
        }

        function addFilesToTask(){


            $sql = "SELECT name, image_file_base64 FROM scheduled_task_has_files where scheduled_task_id = :id;";
            $param= array(':id'=>$this->id_scheduled_task);
            $data= DATA::Ejecutar($sql,$param);
            if ($data){

                foreach ($data as $subTask_file) {        
                    $objFile = new stdClass();
                    
                    $detalleFile = array( $this->project_id,
                                        $this->id,
                                        $subTask_file["name"],
                                        $subTask_file["image_file_base64"]
                                    );

                    $objFile->jsonrpc = "2.0";
                    $objFile->method = "createTaskFile";
                    $objFile->id = $this->id;
                    $objFile->params = $detalleFile;

                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => Globals::$jsonrpcURL,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => json_encode($objFile),
                        CURLOPT_HTTPHEADER => array(
                            "Authorization: Basic ". Globals::$token ."=",
                            "cache-control: no-cache",
                            "content-type: application/json",
                            "Postman-Token: ". Globals::$postmantoken
                        )       
                    ));
                    
                    $response = curl_exec($curl);
                    $err = curl_error($curl);
                    
                    curl_close($curl);
                    
                    if ($err) {
                    echo "cURL Error #:" . $err;
                    } else {
                        echo "<br>";
                        echo "Resultado de archivo: ";
                        echo $response;
                    }
                }
            }            
        }
        

        function imprimeTabla($resultado){
            // Montar el resultado de los registro de la base de datos
            // Encabezado de la tabla

            echo "<table borde='2'>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>USER_ID</th>";
            echo "<th>Min</th>";
            echo "<th>Hora</th>";
            echo "<th>DiaMes</th>";
            echo "<th>Año</th>";
            echo "<th>DiaSemana</th>";
            echo "<th>Title</th>";
            echo "<th>Detail</th>";
            echo "<th>File</th>";
            echo "<th>Sub_Task</th>";
            echo "<th>Proyect_ID</th>";
            echo "<th>Column_ID</th>";
            echo "</tr>";

            // Bucle while que recorre cada registro y muestra cada campo en la tabla.

            foreach ($resultado as $columna) {
                echo "<tr>";
                echo    "<td>" . $columna['id'] . "</td>
                        <td> <center>" . $columna['user_id'] . "</center> </td>
                        <td>" . $columna['min'] . "</td>
                        <td>" . $columna['hour'] . "</td>
                        <td>" . $columna['dom'] . "</td>
                        <td>" . $columna['year'] . "</td>
                        <td>" . $columna['dow'] . "</td>
                        <td>" . $columna['title'] . "</td>
                        <td>" . $columna['detail'] . "</td>
                        <td>" . $columna['file'] ."</td>
                        <td>" . $columna['sub_task'] . "</td>
                        <td>" . $columna['project_id'] . "</td>
                        <td>" . $columna['column_id'] . "</td>";

                echo "</tr>";
            }
            echo "</table>"; // Fin de la tabla
        }

    }
?>