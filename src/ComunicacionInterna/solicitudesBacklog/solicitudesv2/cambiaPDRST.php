<?php error_reporting(0); ?>
<!doctype html>
<html>
<head>

 <!-- SCRIPT PARA CAMBIAR EL PDR -->
         <script type="text/javascript">
        function cambiaPDR(){
			
			var codigo ="<?php echo $solicitudID;?>";
			pdr=$("#pdrAsignado").val();
			 
			
			 
			 $('#divPDR').load("cambiaPDR.php", {pdr: pdr, codigo: codigo}, function(data){

    		});
		}
         </script>

<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>

<?php
//conexion
require_once("../../../ConexionDBT.php");
require_once("../../../ConexionIntranet2.php");

//obtengo parametros

$codigo = $_POST['codigo'];
$pdr = $_POST['pdr'];

//echo "UPDATE SGI_Quejas_Solicitudesv2 SET xt_pdr = '$pdr' WHERE xt_quejaSolicitud = '$codigo'";
//echo "UPDATE SGI_Quejas_Solicitudes_Estatusv2 SET kf_usuario = '$pdr' WHERE xt_quejaSolicitud = '$codigo'";

//Actualizo registros de pdr en la tabla de SGI_Quejas_solicitudesv2
if($INTRANETV2 -> Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_pdr = '$pdr' WHERE xt_quejaSolicitud = '$codigo'")){

//Actualizo registro de pdr en la tabla de SGI_quejas_Solicitudes_Estatusv2
$INTRANETV2 -> Execute("UPDATE SGI_Quejas_Solicitudes_Estatusv2 SET kf_usuario = '$pdr' WHERE xt_quejaSolicitud = '$codigo'");

?>
<script>
	alert("PDR Asignado");
	window.location.reload();
</script>
<?php

}

//pongo lo del dov
 echo "<table border='0' align='center' width='700'>";
        echo "<tr>";
            echo "<td id='titleBlueLineBottom' colspan='3'></td>";
        echo "</tr>";
        echo "<tr height='10px;'></tr>";
        echo "<tr>";
            echo "<td width='25px;'> </td>";
           // echo "<td id='iconosTexto' align='left' colspan='2'>$pdr</td>";
			
			//select de PDR
			
			echo "<td>";
				echo "<select name='pdrAsignado' id='pdrAsignado'>";
                    //echo "<option value=''>Elegir......</option>";
                    $r = $INTRANETV2->Execute("SELECT xt_administrador FROM SGI_Backlog_Administradores_de_Sistemas WHERE xt_sistema = 'SOPORTE TECNICO'");
                    while($fila = $r->fetchRow()){
						
						if($fila[0] == "$pdr"){
							 echo "<option value='".$fila[0]."' SELECTED>$fila[0]</option>";
						}else {
                        	echo "<option value='".$fila[0]."'>$fila[0]</option>";
						}
                    }
                echo "</select>";
			echo "</td>";
			
			
        echo "</tr>";
		
		echo"<tr height='40'>";
			echo"<td valign='bottom' style='padding:0px 0px 0px 220px' colspan='2'>";
			?>
			<div id='btn1' ><a style='cursor:pointer' id='insertaP'  onClick='cambiaPDR()'><img src='../../Imagenes/ICN_BotonAgregar.png' height='25' width='80'></a></div>
             
             <?php
                                              
				//echo "<input type='submit' name='Enviar' src = '../Imagenes/ICN_BotonAgregar.png'>";
			echo"</td>";
		echo"</tr>";	
		
    echo "</table>";
	
	
?>
</body>
</html>