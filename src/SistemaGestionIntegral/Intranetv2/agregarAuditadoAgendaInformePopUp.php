<?php
 
$nombrephp = 'altaAuditoriaPopUp.php';
require_once("../../ConexionDBT.php");
require_once("../../ConexionIntranet2.php");
require_once("../../compruebaUsuario.php");

error_reporting(E_PARSE);

$clave = $_GET['clave'];
$manual = $_GET['manual'];
$auditor = $_GET['auditor'];
$fechaext = $_GET['fechaext'];
$breadcrumb = "<a href='../../Home.php' id='breadcrumbs'> Home / </a><a href='../homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			   <a href='../Modulos.php' id='breadcrumbs'> Módulos / </a><a href='tablero_auditorias.php' id='breadcrumbs'> Auditorías </a>";

if(($_POST['manual'] == "")||($_POST['auditor'] == "")||($_POST['persona'] == "")||($_POST['puesto'] == "")||($_POST['punto'] == "")||($_POST['fecha'] == "")||($_POST['hora'] == "")){
	
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta charset="utf-8" />
                <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
                <title>Agregar Persona Auditada a la Agenda</title>
                <?php
                if($estiloUsuario == 1){
                    echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
                }else if($estiloUsuario == 2){
                    echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
                }
                ?>
                <link type="text/css" href="../../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
                <script type="text/javascript" src="../../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
                <script type="text/javascript" src="../../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>            

                <script type="text/javascript">;
                    function recargarPadre(){
                        opener.location.reload();
                        window.close();
                    }
                </script> 
            </head>
            <body>
    <?php
	
	echo "<div id='wrapper' style='margin-top: 50px!important; width:700px!important;'>";
	  	echo "<form method='post' action='agregarAuditadoAgendaInformePopUp.php?clave=$clave'>";	
		echo "<table border='0' align='center'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "Agregar Persona Auditada a la Agenda";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr>";
				echo"<td align='center'>";
					echo $breadcrumb;
				echo"</td>";
			echo"</tr>";
			
			echo"<tr height='70px'><td></td></tr>";
		echo "</table>";
		
		echo "<table border='0' align='center' width='450'>";
				
			echo "<tr>";
				echo "<td colspan='3' id='titleBlueLineTop'></td>";
			echo "</tr>";
	
			echo"<tr height='30px'><td colspan='3'></td></tr>";
			
			echo "<tr>";
				echo "<td style='width: 20px;'>";
				echo "</td>";			
				echo "<td id='iconosTexto2' style='width:80px;'>Persona Auditada</td>";
				echo "<td>";
					echo "<input type='text' name='persona'>";
				echo "</td>";
			echo "</tr>";	

			echo"<tr height='10px'><td colspan='3'></td></tr>";

			echo "<tr>";
				echo "<td style='width: 20px;'>";
				echo "</td>";			
				echo "<td id='iconosTexto2' width='100px'>Puesto Auditado</td>";
				echo "<td>";
					echo "<input type='text' name='puesto'>";
				echo "</td>";				
			echo "</tr>";
			
			echo"<tr height='10px'><td colspan='3'></td></tr>";

			echo "<tr>";
				echo "<td style='width: 20px;'>";
				echo "</td>";			
				echo "<td id='iconosTexto2' width='100px'>Punto Auditado</td>";
				echo "<td>";
					echo "<input type='text' name='punto'>";
				echo "</td>";				
			echo "</tr>";
			
			echo"<tr height='10px'><td colspan='3'></td></tr>";

			echo "<tr>";
				echo "<td style='width: 20px;'>";
				echo "</td>";			
				echo "<td id='iconosTexto2' width='100px' colspan = '3'>Fecha y hora auditada</td>";
			echo "</tr>";

			echo"<tr height='10px'><td colspan='3'></td></tr>";

			echo "<tr>";
				echo "<td style='width: 20px;'>";
				echo "</td>";	
				echo "<td><span style='display:inline-block; width: 20px;'></span><input type='date' name='fecha' value='".date('Y-m-d')."'   size='10'></td>";
				  
				echo "<td>";
				?>
				<input type="time" class="form-control" value="<?php $date = date("H:i"); echo "$date"; ?>" name='hora' id='time'" />
				 <?php
				echo "</td>";	
			echo "</tr>";
			
			echo"<tr height='30px'><td colspan='3'></td></tr>";

			echo"<tr height='40px'>";
				echo"<td valign='bottom' align='right' colspan='3'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29' style='padding-right:30px;'>";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr height='20px'><td colspan='3'></td></tr>";
			
			echo "<tr>";
				echo "<td colspan='3' id='titleBlueLineBottom'></td>";
			echo "</tr>";
			
			echo"<tr height='50px'><td colspan='3'></td></tr>";
		echo "</table>";
		echo "<input type='hidden' value='$manual' name='manual'>";
		echo "<input type='hidden' value='$auditor' name='auditor'>";
		echo "<input  type='hidden' value='$fechaext' name='fechaext'>";
		echo "</form>";
	echo "</div>";

} else if(($_POST['manual'] != "")&&($_POST['auditor'] != "")&&($_POST['persona'] != "")&&($_POST['puesto'] != "")&&($_POST['punto'] != "")&&($_POST['fecha'] != "")&&($_POST['hora'] != "")&&($_POST['fechaext'] != "")){
	
	$clave = $_GET['clave'];
	$auditor = $_POST['auditor'];
	$manual = $_POST['manual'];
	$fechaext = $_POST['fechaext'];
	$persona = $_POST['persona'];
	$puesto = $_POST['puesto'];
	$punto = $_POST['punto'];
	$fecha = $_POST['fecha'];
	$fecha	= new DateTime ($fecha);
	$fecha	= $fecha->format("Y-m-d");
	$hora = $_POST["hora"];
	$fechaAuditoria = $fecha . " " . $hora;
	$query="INSERT INTO SGI_Auditorias_Auditados (xt_claveAuditoria, xt_codigoManual, xt_claveAuditor, xt_auditado, xt_puestoAuditado, xt_puntoAuditado, xd_fecha,xd_fechaRealizacionAuditoria) VALUES('$clave', '$manual', '$auditor', '$persona', '$puesto', '$punto','$fechaAuditoria','$fechaext')";

	if($INTRANETV2->Execute("INSERT INTO SGI_Auditorias_Auditados (xt_claveAuditoria, xt_codigoManual, xt_claveAuditor, xt_auditado, xt_puestoAuditado, xt_puntoAuditado, xd_fecha,xd_fechaRealizacionAuditoria) VALUES('$clave', '$manual', '$auditor', '$persona', '$puesto', '$punto','$fechaAuditoria','$fechaext')")){		
		?>
            <script type="text/javascript">
                opener.location.reload();
                window.close();
            </script> 
		<?php
		
	} else{
echo"
	<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
	<html xmlns=\"http://www.w3.org/1999/xhtml\">
	    <head>
	        <meta charset=\"utf-8\" />
	        <link rel=\"shortcut icon\" type=\"image/x-icon\" href=\"../../Imagenes/ICN_PestanaWebGE.png\">
	        <title>Agregar Registro en la Agenda</title>";
	        if($estiloUsuario == 1){
	            echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
	        }else if($estiloUsuario == 2){
	            echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
	        }
	        echo "
	    </head>
	    <body>	";

		echo "<div id='wrapper' style='margin-top: 50px!important; width:700px!important;'>";
			echo "<table border='0' align='center'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "Registro de Agenda no Agregada";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr>";
					echo"<td align='center'>";
						echo $breadcrumb;
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='70'><td></td></tr>";
			echo "</table>";
			
			echo "<table border='0' align='center' width='450px'>";
					
				echo "<tr>";
					echo "<td id='titleBlueLineTop' width='450px'></td>";
				echo "</tr>";
		
				echo "<tr height='15px'><td></td></tr>";
				
				echo "<tr align='left' height='20px'>";
					echo "<td id='iconosTexto2' align='center'>Error</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td  align='center'>";
						echo "Registro no agregado
						<br> $query";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='10px'><td></td></tr>";
				
				echo "<tr height='40px'>";
					echo "<td valign='bottom' align='right'>";
						echo "<input type='button' value='Finalizar' onclick=\"window.close();\">";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='10px'><td></td></tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'></td>";
				echo "</tr>";
				
				echo "<tr height='30px'>";
					echo "<td align='right'></td>";
				echo "</tr>";
						
			echo "</table>";
			
		echo "</div>";
	}
}
?>
	</body>
</html>
