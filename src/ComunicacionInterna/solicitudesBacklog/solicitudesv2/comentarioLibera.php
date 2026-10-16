<?php error_reporting(0); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>
</body>
</html><!doctype html>
<html>
<head>

<?php
require_once("../../../ConexionDBT.php");
require_once("../../../ConexionIntranet2.php");

 $solicitudID = $_POST['codigo'];

 $comentarioLibera = $_POST['comentario'];
?>

<meta charset="utf-8">
<title>Documento sin título</title>

<!-- SCRIPT PARA CAMBIAR EL COLOR DE LAS CELDAS -->
 <!-- SCRIPT PARA GUARDAR AL COMENTARIO DE LIBERACION DE FUNCIONALIDAD -->
 <script language="javascript" type="text/javascript">
 
 function comentarioLibera(){
	 
	 var codigo ="<?php echo $solicitudID;?>";
	 
	var comentarioLibera = document.getElementById('comentarioLibera').value;
	
	if(comentarioLibera != ''){
		
		$('#comentarioLiberacion').load("comentarioLibera.php", {codigo: codigo, comentario : comentarioLibera}, function(data){

        })
		
	}
	
	  

 }
 
 </SCRIPT>
 
</head>

<body>

<?php

	//inserto comentario
	if($comentarioLibera != ''){
		
		$INTRANETV2->getOne("UPDATE SGI_Backlog_Liberacion_Funcionalidad SET xt_comentarios = '$comentarioLibera' WHERE xt_quejaSolicitud = '$solicitudID' and xt_status = 'LIBERADA'");
		
		
	?>
<script>
	alert("Comentario registrado correctamente");
</script>
<?php
		
	}

	//hago consulta para obtener el comentario en liberacion
              
	$comentarioLiberacion = $INTRANETV2->getOne("SELECT xt_comentarios FROM SGI_Backlog_Liberacion_Funcionalidad where xt_quejaSolicitud ='$solicitudID' and xt_status = 'LIBERADA'");

	
		
		echo "<table width='60%' align='center'>";
	
	
		
		echo "<tr height='15px'></tr>";
		
		echo "<tr align='center'>";
			echo "<td>Comentarios:</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr align='center'>";
			echo "<td> <textarea id='comentarioLibera' rows='4' cols='70'>$comentarioLiberacion</textarea> </td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='3' 			
			style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		
		
		
		echo"<tr height='40'>";
			echo"<td valign='bottom' align='right' colspan='2'>";
			?>
			<div id='btn1' align='right'><a style='cursor:pointer' id='insertaP'  onClick='comentarioLibera()'><img src='../../../Imagenes/ICN_BotonAgregar.png' height='25' width='80'></a></div>
             
             <?php
                                              
				//echo "<input type='submit' name='Enviar' src = '../Imagenes/ICN_BotonAgregar.png'>";
			echo"</td>";
		echo"</tr>";	
		
		echo "<tr height='50px'></tr>";
		
		
	echo "</table>";
	
		

?>





</body>
</html>