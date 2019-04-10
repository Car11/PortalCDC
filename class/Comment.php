<?php
if (!isset($_SESSION))
    session_start();
if(isset($_POST["action"])){
    $comment= new Comment();
    switch($_POST["action"]){
        case "Load":
            echo json_encode($comment->Load());
            break;
        case "LoadbyTask":
            $comment->taskId=$_POST["taskId"];
            echo json_encode($comment->LoadbyTask());
            break;
        case "Insert":
            $comment->Insert();
            break;
        case "Delete":
            $comment->Delete();
            break;
    }
}
class Comment{
    public $id;
    public $taskId;   
    public $userId;
    public $username;
    public $name;
    public $reference;
    public $comment;
    public $dateCreation;
    public $dateModification;
    //
    function __construct(){
        require_once("conexion.php");
        require_once("Globals.php");
        //
        Globals::ConfiguracionIni();
        // identificador único
        if(isset($_POST["id"])){
            $this->id= $_POST["id"];
        }
        //
        if(isset($_POST["obj"])){
            $obj= json_decode($_POST["obj"],true);
            $this->id= $obj["id"] ?? null;
            $this->taskId= $obj["taskId"] ?? null;
            $this->userId= $_SESSION["userid"];   
            $this->username= $obj["username"] ?? '';
            $this->name= $obj["name"] ?? '';
            $this->reference= $obj["reference"] ?? '';
            $this->comment= $obj["comment"] ?? '';
        }
    }
    //
    function Load(){
        try {
            $sql='SELECT c.id, task_id, user_id, date_creation, comment, reference, date_modification , u.username, u.name
                FROM comments c inner join users u on u.id= c.user_id
                WHERE c.id= :id';
            $param= array(':id'=>$this->id);
            $data= DATA::Ejecutar($sql,$param);
            return $data;
        }     
        catch(Exception $e) {            
            header('HTTP/1.0 400 Bad error');
            die(json_encode(array(
                'code' => $e->getCode() ,
                'msg' => 'Error al cargar los comentarios'))
            );
        }
    }

    function LoadbyTask(){
        try {
            $sql='SELECT c.id, task_id, user_id, date_creation, comment, reference, date_modification , u.username, u.name
                FROM comments c inner join users u on u.id= c.user_id
                WHERE task_id= :taskId
                ORDER BY c.id desc
            ';
            $param= array(':taskId'=>$this->taskId);
            $data= DATA::Ejecutar($sql,$param);
            return $data;
        }     
        catch(Exception $e) {            
            header('HTTP/1.0 400 Bad error');
            die(json_encode(array(
                'code' => $e->getCode() ,
                'msg' => 'Error al cargar los comentarios'))
            );
        }
    }

    function Update(){
        try {
            
        }     
        catch(Exception $e) {
            header('HTTP/1.0 400 Bad error');
            die(json_encode(array(
                'code' => $e->getCode() ,
                'msg' => $e->getMessage()))
            );
        }
    }

    function Insert(){
        try {
            $curl = curl_init();



            $objComment = new stdClass();
            $detalleObjComment = new stdClass();
            
            $detalleObjComment->task_id = $this->taskId;
            $detalleObjComment->user_id = $this->userId;
            $detalleObjComment->content = utf8_encode($this->comment);

            $objComment->jsonrpc = "2.0";
            $objComment->method = "createComment";
            $objComment->id = "156";
            $objComment->params = $detalleObjComment;

            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => Globals::$jsonrpcURL,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($objComment),
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
            if(!$err)
                return true;
            else throw new Exception('Error al agregar.', 978);
        }     
        catch(Exception $e) {
            header('HTTP/1.0 400 Bad error');
            die(json_encode(array(
                'code' => $e->getCode() ,
                'msg' => $e->getMessage()))
            );
        }
    }     

    function Delete(){
        try {
            $curl = curl_init();

            
            $objComment = new stdClass();
            $detalleObjComment = new stdClass();
            
            $detalleObjComment->comment_id = $this->id;

            $objComment->jsonrpc = "2.0";
            $objComment->method = "removeComment";
            $objComment->id = "156";
            $objComment->params = $detalleObjComment;

            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => Globals::$jsonrpcURL,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($objComment),
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
            if(!$err)
                return true;
            else throw new Exception('Error al eliminar.', 978);
        }     
        catch(Exception $e) {
            header('HTTP/1.0 400 Bad error');
            die(json_encode(array(
                'code' => $e->getCode() ,
                'msg' => $e->getMessage()))
            );
        }
    }  

}

?>