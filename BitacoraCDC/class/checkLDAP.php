
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<form action="checkLDAP.php" method="post">
Valor a buscar: <input type="text" name="searchValue"><br>
Filtro: <select name="tipoFiltro">
    <option value='mail'>Correo</option>
    <option value='samAccountName'>Usuario</option>
    <option value='samAccountName'>Nombre</option>
    <option value='description'>Cedula</option>
</select>
<br>
<input type="submit">
</form>

</body>

</html>




<?php 

$searchLDAP= new SearchLDAP();

if(isset($_POST["tipoFiltro"])){
    $searchLDAP->tipoFiltro= $_POST["tipoFiltro"];
}
if(isset($_POST["searchValue"])){
    $searchLDAP->searchValue= $_POST["searchValue"];
}
// $searchLDAP->tipoFiltro = "samAccountName";
// $searchLDAP->searchValue = "jaroja4";

// $searchLDAP->tipoFiltro = "mail";
// $searchLDAP->searchValue = "oespinoza@ice.go.cr";
// $searchLDAP->searchValue = "LVasquez@ice.go.cr";
// $searchLDAP->ValidarUsuarioLDAP();
// $searchLDAP->searchValue = "jcorrales@ice.go.cr";
// $searchLDAP->ValidarUsuarioLDAP();
// $searchLDAP->searchValue = "CPalacios@ice.go.cr";
// $searchLDAP->ValidarUsuarioLDAP();
// $searchLDAP->searchValue = "AChaconC@ice.go.cr";
$searchLDAP->ValidarUsuarioLDAP();






class SearchLDAP{
    public $searchValue = "";
    public $tipoFiltro = "mail";
    public $usuario = "";
    public $dn = "";
    public $email = "";
    public $nombre = "";
    public $cedula = "";
    public $telephonenumber = "";
    public $streetaddress = "";

	function __construct(){
        require_once("Conexion.php");
        require_once("Log.php");
    }

    function ValidarUsuarioLDAP (){
        $LDAP_servicio = DATA::getLDAP_Param();
        $LDAP_connect = ldap_connect($LDAP_servicio["LDAP_server"], $LDAP_servicio["LDAP_port"]);
        $LDAP_bind = @ldap_bind($LDAP_connect, $LDAP_servicio["LDAP_user"], $LDAP_servicio["LDAP_passwd"]);
        if ($LDAP_bind) {
            $LDAP_filter="(".$this->tipoFiltro."=$this->searchValue)";
            $search_result=ldap_search($LDAP_connect,$LDAP_servicio["LDAP_base_dn"],$LDAP_filter);
            $LDAP_user_data = ldap_get_entries($LDAP_connect, $search_result);  
            // var_dump($LDAP_user_data);
            if($LDAP_user_data["count"] < 1){
                @ldap_close($LDAP_connect);
                return false;
            }       
            $this->dn = $LDAP_user_data[0]["dn"];
            $this->email= $LDAP_user_data[0]["mail"][0];
            $this->nombre = $LDAP_user_data[0]["cn"][0];
            $this->usuario = $LDAP_user_data[0]["samaccountname"][0];
            $this->cedula = $LDAP_user_data[0]["description"][0];
            $this->telephonenumber = $LDAP_user_data[0]["telephonenumber"][0];
            $this->streetaddress = $LDAP_user_data[0]["streetaddress"][0];
            
            @ldap_close($LDAP_connect);
            var_dump($this);
            
        } else {
            error_log("Falla el Bind: " . ldap_error($ldap));
            return false;  
        }
    }
}

?>