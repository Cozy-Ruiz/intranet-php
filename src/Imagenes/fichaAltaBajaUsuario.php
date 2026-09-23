<?php
$nombrephp='fichaAltaBajaUsuario.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
/*require_once("MailSolicitudRevisar.php");
require_once("MailSolicitudRechazar.php");
require_once("MailSistemaAsignar.php");
*/
$codigo    = $_GET['codigo'];

$categoriaUsr = $INTRANET->getOne("SELECT kf_categoria FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");

//Defino estilo
if($estiloUsuario == 1){
	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
}else if($estiloUsuario == 2){
    echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
}

$s = $INTRANET->Execute("SELECT xt_quejaSolicitud, xt_titulo, xt_descripcion, xt_ruta, kf_usuarioId, xt_status, xt_pdr, xt_ciudad FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$codigo' AND xt_tipo = 'B' ");
while($r = $s->fetchRow()){
	$clave 				= $r[0];
	$titulo 			= $r[1];
	$descripcion 		= nl2br ($r[2]);
	$ruta 				= $r[3];
	$solicitanteID 		= $r[4];
	$status             = $r[5];
	$pdr                = $r[6];
	$ciudad             = $r[7];
}
///PDR
$pdrNombre = "";
$pdrUserId = "";					
						
$s = $INTRANET->Execute("SELECT IU.xt_nombre, SQS.xt_pdr FROM SGI_Quejas_Solicitudesv2 SQS, IntranetGEA_USUARIOS IU WHERE SQS.xt_tipo = 'B' AND SQS.xt_quejaSolicitud = '$codigo' AND SQS.xt_pdr = IU.kp_usuario ");
while($r = $s->fetchRow()){
	$pdrNombre = $r[0];
	$pdrUserId = $r[1];

} unset($r); unset($s);	
	
?>      
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Ficha Alta Baja</title>
    <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
    <link type="text/css" href="../../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
    <script type="text/javascript" src="../../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="../../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
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
    
     <script type="text/javascript">
			function cambiaPDR(){
				
				var codigo ="<?php echo $codigo;?>";
				
				pdr             = $("#pdrAsignado").val();
				ciudad          = $("#ciudad").val();
				descripcionSoli = $("#descripcionSoli").val();
				tituloSoli      = $("#tituloSoli").val();
				tipoSol         = $("#tipoSol").val();
				 
				alert(codigo+pdr+ciudad+descripcionSoli+tituloSoli+tipoSol);
					 
				//$('#divPDR').load("cambiaPDRST.php", {pdr: pdr, codigo: codigo}, function(data){
	
				//});
			}
     </script>   
    
    <script language="javascript" type="text/javascript">
        function cambiaPrioridad(prioridad){
     
            var codigoS ="<?php echo $codigo;?>";
            var usuario = "<?php echo $usuarioId;?>";
            var prioridadNueva=$("#prioridadAsignada").val();
            var prioriJustifica=$("#txtJustificacion").val();
            
            var prioridadAnt = prioridad;   
    		//alert(prioridadAnt+prioridadNueva+codigoS+usuario+prioriJustifica);
       
          	 if(prioridadNueva != ''){
        
                 $('#contPrioridad').load("cambiaPrioridadSolicitud.php", {codigoS:codigoS, prioridadAnt:prioridadAnt, prioridadNueva:prioridadNueva, usuario:usuario, prioriJustifica:prioriJustifica}, function(data){

                 })
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
    
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

    <script>

	//CAMBIO DE DATOS
		$(document).ready(function() 
		{       
			var td,campo,valor,id;
			$(document).on("click","td.editable center",function(e)
			{
				e.preventDefault();
				$("td:not(.id)").removeClass("editable");
				td=$(this).closest("td");
				
				campo=$(this).closest("td").data("campo")
				
				valor=$(this).text();
				
				codigo= '<?php echo $codigo; ?>';
				
				td.select("").html("<select name='"+campo+"' value='"+valor+"'><option value='Alberto_Martinez'>Alberto Martinez</option><option value='Ricardo_Garcia'>Ricardo Garcia</option><option value='Lizbeth_Guadarrama'>Lizbeth Guadarrama</option><option value='cozy'>Cosijopi Richard Ruiz</option><option value='Emmanuel_Crisanto'>Emmanuel Crisanto</option><option value='Cuauhtemoc_Ugalde'>Cuauhtemoc Ugalde</option><option value='Abel_Castillo'>Abel Castillo</option></select><br><a class='enlace guardar' href='#'>Guardar</a><a class='enlace cancelar' href='#'>Cancelar</a>");
				
				
				});
			
			
			$(document).on("click",".cancelar",function(e)
			{
				e.preventDefault();
				td.html("<span><center>"+valor+"</center></span>");
				$("td:not(.id)").addClass("editable");
			});
			
			$(document).on("click",".guardar",function(e)
			
		
			{   
			
			
				campo2 = campo;
				
				
				$(".mensaje").html("<img src='../../Imagenes/ICN_BotonOk.png'>");
				e.preventDefault();
				nuevovalor=$(this).closest("td").find("select").val();
				
			
				
			
				$.ajax({
					
					type: "POST",
					url: "agrega_modifica.php",
					data: { campo: campo2, nuevovalor: nuevovalor, codigo:codigo }			
				
				})
				.done(function( msg ) {
					$(".mensaje").html(msg);
					td.html("<span>"+nuevovalor+"</span>");
					$("td:not(.id)").addClass("editable");
					setTimeout(function() {$('.ok,.ko').fadeOut('fast');}, 3000);
					
					
				});
			 
			 	alert(valor+codigo+nuevovalor);
				
			});
			
			
		});

</script>
    
</head>
<body>
<?php


$breadcrumb="<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Home.php' id='breadcrumbs'>Home / </a><a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/comunicacionInterna.php' id='breadcrumbs'> Comunicación Interna / </a>
<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/tableroSolicitudesyQuejasv2.php' id='breadcrumbs'> Solicitudes </a>";
			
echo"<div id='wrapperFicha' align='center'>";
	echo "<table border='0' align='center' name='Encabezado' width='700px'>";
		echo "<tr height='12px'>";
			echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId." </td>";
		echo "</tr>";
		echo"<tr height='20px'> </tr>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Ficha Alta Baja Usuario</font>";
			echo"</td>";
		echo"</tr>";
		echo"<tr>"; 
			echo"<td align='center' valign='top' height='20px'>";
				echo "<table border='0' align='center'>";
					echo "<tr height='20px'>";
						echo "<td valign='middle'>";
							echo "<img src='../../Imagenes/ICN_PointMeTo.png' id='banana1' style='display:none;' onclick='showBanana(0);'>";
							echo "<img src='../../Imagenes/ICN_PointMeTo.png' id='banana0' style='display:inline-block;' onclick='showBanana(1);'>";
						echo "</td>";
						
						echo "<td valign='middle'>";
							echo "<font style='display:inline-block;'>".$breadcrumb."</font>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo"</td>";
		echo"</tr>";
   echo "</table>";
	
   	echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
		echo "<tr>";
			echo "<td align='center'>";
				//$archivo = $_SERVER['DOCUMENT_ROOT'];
				//echo $_SERVER['DOCUMENT_ROOT']."<br />";
				$currentDir 	=  getcwd();
				$directorios 	= explode('/',$currentDir);
				
				$bandera 	= 0;
				$cuentaDir	= 0;
				
				for($o = 0; $o < count($directorios); $o++){
					if($directorios[$o] == "INTRANET_GEA"){
						$bandera = 1;	
					}
					
					if(($bandera == 1) && ($directorios[$o] != "INTRANET_GEA")){
						$cuentaDir++;
					}	
				} unset($o); unset($bandera);
				
				$subirDir = "";
				
				for($o = 1; $o <= $cuentaDir; $o++){
					$subirDir = $subirDir."../";
				} unset($o);
				
				//echo "SUBDIR: $subirDir, CUENTADIR: $cuentaDir";
				
				//echo "<a href='$archivo' >Archivo</a>";
			
				?>
					<table border='0' align='center' id='breadcrumbs' style='border:1px solid #007cbd;'>
						<tr>
							<td valign='top'>
                            	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/comunicacionInterna.php' id='breadcrumbs'>
                                	Comunicación Interna
                                </a><br />
                                
								<ul style='list-style-type:square;'>
                                	<li>
                                    	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/TableroBoletines.php' id='breadcrumbs'>
                                        	Boletines
                                        </a>
                                    </li>
                                    <li>
                                    	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/listaQueHacer.php' id='breadcrumbs'>
                                        	Qué hacer
                                        </a>
                                    </li>
                                    <li>
                                    	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/tableroSolicitudesyQuejasv2.php' id='breadcrumbs'>
                                        	Solicitudes y Quejas
                                        </a>
                                    </li>
                                    <li>
                                    	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/busquedaPersonal.php' id='breadcrumbs'>
                                        	Acceso Autorizado
                                        </a>
                                    </li>
                                </ul>
                            
							</td>
						</tr>
                        <tr>
							<td valign='top'>
                            	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/homeSGI.php' id='breadcrumbs'>
                                	Gestión Integral
                                </a><br />
                                
                                <ul style='list-style-type:square;'>
                                	<li>
                                    	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Normas.php' id='breadcrumbs'>
                                        	Normas
                                        </a><br />
                                        
                                        <ul style='list-style-type: disc;'>
                                        	<li>
                                            	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/CapituloNorma.php?norma=ISO' id='breadcrumbs'>
                                                    ISO
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/CapituloNorma.php?norma=NMX' id='breadcrumbs'>
                                                    NMX
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/CapituloNorma.php?norma=NEEC' id='breadcrumbs'>
                                                    NEEC
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                    	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/manuales.php' id='breadcrumbs'>
                                        	Manuales
                                        </a><br />
                                        
                                        <ul style='list-style-type: disc;'>
                                        	<li>
                                            	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Documento.php?manual=GE-MC' id='breadcrumbs'>
                                                	Manual de Gestión Integral
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Documento.php?manual=GE-CDR' id='breadcrumbs'>
                                                    Manual de Control de Documentos y Registros
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Documento.php?manual=GE-AI' id='breadcrumbs'>
                                                    Manual de Auditorías Internas
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Documento.php?manual=GE-CC' id='breadcrumbs'>
                                                    Manual del Comité de Calidad
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Documento.php?manual=GE-DG' id='breadcrumbs'>
                                                    Manual de Dirección General
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Documento.php?manual=GE-ADM' id='breadcrumbs'>
                                                    Manual de Administración
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Documento.php?manual=GE-RH' id='breadcrumbs'>
                                                    Manual de Recursos Humanos
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Documento.php?manual=GE-TI' id='breadcrumbs'>
                                                    Manual de Tecnologias de la Información
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Documento.php?manual=GE-OPE' id='breadcrumbs'>
                                                    Manual de Operaciones
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                    	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Modulos.php' id='breadcrumbs'>
                                        	Módulos del SGI
                                        </a><br />
                                        
                                        <ul style='list-style-type: disc;'>
                                        	<li>
                                            	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Riesgos.php' id='breadcrumbs'>
                                                	Administración de Riesgos
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/ReunionesyAcuerdos.php' id='breadcrumbs'>
                                                    Reuniones y Acuerdos
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/tableroPreventivasCorrectivas.php' id='breadcrumbs'>
                                                    Acciones Preventivas y Correctivas
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/tableroAuditorias.php' id='breadcrumbs'>
                                                    Auditorías
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Procesos.php' id='breadcrumbs'>
                                                    Inventario de Procesos
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            
							</td>
						</tr>
                        <tr>
							<td valign='top'>
                            	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Aplicaciones/aplicaciones.php' id='breadcrumbs'>
                                	Aplicaciones
                                </a><br />
                                
                                <ul style='list-style-type:square;'>
                                	<li>
                                    	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Aplicaciones/operaciones.php' id='breadcrumbs'>
                                        	Operaciones
                                        </a>
                                    </li>
                                    <li>
                                    	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/AdministracionProyectos/admonPro.php' id='breadcrumbs'>
                                        	Administración de Proyectos
                                        </a>
                                    </li>
                                </ul>
                                
							</td>
						</tr>
                        <tr>
							<td valign='top'>
                            	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Registros/Registros.php' id='breadcrumbs'>
                                	Registros
                                </a><br />
                                
                                <ul style='list-style-type:square;'>
                                    <li>
                                    	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Registros/TableroVisitas2.php' id='breadcrumbs'>
                                        	Visitas
                                        </a>
                                    </li>
                                     <li>
                                        <a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Registros/tableroRegistros.php' id='breadcrumbs'>
                                            Registros
                                        </a>
                                    </li>
                                </ul>
                                
							</td>
						</tr>
                        <tr>
							<td valign='top'>
                            	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Configuraciones/configuraciones.php' id='breadcrumbs'>
                                	Configuraciones
                                </a><br />
                                
                                <ul style='list-style-type:square;'>
                                	<li>
                                    	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Configuraciones/ModificaPassword.php' id='breadcrumbs'>
                                        	Contraseñas
                                        </a>
                                    </li>
                                </ul>
                                
							</td>
						</tr>
					</table>
                <?php
				
			echo "</td>";
		echo "</tr>";
	echo "</table>";
		
	$perfil = array();
	//OBTENER LOS PERFILES DEL USUARIO CON LA SESION INICIADA
	$indexPerfil = 0;
	$r = $INTRANET->Execute("SELECT xt_perfil FROM SGI_Backlog_Perfiles WHERE xt_nombreUsuario = '$usuarioId'");
	while($s = $r->fetchRow()){
		$perfil[$indexPerfil] = $s[0];
		$indexPerfil++;
	}
				
	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 
	
	if(@$clave != ''){
	
		echo "<table border='0' align='center' width='700'>";
			echo"<tr>";
				echo"<td align='left' id='titulo2' width='550'><b>$clave</b></td>";
				echo"<td align='right' id='iconosTexto2' width='150'>";						
					if($status != ''){
					echo "<b>Status: ".ucwords(strtolower($status))."</b>";
					}		
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
				echo "<td id='iconosTexto' colspan='2' align='left'><b>$titulo</b></td>";
				if ($ruta != NULL){
				echo"<td id='iconosTexto' width='50' align='right'><a href='downloadSolicitud.php?file=$ruta'><img src='Imagenes/ICN_Archivo.png'></a></td>";
				echo"<td id='iconosTexto' width='20' align='right'><a href='cambiarArchivoAltaBaja.php?solicitudID=".urlencode($codigo)."&Usuario=".urlencode($usuarioId)."&etapa=&estatus=' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=400,scrollbars=yes')\"><img src='Imagenes/ICN_Settings.png' width='15' height=15'></a></td>";
				}else {
				echo"<td id='iconosTexto' width='50' align='right'></td>";
				}
			echo "</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo "<tr>";
				echo "<td width='20'> </td>";
				echo "<td width='20'> </td>";
				echo "<td width='610' align='justify' id='fileItem'>$descripcion</td><td></td>";
			echo "</tr>";
			
			echo"<tr height='30'> </tr>";
		echo "</table>";
		
		if($solicitanteID != ""){
			echo "<table border='0' align='center' width='700'>";
			echo"<tr>";
				echo"<td align='left' id='titulo2' width='550'><b>Solicitante</b></td>";
			echo"</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			
			echo"<tr height='30'> </tr>";
		echo "</table>";
				
		echo "<table border='0' align='center' width='700'>";	
			echo "<tr>";
				echo "<td width='20px'></td>";
				
					$nombreSolicitabnte = $INTRANET->getOne("SELECT xt_nombre FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$solicitanteID'");
					
				echo "<td align='left' width='680px' id='iconosTexto'><b>$nombreSolicitabnte</b></td>";
			echo "</tr>";
			
			echo"<tr height='30'> </tr>";
			
		echo "</table>";	
		}	
		
		//PRIORIDAD
		$ss = $INTRANET->Execute("SELECT xt_prioridad, xt_justificacion, xd_fecha FROM SGI_Backlog_Prioridad WHERE xt_quejaSolicitud = '$codigo' ORDER BY xd_fecha ASC");
		while($rr = $ss->fetchRow()){
			$prioridad = $rr[0];
			$justificacion = $rr[1];
			$fechaPrioridad = $rr[2];
		}
		if(@$prioridad != ''){
			echo "<table border='0' align='center' width='700'>";
				echo"<tr>";
					echo"<td align='left' id='titulo2' width='550'><b>Prioridad</b></td>";
					
				echo"</tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				
				echo"<tr height='20'> </tr>";
			echo "</table>";
		
			if($perfil[0] == 'Jefe de Desarrollo' || $perfil[0] == 'Asignador PDR'){
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
					
							echo "<td colspan='2' style='padding:0px 0px 0px 15px' id='fileItem'>$justificacion</td>";
						echo "</tr>";
				
						echo"<tr height='20px'> </tr>";
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
						
						//funcion para determinar si muestra seccion de justificacion(NO MOVER)
						
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
					
					echo "<div id='justificacionP' style='display:none'>";
						echo "<table border='0' align='center' width='700'>";
					
							echo "<tr>";
							echo"<tr height='10'> </tr>";
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
									  $tipoSolicitud = $INTRANET->getOne("SELECT xt_tipoSolicitud FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$codigo'");
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
						echo "<td width='610' align='justify' id='fileItem'>$justificacion</td>";
					echo "</tr>";
					
					echo"<tr height='30'> </tr>";
				echo "</table>";
			}
		}
		///PDR
		if($pdr != ""){
			echo "<table border='0' align='center' width='700'>";
				echo"<tr height='30'> </tr>";	
				echo "<tr>";
					echo "<td align='left' id='titulo2' colspan='2'><b>PDR (Persona Directamente Responsable)</b></td>";
				echo"</tr>";
		
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
		
				echo"<tr height='30'> </tr>";
		
				echo "<tr>";
					echo "<td width='20px'></td>";
						$pdrNombre = $INTRANET->getOne("SELECT xt_nombre FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$pdr'");
					echo "<td align='left' width='680px' id='iconosTexto'><b>$pdrNombre</b></td>";
				echo "</tr>";
		
				echo"<tr height='30'> </tr>";
		
			echo "</table>";
		}
		//if($pdr != "" && $categoriaUsr == 'Administrador'){
			echo "<table border='0' align='center' width='700'>";	
				echo "<tr>";
					echo "<td align='left' id='titulo2' colspan='2'><b>Sistema(s)</b></td>";
				echo"</tr>";
			
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
			echo"</table>";
		
			echo "<table border='0' align='center' width='600'>";			
				echo"<tr height='30'> </tr>";
			
				echo "<tr>";
					echo "<td width='20px'></td>";
					echo "<td align='left' width='180px' id='iconostexto2'><b>Sistemas</b></td>";
					echo "<td align='left' width='240px' id='iconostexto2'><b>Administrador de Sistema</b></td>";
					//echo "<td align='left' width='150px' id='iconostexto2'><b>Estatus</b></td>";
					echo "<td colspan='6' align='right'></td>";
				echo "</tr>";
			echo"</table>";
			
			echo "<table border='0' align='center' width='650'>";
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				echo"<tr height='10'> </tr>";
			echo"</table>";
			
			
		 $l = $INTRANET->Execute("SELECT xt_sistema, xt_tipo FROM SGI_Backlog_Solicitud_Sistemas_Temporal WHERE xt_quejaSolicitud = '$codigo' ");
				while($o = $l->fetchRow()){
					$sistema        = $o[0];
					$tipoSolicitud  = $o[1];	
					
		$administrador = $INTRANET->getOne("SELECT P.xt_programador FROM BACKLOG.ENTREGABLES E, BACKLOG.PDR P, IntranetGEA.SGI_Backlog_Solicitud_Sistemas_Temporal SGT
		 WHERE E.xt_codigoEntregable = P.xt_codigoEntregable AND SGT.xt_codigoEntregable = P.xt_codigoEntregable AND E.xt_solicitud = '$codigo' AND SGT.xt_sistema = '$sistema'");				
				
	  echo"<form name = 'fichaAltaBajaUsuario' action='fichaAltaBajaUsuario.php?codigo=".urlencode($codigo)."' method='post' enctype='multipart/form-data'>";		
	  echo "<table border='0' align='center' width='600'>";
		  echo"<tr height='5'> </tr>";

		  echo "<tr>";
			 /* echo "<td width='40px'></td>";
			  echo "<td align='left' width='140px' valign='top' id='iconosTexto'><b>".$sistema."</b></td>";  
				*/
			if($administrador != ''){
				
			echo "<td width='20px'></td>";
			echo "<td align='left' width='140px' valign='top' id='iconosTexto'>";
				echo "<table border='0' align='left' width='140'>";
					echo "<tr>";
				 		 echo "<td align='left' width='140px' valign='top' id='iconosTexto'><b>".$sistema."</b></td>"; 
				  echo"<tr height='10'> </tr>";
				 echo "</table>"; 
		   echo"</td>";
		  echo "<td align='center' width='250px' id='iconosTexto'>";	  
			  echo "<div id='contPDR' style='display:block'>";
				echo "<table border='0' align='left' width='300'>";
					echo "<tr>";
						
						$nombreAdministrador = $INTRANET->getOne("SELECT xt_nombre FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$administrador'");
						
						echo "<td class='editable' data-campo='$administrador'><span><center><b>".$nombreAdministrador."</b></center></span></td>";
						
						echo"<td align='left' valign='bottom' style='padding:0px 0px 0px 10px' colspan='2'></td>";
					echo "</tr>";
		
					echo"<tr height='10'> </tr>";
			
					echo "<tr>";
						echo "<td width='20'> </td>";
				
						echo "<td colspan='2' style='padding:0px 0px 0px 15px' id='fileItem'></td>";
					echo "</tr>";
			
					
					echo"<tr height='10'> </tr>";
				echo "</table>";
					
					/*		  
				echo "<table border='1' align='center' width='300'>";
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
			  echo "<table border='0' align='left' width='200'>";
				  echo "<tr>";
					echo "<td id='iconosTexto' align='left'>";
					
						echo "<select name='pdrAsignado' id='pdrAsignado'>";
							$r = $INTRANET->Execute("SELECT xt_usuario, xt_nombre FROM BACKLOG.PROGRAMADORES ORDER by xt_nombre");
				
												  while($fila = $r->fetchRow()){
													  $nombreAdministrador = $fila[1];
													  
													  if($fila[0] == "$administrador"){
														   echo "<option value='".$fila[0]."' SELECTED>$fila[1]</option>";
													  }else {
														  echo "<option value='".$fila[0]."'>$fila[1]</option>";
													  }
													  
												  }
							echo "</select>";
							//echo "<input type='hidden' id='tipoEnvio' name='tipoEnvio' value='$tipoSoliEnvio'>";
							echo "<input type='hidden' id = 'codigoAdministrador' name='codigoAdministrador' value='$codigo'>";
							echo "<input type='hidden' id = 'descripcionSoli' name='descripcionSoli' value='$descripcion'>";
							//echo "<input type='hidden' name='descripcionEnvio' value='$descripcionEnvio'>";
							echo "<input type='hidden' id = 'tituloSoli' name='tituloSoli' value='$titulo'>";
							echo "<input type='hidden' id = 'ciudad' name='ciudad' value='$ciudad'>";
							echo "<input type='hidden' id = 'tipoSol' name='tipoSol' value='EA'>";
					echo "</td>";
							   
				  //funcion para determinar si muestra seccion de justificacion
					  ?>
					  <script>
						  $("#pdrAsignado").change(function(){
							  var PDR = $(this).val()
							  
							  alert("Has seleccionado" + PDR);
							  
							  var vJustificacionPDR=document.getElementById("justificacionPDR");
							  var vJustificacion1P=document.getElementById("justificacion1P");
				  
							  if(vJustificacionPDR.style.display == 'none') {
								  vJustificacionPDR.style.display = 'block';
								  vJustificacion1P.style.display = 'none';
							   } 
						  
						  });
						  
					  </script>
							  
					 <?php
											
				//echo"<tr height='10'> </tr>";
					echo"</table>";
						
					echo "<div id='justificacionPDR' style='display:none'>";
						
					echo "<table border='0' align='center' width='200'>";
						
						echo"<tr height='20'> </tr>";
						
						//boton para modificar prioridad
						echo"<tr height='0'>";
							echo"<td align='right' valign='bottom' style='padding:0px 0px 0px 180px' colspan='2'>";
								
							?>
							<div id="btn1" ><a style="cursor:pointer" id="insertaP"  onClick="cambiaPDR()"><font color='#007CBD'>Modificar</font></a></div>
							<?php
														  
						   echo"</td>";
					  echo"</tr>";
					  echo"<tr height='10'> </tr>";
			   echo "</table>";
			   echo "</div>";*/
			  echo "</div>";
			  
			   echo"</td>";
		echo"</tr>";
		echo"<tr height='10'> </tr>";
   echo "</table>";
   

	}else{
		echo "<td width='30px'></td>";
		echo "<td align='left' width='170px' valign='top' id='iconosTexto'><b>".$sistema."</b></td>";  
			echo "<td align='center' width='250px' id='iconosTexto'>";	  
				 $administrador = $INTRANET->getOne("SELECT P.xt_programador FROM BACKLOG.ENTREGABLES E, BACKLOG.PDR P, IntranetGEA.SGI_Backlog_Solicitud_Sistemas_Temporal SGT
				  WHERE E.xt_codigoEntregable = P.xt_codigoEntregable AND SGT.xt_codigoEntregable = P.xt_codigoEntregable AND E.xt_solicitud = '$codigo' AND SGT.xt_sistema = '$sistema'");
	
		
						 // echo"<td width='200' valign='top' align='left'>";
						echo "<select name='asignaAdministrador' size='1' >";
							echo "<option value=''>Elegir...</option>";
							$s= $INTRANET->Execute("SELECT xt_usuario, xt_nombre FROM BACKLOG.PROGRAMADORES ORDER by xt_nombre  ");
								while($r= $s -> fetchRow()){	
								
									echo"<option value='".$r[0]."'>".$r[1]."</option>";
									
								}unset($r); unset ($s);		
					 echo"</select>";
					  echo "<input type='hidden' name='sistemas' value='$sistema'>";
					  echo "<input type='hidden' name='codigoAdministrador' value='$codigo'>";
					  echo "<input type='hidden' name='descripcionPermiso' value='$descripcion'>";
					  echo "<input type='hidden' name='tituloPermiso' value='$titulo'>";
					  echo "<input type='hidden' name='ciudad' value='$ciudad'>";
					  echo "<input type='hidden' name='tipoSol' value='$tipoSolicitud'>";			
					  echo "</td>";
		
					echo "<td colspan='6' valign='top'  align='center' width='300'><input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='70' height='19'></td>";
					
					echo "</tr>"; 
					
					echo"</td>";
				 echo"</tr>";
			 echo"<tr height='10'> </tr>";
			  echo "</table>";
			 echo"</form>";
			
			
	}

}
	
					/*
					
					//Consulta el nombre del administrador de sistema asignado para Alta o baja del entregable
					$administrador = $INTRANET->getOne("SELECT P.xt_programador FROM BACKLOG.ENTREGABLES E, BACKLOG.PDR P, IntranetGEA.SGI_Backlog_Solicitud_Sistemas_Temporal SGT WHERE E.xt_codigoEntregable = P.xt_codigoEntregable AND SGT.xt_codigoEntregable = P.xt_codigoEntregable AND E.xt_solicitud = '$codigo' AND SGT.xt_sistema = '$sistema'");
			
					if($administrador != ''){
						
						echo"<td width='230' id='iconosTexto' align='left'>".$administrador."</td>";
						
					}else{
						
						echo"<td width='230' align='left'>";
							echo "<select name='asignaAdministrador' size='1' >";
									echo "<option value=''>Elegir</option>";
									$s= $INTRANET->Execute("SELECT xt_usuario, xt_nombre FROM BACKLOG.PROGRAMADORES ORDER by xt_nombre  ");
										while($r= $s -> fetchRow()){	
										
											echo"<option value='".$r[0]."'>".$r[1]."</option>";
											
										}unset($r); unset ($s);		
							 echo"</select>";
							  echo "<input type='hidden' name='sistemas' value='$sistema'>";
							  echo "<input type='hidden' name='codigoAdministrador' value='$codigo'>";
							  echo "<input type='hidden' name='descripcionPermiso' value='$descripcion'>";
							  echo "<input type='hidden' name='tituloPermiso' value='$titulo'>";
							  echo "<input type='hidden' name='ciudad' value='$ciudad'>";
							  echo "<input type='hidden' name='tipoSol' value='$tipoSolicitud'>";				
					  echo "</td>";
					}
					//consulta el avance del entregable
				/*	$progreso = $INTRANET->getOne("SELECT E.xn_progreso FROM BACKLOG.ENTREGABLES E, BACKLOG.PDR P, IntranetGEA.SGI_Backlog_Solicitud_Sistemas_Temporal SGT WHERE E.xt_codigoEntregable = P.xt_codigoEntregable AND SGT.xt_codigoEntregable = P.xt_codigoEntregable AND E.xt_solicitud = '$codigo' AND SGT.xt_sistema = '$sistema'");
						
					if($progreso == 0){		
						echo "<td align='center' width='80px' id='iconosTexto'><img src='Imagenes/ICN_BotonRojo.png'></td>";
					}else if($progreso == 100){
						echo "<td align='center' width='80px' id='iconosTexto'><img src='Imagenes/ICN_BotonVerde.png'></td>";
					}
				*/	/*
					if($administrador != ''){
						
						if($perfil[0] == 'Jefe de Desarrollo' || $perfil[0] == 'Asignador PDR'){
							
							echo "<td colspan='6' align='center'></td>";
							
						}else{
							echo "<td colspan='6' align='center'><input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='70' height='19'></td>";
						}
					}else{
						echo "<td colspan='6' align='center'><input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='70' height='19'></td>";

					}
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
		 echo"</form>";		
		 echo "</table>"; 
		}*/
		
		 echo "<table border='0' align='center' width='650'>";
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			echo "<tr height='30'>";
				echo "<td align='right' colspan='5'> </td>";
			echo "</tr>";	
		echo"</table>";
	 	
		//Recibe parametros para asignar sistema a un administrador y guardar en PDR
		if(@$_POST['asignaAdministrador'] != ''){
			 
		   $asignaSistema = $_POST['asignaAdministrador'];
		   $sistemas    = $_POST['sistemas'];
		   $codigoAdmin = $_POST['codigoAdministrador'];
		   $descripcionAdmin = $_POST['descripcionPermiso'];
		   $tituloAdmin = $_POST['tituloPermiso'];
		   $oficina     = $_POST['ciudad'];
		   $tipoAdm     = $_POST['tipoSol'];
	
		   $consecutivo = 0;
		  
		   $s = $INTRANET->Execute("SELECT MAX(xn_consecutivo) FROM BACKLOG.ENTREGABLES");
			  while($r = $s->fetchRow()){
				  $consecutivo = $r[0];
			  }unset($r);
			  
			$consecutivo++;
				
			$codigoE = $oficina."-AB-";
				
			//Crea el codigo de la Solicitud para el entregable
			if(strlen($consecutivo) == 1){	
				$codigoE =$codigoE."0000".$consecutivo;
				
			} else if(strlen($consecutivo) == 2){
				$codigoE = $codigoE."000".$consecutivo;
				
			} else if(strlen($consecutivo) == 3){
				$codigoE = $codigoE."00".$consecutivo;
				
			} else if(strlen($consecutivo) == 4){
				$codigoE = $codigoE."0".$consecutivo;
				
			}else if(strlen($consecutivo) >= 5){
				$codigoE = $codigoE.$consecutivo;
				
			} 
			
			$posicion = 0;
			
			$y = $INTRANET->Execute("SELECT MAX(xn_posicion) FROM BACKLOG.PDR WHERE xt_programador = '$asignaSistema' ");
			while($q = $y->fetchRow()){
					
				$posicion = $q[0];
				
			} unset($q);
			
			$posicion++;
			
			//Inserta Entregable y nombre del PDR asignado para Alta/Baja de Sistema
			if($INTRANET->Execute("INSERT INTO BACKLOG.ENTREGABLES (xt_codigoEntregable,xt_titulo,xt_descripcion,xt_solicitud, xn_consecutivo, xn_progreso, xt_prioridad) VALUES ('$codigoE','$titulo','$descripcionAdmin','$codigoAdmin', '$consecutivo', 0, 'Normal')")){
				
				$INTRANET->Execute("INSERT INTO BACKLOG.PDR (xt_codigoEntregable,xt_programador,xn_posicion) VALUES ('$codigoE','$asignaSistema','$posicion')");
				
				$INTRANET->Execute("INSERT INTO BACKLOG.HISTORIAL_ENTREGABLE (xt_codigoEntregable,xt_programador,xn_posicion) VALUES ('$codigoE','$asignaSistema','$posicion')");
				
				$INTRANET->Execute("INSERT INTO SGI_Backlog_Prioridad (xt_quejaSolicitud,xt_prioridad,xt_usuario, xt_justificacion) VALUES ('$codigo','Normal','$asignaSistema','')");
				
				$INTRANET->Execute("UPDATE SGI_Backlog_Solicitud_Sistemas_Temporal SET xt_codigoEntregable = '$codigoE' WHERE xt_quejaSolicitud = '$codigo' and xt_sistema = '$sistemas' ");
				
			/*	
				$correoAsigna = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '".$usuarioId."' ");
				$nombreAsigna = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '".$usuarioId."' ");
				
				$correoAdministrador = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$asignaSistema' ");
				$nombreAdministrador = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$asignaSistema' ");
				
					new MailSistemaAsignar($clave, $correoAdministrador, $nombreAdministrador, $correoAsigna, $nombreAsigna,$tipoAdm, $titulo, $descripcion,$sistemas,$INTRANET);
	 */
				echo"<script language='javascript'>window.location='fichaAltaBajaUsuario.php?codigo=".urlencode($codigo)."'</script>;";																
			
			}
		  }
	//	}
		
		if($status != 'SIN ASIGNAR'){
			
			echo "<table border='0' align='center' width='700'>";	
				echo"<tr>";
					echo"<td align='left' id='titulo2'><b>Seguimiento</b></td>";
					echo"<td align='right' id='iconosTexto2'></td>";
				echo"</tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				
				echo"<tr height='30'> </tr>";
			echo "</table>";
			
		}
							
		$s = $INTRANET->Execute("SELECT xt_estatus, xt_contenido, xd_fecha, xt_ruta, xn_numero FROM SGI_Quejas_Solicitudes_Estatusv2 WHERE xt_quejaSolicitud = '$codigo' ORDER BY xn_numero ");	
			while($r = $s->fetchRow()){
				$estatusEtapa	= $r[0];
				$contenidoEtapa	= $r[1];
				$fechaEtapa	= date('Y-m-d', strtotime($r[2]));
				$rutaEtapa 		= $r[3];
				$numero         = $r[4];
	
				echo "<table border='0' align='center' width='700'>";
					echo "<tr>";
						echo "<td> </td>";
						if($estatusEtapa == 'REVISION'){
							echo "<td id='iconosTexto' colspan='2' align='left'>$fechaEtapa <b>Para Revisión</b></td>";
						}else{
							echo "<td id='iconosTexto' colspan='2' align='left'>$fechaEtapa <b>".ucwords(strtolower($estatusEtapa))."</b></td>";
						}
						
						if($rutaEtapa != NULL){
							echo "<td id='iconosTexto' width='50' align='right'>";
								echo "<a href='downloadSeguimientoSolicitud.php?file=$rutaEtapa'>";
									echo "<img src='Imagenes/ICN_Archivo.png'>";
								echo "</a>";
							echo"<td id='iconosTexto' width='20' align='right'><a href='cambiarArchivoAltaBaja.php?solicitudID=".urlencode($codigo)."&Usuario=".urlencode($usuarioId)."&etapa=".urlencode($numero)."&estatus=".urlencode($estatusEtapa)."' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=400,scrollbars=yes')\"><img src='Imagenes/ICN_Settings.png' width='15' height=15'></a></td>";
							echo "</td>";
							
						}else {
							
							echo "<td id='iconosTexto' width='50' align='right'></td>";	
							
						}
					echo "</tr>";
					
					echo"<tr height='10'> </tr>";
					
					echo "<tr>";
							echo "<td width='20'> </td>";
							echo "<td width='20'> </td>";
							echo "<td width='610' align='justify' id='fileItem'>$contenidoEtapa</td><td></td>";
					echo "</tr>";
						
					
					echo"<tr height='30'> </tr>";
				echo "</table>";
						
			}unset($r); unset($s); unset($i);
			
			
		$estatusRevision = $INTRANET->getOne("SELECT xt_status FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$codigo' AND xt_status IN ('ASIGNADA','REVISION')");
		
		if($estatusRevision != '' && $pdr == $usuarioId){
			
			echo "<form name='agregarSeguimiento' method='POST' action='fichaAltaBajaUsuario.php?codigo=".urlencode($codigo)."'  enctype='multipart/form-data'>";				
			echo "<table border='0' align='center' width='700'>";
				  
				echo "<tr>";
					echo "<td width='30'> </td>";
					echo "<td colspan='4' id='iconosTexto2'><b style='font-size:16px;'>Para Revisión</b></td>";
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
					echo "<td id='iconosTexto2' align='left' colspan='2'>Fecha</td>";
					echo "<td width='20'> </td>";
				echo "</tr>";
				
				echo"<tr align='left'>";
					echo "<td width='30'> </td>";
					echo "<td width='20'> </td>";
					echo "<td  align='left' colspan='2'>";
						echo "<input type='text' class='DatP' size=10 maxlength=10 name='fechaRevision'>";
						
						echo "<input type='hidden' name='status' value='REVISION'>";
						
					echo"</td>";
					echo "<td width='20'> </td>";
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
				
				echo"<tr height='20'> ";
					echo "<td width='30'> </td>";
					echo "<td width='20'> </td>";
					echo"<td valign='bottom' align='left' colspan='2' id='iconosTexto2'>";
						echo"Descripción";
					echo"</td>";
					echo "<td width='20'> </td>";
				echo"</tr>";
				
				echo"<tr> ";
					echo "<td width='30'> </td>";
					echo "<td width='20'> </td>";
					echo"<td valign='bottom' align='left' colspan='2'>";
						echo"<textarea name='descripcionRevision' style='width: 600px; height: 100px;'></textarea>";
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
						echo "<input type='file' name='archivoRevision'>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='15'>";
					echo "<td colspan='5'> </td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td width='30'> </td>";
					echo "<td colspan='4' id='titleBlueLineBottom'> </td>";
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
				
				echo"<tr height='40'>";
					echo "<td width='30'> </td>";
					echo"<td valign='bottom' align='right' colspan='4'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
					echo"</td>";
				echo"</tr>";
				
				echo "<tr height='30'>";
					echo "<td align='right' colspan='5'></td>";
				echo "</tr>";
						
			echo "</table>";
			echo "</form>";
			  
		}
		
		//Recibe parametros cuando la solicitud esta en revision
		if((@$_POST['status'] == "REVISION") && (@$_POST['fechaRevision'] != "") && (@$_POST['descripcionRevision'] != "")){
			  
			$fechaInsert		= date('Y-m-d', strtotime($_POST['fechaRevision']));
			$descripcionInsert 	= nl2br($_POST['descripcionRevision']);
			
			$estatusMax 	= 0;
			
			$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Quejas_Solicitudes_Estatusv2 WHERE xt_quejaSolicitud = '$codigo' ");
			
			while($r = $s->fetchRow()){
				
				$estatusMax = $r[0];
				
			} unset($r);
			
			$estatusMax++;
			
			if($INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2(xt_quejaSolicitud, xn_numero, xt_estatus, xt_contenido, xd_fecha, kf_usuario) VALUES('$codigo', '$estatusMax' , 'REVISION', '$descripcionInsert', '$fechaInsert', '$usuarioId') ")){
																		
				$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = 'REVISION' WHERE xt_quejaSolicitud = '$codigo' ");
				
				$correoSolicitante = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$solicitanteID' ");
				$nombreSolicitante = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$solicitanteID' ");
					
					new MailSolicitudRevisar($clave, $correoSolicitante, $nombreSolicitante, $descripcionInsert);
			}

				
			 $extension = pathinfo($_FILES['archivoRevision']['name'], PATHINFO_EXTENSION);  
			 if($extension != ''){
				
				$ruta = "D:/INTRANET/documentosSolicitudes/";
				$directorioCompleto = $ruta.$codigo;
				# si exsite la carpeta o se ha creado
				if(file_exists($directorioCompleto) || @mkdir($directorioCompleto)){
	
					$nombreNuevo = "Revision".($estatusMax-1)."-".$codigo.".".$extension;
					$nombreArchivo = $directorioCompleto."/".$nombreNuevo;
					
					if (@move_uploaded_file($_FILES['archivoRevision']['tmp_name'], $nombreArchivo)){
			
						$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudes_Estatusv2 SET xt_ruta = '$nombreArchivo' WHERE xt_quejaSolicitud = '$codigo' AND xn_numero = $estatusMax ");
						
					}
				}
			 }		 								
			echo"<script language='javascript'>window.location='fichaAltaBajaUsuario.php?codigo=".urlencode($codigo)."'</script>;";				
		// }
		}
		   
		$estatusEvaluacion = $INTRANET->getOne("SELECT xt_status FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$codigo'");
		  
		if($estatusEvaluacion == 'REVISION' || $estatusEvaluacion == 'RECHAZADA' && $solicitanteID == $usuarioId){
			 
			 echo "<form name='agregarSeguimiento' method='POST' action='fichaAltaBajaUsuario.php?codigo=".urlencode($codigo)."'  enctype='multipart/form-data'>";			
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
						  echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
					  echo"</td>";
				  echo"</tr>";
				  
				  echo "<tr height='30'>";
					  echo "<td align='right' colspan='5'></td>";
				  echo "</tr>";
						  
			 echo "</table>";  
			 echo "</form>";
			 
		 }else{
			 
		 }
		 
		 //Recibe parametros cuando la solicitud se Rechaza o se da por Terminada
		 if((@$_POST['status'] == "EVALUACION") && (@$_POST['fechaEvaluacion'] != "") && (@$_POST['descripcionEvaluacion'] != "") && (@$_POST['evaluacion'] != "")){
			
			$fechaInsert		= date('Y-m-d', strtotime($_POST['fechaEvaluacion']));
			$descripcionInsert 	= nl2br($_POST['descripcionEvaluacion']);
			$evaluacion 		= $_POST['evaluacion'];		
			
			$estatusMax 	= 0;
			
			$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Quejas_Solicitudes_Estatusv2 WHERE xt_quejaSolicitud = '$codigo' ");
			
			while($r = $s->fetchRow()){
				
				$estatusMax = $r[0];
				
			} unset($r);
			
			$estatusMax++;
															
			if($INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2(xt_quejaSolicitud, xn_numero, xt_estatus, xt_contenido, xd_fecha, kf_usuario) VALUES('$codigo', '$estatusMax' , '$evaluacion', '$descripcionInsert', '$fechaInsert', '$usuarioId') ")){
																		
				$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudesv2 SET xt_status = '$evaluacion' WHERE xt_quejaSolicitud = '$codigo' ");
				
				if($evaluacion == "RECHAZADA"){
					
					$correoPDRMail = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$pdrUserId' ");
					$nombrePDRMail = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$pdrUserId' ");
				
					new MailSolicitudRechazar($clave, $correoPDRMail, $nombrePDRMail, $descripcionInsert);	
				}
				
				$extension = pathinfo($_FILES['archivoEvaluacion']['name'], PATHINFO_EXTENSION);  
				 if($extension != ''){
					
					$ruta = "D:/INTRANET/documentosSolicitudes/";
					$directorioCompleto = $ruta.$codigo;
					# si exsite la carpeta o se ha creado
					if(file_exists($directorioCompleto) || @mkdir($directorioCompleto)){
						
						//cambio nombre de archivo
						if($evaluacion == 'TERMINADA'){
						   $nombreNuevo = "Evaluacion"."_".$codigo.".".$extension;
						}else if($evaluacion == 'RECHAZADA'){
							$nombreNuevo = "Rechazada"."_".$codigo.".".$extension;
						}
								
						$nombreArchivo = $directorioCompleto."/".$nombreNuevo;
						
						if (@move_uploaded_file($_FILES['archivoEvaluacion']['tmp_name'], $nombreArchivo)){
			
						$INTRANET->Execute("UPDATE SGI_Quejas_Solicitudes_Estatusv2 SET xt_ruta = '$nombreArchivo' WHERE xt_quejaSolicitud = '$codigo' AND xn_numero = $estatusMax ");
					
						}
					}
				 }		
				echo"<script language='javascript'>window.location='fichaAltaBajaUsuario.php?codigo=".urlencode($codigo)."'</script>;";
			}
		}
		echo "<table border='0' align='center' width='700'>";	
		///LINEA FINAL
			echo "<tr height='30px'> </tr>";
			echo "<tr>";
				echo "<td id='titleBlueLineBottom'></td>";
			echo "</tr>";
		
			echo"<tr height='10px'> </tr>";
			
			/*echo "<tr>";
				echo "<td align='right'>";
					if(($solicitanteID == $usuarioId) || ($categoriaUsr == "Administrador")){
						echo "<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/fichaAltaBajaModificar.php?id=$codigo' ><img src='Imagenes/ICN_BotonModificar.png' width='90' height='29'></a>";
					}
				echo "</td>";
			echo "</tr>";
			*/
			echo "<tr>";
				echo "<td align='center' id='nota_al_pie'>";
				$h = $INTRANET->Execute("SELECT IU.xt_nombre, SQ.xd_fecha FROM SGI_Quejas_Solicitudesv2 SQ, IntranetGEA_USUARIOS IU WHERE SQ.kf_usuarioId = IU.kp_usuario AND  SQ.xt_quejaSolicitud = '$codigo' AND SQ.xt_tipo = 'B' ");
						while($b = $h->fetchRow()){
							$nombreSolicitante = $b[0];
							$fechaCreacion 	= date('Y-m-d', strtotime($b[1]));
							///Titulo
							echo "Creado: ".$fechaCreacion.", ".$nombreSolicitante;
						}
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='40px'> </tr>";
		echo "</table>";
	
	}else{
		
		echo "<table border='0' align='center' width='700'>";
			echo "<tr>";
				echo"<td valign='bottom' align='center' colspan='2' id='titulo2'>";
				echo"<i>No existe Solicitud</i>";
				echo"</td>";
			echo "</tr>";
		echo "</table>";
	}	
echo"</div>";	
?>		
</body>
</html>		
  


