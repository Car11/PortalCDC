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
        echo json_encode($brm->readBilling(21,12,2018,17,'00'));        
        break;      
    }
}

class varEvents{
    public $data= [];
    public $label='';
}

class BRM{
    public $id;
    public $cantidad;
    public $fecha;
    //
    public static function readBilling($diadom, $mesdom, $anndom, $hora, $min){
        try{
            error_log('*************************************');
            error_log('*************************************');
            error_log('************** INICIANDO ************');
            error_log('*************************************');
            error_log('*************************************');
            $date=date_create_from_format("Y-m-d H:i",$anndom.'-'.$mesdom.'-'.$diadom.' '.$hora.':'.$min);      
            error_log('TimeStamp: '.$date->getTimestamp());
            $sql="SELECT   to_char (TO_DATE('31-12-1969 23:00:00','dd-mm-yyyy hh24:mi:ss')+(MOD_T-(5*60*60))/86400, 'yyyy-mm-dd hh24:mi') Fecha_Actual,
                count(*) CANT
                FROM     Bill_T
                where end_t = 1545411600  and Name = 'PIN Bill' and INVOICE_OBJ_ID0 = 0
                GROUP BY to_char (TO_DATE('31-12-1969 23:00:00','dd-mm-yyyy hh24:mi:ss')+(MOD_T-(5*60*60))/86400, 'yyyy-mm-dd hh24:mi')
                ORDER BY 1 desc";
            // error_log('SQL: '.$sql);
            //$param= array(':tsMin'=>'1544543190');
            $data = DATA::Ejecutar($sql);
            $evento = new varEvents();
            $evento->label = 'Billing';
            $evento->data = [];
            $i =0;
                        
            while($row = oci_fetch_array($data, OCI_ASSOC)) {
                error_log('FETCH: '. $row);
                array_push ($evento->data, [ $i, floatval($row['CANT'])]);
                $i++;
            }

            $resultado= [];
            array_push ($resultado, $evento);
            return $resultado;
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