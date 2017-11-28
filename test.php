<?php


// echo "Nombre: " . $_FILES['archivo']['name'] . "<br>";
//   echo "Tipo: " . $_FILES['archivo']['type'] . "<br>";
//   echo "Tamaño: " . ($_FILES["archivo"]["size"] / 1024) . " kB<br>";
//   echo "Carpeta temporal: " . $_FILES['archivo']['tmp_name'];
 



if (!isset($_SESSION))
session_start();
include_once('class/Globals.php');
// Sesion de usuario
require_once("class/Sesion.php");
$sesion = new Sesion();
if (!$sesion->estado){
  $_SESSION['url']= explode('/',$_SERVER['REQUEST_URI'])[2];
  header('Location: Login.php');
  exit;
}

?>

<!doctype html>
<html lang="en">
  <head>
    <title>Hello, world!</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <script src="js/jquery.js" type="text/jscript"></script>
    <script src="js/ScheduledTask.js" languaje="javascript" type="text/javascript"></script> 
    <script src="js/bootstrap.min.js"></script>
         <!-- CSS de Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/datatables.css" type="text/css"/>     
    
   </head>
    <body>

        <form action="subearchivo.php" method="post" enctype="multipart/form-data"> 
          <b>Campo de tipo texto:</b> 
          <br> 
          <input type="text" name="cadenatexto" size="20" maxlength="100"> 
          <input type="hidden" name="MAX_FILE_SIZE" value="100000"> 
          <br> 
          <br> 
          <b>Enviar un nuevo archivo: </b> 
          <br> 
          <input name="userfile" type="file"> 
          <br> 
          <input type="submit" value="Enviar"> 
      </form>
    
    <?php
//imagen png codificada en base64
// $Base64Img = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAK8AAACvAQMAAA
// 				   CxXBw2AAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAWVJREFUSIn
// 				   Nlr2Vg0AMhMUjIKQEl0Jpx3ZGKS7BIYHfzukPHevDKVolmO85mBWaWRG0Nhrf8
// 				   2vZMOprpe4wGMuPwMQlf3vT4/kjD64czJJUMAtUzDq3wPyX+UU9YMA7eInXbvC
// 				   nwKFKn6kDjDqhaawPROB2Tu7EbhKITlx554ul7sYfAr0GYKcFK7V1Jz6UMX4Ap
// 				   U47e3wNrO80JOOjnoTAGjvxoGknSsJeHtQ8oRyHVQ8gjZbUlMbSnIVhn9wFlkM
// 				   gD6McAJaaRZ1FWdhm0Dpoc1DJvITyF49p2N4Dh7n16iuemhQTm4Nj+Nwkmpqz53
// 				   c2HiMHrQKL2Wm0CVVMeVi2MM1BK73qxFKOPcY3SsQ+fC4wYl3aLv2WRxJ2Sc02c
// 				   74BJZS2PnArUA6z+P4NP9Wagk8bdVTtEOMacyjJzY3I7zRsX/oKq5fUSfnYG3ja
// 				   qHGEkuw6OdgkNQLP6y3kyqZ/W+9t+BeB6j/x9fcYdwAAAABJRU5ErkJggg==";

$Base64Img = "";
           //eliminamos data:image/png; y base64, de la cadena que tenemos
//hay otras formas de hacerlo				   
list(, $Base64Img) = explode(';', $Base64Img);
list(, $Base64Img) = explode(',', $Base64Img);
//Decodificamos $Base64Img codificada en base64.
$Base64Img = base64_decode($Base64Img);
//escribimos la información obtenida en un archivo llamado 
//unodepiera.png para que se cree la imagen correctamente
file_put_contents('Imagen.png', $Base64Img);	
echo "<img src='Imagen.png' alt='Imagen' />"; 
?>


<?php
$str = 'VGhpcyBpcyBhbiBlbmNvZGVkIHN0cmluZw==';
echo base64_decode($str);
?>



  </body>
</html>