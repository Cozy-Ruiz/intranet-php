<?php error_reporting(0); ?>
<!doctype html>
<html>
<head>

<?php
require_once("../../../ConexionDBT.php");
require_once("../../../ConexionIntranet2.php");

 $solicitudID = $_POST['codigo'];

 $comentarioVN = $_POST['comentario'];
?>

<meta charset="utf-8">
<title>Documento sin título</title>

<!-- SCRIPT PARA CAMBIAR EL COLOR DE LAS CELDAS -->
 <script language="javascript" type="text/javascript">
 
 function comentarioVN(){
	 
	 var codigo ="<?php echo $solicitudID;?>";
	 
	var comentarioVN = document.getElementById('comentarioVerifN').value;
	
	if(comentarioVN != ''){
		
		alert (comentarioVN);
		
		$('#comentarioVN').load("comentarioVN.php", {codigo: codigo, comentario : comentarioVN}, function(data){

        })
		
	}
	
	  

 }
 
 </SCRIPT>
 
</head>

<body>

<?php

	//inserto comentario
	if($comentarioVN != ''){
		
		$INTRANETV2->getOne("UPDATE SGI_Backlog_Validaciones SET xt_comentario = '$comentarioVN' WHERE xt_quejaSolicitud = '$solicitudID' and 
		xt_tipoValidacion = 'NEGOCIO'");
		
		?>
        <script language="javascript" type="text/javascript">
        alert("Modificaciones realializadas correctamente");
        </script>
        <?php
		
	}

	//hago consulta para obtener el comentario en validacion de negocio
              
	$comentarioVN = $INTRANETV2->getOne("SELECT xt_comentario FROM SGI_Backlog_Validaciones where xt_quejaSolicitud ='$solicitudID' and 
	xt_tipoValidacion = 'NEGOCIO'");

	
		
		echo "<div id='comentarioVN'>";
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
			echo "<td> <textarea id='comentarioVerifN' rows='4' cols='70'>$comentarioVN</textarea> </td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='3' 			
			style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		
		
		
		echo"<tr height='40'>";
			echo"<td valign='bottom' align='right' colspan='2'>";
			?>
			<div id='btn1' align='right'><a style='cursor:pointer' id='insertaP'  onClick='comentarioVN()'><img src='../../../Imagenes/ICN_BotonAgregar.png' height='25' width='80'></a></div>
             
             <?php
                                              
				//echo "<input type='submit' name='Enviar' src = '../Imagenes/ICN_BotonAgregar.png'>";
			echo"</td>";
		echo"</tr>";	
		
		echo "<tr height='50px'></tr>";
		
		
	echo "</table>";
	
	echo "</div>";

		

?>





</body>
</html>