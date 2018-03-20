
<?php 



echo('INICIO');








$db = "(DESCRIPTION= (ADDRESS= (PROTOCOL=TCP) (HOST=rac-vfactprd) (PORT=1523) ) (LOAD_BALANCE=yes) (CONNECT_DATA= (SERVER=DEDICATED) (SERVICE_NAME=TAF_BRM) (FAILOVER_MODE= (TYPE=SELECT) (METHOD=BASIC) (RETRIES=180) (DELAY=5) ) ) )";

$conn = oci_connect('jleon_oper', 'emi2014', $db);

if (!$conn) {

$e = oci_error();

trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);

}

else{

echo('FIN');

}



$stid = oci_parse($conn, 'select count(CURRENT_TOTAL) from bill_t where Name = PIN Bill and end_t = 1520488800;');

oci_execute($stid);

// $MYDB =
//     (DESCRIPTION =
//       (ADDRESS = (PROTOCOL = TCP)(HOST = mymachine.oracle.com)(PORT = 1521))
//       (CONNECT_DATA =
//         (SERVER = DEDICATED)
//         (SERVICE_NAME = XE)
//       )
//     )

// $MYDB =   "(DESCRIPTION=
//             (ADDRESS=
//                 (PROTOCOL=TCP)
//                 (HOST=rac-vfactprd)
//                 (PORT=1523)
//             )
//             (LOAD_BALANCE=yes)
//             (CONNECT_DATA=
//                 (SERVER=DEDICATED)
//                 (SERVICE_NAME=TAF_BRM)
//                 (FAILOVER_MODE=
//                     (TYPE=SELECT)
//                         (METHOD=BASIC)
//                         (RETRIES=180)
//                         (DELAY=5)
//                 )
//             )
//         )";



?>



