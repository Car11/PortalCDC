<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <title>Cron Task</title>
    </head>
    <body>
        <h1>Cron Task</h1>
        <?php
        // Datos de la base de datos
        //PRODUCCION
        $usuario = "operti";
        $password = "b7F3sW7P*8g-4b_e";
        $servidor = "10.3.2.197";
        $basededatos = "kanboard";
        $jsonRPC = "http://" . $servidor . "/kanboard/jsonrpc.php";
        $authorization = "anNvbnJwYzo2ZmZhNWVmMzczM2U5YzBiOGJhMDA2ZmI5ODkzMzFhOTRiOWU4NzRkYTk5OWYwZjhkNzJmMTljMzNkZjg";


        // Datos de la base de datos
        //DESARROLLO
        // $usuario = "operti";
        // $password = "SanPedro1";
        // $servidor = "10.3.2.156";
        // $basededatos = "kanboard";
        // $jsonRPC = "http://". $servidor ."/kanboard/jsonrpc.php";
        // $authorization = "anNvbnJwYzo2ZmZhNWVmMzczM2U5YzBiOGJhMDA2ZmI5ODkzMzFhOTRiOWU4NzRkYTk5OWYwZjhkNzJmMTljMzNkZjg";
       


        // creación de la conexión a la base de datos con mysql_connect()
        $conexion = mysqli_connect( $servidor, $usuario, $password ) or die ("No se ha podido conectar al servidor de Base de datos");
        
        mysqli_set_charset($conexion,"utf8");
        
        // Selección del a base de datos a utilizar
        $db = mysqli_select_db( $conexion, $basededatos ) or die ( "Upps! Pues va a ser que no se ha podido conectar a la base de datos" );
        // establecer y realizar consulta. guardamos en variable.
        $consulta = "SELECT * FROM scheduled_task WHERE (scheduled_task.min = (select Date_format(now(),'%i')) or 
                        scheduled_task.min = 't') and (scheduled_task.hour = (select Date_format(now(),'%H')) or 
                        scheduled_task.hour = 't') and (scheduled_task.dom = (select Date_format(now(),'%d')) or 
                        scheduled_task.dom = 't') and (scheduled_task.year = (select Date_format(now(),'%Y')) or 
                        scheduled_task.year = 't') and (scheduled_task.dow = (select Date_format(now(),'%w')) or 
                        scheduled_task.dow = 't');";

        $resultado = mysqli_query( $conexion, $consulta ) or die ( "Algo ha ido mal en la consulta a la base de datos");
        // Motrar el resultado de los registro de la base de datos
        // Encabezado de la tabla

        echo "<table borde='2'>";
        echo "<tr>";
        echo "<th>ID</th>";
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
        while ($columna = mysqli_fetch_array( $resultado ))
        {
            echo "<tr>";
            echo "<td>" . $columna['id'] . "</td><td>" . $columna['user_id'] . "</td><td>" . $columna['min'] . "</td><td>" . $columna['hour'] . "</td><td>" . $columna['dom'] . "</td><td>" . $columna['year'] . "</td><td>" . $columna['dow'] . "</td><td>" . $columna['title'] . "</td><td>" . $columna['detail'] . "</td><td>" . $columna['file'] ."</td><td>" . $columna['sub_task'] . "</td><td>" . $columna['project_id'] . "</td><td>" . $columna['column_id'] . "</td>";

            echo "</tr>";
            crearTarea($columna['id'], $columna['user_id'], $columna['title'], $columna['detail'], $columna['file'],  $columna['sub_task'], $columna['project_id'], $columna['column_id']);
        }

        echo "</table>"; // Fin de la tabla
        // cerrar conexión de base de datos
        mysqli_close( $conexion );
        
        
        function crearTarea($id, $user_id, $title, $detail, $file, $subTask, $project_id, $column_id)
        {
            $curl = curl_init();
            global $jsonRPC;
            global $authorization;




            $task = new stdClass();
            $detalleTask = new stdClass();

            $detalleTask->owner_id = $user_id;
            $detalleTask->creator_id = 0;
            $detalleTask->description = $detail;
            $detalleTask->category_id = 0;
            $detalleTask->score = 0;
            $detalleTask->title =  $title;
            $detalleTask->project_id = $project_id;
            $detalleTask->color_id = "green";
            // $detalleTask->column_id = $column_id;
            // $detalleTask->date_started = $t_started;
            $detalleTask->recurrence_status = 0;
            $detalleTask->recurrence_trigger = 0;
            $detalleTask->recurrence_factor = 0;
            $detalleTask->recurrence_timeframe = 0;
            $detalleTask->recurrence_basedate = 0;

            $task->jsonrpc = "2.0";
            $task->method = "createTask";
            $task->id = $id;
            $task->params = $detalleTask;

            curl_setopt_array($curl, array(
                CURLOPT_URL => $jsonRPC,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($task),
                CURLOPT_HTTPHEADER => array(
                "authorization: Basic " . $authorization ."=",
                "cache-control: no-cache",
                "content-type: application/json",
                "postman-token: 6f7211a7-99df-f951-788c-3274e311bb7c"
                    ),
                )
            );

            $response = curl_exec($curl);
            $err = curl_error($curl);
            
            $id_new_task = json_decode($response)->result;

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                    echo "Resumen de tarea: ".$response;
                }

            if ($subTask == "1"){
                global $servidor, $usuario, $password, $basededatos;
                $conexion = mysqli_connect( $servidor, $usuario, $password ) or die ("No se ha podido conectar al servidor de Base de datos");
                $db = mysqli_select_db( $conexion, $basededatos ) or die ( "Upps! Pues va a ser que no se ha podido conectar a la base de datos" );
                $consulta = "SELECT * FROM scheduled_sub_task WHERE id_scheduled_task = " . $id . ";";
                $resultado = mysqli_query( $conexion, $consulta ) or die ( "Algo ha ido mal en la consulta a la base de datos");

                echo "El ID DE SCHEDULED_TASK ES: ".$id;
                while ($columna = mysqli_fetch_array( $resultado ))
                {
                    crearSubTarea($id_new_task, $columna['title']);
                }
                mysqli_close( $conexion );
            }

            if ($file == "1"){
                global $servidor, $usuario, $password, $basededatos;
                $conexion = mysqli_connect( $servidor, $usuario, $password ) or die ("No se ha podido conectar al servidor de Base de datos");
                $db = mysqli_select_db( $conexion, $basededatos ) or die ( "Upps! Pues va a ser que no se ha podido conectar a la base de datos" );
                $consulta = "SELECT name, image_file_base64 FROM kanboard.scheduled_task_has_files where scheduled_task_id = " . $id . ";";
                $resultado = mysqli_query( $conexion, $consulta ) or die ( "Algo ha ido mal en la consulta a la base de datos");

                echo "Existen Archivos para la tarea programda: ".$id;
                while ($columna = mysqli_fetch_array( $resultado ))
                {
                    addFilesToTask($project_id, $id_new_task, $columna['name'],$columna['image_file_base64']);
                }
                mysqli_close( $conexion );
            }


        }
        
        function crearSubTarea($id_scheduled_task, $title){
                    
            global $jsonRPC;
            global $authorization;


            $objSubTask = new stdClass();

            $detalleSubTask->task_id = $id_scheduled_task;
            $detalleSubTask->title = $title;

            $objSubTask->jsonrpc = "2.0";
            $objSubTask->method = "createSubtask";
            $objSubTask->id = "2041554661";
            $objSubTask->params = $detalleSubTask;

            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $jsonRPC,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            // CURLOPT_POSTFIELDS => $cadenaRapida,
            CURLOPT_POSTFIELDS => json_encode($objSubTask),
            CURLOPT_HTTPHEADER => array(
                "authorization: Basic " . $authorization ."=",
                "cache-control: no-cache",
                "content-type: application/json",
                "postman-token: 7d6ecbd4-b715-9c90-38c1-ab559f5e1409"
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
            
            global $jsonRPC;
            global $authorization;
            // $cadenaRapida = "{ \"jsonrpc\": \"2.0\", \"method\": \"createSubtask\", \"id\": 2041554661, \"params\": { \"task_id\":" . $id_scheduled_task . ", \"title\": \"" . $title . "\" } }";
            $cadenaRapida = "{ \"jsonrpc\": \"2.0\", \"method\": \"createTaskFile\", \"id\": 94500810, \"params\": [" . $id_project . ", " . $id_task . ", \"" . $name . "\", \"" . $image_file_base64 . "\"]}";
            $curl = curl_init();
            echo "El id del project es: ".$id_project;
            curl_setopt_array($curl, array(
              CURLOPT_URL => $jsonRPC,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => $cadenaRapida,
              CURLOPT_HTTPHEADER => array(
                "authorization: Basic " . $authorization ."=",
                "cache-control: no-cache",
                "content-type: application/json",
                "postman-token: b2622d57-2e34-5c8c-d880-c76cb15672c1"
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


        ?>    
    </body>
</html>
        
        
        
