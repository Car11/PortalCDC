<?php

//class UserLDAP{
   // public $username="";
   // public $password="";

    //function ValidarUsuarioLDAP (){

        $adServer = "icetel.ice";
        $ldapport = 3268;
        
        $ldap = ldap_connect($adServer, $ldapport);
        
        $username = "jaroja4";
        $password = "Password";

        $ldaprdn = 'icetel' . "\\" . $username;

        //ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        //ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

        $bind = @ldap_bind($ldap, $ldaprdn, $password);


        if ($bind) {
            $filter="(sAMAccountName=$username)";
            $result = ldap_search($ldap,"dc=icetel,dc=ice",$filter);
            ldap_sort($ldap,$result,"sn");
            $info = ldap_get_entries($ldap, $result);
            for ($i=0; $i<$info["count"]; $i++)
            {
                if($info['count'] > 1)
                    break;
                //echo "<p>You are accessing <strong> ". $info[$i]["sn"][0] .", " . $info[$i]["givenname"][0] ."</strong><br /> (" . $info[$i]["samaccountname"][0] .")</p>\n";
                echo "<p>Accediendo como: <strong> ". $info[$i]["givenname"][0] ." " . $info[$i]["sn"][0] ."</strong>\n <br /> Usuario: <strong>" . $info[$i]["samaccountname"][0] ."</strong></p>\n";
                
                
                echo "<p>Correo: <strong> ". $info[$i]["mail"][0] . "</strong></p>\n";
                echo "<p>Telefono: <strong> ". $info[$i]["telephonenumber"][0] . "</strong></p>\n";
                
                


                echo '<pre>';
                //var_dump($info);
                echo '</pre>';
                //$userDn = $info[$i]["distinguishedname"][0]; 
            }
            @ldap_close($ldap);
        } else {
            $msg = "Invalid email address / password";
            echo $msg;
        }
    //}
//}

 ?>






