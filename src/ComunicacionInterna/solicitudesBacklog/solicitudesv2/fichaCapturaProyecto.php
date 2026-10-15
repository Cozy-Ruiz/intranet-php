<?php error_reporting(0); ?>
<?php
$nombrephp = 'fichaCapturaEnvioArchivos.php';
require_once("../../../ConexionDBT.php");
require_once("../../../compruebaUsuario.php");
//require_once("MailSolicitudAsignar.php");


//obtengo la(s) ciudad del usuario
$indice = 0;
$s = $INTRANET->Execute("SELECT
	CASE xt_ciudad
WHEN 'DF' THEN
	'CMX'
WHEN 'LR' THEN
	'LRD'
ELSE
	xt_ciudad
END
FROM
	IntranetGEA.SGI_Empleados
WHERE
	kf_usuario = '$usuarioId'
ORDER BY
	xt_ciudad ");

while($r = $s->fetchRow()){
	$ciudadesDisponibles[$indice] = $r[0];
	$indice++;
	
} unset($r); unset($s); unset($indice);


//Defino estilo
if($estiloUsuario == 1){
	echo "<link type='text/css' rel='stylesheet' href='../../../css/styleHomePage.css'/>";
}else if($estiloUsuario == 2){
    echo "<link type='text/css' rel='stylesheet' href='../../../css/styleHomePage2.css'/>";
}
?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Ficha Captura Funcionalidad Proyecto</title> 
       	    <link rel="shortcut icon" type="image/x-icon" href="../../../Imagenes/ICN_PestanaWebGE.png">
            <link type="text/css" href="../../../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
            <script type="text/javascript" src="../../../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
            <script type="text/javascript" src="../../../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
            <script type="text/javascript">;
                    $(function(){
                        $(".DatP").datepicker({ dateFormat: 'yy-mm-dd',
                         monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] ,
                         dayNamesMin:  ['Dom','Lun','Mar','Mie','Jue','Vie','Sab']
                        
                         });
                    });
            </script>
            
            <script type="text/javascript">
                function reCargarPadre(){
                    opener.location.reload();
                    window.close();
                }
            </script>
            
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
            <!--<script language="javascript" type="text/javascript" src="jquery-1.3.2.min.js"></script>-->
            <script language="javascript" type="text/javascript">
                $(document).ready(function(){
                    $(".contenido").hide();
                    $("#envioArchivos").change(function(){
                    $(".contenido").hide();
                        $("#div_" + $(this).val()).show();
                    });
                });
            </script>

            
    </head>
    <body>
<?php



$breadcrumb="<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Home.php' id='breadcrumbs'>Home / </a><a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/comunicacionInterna.php' id='breadcrumbs'> Comunicación Interna / </a> 
			<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/tableroSolicitudesyQuejasv2.php' id='breadcrumbs'> Solicitudes </a>";
			
echo"<div id='wrapperFicha' align='center'>";
	
	echo "<table border='0' align='center' name='Encabezado' width='700px'>";
	
		echo "<tr height='12px'>";
			echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId." </td>";
		echo "</tr>";
		
		echo"<tr height='20px'> </tr>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Nueva Funcionalidad de Proyecto</font>";
			echo"</td>";
		echo"</tr>";
		echo"<tr>"; 
			echo"<td align='center' valign='top' height='20px'>";
				echo "<table border='0' align='center'>";
					echo "<tr height='20px'>";
						echo "<td valign='middle'>";
							echo "<img src='../../../Imagenes/ICN_PointMeTo.png' id='banana1' style='display:none;' onclick='showBanana(0);'>";
							echo "<img src='../../../Imagenes/ICN_PointMeTo.png' id='banana0' style='display:inline-block;' onclick='showBanana(1);'>";
						echo "</td>";
						
						echo "<td valign='middle'>";
							echo "<font style='display:inline-block;'>".$breadcrumb."</font>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo"</td>";
		echo"</tr>";
		//echo"<tr height='70'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
		include("../../../navegacion_banana.php");
	echo "</table>";
		
	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 

		
//CUERPO SOLICITUD
$fecha = date("Y-m-d");
echo "<form name='form' action='procesaSolicitudPY.php?usuario=".base64_encode($usuarioId)."' method='POST'  enctype='multipart/form-data'>";
	echo "<table border='0' align='center' width='700'>";
		echo"<tr>";
			echo"<td align='left' id='titulo2' width='550'>";
				echo "DATOS GENERALES";
			echo"</td>";
			echo"<td align='right' id='iconosTexto2' width='150'>";
			//Aqui va el estatus de la solicitud
			echo"</td>";
		echo"</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
		
		echo"<tr height='30'> </tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='700'>";
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td id='iconosTexto' colspan='2' align='left'><b>Fecha</b></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td height='10px;'>";				
			echo"</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td id='iconosTexto' colspan='2' align='left'>&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='fecha' style='width:18%;height:23px;' value='$fecha' readonly></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td height='10px;'>";				
			echo"</td>";
		echo "</tr>";		
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td id='iconosTexto' colspan='2' align='left'><b>Grupo</b></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td height='10px;'>";				
			echo"</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td id='iconosTexto' colspan='2' align='left'>&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<input type='text' name='grupo' style='width:10%;height:23px;' value='GE' readonly>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td height='10px;'>";				
			echo"</td>";
		echo "</tr>";		
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td id='iconosTexto' colspan='2' align='left'><b>Ciudad</b></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td height='10px;'>";				
			echo"</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td id='iconosTexto' colspan='2' align='left'>&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "<select name='ciudad' id ='ciudad'>";
			for($a=0; $a<count($ciudadesDisponibles); $a++){
				echo "<option value='".$ciudadesDisponibles[$a]."' selected='selected'>$ciudadesDisponibles[$a]</option>";
			}
		   echo "</select>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td height='10px;'>";				
			echo"</td>";
		echo "</tr>";		
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td id='iconosTexto' colspan='2' align='left'><b>Proyecto</b></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td height='10px;'>";				
			echo"</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td id='iconosTexto' colspan='2' align='left'>&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<select name='sistema' id ='proyecto'>";				  
				   $r1 = $INTRANET->Execute("SELECT DISTINCT xt_nombreProyecto, xt_codigoProyecto FROM IntranetGEA.SGI_Portafolio_Proyecto");
					  while($fila1 = $r1->fetchRow()){
						if($fila1[1] == 'GE-FF-2014-0025'){
							echo "<option value='".$fila1[0]."' selected='selected'>$fila1[0]</option>";
						}else{
					
					  		echo "<option value='".$fila1[0]."'>$fila1[0]</option>";
						}
					  }
				echo "</select>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td height='10px;'>";				
			echo"</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td id='iconosTexto' colspan='2' align='left'><b>Código WBS</b></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td id='iconosTexto' colspan='4' align='left'>&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "<input type='text' name='wbs' size=25 required>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td height='10px;'>";				
			echo"</td>";
		echo "</tr>";
		
		
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td id='iconosTexto' colspan='2' align='left'><b>T&iacute;tulo</b></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td height='10px;'>";				
			echo"</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td id='iconosTexto' colspan='4' align='left'>&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<input type='text' name='titulo' style='width:80%;height:23px;' placeholder='Titulo' required>";
				//echo "<textarea name='titulo' style='width:100%;height:23px;' placeholder='Titulo'></textarea>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td height='10px;'>";				
			echo"</td>";
		echo "</tr>";		
		
				
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td id='iconosTexto' colspan='2' align='left'><b>Descripci&oacute;n</b></td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td height='10px;'>";				
			echo"</td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td> </td>";
			echo "<td> </td>";
			echo "<td id='iconosTexto' colspan='4' align='left'>&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<textarea name='descripcion' style='width:80%;height:70px;' placeholder='Descripcion' required></textarea>";
			echo "</td>";
		echo "</tr>";
		echo "<tr>";
		//campo hiden de prioridad
			echo "<input type='hidden' name='prioridad' value='Normal'>";
			echo "<input type='hidden' name='usuario' value='$usuarioId'>";
		echo "</tr>";
	echo "</table>";
	echo "<br>";
	echo "<br>";

	echo "<br>";
	echo "<table border='0' align='center' width='700'>";	
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
		echo"<tr height='30'> </tr>";
		echo "<tr>";
			echo "<td></td>";
			echo "<td align='right'>";
		  		echo "<input type='image' onclick='SubmitForm(this.form);' src='../../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				//echo "<input type='submit' name='Enviar' src = 'Imagenes/ICN_BotonAgregar.png'>";
			echo "</td>";
		echo "</tr>";
	echo "</table>";
	echo "<br>";
	echo "<br>";
	echo "</form>";
echo "</div>";
?>
</body>
</html>