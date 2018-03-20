<?php 

$tns = "(DESCRIPTION= (ADDRESS= (PROTOCOL=TCP) (HOST=rac-vfactprd) (PORT=1523) ) (LOAD_BALANCE=yes) (CONNECT_DATA= (SERVER=DEDICATED) (SERVICE_NAME=TAF_BRM) (FAILOVER_MODE= (TYPE=SELECT) (METHOD=BASIC) (RETRIES=180) (DELAY=5) ) ) )";

$db_username = "jleon_oper"; 
$db_password = "emi2014"; 

try{ 
    
    $conn = new PDO("oci:dbname=".$tns,$db_username,$db_password);
    $stmt = $conn->prepare("select count(CURRENT_TOTAL) from TAF_BRM.bill_t where Name = 'PIN Bill' and end_t = 1520488800;");
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    var_dump($results);

    $stmt->closeCursor();
    
    echo('SI CONECTA'); 
    
}
catch(PDOException $e)
    { 
        echo ($e->getMessage()); 
    } 
?>

