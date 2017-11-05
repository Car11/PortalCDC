<?php
if (!isset($_SESSION))
    session_start();
//require_once('Globals.php');
//Globals::ConfiguracionIni();
if(isset($_POST["action"])){
    $Project= new Project();
    switch($_POST["action"]){       
        case "GetByUserID":
            echo json_encode($Project->GetByUserID());
            break;
        case "Load": // carga visitante por cedula
            //echo json_encode($Project->Cargar($_POST["cedula"]));
            break;        
        case "Insert":
            /*$Project->title= $_POST["title"];
            $Project->description= $_POST["description"];
            $Project->Insert();*/
            break;
        case "Update":
            /*$Project->ID= $_POST["idvisitante"];
            $Project->cedula= $_POST["cedula"];
            $Project->nombre= $_POST["nombre"];
            $Project->empresa= $_POST["empresa"];
            $Project->permisoanual= $_POST["permiso"];
            $Project->Modificar();*/
            break;
        case "Delete":
            /*$Project->ID= $_POST["idvisitante"];            
            $Project->Eliminar();*/
            break;        
    }
}
    
class Project{
    public $id='';
    public $name;
    public $role;
    public $description;
    public $default_column_id = 42;   

    function __construct(){
        require_once("Conexion.php");
        require_once("Log.php");
    }
    
    function GetByUserID(){
        try {
            $sql='SELECT p.id, p.name, u.role
                FROM kanboard.projects p INNER JOIN kanboard.project_has_users u on p.id=u.project_id
                where u.user_id=:userid';
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

    //
    // Funciones de Mantenimiento.
    //
}

?>