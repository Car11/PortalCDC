<?php 
    require_once("../class/Visitante.php");
    $visitante= new Visitante();
    //
    if (isset($_POST['cedula'])) { 
        $visitante->cedula=$_POST['cedula'];        
    }
    else {
        error_log($e->getMessage());
        exit;
    }
    if (isset($_POST['visitanteexluido'])) {  
        $visitante->visitante=$_POST['  '];
        $visitante->ConsultaVisitante();
    }
    if (isset($_POST['ip_cliente'])) { 
        $visitante->ip_cliente=$_POST['ip_cliente'];        
    }
    $visitante->ValidaID();
?>