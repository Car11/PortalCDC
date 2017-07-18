<?php



?>



<!doctype html>
 <html>

   <head>
      <meta charset="utf-8"/>   
      <title>Login CDC</title>
   </head>

   <body>
      <form  name="Usuario" action="request/enviaUsuario.php" method="POST">                      
          <input type="text" id="username" name="username" placeholder="USUARIO" maxlength="20" /><br>
          <input type="password" id="password" name="password" placeholder="CONTRASEÑA" maxlength="20" />
          <input  type="submit" value="Ingresar" id="login" />
          <button type="button" onclick="onVuelve()">Cancelar</button>
      </form>      
   </body>

 </html>