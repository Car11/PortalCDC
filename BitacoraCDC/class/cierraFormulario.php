<?php
if (!isset($_SESSION))
    session_start();
require_once('Globals.php');
require_once("Conexion.php");

try {
    error_log('Inicia cierre de formularios');
    $sql='update formulario 
        set idEstado = 3
        where fechasalida < now() and idEstado = 1;';
    $data= DATA::Ejecutar($sql);
    error_log('Finaliza cierre de formularios');
}     
catch(Exception $e) {   
    error_log($e->getMessage());
    error_log('Error al cerrar formularios');
}

?>