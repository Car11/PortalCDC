<?php

include_once("ldap.php");

class Usuario{
    public $userName;
    public $Password="";

    //include_once("../class/ldap.php");
    
        /*function __construct(){
        require_once("ldap.php");
    }
*/
    function ValidarUsuario (){

        //Primero Valida si es un usuario de Red

        $UserLDAP = new UserLDAP();

        $UserLDAP->username= $this->userName;
        $UserLDAP->password=$this->Password;
        
        $UserLDAP->ValidarUsuarioLDAP();


        //Luego valida si esta en la base de datos
    }
}

?>
