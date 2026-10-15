<?php error_reporting(0); ?>
﻿<?php


header('Content-Type: text/html; charset=UTF-8');


$nombrephp='fichaSoporteTecnico.php';
require_once("../../../ConexionDBT.php");
require_once("../../../ConexionIntranet2.php");
require_once("../../../compruebaUsuario.php");

error_reporting(E_PARSE);

/*require_once("MailSolicitudAsignar.php");
require_once("MailSolicitudRevisar.php");
require_once("MailSolicitudRechazar.php");*/

//$solicitudID = $_GET['id'];
$codigo = $_GET['codigo'];
//$codigo = "GE-B-DF-15-047";
// save old value
$saved = getenv("upload_tmp_dir");
// extra paths to add
$newld = "/extra/library/dir:/another/path/to/lib";
// append old paths if any
if ($saved) { $newld .= ":$saved"; }
// set new value
putenv("upload_tmp_dir");
// do system command;
@system("mycommand -with args");
// mycommand is loaded using
// libs in the new path list
// restore old value 
putenv("LD_LIBRARY_PATH=$saved");

$breadcrumb="<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Home.php' id='breadcrumbs'>Home / </a><a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/comunicacionInterna.php' id='breadcrumbs'>Comunicación Interna / </a>
			<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/solicitudesv2/tableroSolicitudesyQuejasv2.php' id='breadcrumbs'> Solicitudes </a>";

?>
<!DOCTYPE html>
<html lang='es'>
	<head>
        <meta charset="utf-8">
        <title><?php echo $codigo; ?></title>
		<?php
		if($estiloUsuario == 1){
			?>
			<link type='text/css' rel='stylesheet' href='../../../css/styleHomePage.css'/>
            <?php
		}else if($estiloUsuario == 2){
			?>
			<link type='text/css' rel='stylesheet' href='../../../css/styleHomePage2.css'/>
            <?php
		}
		?>
        
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
        
        <script type="text/javascript">
        function PopUp(){
            window.open("http://71.144.19.155/INTRANET_GEA/Backlog/solicitudesv2/cierreSoporteTecnico.php?codigo=<?php echo $codigo; ?>&usuario=<?php echo $usuarioId; ?>","_blank", "toolbar=yes, scrollbars=no, resizable=yes, top=500, left=500,width=800, height=800");
        }
        </script>
        
        <script>
 
			$('#prioridadAsignada').change(function(){
			 
			var ciudad = $(this).val()
			
			alert('Has seleccionado ' + ciudad);
			 
			});
		</script>
   		
        <!-- SCRIPT PARA CAMBIAR EL PDR -->
        <script type="text/javascript">
			function cambiaPDR(tipoS, titulo, nombreSolicitante, correoSolicitante){

				var codigo ="<?php echo $codigo;?>";
				var titulo = titulo;
				var tipoS = tipoS;
				var nombreSolicitante = nombreSolicitante;
				var correoSolicitante = correoSolicitante;
				var pdr=$("#pdrAsignado").val();
				//alert(codigo+pdr);
				
				document.getElementById("contCambiaPDR").style.display="none";
	   			document.getElementById("contPDR").style.display="block";
					 
				$('#contCambiaPDR').load("cambiaPDRST2.php",{pdr: pdr, codigo: codigo, titulo: titulo, tipoS: tipoS, correoSolicitante: correoSolicitante, nombreSolicitante: nombreSolicitante}, function(data){
	
				});
			}
         </script>
         
         <!-- SCRIPT PARA MOSTRAR EL DIV DE CAMBIO DE PRIORIDAD -->
		<script language="javascript" type="text/javascript">
            function activaCP(){
         
                var div1 = document.getElementById("contPU");
                var div2 = document.getElementById("contCambiaP");
             
                if(div1.style.display == "block"){
                    div1.style.display = "none";
                    div2.style.display = "block";
                }
             
            }
        </script>
        
         <!-- SCRIPT PARA MOSTRAR EL DIV DE CAMBIO DE PRIORIDAD -->
		<script language="javascript" type="text/javascript">
            function activaPDR(){
         
                var div1 = document.getElementById("contPDR");
                var div2 = document.getElementById("contCambiaPDR");
             
                if(div1.style.display == "block"){
                    div1.style.display = "none";
                    div2.style.display = "block";
                }
             
            }
        </script>   
     
        <!-- SCRIPT PARA CAMBIAR LA PRIORIDAD -->
        <script language="javascript" type="text/javascript">
             function cambiaPrioridad(prioridad){
                  
                var codigoS ="<?php echo $codigo;?>";
                var usuario = "<?php echo $usuarioId;?>";
                var prioridadNueva=$("#prioridadAsignada").val();
                var prioriJustifica=$("#txtJustificacion").val();
                
                var prioridadAnt = prioridad;
                   
                if(prioridadNueva != ''){
                    
                    $('#contPrioridad').load("cambiaPrioridadSolicitud.php", {codigoS:codigoS, prioridadAnt:prioridadAnt, prioridadNueva:prioridadNueva, usuario:usuario, prioriJustifica:prioriJustifica}, function(data){
            
                    })
                    
                    //alert(prioridadAnt+prioridadNueva+codigoS+prioriJustifica);
                    
              //  }           
             }    
      </script>
         
    </head>
    <body>
<?php

      
echo"<div id='wrapperFicha' align='center'>";
	
	echo "<table border='0' align='center' name='Encabezado' width='700px'>";
	
		echo "<tr height='12px'>";
			echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId." </td>";
		echo "</tr>";
		
		echo"<tr height='20px'> </tr>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Solicitud de soporte técnico</font>";
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
			echo "</td>";
		echo "</tr>";
		
	$perfil = array();
	//OBTENER LOS PERFILES DEL USUARIO CON LA SESION INICIADA
	$indexPerfil = 0;
	$r = $INTRANET->Execute("SELECT xt_perfil FROM SGI_Backlog_Perfiles WHERE xt_nombreUsuario = '$usuarioId'");
	while($s = $r->fetchRow()){
		$perfilCP[$indexPerfil] = $s[0];
		$indexPerfil++;
	}
			
		echo "<table border='0' align='center'>";
			echo"<tr height='100'><td></td></tr>";
		echo "</table>"; 


		if((@$_POST['status'] == "EVALUACION") && (@$_POST['fechaEvaluacion'] != "") && (@$_POST['evaluacion'] != "")){
	
			$fechaInsert		= date('Y-m-d', strtotime($_POST['fechaEvaluacion']));
			$descripcionInsert 	= nl2br($_POST['descripcionEvaluacion']);
			$evaluacion 		= $_POST['evaluacion'];		
			
			$estatusMax 	= 0;
			
			$s = $INTRANETV2->Execute("SELECT MAX(xn_numero) FROM SGI_Quejas_Solicitudes_Estatusv2 WHERE xt_quejaSolicitud = '$codigo' ");
			
			while($r = $s->fetchRow()){
				
				$estatusMax = $r[0];
				
			} unset($r);
			
			$estatusMax++;
			
																	
			if($INTRANETV2->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2(xt_quejaSolicitud, xn_numero, xt_estatus, xt_contenido, xd_fecha, kf_usuario) 
																	VALUES('$codigo', '$estatusMax' , '$evaluacion', '$descripcionInsert', '$fechaInsert', '$usuarioId') ")){
																		
				$INTRANETV2->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = '$evaluacion' WHERE xt_quejaSolicitud = '$codigo' ");
				
				if($evaluacion == "RECHAZADA"){
					
					$correoPDRMail = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$pdrUserId' ");
					$nombrePDRMail = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$pdrUserId' ");
				
					$enviaMailRechaza = new MailSolicitudRechazar();
					$enviaMailRechaza->mailSolicitudRechazarIntra($clave, $correoPDRMail, $nombrePDRMail, $descripcionInsert);
					
				}
			}
			$archivo = $_FILES['archivoEvaluacion']['name'];
			
			
			if ($archivo != ""){
				
				 $destino = "../../SeguimientoEtapas/".$archivo;
				
				if (move_uploaded_file($_FILES['archivoEvaluacion']['tmp_name'], $destino)){
	
					$INTRANETV2->Execute("UPDATE SGI_Quejas_Solicitudes_Estatusv2 SET xt_ruta = '$archivo' WHERE xt_quejaSolicitud = '$solicitudID' AND xn_numero = $estatusMax ");
				}
				
			}
			$archivo = $_FILES['archivoEvaluacion']['name'];
			
			if ($archivo != ""){
				$destino = "../../SeguimientoEtapas/".$archivo;
				
				if (move_uploaded_file($_FILES['archivoEvaluacion']['tmp_name'], $destino)){
					
					$INTRANETV2->Execute("UPDATE SGI_Quejas_Solicitudes_Estatusv2 SET xt_ruta = '$archivo' WHERE xt_quejaSolicitud = '$solicitudID' AND xn_numero = $estatusMax  ");
		
					//$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudes_Estatus SET xt_ruta = '$archivo' WHERE kp_estatusID = $estatusMax ");
					
				}
			}
			
			//echo"<script language='javascript'>window.location='fichaSoporteTecnico.php?codigo=".urlencode($solicitudID)."'</script>;";
		 }
	
	/*********************************************************************************************************
	*                                                                                                         *
	*                          Consultas                                                                      *
	**********************************************************************************************************/
	
	$s = $INTRANETV2->Execute("SELECT xt_quejaSolicitud,xt_titulo,xt_grupo,xt_ciudad,xd_fecha,xt_descripcion,xt_ruta,kf_usuarioId,xt_status,xt_pdr, xt_tipoSolicitud FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$codigo'");
	while($r = $s->fetchRow()){
		$titulo = $r[1];
		$codigo = $r[0];
		$descripcion = $r[5];
		$solicitante = $r[7];
		$estatus = $r[8];
		$rutaDocumento = $r[6];
		$fechaSolicitud = $r[4];
		$pdr = $r[9];
		$tipoS = $r[10];
	}
	
	//obtengo prioridad y justificacion
	$ss = $INTRANETV2->Execute("SELECT xt_prioridad, xt_justificacion, xd_fecha FROM SGI_Backlog_Prioridad WHERE xt_quejaSolicitud = '$codigo' ORDER BY xd_fecha ASC");
	 
	while($rr = $ss->fetchRow()){
		$prioridad = $rr[0];
		$justificacionS = $rr[1];
		$fechaPrioridad = $rr[2];
	
	}
	
	
	$sss = $INTRANETV2->Execute("SELECT xt_titulo, xt_contenido,xt_ruta, xd_fecha FROM SGI_Quejas_Solicitudes_Estatusv2 WHERE xt_quejaSolicitud = '$codigo'");
	while($rrr = $sss->fetchRow()){
		$tituloE = $rrr[0];
		$contenidoE = $rrr[1];
		$rutaE = $rrr[2];
		$fechaE = $rrr[3];
	}
	//CUERPO SOLICITUD
	  echo "<table border='0' align='center' width='700'>";
		  echo"<tr>";
			  echo"<td align='left' id='titulo2' width='450'>";
				  echo "<b>$codigo</b>";
			  echo"</td>";
			  echo"<td align='right' id='titulo2' width='250'>";
			  echo "Estatus: ".ucwords(strtolower($estatus))."";//Aqui va el estatus de la solicitudID
			  echo"</td>";
		  echo"</tr>";
		  
		  echo "<tr>";
			  echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		  echo "</tr>";
		  
		  echo"<tr height='15px'> </tr>";
	  echo "</table>";
	  
	  echo "<table border='0' align='center' width='700'>";
		  echo "<tr>";
			  echo "<td width='25px;'> </td>";
			  echo "<td id='iconosTexto' align='left'><b>$titulo</b></td>";
		  echo "</tr>";
		  echo "<tr>";
			  echo "<td height='10px;'>";				
			  echo"</td>";
		  echo "</tr>";        
	  echo "</table>";
	
	  echo "<table border='0' align='center' width='700'>";
		  echo "<tr>";
			  echo "<td width='60px;'> </td>";
			   echo "<td align='justify' id='fileItem'>$descripcion</td>";
			   
			   if($rutaDocumento != ''){
					echo "<td width='40px;' align = 'center' valign = 'top'><a href='http://71.144.19.155/INTRANET_GEA/Backlog/solicitudesv2/extraccionDoctos.php?codigo=$codigo&ruta=$rutaDocumento' style='margin-top:-5px;'><img src='../../../Imagenes/ICN_Archivo.png'></a></td>";
			   }else{
					echo "<td width='40px;'></td>"; 
			   }
		  echo "</tr>";
	 echo "</table>";
	 echo "<br><br>";
	
	 echo "<table border='0' align='center' width='700'>";
		echo"<tr>";
			echo"<td align='left' id='titulo2'>";
				echo "<b>Solicitante</b>";
			echo"</td>";
			echo "<td width='25px;'> </td>";
			echo "<td width='25px;'> </td>";
			echo"</td>";
		echo"</tr>";        
	 echo "</table>";
	
	 echo "<table border='0' align='center' width='700'>";
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='3'></td>";
		echo "</tr>";
		echo "<tr height='10px;'></tr>";
		echo "<tr>";
			echo "<td width='25px;'> </td>";
				$nombreSolicitante = $INTRANET->getOne("SELECT xt_nombre FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$solicitante' ");
			echo "<td id='iconosTexto' align='left' colspan='2'>$nombreSolicitante</td>";
		echo "</tr>";
	 echo "</table>";
	 echo "<br>";
	
	  echo "<br><br>";
	
	  //PRIORIDAD
	 echo "<table border='0' align='center' width='700'>";
		  echo"<tr>";
			  echo"<td align='left' id='titulo2' width='550'><b>PDR (Persona Directamente Responsable)</b></td>";
			  echo"</td>";
		  echo"</tr>";
		  
		  echo "<tr>";
			  echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		  echo "</tr>";
		  
		  echo"<tr height='20'> </tr>";
	 echo "</table>";
		  //select de PDR
			  
	  //verifico perfil para habilitar funcionalidad 
	  //echo "Select xt_perfil from SGI_Backlog_Perfiles WHERE xt_nombreUsuario = '$usuarioId'";
	  $p = $INTRANETV2->Execute("Select xt_perfil from SGI_Backlog_Perfiles WHERE xt_nombreUsuario = '$usuarioId'");
	  $bandera = 0;
	  while($perfilPDR = $p -> FetchRow()){
		  
		  $perfilActiva = $perfilPDR[0];
	  }
	  
	  $nombrePDR = $INTRANET->getOne("SELECT xt_nombre FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$pdr'");
					   
	  //echo"$perfilActiva";
	  if(@$perfilActiva == 'Jefe de Desarrollo' || @$perfilActiva == 'Asignador PDR'){
			  
		  echo "<div id='contPDR' style='display:block'>";
			  echo "<table border='0' align='center' width='700'>";
				  echo "<tr>";
					  echo "<td> </td>";
					  
					  echo "<td id='iconosTexto' align='left'><b>".$nombrePDR."</b></td>";
					  
					  echo"<td align='left' valign='bottom' style='padding:0px 0px 0px 10px' colspan='2'></td>";
				  echo "</tr>";
	  
				  echo"<tr height='10'> </tr>";
		  
				  echo "<tr>";
					  echo "<td width='20'> </td>";
			  
					  echo "<td colspan='2' style='padding:0px 0px 0px 15px' id='fileItem'></td>";
				  echo "</tr>";
		  
				  
				  echo"<tr height='10'> </tr>";
			  echo "</table>";
			  
			  echo "<table border='0' align='center' width='700'>";
			  echo "<tr>";
				  
					  echo"<td align='right' valign='bottom' style='padding:0px 0px 0px 10px' colspan='2'>";
					  ?>
					  <div id="btn1" ><a style="cursor:pointer" id="insertaP"  onClick="activaPDR()"><font color='#007CBD'>Modificar</font></a></div>
						  <?php
				  echo "</td>";
				  
				  echo "</tr>";
				  
				  echo"<tr height='20'> </tr>";
			  echo "</table>";
		   echo "</div>";
			  
		   echo "<div id='contCambiaPDR' style='display:none'>";
			echo "<table border='0' align='center' width='700'>";
				echo "<tr>";
				  echo "<td id='iconosTexto' align='left'>";
					  echo "<select name='pdrAsignado' id='pdrAsignado'>";
					  $pdrAntiguo = $INTRANETV2->Execute("SELECT xt_pdr from SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$codigo'");
					  $r = $INTRANETV2->Execute("SELECT BS.xt_administrador, IU.xt_nombre FROM SGI_Backlog_Administradores_de_Sistemas BS, IntranetGEA.IntranetGEA_USUARIOS IU WHERE BS.xt_administrador = IU.kp_usuario AND BS.xt_sistema = 'SOPORTE TECNICO'");
											while($fila = $r->fetchRow()){
												$nombreAdministrador = $fila[1];
												
												if($fila[0] == "$pdrAntiguo"){
													 echo "<option value='".$fila[0]."' SELECTED>$fila[1]</option>";
												}else {
													echo "<option value='".$fila[0]."'>$fila[1]</option>";
												}
											}
					  echo "</select>";
				  echo "</td>";
			  echo "</tr>";	
			  echo"<tr height='40'>";
			 echo"<td align='right' valign='bottom' style='padding:0px 0px 0px 10px' colspan='2'>";			
			 $r = $INTRANET->Execute("SELECT xt_nombre, xt_correo FROM PERFILES.USUARIOS WHERE xt_usuario = '$pdr'");

				while($listDatosPDR = $r->fetchRow()){
	
					$nombrePDR = $listDatosPDR[0];
					$correoPDR = $listDatosPDR[1];
				}
			$usuarioSolicitante = $INTRANETV2->getOne("SELECT kf_usuarioId FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$codigo'");
			$j = $INTRANET->Execute("SELECT xt_nombre, xt_correo FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioSolicitante'");

			while($listDatos = $j->fetchRow()){

				$nombreSolicitante = $listDatos[0];
				$correoSolicitante = $listDatos[1];
			}
				?>
				<div id="btn1" ><a style="cursor:pointer" id="insertaP"  onClick="cambiaPDR('<?php echo $tipoS;?>','<?php echo $titulo;?>','<?php echo $nombreSolicitante;?>','<?php echo $correoSolicitante;?>')"><font color='#007CBD'>Asignar</font></a></div>
				 <?php
				
					
									
						
 			echo"</td>";
			echo"</tr>";
		  //funcion para determinar si muestra seccion de justificacion
			  ?>
			  <script>
				  $("#pdrAsignado").change(function(){
					  var PDR = $(this).val()
					  //alert("Has seleccionado" + PDR);
					  
					  var vJustificacionPDR=document.getElementById("justificacionPDR");
					  var vJustificacion1P=document.getElementById("justificacion1P");
		  
					  if(vJustificacionPDR.style.display == 'none') {
						  vJustificacionPDR.style.display = 'block';
						  vJustificacion1P.style.display = 'none';
					   } 
				  
				  });
				  
			  </script>
					  
					  <?php
			  echo"<tr height='10'> </tr>";
		  echo"</table></div>";
			  
		  echo "<div id='justificacionPDR' style='display:none'>";
			  
		  echo "<table border='0' align='center' width='700'>";
			  
			  echo"<tr height='20'> </tr>";
			  
			  //boton para modificar prioridad
			  //echo"<tr height='0'>";
				//  echo"<td align='right' valign='bottom' style='padding:0px 0px 0px 180px' colspan='2'>";
					  
				/* ?>
				 <div id="btn1" ><a style="cursor:pointer" id="insertaP"  onClick="cambiaPDR()"><font color='#007CBD'>Modificar</font></a></div>
				 <?php*/
												
				  //echo "<input type='submit' name='Enviar' src = '../Imagenes/ICN_BotonAgregar.png'>";
				 // echo"</td>";
			  //echo"</tr>";
			  echo"<tr height='10'> </tr>";
			  echo "</table>";
		   echo "</div>";
		 echo "</div>";
	  
	  }else{
			  
		echo "<table border='0' align='center' width='700'>";
			echo "<tr>";
				echo "<td> </td>";
				echo "<td id='iconosTexto' colspan='2' align='left'><b>".$nombrePDR."</b></td>";
			echo "</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo"<tr height='30'> </tr>";
		echo "</table>";
		  
	  }
	  
		 echo"<table border='0' align='center' width='700'>";
			  echo"<tr>";
				  echo"<td align='left' id='titulo2' width='550'><b>Prioridad</b></td>";
				  
			  echo"</tr>";
			  
			  echo "<tr>";
				  echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			  echo "</tr>";
			  
			  echo"<tr height='20'> </tr>";
		  echo "</table>";
			  
		if(@$perfilActiva == 'Jefe de Desarrollo' || @$perfilActiva == 'Asignador PDR'){
			echo "<div id='contPU' style='display:block'>";
				echo "<table border='0' align='center' width='700'>";
					echo "<tr>";
						echo "<td> </td>";
						echo "<td id='iconosTexto' width='40px' align='left'><b>$prioridad</b></td>";
						echo"<td align='left' valign='bottom' style='padding:0px 0px 0px 10px' colspan='2'></td>";
					echo "</tr>";
	  
					echo"<tr height='10'> </tr>";
			
					echo "<tr>";
						echo "<td width='20'> </td>";
				
						echo "<td colspan='2' style='padding:0px 0px 0px 15px' id='fileItem'>$justificacionS</td>";
					echo "</tr>";
			
					
					echo"<tr height='10'> </tr>";
				echo "</table>";
				
			  echo "<table border='0' align='center' width='700'>";
				  echo "<tr>";
					  echo"<td align='right' valign='bottom' style='padding:0px 0px 0px 10px' colspan='2'>";
					  ?>
					  <div id="btn1" ><a style="cursor:pointer" id="insertaP"  onClick="activaCP()"><font color='#007CBD'>Modificar</font></a></div>
						  <?php
					  echo "</td>";
				  echo "</tr>";
				  
				  echo"<tr height='20'> </tr>";
			  echo "</table>";
		  echo "</div>";
				  
		  echo "<div id='contCambiaP' style='display:none'>";
			  echo "<table border='0' align='center' width='700'>";
				  echo "<tr id='contPrioridad'>";
					  $arrPrioridades = array('Normal', 'Urgente', 'Emergencia');
					  echo "<td style='padding:0px 15px 0px 30px'>";
						  echo "<select name='prioridadAsignada' id='prioridadAsignada'>";
							  for($a = 0; $a < 3; $a ++){
							  
								  if($arrPrioridades[$a] == "$prioridad"){
									  echo "<option value='".$arrPrioridades[$a]."' SELECTED>$arrPrioridades[$a]</option>";
								  }else{
								  
									  echo "<option value='".$arrPrioridades[$a]."'>$arrPrioridades[$a]</option>";
								  }
							  }
						  echo "</select>";
					  echo "</td>";
				  echo "</tr>";
				  echo"<tr height='30'> </tr>";
				  //funcion para determinar si muestra seccion de justificacion
				  ?>
				  <script>
					  $("#prioridadAsignada").change(function(){
						  var prioridad = $(this).val()
						  //alert("Has seleccionado" + prioridad);
						  
						  var vJustificacionP=document.getElementById("justificacionP");
						  var vJustificacion1=document.getElementById("justificacion1");
		  
						  if(vJustificacionP.style.display == 'none') {
							  vJustificacionP.style.display = 'block';
							  vJustificacion1.style.display = 'none';
						   } 
					  });
					  
				  </script>
			  
				  <?php
			echo "</table>";
			
			echo "<table border='0' align='center' width='700'>";
			  echo "<tr>";
			  echo "<td>";
					echo "<div id='justificacionP' style='display:none'>";
					 echo "</tr>"; 
			  echo"</td>"; 
			echo "</table>";
			
			echo "<table border='0' align='center' width='700'>";
		
				echo "<tr>";
					echo "<td id='titulo2' colspan='2' align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Justificaci&oacute;n:</td>";
				echo "</tr>";
	
				echo "<tr>";
					echo "<td height='10px;'></td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td id='iconosTexto' colspan='2' align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<textarea style='width:80%;height:70px;' id='txtJustificacion' name='txtJustificacion' placeholder='Justificación'></textarea></td>";
				echo "</tr>";
	  
				//boton para modificar prioridad
				echo"<tr height='0'>";
					echo"<td align='right' valign='bottom' style='padding:0px 0px 0px 180px' colspan='2'>";
						//obtengo el tipo de solicitud
						$tipoSolicitud = $INTRANETV2->getOne("SELECT xt_tipoSolicitud FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$codigo'");
				
						?>
							  <div id="btn1" ><a style="cursor:pointer" id="insertaP"  onClick="cambiaPrioridad('<?php echo $prioridad; ?>')"><font color='#007CBD'>Modificar</font></a></div>
					   <?php
										  
					  echo"</td>";
				  echo"</tr>";	
		  echo "</table>";
							  
		echo "</div>";
	   echo "</div>";
				   
	  }else{
		  echo "<table border='0' align='center' width='700'>";
			  echo "<tr>";
				  echo "<td> </td>";
				  echo "<td id='iconosTexto' colspan='2' align='left'><b>$prioridad</b></td>";
			  echo "</tr>";
		  
			  echo"<tr height='10'> </tr>";
		  
			  echo "<tr>";
				  echo "<td width='20'> </td>";
				  echo "<td width='20'> </td>";
				  echo "<td width='610' align='justify' id='fileItem'>$justificacionS</td>";
			  echo "</tr>";
		  
			  echo"<tr height='30'> </tr>";
		  echo "</table>";
	  }
	  
	  //SEGUIMIENTO
	  echo "<table border='0' align='center' width='700'>";
		  echo"<tr height='30'> </tr>";
			  echo"<tr>";
				  echo"<td align='left' id='titulo2'>";
					  echo "<b>Seguimiento</b>";
				  echo"</td>";
				  echo "<td width='25px;'> </td>";
				  echo "<td width='25px;'> </td>";
			  echo"</tr>";  
			  echo "<tr>";
				  echo "<td id='titleBlueLineBottom' colspan='3'></td>";
		  echo "</tr>";      
	  echo "</table>";
	  echo "<br>";
	  
	  
	  //obtengo los status asignados a la solicitud
	  $statusS = $INTRANETV2->Execute("Select SE.xt_estatus, SE.xn_numero, SE.xd_fecha, SE.xt_contenido, SE.xt_ruta, SE.kf_usuario, IU.xt_nombre, SE.xd_fechaCreacion from SGI_Quejas_Solicitudes_Estatusv2 SE, IntranetGEA.IntranetGEA_USUARIOS IU WHERE SE.xt_quejaSolicitud = '$codigo' AND SE.kf_usuario = IU.kp_usuario ORDER BY SE.xn_numero ASC");
	  
	  $indexSS = 0;
	  $fechaSolicitud = array();
	  while($e = $statusS->fetchRow()){
		  $statusSolicitud[$indexSS] = $e[0];
		  $fechaSolicitud[$indexSS] = $e[2];
		  
		  $numeroSEstatus[$indexSS] = $e[1];
		  $contenidoEstatus[$indexSS] = $e[3];
		  $rutaEstatus[$indexSS] = $e[4];
		  $usuarioPdr[$indexSS] = $e[6];
		  $fechaCreacion[$indexSS] = $e[7];
		  $indexSS ++;
	  }
	  
	  if(count($statusSolicitud) < 2){
		  
		  echo "<table border='0' align='center' width='700'>";
			  for($i = 0; $i < count($statusSolicitud); $i++){
		  
				  echo "<tr>";
					  echo "<td width='150px'>$fechaCreacion[$i]</td>";
					  echo "<td>$statusSolicitud[$i]</td>";
				  echo "</tr>";
	  
				  if($statusSolicitud[$i] == 'ASIGNADA'){
					  echo "<tr>";
						  echo "<td colspan='2'><font color='#636262'> Asignada a: $usuarioPdr[$i]</font></td>";
					  echo "</tr>";
					  
					  echo "</table>";
				  }
			  
			  }//fin del for
			  
			  //verificamos que el perfil sea Soporte Tecnico para habilitar funcionalidad
			  
			  //consultamos la tabla de perfiles

			  $perfil = $INTRANETV2->getOne("Select xt_perfil from SGI_Backlog_Perfiles WHERE xt_nombreUsuario = '$usuarioId'");

			  if($perfil == 'Soporte Tecnico'){
				  if ($usuarioId == $pdr){
					  
				  echo "<table border='0' align='center' width='700'>";
					  echo "<tr height='10px'></tr>";
					  echo "<tr>";
						  echo "<td width='90px'>Atendida</td>";
						   echo "<td align='left' style='font-size:35px;' height='15px;'><a href='javascript:void(0);' onclick='PopUp()'><img 
						  src='../../../Imagenes/ICN_BotonAzul.png'/></a></td>";
					  
					  echo "</tr>";
				  echo "</table>";
				  }
			  }
		  
	  }else{
	  
	  echo "<table border='0' align='center' width='700'>";
	  //listo los diferentes status
		  for($i = 0; $i < count($statusSolicitud); $i++){
		  
			  echo "<tr>";
				  echo "<td width='105px'>$fechaSolicitud[$i]</td>";
	
				  if($statusSolicitud[$i] == 'TERMINADA'){
					  echo "<td>ATENDIDA</td>";
				  }else{
					  echo "<td>$statusSolicitud[$i]</td>";	
				  }
			  echo "</tr>";
		  
			  if($statusSolicitud[$i] == 'ASIGNADA'){
				  echo "<tr>";
					  echo "<td colspan='2'><font color='#636262'> Asignada a: $usuarioPdr[$i]</font></td>";
				  echo "</tr>";
				  
				  echo "<tr height='10px'></tr>";
					  
			  }else if($statusSolicitud[$i] == 'REVISION' && !in_array('TERMINADA', $statusSolicitud)){
				echo "<form name='agregarSeguimiento' method='POST' action='fichaSoporteTecnico.php?codigo=".$codigo."'  enctype='multipart/form-data'>";
					
					echo "<table border='0' align='center' width='700'>";
						
						echo "<tr>";
							echo "<td width='30'> </td>";
							echo "<td colspan='4' id='iconosTexto2'><b style='font-size:16px;'>Evaluar</b></td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td width='30'> </td>";
							echo "<td colspan='4' id='titleBlueLineBottom'> </td>";
						echo "</tr>";
						
						echo "<tr height='15'>";
							echo "<td colspan='5'> </td>";
						echo "</tr>";
						
						echo "<tr align='left' height='20' >";
							echo "<td width='30'> </td>";
							echo "<td width='20'> </td>";
							echo "<td id='iconosTexto2' align='left'>Fecha</td>";
							echo "<td id='iconosTexto2' align='left'>Evaluación</td>";
							echo "<td width='20'> </td>";
						echo "</tr>";
						
						echo"<tr align='left'>";
							echo "<td width='30'> </td>";
							echo "<td width='20'> </td>";
							echo "<td  align='left'>";
								echo "<input type='text' class='DatP' size=10 maxlength=10 name='fechaEvaluacion'>";
							echo"</td>";
							echo "<td align='left'>";
								echo "<select name='evaluacion'>";
									echo "<option value=''>Elegir...</option>";
									echo "<option value='RECHAZADA'>Rechazada</option>";
									echo "<option value='TERMINADA'>Terminada</option>";
								echo "</select>";
								
								echo "<input type='hidden' name='status' value='EVALUACION'>";
								
							echo "</td>";
							echo "<td width='20'> </td>";
						echo "</tr>";
						
						echo"<tr height='10'> </tr>";
						
						echo"<tr height='20'>";
							echo "<td width='30'> </td>";
							echo "<td width='20'> </td>";
							echo"<td valign='bottom' align='left' colspan='2' id='iconosTexto2'>";
								echo"Descripción";
							echo"</td>";
							echo "<td width='20'> </td>";
						echo"</tr>";
						
						echo"<tr>";
							echo "<td width='30'> </td>";
							echo "<td width='20'> </td>";
							echo"<td valign='bottom' align='left' colspan='2'>";
								echo"<textarea name='descripcionEvaluacion' style='width: 600px; height: 60px;'></textarea>";
							echo"</td>";
							echo "<td width='20'> </td>";
						echo"</tr>";
						
						echo"<tr height='10'> </tr>";
						
						echo "<tr align='left' height='20'>";
							echo "<td width='30'> </td>";
							echo "<td width='20'> </td>";
							echo "<td id='iconosTexto2' align='left' colspan='3'>Seleccione un archivo:</td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td width='30'> </td>";
							echo "<td width='20'> </td>";
							echo "<td colspan='3'>";
								echo "<input type='file' name='archivoEvaluacion'>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr height='15'>";
							echo "<td colspan='5'> </td>";
						echo "</tr>";
						
						
						echo "<tr>";
							echo "<td width='20'> </td>";
							echo "<td colspan='4' id='titleBlueLineBottom'> </td>";
						echo "</tr>";
						
						echo"<tr height='10'> </tr>";
						
						echo"<tr height='40'>";
							echo "<td width='20'> </td>";
							echo"<td valign='bottom' align='right' colspan='4'>";
								echo "<input type='image' onclick='SubmitForm(this.form);' src='../../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
							echo"</td>";
						echo"</tr>";
						
						echo "<tr height='30'>";
							echo "<td align='right' colspan='5'></td>";
						echo "</tr>";
								
					echo "</table>";
					
				echo "</form>";
		////EVALUACION INSERCION

			  }else if ($statusSolicitud[$i] == 'TERMINADA'){
			  
				  echo "<tr>";
					  echo "<td colspan='2'><font color='#636262'> Atendida por: $usuarioPdr[$i]</font></td>";
				  echo "</tr>";
				  echo "</table>";
			  
						  //verifico si tiene algun comentario
				  if($contenidoEstatus[$i] != ''){
			  
					  echo "<table border='0' align='center' width='700'>";
						  echo "<tr height='10px'></tr>";
							  echo"<tr>";
								  echo "<td width='35px;'> </td>";
						  
								  echo"<td align='left' style='font-size:14px;color:#007CBD;'>";
									  echo "Comentarios";
								  echo"</td>";            
								  echo "<td width='100px;'></td>";
							  echo"</tr>";  
					  
							  echo "<tr>";
								  
								  echo "<td width='100px;'></td>";
								  echo "<td id='titleBlueLineBottom' colspan='2'></td>";
							  echo "</tr>";
					  
						  echo "<tr><td height='3px;'></td</tr>"; 
					  echo "</table>";	
			  
					  echo "<table border='0' align='center' width='700'>";
						  echo"<tr>";
							  
							  echo "<td width='100px;' height='10px;'></td>";
							  echo"<td  style='padding:0px 0px 0px 20px' id='fileItem'>";
								  echo $contenidoEstatus[$i];
							  echo"</td>"; 
				  
							  //verifico si tiene archivo
							  if($rutaEstatus[$i] != ''){           
								  echo "<td width='40px;'align = 'center' valign = 'top'><a 
								  href='http://71.144.19.155/INTRANET_GEA/Backlog/solicitudesv2/extraccionDoctos.php?codigo=$codigo&ruta=$rutaEstatus[$i]' 
								  style='margin-top:-5px;'><img src='../../../Imagenes/ICN_Archivo.png'></a></td>";
							  }else{
								  echo "<td></td>";	
							  }
						  echo"</tr>";
				  
						  echo "<tr><td height='3px;'></td</tr>"; 
						  echo "<tr>";
				 
					  echo "<td width='100px;'></td>";
				  echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			  echo "</tr>";  
		  echo"</table>";
	
				  }
			  }
		  }
	  }
			  
	  //cierro la ficha
	  echo "<table border='0' align='center' width='700'>";	
	  
		  echo "<tr height='40px'></tr>";
		   echo "<tr>";
			  
			  echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		   echo "</tr>";
		   echo "<tr>";
		   
			  echo "<td align='center'><font color='#636262'>Created by: Grupo Escalante Agencias Aduanales, 2015</font></td>";
		   echo "</tr>";
		   
		   echo "<tr height='40px'></tr>";  
		  
	  echo "</table>";		
			
	?>
	</body>
	</html>