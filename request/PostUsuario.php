<?php 
    require_once("../class/usuario.php");
    require_once("../class/Sesion.php");
    require_once("../class/Log.php");

    $usuario= new Usuario();
    $sesion = new Sesion();
    //
    if(isset($_POST["username"]) && isset($_POST["password"])){
        $usuario->usuario=$_POST['username'];        
        $usuario->contrasena=$_POST['password'];
        if($usuario->LDAPCheck())
        {
            $sesion->Inicio($usuario->usuario, $usuario->rol, $usuario->id, $usuario->nombre);
            //print('<br>role: '. $usuario->rol );
            //print('<br>id: '. $usuario->id );exit;
            if(isset($_SESSION['url'])){
                header('Location: ../'. $_SESSION['url']); 
                unset($_SESSION['url']);
                exit;
            }
            else {
                header('Location: ../MiCuenta.php'); 
                exit;
            }
        }
        else //usuario denegado
        {
            $sesion->Fin();
            header('Location: ../Login.php?ID=invalid');
            exit;
        }
    }
    else {
		header('Location: ../Login.php?ID=error');
		exit;
    }
?>