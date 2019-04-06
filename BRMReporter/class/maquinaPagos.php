<?php 
if (!isset($_SESSION))
    session_start();
// require_once('Globals.php');
require_once("conexion.php");

try{
    error_log('************** INICIANDO ************');
    $sql="SELECT count(*) as cant
        FROM pin.ICE_RECARGAS_PREPAGO_MTA_T 
        WHERE status = 0
        GROUP BY status";
    $data = DATA::Ejecutar($sql);    
    while($row = oci_fetch_array($data, OCI_ASSOC)) {
        echo $row['CANT'];
    }
}
catch(Exception $e) {
    error_log("[ERROR]  (".$e->getCode()."): ". $e->getMessage());
    header('HTTP/1.0 400 Bad error');
    die(json_encode(array(
        'code' => $e->getCode() ,
        'msg' => 'Error al cargar la informacion'))
    );
}

?>