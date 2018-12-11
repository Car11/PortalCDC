<?php 
if (!isset($_SESSION))
session_start();
// require_once('Globals.php');
require_once("conexion.php");
// require_once("Log.php");
// require_once("Sesion.php");

if(isset($_POST["action"])){
$brm= new BRM();   
switch($_POST["action"]){       
    case "readBilling":
        // $brm->brm= $_POST["username"];
        // $brm->contrasena= $_POST["password"];
        $brm->readBilling(12,8,2018,00,00);
        break;      
}
}

class BRM{
    public $id;
    public $cantidad;
    public $fecha;
    //
    public static function readBilling($diadom, $mesdom, $anndom, $hora, $min){
        try{
            //long tsMin = app.TimeStampDom(app.MesDOM.ToString(), app.DiaDOM.ToString(), app.AnnDOM.ToString());//, ultimosminutos.Hour.ToString(), ultimosminutos.Minute.ToString(), "0");
            $sql="SELECT  to_char (TO_DATE('31-12-1969 23:00','dd-mm-yyyy hh24:mi')+(MOD_T-(5*60*60))/86400, 'yyyy-mm-dd hh24') HORA,
                    count(*) CANT , count(DISTINCT( to_char (TO_DATE('31-12-1969 23:00:00','dd-mm-yyyy hh24:mi:ss')+(MOD_T-(5*60*60))/86400, 'yyyy-mm-dd hh24:mi')))  MINN, 
                    CAST( COUNT(*)/ count(DISTINCT( to_char (TO_DATE('31-12-1969 23:00:00','dd-mm-yyyy hh24:mi:ss')+(MOD_T-(5*60*60))/86400, 'yyyy-mm-dd hh24:mi'))) AS DECIMAL(10,0) )PROM 
                FROM bill_t
                where Name = 'PIN Bill' and INVOICE_OBJ_ID0 = 0 and  end_t = :tsMin
                GROUP BY  to_char (TO_DATE('31-12-1969 23:00','dd-mm-yyyy hh24:mi')+(MOD_T-(5*60*60))/86400, 'yyyy-mm-dd hh24') 
                order by HORA";
            $param= array(':tsMin'=>'1544543190');
            $data = DATA::Ejecutar($sql,$param);            
        }
        catch(Exception $e) {
            error_log("[ERROR]  (".$e->getCode()."): ". $e->getMessage());
            header('HTTP/1.0 400 Bad error');
            die(json_encode(array(
                'code' => $e->getCode() ,
                'msg' => 'Error al cargar la informacion'))
            );
        }
    }
}
?>