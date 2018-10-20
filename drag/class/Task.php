<?php
if (!isset($_SESSION))
session_start();
require_once('../../class/globals.php');
require_once("../../class/conexion.php");
require_once("../../class/Log.php");

function __construct(){
require_once("../../class/conexion.php");
require_once("../../class/Log.php");
}

Globals::ConfiguracionIni();
if(isset($_POST["action"])){
    $task= new Task();
    switch($_POST["action"]){       
        case "LoadColumns": 
            echo json_encode($task->LoadColumns());
            break;
        case "LoadTask": 
            echo json_encode($task->LoadTask());
            break; 
    }
}

class Task{
    public $id;
    public $title;


    function LoadColumns(){
        try {
            $sql='SELECT position, title
            FROM columns 
            WHERE project_id = :project_id
            ORDER BY position ASC;';   

            $param= array(':project_id'=>17);
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
            $sql='SELECT t.id, t.title, t.date_creation, c.position
            FROM kanboard.tasks as t
            INNER JOIN columns as c ON t.column_id = c.id
            where c.project_id = :project_id and t.is_active =1;';   

            $param= array(':project_id'=>17);
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
}

?>