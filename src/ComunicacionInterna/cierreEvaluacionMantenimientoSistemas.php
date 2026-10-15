<?php error_reporting(0); ?>
<?php error_reporting(0); ?>
<?php
$nombrephp='fichaSolicitud.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Cierre de Evaluaci&oacute;n de Soporte T&eacute;cnico</title>
<?php
            if($estiloUsuario == 1){
                echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
            }else if($estiloUsuario == 2){
                echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
            }
            ?>
 <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
        <link type="text/css" href="../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
        <script type="text/javascript" src="../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
        <script type="text/javascript">
                    function reCargarPadre(){
                        opener.location.reload();
                        window.close();
                    }
        </script>
        

</head>

<body>
<?PHP

//echo "<div id='wrapper'>";
  echo "<form name='cierreMantenimiento' method='post' action='cierreSoporteTecnico.php'>";  
    
    echo "<table border='0' align='center' width='700' >";  
        
        echo"<tr >";
                echo"<td align='center' width='600' id='titulo1' colspan='2'>";
                    echo "GE-B-DF-15-272";
                echo "</td>";
        echo"</tr>";
        
        echo "<tr height='30'> </tr>";
        
        echo "<tr>";
            echo "<td id='titleBlueLineBottom' colspan='2'></td>";
        echo "</tr>";   
    echo "</table>";    
        
    echo "<table border='0' align='center' width='700' >";      
        echo"<tr >";
                echo "<td  width='50px;'></td>";
                echo"<td align='left' width='550' id='manualVinculo' colspan='2'>";
                    echo "Evaluar";
                echo "</td>";
        echo"</tr>";
        echo "<tr height='30'> </tr>";
    echo "</table>";
        
    echo "<table border='0' align='center' width='700' >";      
            echo"<tr height='40'>";
            echo "<td width='200' align='right'>";
                    echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonAceptar.png' width='175' height='46'>";
                echo"</td>";
                echo "<td width='40'> </td>";
                echo"<td valign='bottom' align='left' width='200'>";
                    echo "<img src='../Imagenes/ICN_BotonRechazar.png' width='175' height='46' onClick='window.close()'>";
                echo "</td>";
            echo"</tr>";
            
            echo "<tr height='30'> </tr>";
    echo "</table>";
    
    echo "<table border='0' align='center' width='600' >";
            echo"<tr >";
                echo"<td align='left' id='iconosTexto2' colspan='2'>";
                    echo "<b>Comentarios:</b>";
                echo "</td>";
            echo"</tr>";
            echo "<tr>";
                echo "<td id='titleBlueLineBottom' colspan='4'></td>";
            echo "</tr>";
            echo "<tr height='10'> </tr>";
            echo"<tr> ";
                echo"<td valign='bottom' align='left' colspan='2'>";
                    echo"<textarea name='comentarios' style='width: 600px; height: 80px;' placeholder='Comentarios'></textarea>";
                echo"</td>";
            echo"</tr>";
            echo "<tr height='10'> </tr>";
            echo "<tr>";
                echo "<td id='titleBlueLineBottom' colspan='4'></td>";
            echo "</tr>";
            echo "<tr height='15'> </tr>";
            echo"<tr >";
                echo"<td align='left' id='iconosTexto2' colspan='2'>";
                    echo "<b>Archivo</b>";
                echo "</td>";
            echo"</tr>";
            echo "<tr>";
                echo "<td id='titleBlueLineBottom' colspan='4'></td>";
            echo "</tr>";
            echo "<tr height='10'> </tr>";
            echo"<tr> ";
                echo "<td width='30'> </td>";
                echo"<td valign='bottom' align='left' colspan='2'>";
                echo "<input id='FileCron' type='file' size='35' name='archivo'>";
                echo"</td>";
            echo"</tr>";
            echo "<tr height='10'> </tr>";
            echo "<tr>";
                echo "<td id='titleBlueLineBottom' colspan='4'></td>";
            echo "</tr>";
            echo "<tr height='30'> </tr>";          
    echo "</table>";
    echo "<table border='0' align='center' width='700' >";  
        echo "<tr>";
            echo "<td id='titleBlueLineBottom' colspan='2'></td>";
        echo "</tr>";   
    echo "</table>";    
        
    
echo "</form>";     
//echo "</div>";    
?>      
