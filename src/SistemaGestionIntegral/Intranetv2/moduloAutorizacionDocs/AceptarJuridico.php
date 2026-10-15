<?php
$nombreModulo="Autorización de Documentos";
$nombrephp = "principalDocumentos.php";
//incluyo los archivos necesarios
require_once("../../../Librerias/adodb/adodb.inc.php");
require_once("header.php"); 
require_once("../../../ConexionIntranet2.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8">
            <title>Autorizacion de Documentos Calidad</title>
        </head>
        <body>
          <div class="form" align=\"center\">
            <form method="POST" action="recoleccionVariable.php" >
            
          <input type="radio" name="nopcion" value="1">Aceptar<br />
          <input type="radio" name="nopcion" value="2">Rechazar<br />
           <input type='text' name='nnota'  value=''><br>         
                
          <button type="submit" value="Submit">envio de autorizacion<br>
      </form>
          
          </div>
        </body>
    
            
        </table>