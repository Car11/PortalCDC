<?php
    include_once('class/Globals.php');
    $ID="";
    if (isset($_GET['ID'])) {
        $ID=$_GET['ID'];
    }
    if(isset($_SESSION['estado']))
        unset($_SESSION['estado']);
    if(isset($_SESSION['idformulario']))
        unset($_SESSION['idformulario']);
    if(isset($_SESSION['cedula']))
        unset($_SESSION['cedula']);
    if(isset($_SESSION['link']))
        unset($_SESSION['link']);
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Control de Acceso</title>
    <link href="css/Style-Base.css?v=<?php echo Globals::cssversion; ?>" rel="stylesheet" />
    <script src="js/jquery.js" type="text/jscript"></script>
    <script src="js/Form-Validate.js" languaje="javascript" type="text/javascript"></script>
     <script>
        $('#username').attr("autocomplete", "off");
        $('#password').attr("autocomplete", "off");
        setTimeout('$("#username").val("");', 100);
        setTimeout('$("#password").val("");', 100);
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bitter:400,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand">
    <link rel="stylesheet" href="assets/css/dh-navbar-inverse.css">
    <link rel="stylesheet" href="assets/css/Features-Clean.css">
    <link rel="stylesheet" href="assets/css/Footer-Dark.css">
    <link rel="stylesheet" href="assets/css/Header-Dark.css">
    <link rel="stylesheet" href="assets/css/KD_Header.css">
    <link rel="stylesheet" href="assets/css/KD_Header1.css">
    <link rel="stylesheet" href="assets/css/KD_Header2.css">
    <link rel="stylesheet" href="assets/css/OcOrato---Login-form.css">
    <link rel="stylesheet" href="assets/css/OcOrato---Login-form1.css">
    <link rel="stylesheet" href="assets/css/styles.css">

</head>
<body>
    <header>
        <h1>Servicios</h1>        
        <div id="logo"><img src="img/Logoice.png" height="75" > </div>
    </header>
    
    <aside></aside>
    
    <section>
       <h2>Ingrese su usuario y contraseña</h2>
        <div id="form">
            <div class="login">    
                <form  name="Usuario" action="request/postUsuario.php" method="POST">                      
                    <input type="text" id="username" class="input-field" name="username" placeholder="USUARIO" maxlength="20" /><br>
                    <input type="password" id="password" class="input-field" name="password" placeholder="CONTRASEÑA" maxlength="20" />
                    <nav class="btnfrm">
                        <ul>
                            <li> <input class="nbtn_blue" type="submit" value="Ingresar" id="login" /></li>
                        </ul>
                    </nav>
                </form>      
                <div id="invalid">
                    <h3>Usuario o Contraseña Inválido</h3>
                </div>
            </div>     
        </div>
        
    </section>       
    
    <aside></aside>
    
<script> 
    var ID = '<?php print $ID ?>';
    if(ID=='invalid'){            
        $("#invalid").css("visibility", "visible");
        //$("#invalido").slideDown("slow");
            //$("#mensaje").css("visibility", "visible");
        //$("h3").css("color", "firebrick");
    }
</script>
</body>
</html>







