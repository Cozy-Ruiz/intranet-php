<?php
/*
 *@author Octavio F. García Robles
 *@version 1.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */

$nombrephp = 'TableroClientesMails.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");
require_once("../MapaBanana.php");

$breadcrumb = "<a href='../Home.php' id='breadcrumbs'> Home / </a><a href='aplicaciones.php' id='breadcrumbs'> Módulos / </a><a href='operaciones.php' id='breadcrumbs'> Operaciones </a>";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8">
        <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
        <title>Clientes con Listas de Distribución</title>
        <?php
        if($estiloUsuario == 1){
            ?>
            <link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>
            <?php
        }else if($estiloUsuario == 2){
            ?>
            <link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>
            <?php
        }
        ?>
        <script>
            function showBanana(valor){
                if(valor == 1){
                    document.getElementById("banana1").style.display="inline-block";
                    document.getElementById("banana0").style.display="none";
                    document.getElementById("mapaIntranet").style.display="inline-block";
                } else if (valor == 0){
                    document.getElementById("banana1").style.display="none";
                    document.getElementById("banana0").style.display="inline-block";
                    document.getElementById("mapaIntranet").style.display="none";
                }
            }
        </script>
    </head>
    
    <body>
		<div id="wrapperSolicitudes" align="center">
        	<table border="0" align="center" width="800px">
            	<tr>
                	<td align="left" id="breadcrumbs">Usuario:&nbsp;<? echo $usuarioId ?></td>
                </tr>
        		
                <tr height="80px"><td></td></tr>
                
                <tr>
                	<td align="center" id="titulo1">Clientes con Listas de Distribución</td>
                </tr>
                
                <tr height="10px"><td></td></tr>
                
                <tr>
                	<td align="center" valign="top" height="20px">
                    	<table border="0" align="center">
                        	<tr height="20px">
                            	<td valign="middle">
                                	<img src="../Imagenes/ICN_PointMeTo.png" id="banana1" style="display:none;" onclick="showBanana(0);">
                                    <img src="../Imagenes/ICN_PointMeTo.png" id="banana0" style="display:inline-block;" onclick="showBanana(1);">
                                </td>
                                
                                <td valign="middle">
                                	<font style="display:inline-block;"><? echo $breadcrumb ?></font>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
			</table>
            
            <?php imprimeMapaBanana(1); ?>
            
            <table border="0" align="center">
                <tr height="50px"><td></td></tr>
            </table>
            
            <table align="center">
                <tr height="20px"><td colspan="3"></td></tr>
                
                <tr id="titulo2">
                    <td align="center" width="20px"></td>
                    <td align="center" width="200px">RFC</td>
                    <td align="center" width="400px">Nombre Corto</td>
                </tr>
                
                <tr height="20px"><td colspan="3" id="titleBlueLineTop"></td></tr>
                
                <?php
                $s = $INTRANET->Execute("SELECT xt_rfc, xt_nombreCorto FROM MASTER_GE.MASTER_MAILS ORDER BY xt_rfc ");
                
                while($r = $s->fetchRow()){
					
                    ?>
                    <tr height="30px" id="titulo12">
                        <td width="20px"></td>
                        
                        <td align="left">
                            <a href="ListaDistribucionCliente.php?c=<?php echo str_replace("&", "%26", $r[0]) ?>" id="manualVinculo" style="text-decoration:none;">
                                <?= $r[0] ?>
                            </a>
                        </td>
                        
                        <td align="left">
                            <a href="ListaDistribucionCliente.php?c=<?php echo str_replace("&", "%26", $r[0]) ?>" id="manualVinculo" style="text-decoration:none;">
                                <?=  iconv("ISO-8859-1", "UTF-8", $r[1]) ?>
                            </a>
                        </td>
                    </tr>
                    <?php
                } unset($r);
                ?>
                <tr height="20px"><td colspan="3"></td></tr>
                
                <tr height="20px"><td colspan="3" id="titleBlueLineTop"></td></tr>
            </table>

            
            <table border="0" align="center">
                <tr height="50px"><td></td></tr>
            </table>
        </div>
	</body>
</html>
<?php
