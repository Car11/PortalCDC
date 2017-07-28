<?php

if (isset($_POST['username']) && isset($_POST['password']) ){
    include_once("../class/usuario.php");
    
    $Usuario = new Usuario();

    $Usuario->userName=$_POST['username'];
    $Usuario->Password=$_POST['password'];
    
    $Usuario->ValidarUsuario();
}

?>