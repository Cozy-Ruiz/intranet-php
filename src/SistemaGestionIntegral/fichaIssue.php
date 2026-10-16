<?php error_reporting(0); ?>
<?php
$nombrephp = 'fichaIssue.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");
require_once("../ConexionIntranet2.php");

error_reporting(E_PARSE);

$id = $_GET['id'];

$tipoAtributo 	= $_POST['atributo'];
$codigoAtributo = $_POST['codigoTratamiento'];
$fechaAtributo  = $_POST['fechaTratamiento'];

if($tipoAtributo != "" || $tipoAtributo != NULL){
	
	$INTRANET->Execute("INSERT INTO SGI_Auditorias_Issues_Tratamientos (xt_tipoTratamiento,xt_codigo,kf_issueID,xd_fecha) VALUES ('$tipoAtributo','$codigoAtributo',$id,'$fechaAtributo')");
	
	header("Location: fichaIssue.php?id=$id");
	
}
		   
$s = $INTRANET->Execute("SELECT AI.kf_auditoriaID, AI.xd_fecha, AI.xt_titulo, AI.xt_descripcion, AI.xt_ruta, A.xt_claveAuditoria, AI.xt_claveIssue,AI.xt_status 
						 FROM SGI_Auditorias_Issues AI, SGI_Auditorias A WHERE AI.kf_auditoriaID = A.kp_auditoriaID AND AI.kp_issueID = $id ");

while($r = $s->fetchRow()){
	
	$auditoriaID 	= $r[0];
	$fecha 			= date('Y-m-d', strtotime($r[1]));
	$titulo 		= $r[2];
	$descripcion 	= nl2br($r[3]);
	$ruta 			= $r[4];
	$clave 			= $r[5];
	$claveIssue 	= $r[6];
	$statusIssue	= $r[7];
	
} unset($r); unset($s);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8" />
            <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
            <link type="text/css" href="../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
            <script type="text/javascript" src="../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
            <script type="text/javascript" src="../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
            <script type="text/javascript">;
            $(function(){
                $(".DatP").datepicker({ dateFormat: 'yy-mm-dd',
                 monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] ,
                 dayNamesMin:  ['Dom','Lun','Mar','Mie','Jue','Vie','Sab']
                
                 });
            });
            </script>
			<title>Ficha Hallazgo</title>
 			<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
            <script>
				
				function showTratamiento(valor){
					if(valor == 1){
						document.getElementById("tratamiento1").style.display="none";
						document.getElementById("tratamiento0").style.display="block";
						document.getElementById("formTratamiento").style.display="block";
					} else if (valor == 0){
						document.getElementById("tratamiento1").style.display="block";
						document.getElementById("tratamiento0").style.display="none";
						document.getElementById("formTratamiento").style.display="none";
					}
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
            
        </head>
        <body>
<?php

$breadcrumb = "<a href='../Home.php' id='breadcrumbs'> Home / </a><a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			   <a href='Modulos.php' id='breadcrumbs'> Módulos / </a><a href='tableroAuditorias.php' id='breadcrumbs'> Auditorías </a>";

echo "<div id='wrapperFichaHallazgos' align='center'>";
	echo "<table border='0' align='left'>";
	
		echo "<tr>";
            echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId."</td>";
        echo "</tr>";
		
		echo "<tr>";
            echo "<td align='left' id='breadcrumbs'>Fecha: ".$fecha."</td>";
        echo "</tr>";		
	
	echo"</table>";
	echo "<table border='0' align='center'>";
		echo "<tr height='80px'><td></td></tr>";
			
		echo "<tr>";
			echo "<td align='center' id='titulo1'>";
				echo "Hallazgo";
			echo "</td>";
		echo "</tr>";
		
		echo "<table border='0' align='center'>";
				echo "<tr height='20px'>";
					echo "<td valign='middle'>";
						echo "<img src='../Imagenes/ICN_PointMeTo.png' id='banana1' style='display:none;' onclick='showBanana(0);'>";
						echo "<img src='../Imagenes/ICN_PointMeTo.png' id='banana0' style='display:inline-block;' onclick='showBanana(1);'>";
					echo "</td>";
					
					echo "<td valign='middle'>";
						echo "<font style='display:inline-block;'>".$breadcrumb."</font>";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		
		echo "<tr height='70px'><td></td></tr>";
	echo "</table>";
		
	//banana de navegacion intranet
	  echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
			  include("../navegacion_banana.php");
		  echo "</table>";
		  
        echo "</td>";
    echo "</tr>";
		
	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 
	
	
	//CUERPO FICHA
	echo "<table border='0' align='center' width='800px'>";
		echo "<tr>";
			echo "<td align='left' id='titulo2'><b>".$claveIssue."</b></td>";
			//echo "<td id='iconosTexto2' align='right'><b>Status: ".$statusIssue."</b></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
		
		echo"<tr height='30px'><td colspan='2'></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='800px'>";
		echo "<tr>";
			echo "<td></td>";
			
			echo "<td id='iconosTexto' colspan='2' align='left'><b>".$titulo."</b></td>";
			
			echo "<td id='iconosTexto' width='50' align='right'>";
			
				if ($ruta != NULL){
					
					echo"<a href='downloadAuditoria.php?file=".$ruta."'><img src='../Imagenes/ICN_Archivo.png'></a>";
					
				}
			
			echo "</td>";
		echo "</tr>";
		
		echo"<tr height='10'><td colspan='4'></td></tr>";
		
		echo "<tr>";
			echo "<td width='20px'></td>";
			echo "<td width='20px'></td>";
			echo "<td width='610px' align='justify' id='fileItem'>".$descripcion."</td>";
			echo "<td></td>";
		echo "</tr>";
		
		echo"<tr height='30px'><td colspan='4'></td></tr>";
	echo "</table>";
	
	///AUDITORIA
	echo "<table border='0' align='center' width='800px'>";			
		echo "<tr>";
			echo "<td align='left' id='titulo2'><b>Auditoría relacionada</b></td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' width='800px'></td>";
		echo "</tr>";
		
		echo "<tr height='30px'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='800px'>";
		echo "<tr>";
			echo "<td width='40px'></td>";
			echo "<td id='fichaRef' width='660px'>";
				echo "<b><a href='FichaAuditoria.php?id=".$auditoriaID."' id='fichaRef'>".$clave."</a></b>";
			echo "</td>";
		echo "</tr>";
		
		echo"<tr height='30px'><td colspan='2'></td></tr>";
	echo "</table>";
	
	///TRATAMIENTO
	echo "<table border='0' align='center' width='800px'>";			
		echo "<tr>";
			echo "<td align='left' id='titulo2' width='680'><b>Tratamiento</b></td>";
			
			echo "<td align='right' width='20' >"; 
				 echo"<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15' id='tratamiento1' style='display:block;' onclick='showTratamiento(1);'>";
				 echo"<img src='../Imagenes/ICN_BotonMas.png' height='15' width='15' id='tratamiento0' style='display:none;' onclick='showTratamiento(0);'>"; 
			echo"</td>";
			
		echo "</tr>";
		
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2' width='800px'></td>";
		echo "</tr>";
		
		echo "<tr height='30px'><td></td></tr>";
		
	echo "</table>";
	
	$s = $INTRANET-> Execute ("SELECT xt_codigo,xd_fecha FROM SGI_Auditorias_Issues_Tratamientos WHERE kf_issueID = $id ORDER BY xd_fecha ASC ");
	echo "<table border='0' align='center' width='800px'>";			
		
		echo "<tr align='left' height='20px'>";
				echo "<td width='20px'></td>";
				echo "<td width='300px' align='left' id='iconosTexto2'>Actividad</td>";
				echo "<td width='100px' align='left' id='iconosTexto2'>Código</td>";
				echo "<td width='100px' align='left' id='iconosTexto2'>Reponsable</td>";
				echo "<td width='50px' align='left' id='iconosTexto2'>Fecha</td>";
				
				
			echo "</tr>";
			
			echo"<tr align='left' height='20px'></tr>";
	echo "</table>";
			
			$a = 0;	
			while($r= $s -> fetchRow()){
				$codigoTratamiento 	= $r[0]; 
				$fechaTratamiento	= date('Y-m-d', strtotime($r[1]));
				
		    $a++;
			
			//$x = $INTRANET->Execute("SELECT AC.kp_accionesID, AC.xt_titulo, SE.kf_pdrID FROM SGI_Acciones_Preventivas_Correctivas AC, SGI_Seguimientos SE WHERE AC.xt_claveAccion = '$codigoTratamiento' AND AC.kp_accionesID = SE.kf_itemOrigenID AND SE.xt_tipoOrigen = 'E'");
				
			$x = $INTRANETV2->Execute("SELECT xt_titulo, xt_pdr FROM SGI_Acciones_Preventivas_Correctivas WHERE xt_claveAccion = '$codigoTratamiento'");
						while($p= $x -> fetchRow()){
							
							$tituloCorrectiva = $p[0];
							$pdrCorrectiva    = $p[1];
							
							
							
				///SCRIPT OCULTAR BLOQUES DE LA ACCION CORRECTIVA
				echo "<script>
						function showCorrectiva".$a."(valor){
							if(valor == 1){
								document.getElementById(\"cuerpoCorrectiva".$a."OFF\").style.display=\"block\";
								document.getElementById(\"cuerpoCorrectiva".$a."ON\").style.display=\"none\";
								document.getElementById(\"seguimientoCorrectiva".$a."\").style.display=\"block\";
							} else if (valor == 0){
								document.getElementById(\"cuerpoCorrectiva".$a."OFF\").style.display=\"none\";
								document.getElementById(\"cuerpoCorrectiva".$a."ON\").style.display=\"block\";
								document.getElementById(\"seguimientoCorrectiva".$a."\").style.display=\"none\";
							}
						}
					</script> ";
					
				$enlaceCorrectiva = "<a href='./Intranetv2/fichaCorrectivav2.php?id=".$codigoTratamiento."' id='fichaRef'>".$codigoTratamiento."</a>";
							
				//$nombrePdr = $INTRANET->getOne("SELECT IU.xt_nombre FROM SGI_Empleados E, IntranetGEA_USUARIOS IU WHERE E.kp_personalId = $pdrCorrectiva AND E.kf_usuario = IU.kp_usuario");

				///MOSTRAR BLOQUE CUERPO SOLICITUD
				echo "<table border='0' align='center' width='800px' id='cuerpoCorrectiva".$a."ON' style='display:block;'>";
					echo "<tr onclick='showCorrectiva".$a."(1);'>";
						echo "<td width='20px'></td>";
						echo "<td width='400px' align='left' id='iconosTexto3' valign='top'>".$tituloCorrectiva."</td>";
						echo "<td width='150px' align='center' id='iconosTexto3' valign='top'>".$enlaceCorrectiva."</td>";
						echo "<td width='150px' align='center' id='iconosTexto3' valign='top'>".$pdrCorrectiva."</td>";
						echo "<td width='50px' align='center' id='iconosTexto3' valign='top'>".$fechaTratamiento."</td>";
				echo "</table>";
				
				echo "<table border='0' align='center' width='800px'>";
					echo "<tr height='8px'>";
						echo "<td colspan='6'> </td>";
					echo "</tr>";
				echo"</table>";
				///OCULTAR BLOQUE CUERPO SOLICITUD
				echo "<table border='0' align='center' width='800px' id='cuerpoCorrectiva".$a."OFF' style='display:none;'>";
					echo "<tr height='5px' onclick='showCorrectiva".$a."(0);'>";
						echo "<td width='20px'></td>";
						echo "<td width='400px' align='left' id='iconosTexto3' valign='top'>".$tituloCorrectiva."</td>";
						echo "<td width='150px' align='center' id='iconosTexto3' valign='top'>".$enlaceCorrectiva."</td>";
						echo "<td width='150px' align='center' id='iconosTexto3' valign='top'>".$nombrePdr."</td>";
						echo "<td width='50px' align='center' id='iconosTexto3' valign='top'>".$fechaTratamiento."</td>";
					echo "</tr>";
				echo "</table>";
				
				echo "<table border='0' align='center' width='800px' id='seguimientoCorrectiva".$a."' style='display:none;'>";
						echo "<tr height='5px'>";
								echo "<td colspan='3' id='titleBlueLineBottom'></td>";
						echo "</tr>";
					
					
					$p = $INTRANET->Execute("SELECT DISTINCT
														SSE.xt_titulo,
														SSE.xd_fecha
													FROM
														SGI_Acciones_Preventivas_Correctivas AC,
														SGI_Seguimientos SE,
														SGI_Seguimiento_Etapas SSE
													WHERE
														AC.xt_claveAccion = '$codigoTratamiento'
													AND AC.kp_accionesID = SE.kf_itemOrigenID
													AND SE.xt_tipoOrigen = 'E'
													AND SE.kp_seguimientoID = SSE.kf_seguimientoID
													ORDER BY
														SSE.xn_etapa");
								while($q = $p->fetchRow()){
									
									$tituloEtapa		= $q[0];
									$fechaEtapa 		= date('Y-m-d', strtotime($q[1]));
									
									if($tituloEtapa == "ASIGNAR"){
						
										$tituloEtapa 	= "Asignada";
										
									} else if($tituloEtapa == "ANALISIS"){
										
										$tituloEtapa 	= "Análisis de la causa raíz";
										
									} else if($tituloEtapa == "DECISION"){
										
										$tituloEtapa 	= "Decisión";
										
									} else if($tituloEtapa == "SOLICITUD"){
										
										$tituloEtapa 	= "Plan de acción";
										
									} else if($tituloEtapa == "EVALUACION"){
										
										$tituloEtapa 	= "Evaluación de la eficacia";
									}
					
								echo "<tr height='15px'>";
									echo "<td colspan='6'></td>";
								echo "</tr>";
								
								echo "<tr>";
									echo "<td width='50px'></td>";
									echo "<td width='100px' align='center' id='textIntro'><b>".$fechaEtapa."</b></td>";
									echo "<td width='430px' align='left' id='textIntro'><b>".$tituloEtapa."</b></td>";
									echo "<td width='50px'></td>";
								echo "</tr>";
								
								
								echo "<tr height='15px'>";
									echo "<td colspan='6'> </td>";
								echo "</tr>";
	
							}
							echo "<tr height='5px'>";
								echo "<td colspan='3' id='titleBlueLineBottom'></td>";
							echo "</tr>";
						
						
						echo "<tr height='30px'>";
							echo "<td colspan='6'></td>";
						echo "</tr>";
					echo "</table>";
		
		
						}
			}
	
	echo "<form method='post' action='fichaIssue.php?id=$id' id='formTratamiento' style='display:none;'>";
		echo "<table border='0' align='center' width='800px'>";	
			
			echo "<tr>";
				echo "<td></td>";
				echo "<td colspan='4' id='iconosTexto2'><b style='font-size:16px;'>Agregar tratamiento</b></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td></td>";
				echo "<td colspan='4' id='titleBlueLineBottom'></td>";
			echo "</tr>";
			
			echo "<tr height='20px'>";
				echo "<td colspan='5'></td>";
			echo "</tr>";
			
			echo "<tr align='left' height='20px'>";
				echo "<td width='20px'></td>";
				echo "<td width='30px'></td>";
				echo "<td width='100px' align='left' id='iconosTexto2'>Fecha</td>";
				echo "<td width='150px' align='left' id='iconosTexto2'>Código</td>";
				echo "<td width='400px' align='left' id='iconosTexto2'> Tipo </td>";
			echo "</tr>";
			
			echo "<tr align='left'>";
				echo "<td></td>";
				echo "<td></td>";
				
				echo "<td align='left'>";
					echo "<input type='text' class='DatP' size='10' maxlength='10' name='fechaTratamiento'>";
					//echo "<input type='hidden' name='status' value='SOLICITUD'>";
				echo "</td>";
				
				echo "<td align='left'>";
					echo "<input type='text' size=20 maxlength=100 name='codigoTratamiento'>";
				echo "</td>";
				
				echo "<td align='left'>";
					echo "<select id='seleccion' name='atributo'>";
						echo "<option value='' selected=''>Elegir...</option>";					
						echo "<option value='SOLICITUD'>Solicitud</option>";
						echo "<option value='PREVENTIVA'>Acción Preventiva</option>";
						echo "<option value='CORRECTIVA'>Acción Correctiva</option>";
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='20px'>";
				echo "<td colspan='5'></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td></td>";
				echo "<td colspan='4' id='titleBlueLineBottom'></td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td colspan='5'></td></tr>";
			
			echo "<tr height='40px'>";
				echo "<td></td>";
				echo "<td valign='bottom' align='right' colspan='4'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='30px'>";
				echo "<td align='right' colspan='5'></td>";
			echo "</tr>";
		echo "</table>";
	echo "</form>";
	
	
	///LINEA
	echo "<table border='0' align='center' width='800px'>";
		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo"<tr height='30px'><td></td></tr>";
	echo "</table>";
	
echo "</div>";
			
?>
    	</body>
    </html>
<?php
						
