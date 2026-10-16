<?php
$name=$_POST["name"];
$email=$_POST["email"];
$subject=$_POST["subject"];
$message=$_POST["message"];



$contenido='<table width="50%" border="0" align="center">
  <tbody><tr>
    <td colspan="2" align="center"><a href="http://quanticolegal.com" target="_blank" <img src="http://quanticolegal.com/img/small-logo.png" alt="logo" class="CToWUd" width="176" height="175"></a><br>Has recibido un mensaje<br>desde Quántico<br><a href="http://quanticolegal.com" target="_blank">Quántico</a></td>
  </tr>
  <tr>
    <td bgcolor="#40BCCB" align="left"><strong>Nombre</strong>
    </td>
    
    <td align="center">
    '.$name.'
    </td>
  </tr>
  
    <tr>
    <td bgcolor="#40BCCB" align="left"><strong>E-mail:</strong>
    </td>
    
    <td align="center">
  '.$email.'
    </td>
  </tr>
  
    <tr>
    <td bgcolor="#40BCCB" align="left"><strong>Asunto:</strong>
    </td>
    
    <td align="center">
   '.$subject.'
    </td>
  </tr>
  
  <tr>
    <td bgcolor="#40BCCB" align="left"><strong>Mensaje:</strong>
    </td>
    
    <td align="center">'.$message.'
    </td>
  </tr>
</tbody></table>';
mail("guillermo@tpx.mx","Contacto desde Quántico",$contenido);
echo "Mensaje enviado correctamente!";
?>