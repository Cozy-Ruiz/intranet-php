<?php
ini_set('max_execution_time', 300);
ini_set("display_errors", 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$nombrephp = 'reporteMensual.php';
require_once("conexionMasterDB.php");
//require_once("compruebaUsuario.php");
?>
	
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Reporte Mensual</title>

<link href="css/style2.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
<script type="text/javascript" src="JQuery/js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript">;
$(function(){
    $(".DatP").datepicker({ dateFormat: 'yy-mm-dd',
     monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] ,
     dayNamesMin:  ['Dom','Lun','Mar','Mie','Jue','Vie','Sab']
    
     });
});
</script>

</head>
<body>
<?php
echo "<div id='wrapperPopUp'>";
	echo "<form method='post' action='reporteMensualExcel2.php'>";

		echo "<table border='0' align='center'>";
			
			echo"<tr height='50'> </tr>";
			
			echo "<tr>";
				echo "<td  width='400' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='15'> </tr>";
			
		echo "</table>"; 	
								
		
		echo "<table border='0' align='center'>";
			
				echo "<tr id='iconosTexto2'>";
					echo"<td align='center' id='iconosTexto'>Start Date</td>";
				echo"</tr>";
				
				echo"<tr height='15'> </tr>";
				
				echo "<tr>";
					echo"<td align='center'><input type='text' name='fechaInicial' class ='DatP'></td>";
				echo "</tr>";
		
				echo"<tr height='15'> </tr>";
				
				echo "<tr id='iconosTexto2'>";
					echo"<td align='center' id='iconosTexto'>End Date</td>";
				echo"</tr>";
				
				echo"<tr height='15'> </tr>";
		
				echo "<tr>";
					echo"<td align='center'><input type='text' name='fechaFinal' class ='DatP'></td>";
				echo "</tr>";
				
				echo"<tr height='15'> </tr>";
				
				echo "<tr id='iconosTexto2'>";
					echo"<td align='center' id='iconosTexto'>Customs</td>";
				echo"</tr>";
				
				echo"<tr height='15'> </tr>";
				
				echo "<tr>";
					echo"<td align='center'>";
						echo "<select name='aduana'>";
							echo "<option value=''> Seleccionar </option>";	
							echo "<option value='470'>Aeropuerto </option>";
							echo "<option value='430'>Veracruz </option>";
							echo "<option value='800'>Nuevo Laredo </option>";
						echo "</select>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='15'> </tr>";
				
				echo "<tr>";
					echo "<td width='400' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
				
				echo"<tr height='15'> </tr>";
					
				echo"<tr>";
					echo"<td valign='bottom' align='right'>";
						echo "<input type='submit' onclick='SubmitForm(this.form);' value='Enviar'></input>";
					echo"</td>";
				echo"</tr>";	
		
		echo "</table>";
	echo "</form>";
echo "</div>";		
															
?>
</body>
</html>
