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
        echo json_encode($brm->readBilling(12,8,2018,00,00));        
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
            //long tsMin = app.TimeStampDom(app.MesDOM.ToString(), app.DiaDOM.ToString(), app.AnnDOM.ToString());//, ultimosminutos.Hour.ToString(), ultimosminutos.Minute.ToString(), "0");
            $sql="SELECT  to_char (TO_DATE('31-12-1969 23:00','dd-mm-yyyy hh24:mi')+(MOD_T-(5*60*60))/86400, 'yyyy-mm-dd hh24') HORA,
                    count(*) CANT ,                     
                    count(DISTINCT( to_char (TO_DATE('31-12-1969 23:00:00','dd-mm-yyyy hh24:mi:ss')+(MOD_T-(5*60*60))/86400, 'yyyy-mm-dd hh24:mi')))  MINN, 
                    CAST( COUNT(*)/ count(DISTINCT( to_char (TO_DATE('31-12-1969 23:00:00','dd-mm-yyyy hh24:mi:ss')+(MOD_T-(5*60*60))/86400, 'yyyy-mm-dd hh24:mi'))) AS DECIMAL(10,0) )PROM 
                FROM bill_t
                where Name = 'PIN Bill' and INVOICE_OBJ_ID0 = 0 and  end_t = '1538373600'
                GROUP BY  to_char (TO_DATE('31-12-1969 23:00','dd-mm-yyyy hh24:mi')+(MOD_T-(5*60*60))/86400, 'yyyy-mm-dd hh24') 
                order by HORA";
            //$param= array(':tsMin'=>'1544543190');
            $data = DATA::Ejecutar($sql);
            $evento = new varEvents();
            $evento->label = 'Billing';
            $evento->data = [];
            $i =0;
            // foreach ($data as $key => $value){
            //     //$_SESSION['ultMedicion']= $value['medicion'];
            //     error_log('Valor Cantidad ('.$i.'): '.$value[2]);
            //     //error_log('Valor Cantidad2 ('.$i.'): '.$value[0][0]);
            //     array_push ($evento->data, [ $i, floatval($value[2])]);
            //     $i++;
            // }
            
            while($row = oci_fetch_array($data, OCI_ASSOC)) {
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