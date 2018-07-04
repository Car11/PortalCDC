<?php
/**
 * Created by Joe of ExchangeCore.com
 */
$dom = "@sabana";
$txt = sprintf("%s@icetel.ice", "jaroja4");
echo $txt;
echo "<br>";

$txt2 = "jaroja4" . $dom;
echo $txt2;

if(isset($_POST['username']) && isset($_POST['password'])){

    $adServer = "ldap://icetel.ice";
	
    $ldap = ldap_connect($adServer);
    $username = $_POST['username'];
    $password = $_POST['password'];

    
    $username = "jaroja4";
    $password = "Icetel2017";
    $password = "Vane1989+";

    $ldaprdn = 'icetel' . "\\" . $username;
    
    $ldaprdn = "jaroja4@icetel.ice";
    $username = "jaroja4";

    ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

    $bind = @ldap_bind($ldap, $ldaprdn, $password);

    //$correo = "JRojasVal@ice.go.cr";
    //   OperacionesTI@ice.go.cr
    if ($bind) {
        // $filter="(mail=$correo)";  //mail   
        //$filter="(samaccountname=$username)"; 
        $filter="(samaccountname=$username)"; 
        //mail   (&(objectCategory=person)(objectClass=user) (|(proxyAddresses=*:jsmith@company.com) (mail=jsmith@company.com)))
        $result = ldap_search($ldap,"DC=icetel,DC=ice",$filter);   //DC=icetel,DC=
        
        //define('LDAP_USER_FILTER', '(&(objectClass=person)(mail=%s))');

        ldap_sort($ldap,$result,"sn");
        $info = ldap_get_entries($ldap, $result);
        echo "<h1>  USURIO ES--->>>" . $info[0]["samaccountname"][0] . "</h1>";

        echo "<h1>  Cantidad de registros: " . $info[0]["count"] . "</h1>"; 

        for ($i=0; $i<$info["count"]; $i++)
        {
            if($info['count'] > 1)
                break;   
            echo "<p>You are accessing <strong> ". $info[$i]["sn"][0] .", " . $info[$i]["givenname"][0] ."</strong><br /> (" . $info[$i]["samaccountname"][0] .")</p>\n";
            echo '<pre>';
            var_dump($info);
            echo '</pre>';
            $userDn = $info[$i]["distinguishedname"][0]; 
        }
        @ldap_close($ldap);
    } else {
        $msg = "Invalid email address / password";
        echo $msg;
    }

}else{
?>
    <form action="#" method="POST">
        <label for="username">Username: </label><input id="username" type="text" name="username" /> 
        <label for="password">Password: </label><input id="password" type="password" name="password" />        <input type="submit" name="submit" value="Submit" />
    </form>

    <?php>

       

    ?>

<?php } ?> 