<?php error_reporting(0); ?>
<?php

//$moduloScript = "Configuracion";
$oficinaScrpt = "";
$nombrephp = 'casoUsoBacklog.php';
require_once("../../ConexionDBT.php");
require_once('../../compruebaUsuario.php');

error_reporting(E_PARSE);

//obtengo parametros

$solicitudID = $_GET['codigo'];

//obtengo titulo, fecha de solicitud, descripcion, solicitante, solicitante original
$s = $INTRANET->Execute("SELECT
							xt_titulo,
							xt_descripcion,
							xd_fecha,
							kf_usuarioId,
							xt_status,
							xt_solicitanteOriginal,
							xd_fechaLimite,
							xt_pdr,
							xt_tipoSolicitud,
							xt_ciudad,
							xt_ruta	
						FROM
							SGI_Quejas_Solicitudesv2 
						WHERE
							xt_quejaSolicitud = '$solicitudID' ");
		
while($j = $s->fetchRow()){
	$tituloSolicitud = $j[0];
	$descripcionSolicitud= $j[1];
	$fechaSolicitud = $j[2];
	$usuarioSolicitud = $j[3];
	$statusSolicitud = $j[4];
	$solicitanteOriginal = $j[5];
	$fechaLimite = $j[6];
	$pdrAsignado = $j[7];
	$tipoSolicitud = $j[8];
	$ciudadSolicitud = $j[9];
	$doctoSolicitud = $j[10];			
}

//obtengo prioridad y justificacion
$ss = $INTRANET->Execute("SELECT xt_prioridad, xt_justificacion, xd_fecha FROM SGI_Backlog_Prioridad WHERE xt_quejaSolicitud = '$solicitudID' ORDER BY xd_fecha ASC");
while($rr = $ss->fetchRow()){
    $prioridad = $rr[0];
    $justificacionS = $rr[1];
    $fechaPrioridad = $rr[2];
}

//obtengo la ubicacion, sistema, proceso, actividad, funcionalidad y rol
$e=$INTRANET->Execute("SELECT xt_sistema, xt_proceso, xt_actividad, xt_funcionalidad, xt_rol FROM SGI_Backlog_Ubicacion WHERE xt_quejaSolicitud = '$solicitudID' ");
while($f = $e->fetchRow()){
	$sistemaUbicacion = $f[0];
	$procesoSistema= $f[1];
	$actividadProceso = $f[2];
	$funcionalidad = $f[3];
	$rol = $f[4];			
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
	<script type="text/javascript" src="../../JS/jquery-1.9.1.js"></script>

	<!-- Funciones de JavaScript -->
	<!-- SCRIPT PARA MOSTRAR Y OCULTAR TR DE DOCUMENTOS -->
	<script type="text/javascript">
		function activaFile(cual){
			var vFile=document.getElementById(cual);
			
			if(vFile.style.display == 'block') {
				vFile.style.display = 'none';
			}else{
				vFile.style.display = 'block';
			}
			//return true;
		}
	</script>
	<!-- TERMINO DE SCRIPT PARA MOSTRAR Y OCULTAR TR DE DOCUMENTOS -->
	
	<!-- SCRIPT PARA CAMBIAR LA PRIORIDAD -->
	<script language="javascript" type="text/javascript">
		function cambiaPrioridad(prioridad){
		  
			var codigoS ="<?php echo $solicitudID;?>";
			var usuario = "<?php echo $usuarioId;?>";
			var prioridadNueva=$("#prioridadAsignada").val();
			var prioriJustifica=$("#txtJustificacion").val();
			
			var prioridadAnt = prioridad;
			
			if(prioridadNueva != ''){
				
				$('#contPrioridad').load("cambiaPrioridadSolicitud.php", {codigoS:codigoS, prioridadAnt:prioridadAnt, prioridadNueva:prioridadNueva, usuario:usuario, prioriJustifica:prioriJustifica}, function(data){
		
				})
				
				//alert(prioridadAnt+prioridadNueva+codigoS);
			}	 
	 	}
	</script>

    <!-- SCRIPT PARA ADAPTAR EL IFRAME -->
    <script language="JavaScript">
    //Ajusta el tamaño de un iframe al de su contenido interior para evitar scroll
    function autofitIframe(id){	
        if (!window.opera && document.all && document.getElementById){
            id.style.height=id.contentWindow.document.body.scrollHeight;
        } else if(document.getElementById) {	
            var id2 = document.getElementById('miFrame');
            id2.style.height=id.contentDocument.body.scrollHeight+"px";
        }
    }
    </script>
    
    <!-- SCRIPT PARA CAMBIAR EL COLOR DE LAS CELDAS -->
    <script language="javascript" type="text/javascript">
        function ilumina(celda, tipo){
            celda1 = document.getElementById(celda);
    
            var codigo ="<?php echo $solicitudID;?>";
            var usuario = "<?php echo $usuarioId;?>";
			
			
			if(tipo == 'ValidacionTecnica'){
				var comentario = document.getElementById('valTecnicaComentarioVerif').value;
				
				document.getElementById("contValidaT").style.display="none";
	   			document.getElementById("cargaValidaT").style.display="block";
	
				if(celda == 'valTecnicaProcede'){
					celda1.style.backgroundColor  = '#42CB27';
					document.getElementById('valTecnicaNoProcede').style.backgroundColor = 'red';
					$('#validacionTecnica').load("aceptarRechazarValidaciones.php", {status: 'ACEPTADA', codigo: codigo, usuario: usuario, comentario:comentario, tipo: 'TECNICA'}, function(data){
						
					})   
				}
		
				if(celda == 'valTecnicaNoProcede'){
					celda1.style.backgroundColor  = '#42CB27';
					document.getElementById('valTecnicaProcede').style.backgroundColor  = 'red';
					$('#validacionTecnica').load("aceptarRechazarValidaciones.php", {status: 'RECHAZADA', codigo: codigo, usuario: usuario, comentario:comentario, tipo: 'TECNICA'}, function(data){
					})
				}
			
			}else if(tipo == "ValidacionNegocio"){
				
				var comentario = document.getElementById('valNegocioComentarioVerif').value;
				document.getElementById("contValidaN").style.display="none";
	   			document.getElementById("cargaValidaN").style.display="block";
				
				if(celda == 'valNegocioProcede'){
					celda1.style.backgroundColor  = '#42CB27';
					document.getElementById('valNegocioNoProcede').style.backgroundColor  = 'red';
					$('#validacionNegocio').load("aceptarRechazarValidaciones.php", {status: 'ACEPTADA', codigo: codigo, usuario: usuario, comentario:comentario, tipo: 'NEGOCIO'}, function(data){
					})   
				}
		
				if(celda == 'valNegocioNoProcede'){
					celda1.style.backgroundColor  = '#42CB27';
					document.getElementById('valNegocioProcede').style.backgroundColor  = 'red';
					$('#validacionNegocio').load("aceptarRechazarValidaciones.php", {status: 'RECHAZADA', codigo: codigo, usuario: usuario, comentario:comentario, tipo: 'NEGOCIO'}, function(data){
					})
				}
				
			}else if(tipo == "ValidacionFinal"){
				
				var comentario = document.getElementById('valFinalComentarioVerif').value;
				document.getElementById("contValidaF").style.display="none";
	   			document.getElementById("cargaValidaF").style.display="block";
				
				if(celda == 'valFinalProcede'){
					celda1.style.backgroundColor  = '#42CB27';
					document.getElementById('valFinalNoProcede').style.backgroundColor  = 'red';
					$('#validacionFinal').load("aceptarRechazarValidaciones.php", {status: 'ACEPTADA', codigo: codigo, usuario: usuario, comentario:comentario, tipo: 'FINAL'}, function(data){
					})   
				}
		
				if(celda == 'valFinalNoProcede'){
					celda1.style.backgroundColor  = '#42CB27';
					document.getElementById('valFinalProcede').style.backgroundColor  = 'red';
					$('#validacionFinal').load("aceptarRechazarValidaciones.php", {status: 'RECHAZADA', codigo: codigo, usuario: usuario, comentario:comentario, tipo: 'FINAL'}, function(data){
					})
				}
			}else if(tipo == "TransladoUsuario"){
				
				var comentario = document.getElementById('transladoUsuarioComentarioVerif').value;
				document.getElementById("contValidaU").style.display="none";
	   			document.getElementById("cargaValidaU").style.display="block";
				
				if(celda == 'transladoUsuarioProcede'){
					celda1.style.backgroundColor  = '#42CB27';
					document.getElementById('transladoUsuarioNoProcede').style.backgroundColor  = 'red';
					$('#transladoUsuario').load("aceptarRechazarValidaciones.php", {status: 'ACEPTADA', codigo: codigo, usuario: usuario, comentario:comentario, tipo: 'TRASLADO_USUARIO'}, function(data){
					})   
				}
		
				if(celda == 'transladoUsuarioNoProcede'){
					celda1.style.backgroundColor  = '#42CB27';
					document.getElementById('transladoUsuarioProcede').style.backgroundColor  = 'red';
					$('#transladoUsuarioFinal').load("aceptarRechazarValidaciones.php", {status: 'RECHAZADA', codigo: codigo, usuario: usuario, comentario:comentario, tipo: 'TRASLADO_USUARIO'}, function(data){
					})
				}
			}	
		}
    </script>
      
    <!-- SCRIPT PARA CAMBIAR EL COLOR DE LAS CELDAS -->
    <script language="javascript" type="text/javascript">
        function ilumina2(celda, color){
            celda1 = document.getElementById(celda);
            //var celda1 = document.getElementById(celda).innerHTML;
    
            var codigo ="<?php echo $solicitudID;?>";
            var usuario = "<?php echo $usuarioId;?>";
            var comentarioMS = "";
            //alert (color+celda+comentarioMS);
    
            if(color == 'white' && celda == 'tdProcede'){
                //alert (celda1);
                //celda1.style.bgcolor  = 'red';
                celda1.style.backgroundColor  = '#42CB27';
                document.getElementById('tdNoProcede').style.backgroundColor  = 'red';
               $('#validacionNegocio').load("aceptarRechazarVN.php", {status: 'ACEPTADA', codigo: codigo, usuario: usuario, comentario:comentarioMS}, function(data){
        
               }) 
            }
    
            if(color == 'white' && celda == 'tdNoProcede'){
                celda1.style.backgroundColor  = '#42CB27';
                document.getElementById('tdProcede').style.backgroundColor  = 'red';
        
                $('#validacionNegocio').load("aceptarRechazarVN.php", {status: 'RECHAZADA', codigo: codigo, usuario: usuario, comentario:comentarioMS}, function(data){
        
                })
            }
        }
    </script>
      
    <!-- SCRIPT PARA MOSTRAR EL DIV DE CAMBIO DE VALIDACION -->
    <script language="javascript" type="text/javascript">
        function muestraCambioV(){
            var validacion = document.getElementById("trValidacion");
            var cambiaV = document.getElementById("contCambioV");
            
            if(validacion.style.display == "block"){
                validacion.style.display = "none";
                cambiaV.style.display = "block";
            }else{
                validacion.style.display = "block";
                cambiaV.style.display = "none";
            }
        }
    </script>
      
      <script type="text/javascript">
      	function mostrarIframe(){

      	}
      </script>
    
    <!-- SCRIPT PARA GUARDAR AL COMENTARIO DE VALIDACION DE NEGOCIO -->
    <script language="javascript" type="text/javascript">	
        function comentarioVN(){ 
            var codigo ="<?php echo $solicitudID;?>";
            var comentarioVN = document.getElementById('comentarioVerifN').value;
        
            if(comentarioVN != ''){
                $('#comentarioVN').load("comentarioVN.php", {codigo: codigo, comentario : comentarioVN}, function(data){
                })		
            }
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
            }else{
                div1.style.display = "block";
                div2.style.display = "none";
            }
        }
    </script>
     
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
    </script>
     
    <!-- SCRIPT PARA CAMBIAR EL COLOR DE LAS CELDAS -->
    <script language="javascript" type="text/javascript">
        function iluminaLibera(celda, color){
            celda1 = document.getElementById(celda);
            //var celda1 = document.getElementById(celda).innerHTML;
            var comentarioLibera = document.getElementById('comentarioLibera').value;
			
			document.getElementById("contValidaL").style.display="none";
	   		document.getElementById("cargaValidaL").style.display="block";
    
            var codigo ="<?php echo $solicitudID;?>";
            var usuario = "<?php echo $usuarioId;?>";
            //alert (color+celda);
        
            if(color == 'white' && celda == 'tdLibera'){
                //alert (celda1);
                //celda1.style.bgcolor  = 'red';
                celda1.style.backgroundColor  = '#42CB27';
               // document.getElementById('tdNoProcede').style.backgroundColor  = 'red';
               
               $('#liberaFuncionalidad').load("aceptarRechazarLibera.php", {status: 'LIBERADA', codigo: codigo, usuario: usuario, comentario:comentarioLibera}, function(data){
        
               })
               
            }
        }
    </script>
	
	<script>
		function reSize()
		{
			try{	
			var oBody	=	ifrm.document.body;
			var oFrame	=	document.all("ifrm");
				
			oFrame.style.height = oBody.scrollHeight + (oBody.offsetHeight - oBody.clientHeight);
			oFrame.style.width = oBody.scrollWidth + (oBody.offsetWidth - oBody.clientWidth);
			}
			//An error is raised if the IFrame domain != its container's domain
			catch(e)
			{
			window.status =	'Error: ' + e.number + '; ' + e.description;
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
    
    <!-- funcion para mostrar select dependientes -->
<script type="text/javascript">

function cargaContenido(opcionCarga) {


// $("#prioridad").change(function () {
  //        $("#prioridad").each(function () {
  var textP = document.getElementById("textPrioridad");
  var valor1 = document.getElementById("proceso").value;
  var valor2 = document.getElementById("contRol").value;
  var valor3 = document.getElementById("contActividad").value;
  var valor4 = document.getElementById("contFuncionalidad").value;
  
  if(opcionCarga == 1){
	  
	  
	 $('#contRol').load("selectDependiente_roles.php", {valorP: valor1}, function(data){

 	 });
  }
  
  if(opcionCarga == 2){
	  
	
	  
	 $('#contActividad').load("selectDependiente_actividades.php", {valorPR: valor2}, function(data){

 	 });
	 
  }
  
  if(opcionCarga == 3){
	  
	 
	  
	$('#contFuncionalidad').load("selectDependiente_funcionalidad.php", {valorPRA: valor3}, function(data){

 	 });
	 
  }
  
   if(opcionCarga == 4){
	  
	
	  
	$('#contCasoUso').load("selectDependiente_casoUso.php", {valorPRAF: valor4}, function(data){

 	 });
	 
  }
  
}


</script>

<script>
	function mueveArchivosSGI(){
		
		//variables
		var codigoSol = "<?php echo $solicitudID; ?>";
		var usuario = "<?php echo $usuarioId; ?>";
		
		var valorP = document.getElementById("proceso").value;
  		var valorR = document.getElementById("contRol").value;
  		var valorA = document.getElementById("contActividad").value;
  		var valorF = document.getElementById("contFuncionalidad").value;
		var valorCU = document.getElementById("contCasoUso").value;
		
		//oculto y muestro los divs correspondientes
		document.getElementById("divUbicacion").style.display="none";
	   	document.getElementById("cargaUbicacion").style.display="block";
		
		if(valorA == ''){
			
			alert("Debe seleccionar una actividad");
			
		}else{
			
			$('#divUbicacion').load("mueveArchivosSGISolicitud.php", {codigo:codigoSol, codP:valorP, codR:valorR, codA:valorA, codF:valorF, codCU:valorCU, usuario: usuario}, function(data){
			})
  
		}
		
	}
	
</script>
         
    
    <?php
	if($estiloUsuario == 1){
	  echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
	}else if($estiloUsuario == 2){
	  echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
	}
	?>
	   
	<title><?php echo $solicitudID; ?></title>
</head>
<body onload=reSize()>

<?php

$breadcrumb="<a href='../../Home.php' id='breadcrumbs'>Home / </a><a href='../comunicacionInterna.php' id='breadcrumbs'> Comunicación Interna / </a> 
			<a href='tableroSolicitudesyQuejasv2.php' id='breadcrumbs'> Solicitudes </a>";

echo "<div id='wrapper'>";
	echo "<table border='0' align='center' width='1160px' style='margin-top:-110px;'>";
		echo "<tr height='40px'><td></td></tr>";
		echo "<tr>";
			echo "<td id='breadcrumbs' width='1160px' align='left'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		echo "<tr height='20px'><td></td></tr>";
	echo "</table>";
	
	//codigo de menu navegable
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Solicitud de desarrollo</font>";
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
		//echo"<tr height='70'> </tr>";
	echo "</table>";
	
	/*echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
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
                            	<a href='../ComunicacionInterna/comunicacionInterna.php' id='breadcrumbs'>
                                	Comunicación Interna
                                </a><br />
                                
								<ul style='list-style-type:square;'>
                                	<li>
                                    	<a href='../ComunicacionInterna/TableroBoletines.php' id='breadcrumbs'>
                                        	Boletines
                                        </a>
                                    </li>
                                    <li>
                                    	<a href='../ComunicacionInterna/listaQueHacer.php' id='breadcrumbs'>
                                        	Qué hacer
                                        </a>
                                    </li>
                                    <li>
                                    	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/tableroSolicitudesyQuejasv2.php' id='breadcrumbs'>
                                        	Solicitudes
                                        </a>
                                    </li>
                                     <li>
                                    	<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/tableroQuejas.php' id='breadcrumbs'>
                                        	Quejas
                                        </a>
                                    </li>
                                    <li>
                                    	<a href='../ComunicacionInterna/busquedaPersonal.php' id='breadcrumbs'>
                                        	Acceso Autorizado
                                        </a>
                                    </li>
                                </ul>
                            
							</td>
						</tr>
                        <tr>
							<td valign='top'>
                            	<a href='../SistemaGestionIntegral/homeSGI.php' id='breadcrumbs'>
                                	Gestión Integral
                                </a><br />
                                
                                <ul style='list-style-type:square;'>
                                	<li>
                                    	<a href='../SistemaGestionIntegral/Normas.php' id='breadcrumbs'>
                                        	Normas
                                        </a><br />
                                        
                                        <ul style='list-style-type: disc;'>
                                        	<li>
                                            	<a href='../SistemaGestionIntegral/CapituloNorma.php?norma=ISO' id='breadcrumbs'>
                                                    ISO
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../SistemaGestionIntegral/CapituloNorma.php?norma=NMX' id='breadcrumbs'>
                                                    NMX
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../SistemaGestionIntegral/CapituloNorma.php?norma=NEEC' id='breadcrumbs'>
                                                    NEEC
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                    	<a href='../SistemaGestionIntegral/manuales.php' id='breadcrumbs'>
                                        	Manuales
                                        </a><br />
                                        
                                        <ul style='list-style-type: disc;'>
                                        	<li>
                                            	<a href='../SistemaGestionIntegral/Documento.php?manual=GE-MC' id='breadcrumbs'>
                                                	Manual de Gestión Integral
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../SistemaGestionIntegral/Documento.php?manual=GE-CDR' id='breadcrumbs'>
                                                    Manual de Control de Documentos y Registros
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../SistemaGestionIntegral/Documento.php?manual=GE-AI' id='breadcrumbs'>
                                                    Manual de Auditorías Internas
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../SistemaGestionIntegral/Documento.php?manual=GE-CC' id='breadcrumbs'>
                                                    Manual del Comité de Calidad
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../SistemaGestionIntegral/Documento.php?manual=GE-DG' id='breadcrumbs'>
                                                    Manual de Dirección General
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../SistemaGestionIntegral/Documento.php?manual=GE-ADM' id='breadcrumbs'>
                                                    Manual de Administración
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../SistemaGestionIntegral/Documento.php?manual=GE-RH' id='breadcrumbs'>
                                                    Manual de Recursos Humanos
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../SistemaGestionIntegral/Documento.php?manual=GE-TI' id='breadcrumbs'>
                                                    Manual de Tecnologias de la Información
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../SistemaGestionIntegral/Documento.php?manual=GE-OPE' id='breadcrumbs'>
                                                    Manual de Operaciones
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                    	<a href='../SistemaGestionIntegral/Modulos.php' id='breadcrumbs'>
                                        	Módulos del SGI
                                        </a><br />
                                        
                                        <ul style='list-style-type: disc;'>
                                        	<li>
                                            	<a href='../SistemaGestionIntegral/Riesgos.php' id='breadcrumbs'>
                                                	Administración de Riesgos
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../SistemaGestionIntegral/ReunionesyAcuerdos.php' id='breadcrumbs'>
                                                    Reuniones y Acuerdos
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../SistemaGestionIntegral/tableroPreventivasCorrectivas.php' id='breadcrumbs'>
                                                    Acciones Preventivas y Correctivas
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../SistemaGestionIntegral/tableroAuditorias.php' id='breadcrumbs'>
                                                    Auditorías
                                                </a>
                                            </li>
                                            <li>
                                            	<a href='../SistemaGestionIntegral/Procesos.php' id='breadcrumbs'>
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
                            	<a href='../Aplicaciones/aplicaciones.php' id='breadcrumbs'>
                                	Aplicaciones
                                </a><br />
                                
                                <ul style='list-style-type:square;'>
                                	<li>
                                    	<a href='../Aplicaciones/operaciones.php' id='breadcrumbs'>
                                        	Operaciones
                                        </a>
                                    </li>
                                    <li>
                                    	<a href='../AdministracionProyectos/admonPro.php' id='breadcrumbs'>
                                        	Administración de Proyectos
                                        </a>
                                    </li>
                                </ul>
                                
							</td>
						</tr>
                        <tr>
							<td valign='top'>
                            	<a href='../Registros/Registros.php' id='breadcrumbs'>
                                	Registros
                                </a><br />
                                
                                <ul style='list-style-type:square;'>
                                    <li>
                                    	<a href='../Registros/TableroVisitas2.php' id='breadcrumbs'>
                                        	Visitas
                                        </a>
                                    </li>
                                     <li>
                                        <a href='../Registros/tableroRegistros.php' id='breadcrumbs'>
                                            Registros
                                        </a>
                                    </li>
                                </ul>
                                
							</td>
						</tr>
                        <tr>
							<td valign='top'>
                            	<a href='../Configuraciones/configuraciones.php' id='breadcrumbs'>
                                	Configuraciones
                                </a><br />
                                
                                <ul style='list-style-type:square;'>
                                	<li>
                                    	<a href='../Configuraciones/ModificaPassword.php' id='breadcrumbs'>
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
	echo "</table>";*/
	echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
		include("../../navegacion_banana.php");
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
		echo"<tr height='80px'><td></td></tr>";
	echo "</table>"; 
	
	//seccion de codigo de solicitud y descripcion
	echo "<table border='0' align='center' width='100%' cellspacing='0'>";
		echo "<tr>";
			echo "<td align='left' width='685px' id='titulo2'>$solicitudID</td>";	
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='2' style='border-style:solid; border-color:#007cbd; border-top-width:1px; border-bottom:none; border-left:none; border-right:none;'>";
			echo "</td>";
		echo "</tr>";
			
		echo"<tr height='10'></tr>";
		echo "<tr>";
			echo "<td id='manualVinculo' style='padding:0px 15px 0px 30px'>";
				echo $tituloSolicitud;
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='10px'></tr>";
		
		echo "<tr>";
			echo "<td style='padding:0px 15px 0px 75px'>";
				echo $descripcionSolicitud;
			echo "</td>";
			//defino si tiene dado de alta algun documento 
			if($doctoSolicitud != ''){
				echo "<td width='15px'>";
					echo "<a href='http://71.144.19.155/INTRANET_GEA/Backlog/extraccionDoctos.php?codigo=$solicitudID&ruta=$doctoSolicitud'><img src='../../Imagenes/ICN_Archivo.png' height='15' width='12' /></a>";
				echo "</td>";	
			}
		echo "</tr>";
	echo "</table>";	
	
	//seccion de fecha de solicitud
	echo "<table border='0' align='center' width='100%' cellspacing='0'>";
		echo"<tr height='25'></tr>";
	
		echo "<tr>";
			echo "<td align='left' width='685px' id='titulo2'>Fecha de solicitud</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='2' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		
		echo"<tr height='10'></tr>";
		
		echo "<tr>";
			echo "<td id='manualVinculo' style='padding:0px 15px 0px 30px'>";
				echo $fechaSolicitud;
			echo "</td>";
		echo "</tr>";
	echo "</table>";
		
	//secccionn de solicitante
	echo "<table border='0' align='center' width='100%' cellspacing='0'>";
		echo"<tr height='25'></tr>";
	
		echo "<tr>";
			echo "<td align='left' width='685px' id='titulo2'>Solicitante</td>";
		echo "</tr>";
	
		echo "<tr>";
			echo "<td colspan='2' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		
		echo"<tr height='10'></tr>";
		
		echo "<tr>";
			echo "<td id='manualVinculo' style='padding:0px 15px 0px 30px'>";
			$solicitanteNombre = $INTRANET->getOne("SELECT xt_nombre FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioSolicitud'");
				echo $solicitanteNombre;
			echo "</td>";
		echo "</tr>";
		
		//secccionn de solicitante original
		
		echo"<tr height='25'></tr>";
		
		echo "<tr>";
			echo "<td align='left' width='685px' id='titulo2'>Solicitante original</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='2' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		
		echo"<tr height='10'></tr>";
		
		echo "<tr>";
			echo "<td id='manualVinculo' style='padding:0px 15px 0px 30px'>";
				echo $solicitanteOriginal;
			echo "</td>";
		echo "</tr>";
	
	
		//secccionn de sistema
		/*echo"<tr height='25'></tr>";
		
		echo "<tr>";
			echo "<td align='left' width='685px' id='titulo2'>Sistema</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='2' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		
		echo"<tr height='10'></tr>";
		
		echo "<tr>";
			echo "<td id='manualVinculo' style='padding:0px 15px 0px 30px'>";
				echo $sistemaUbicacion;
			echo "</td>";
		echo "</tr>";*/
	
		//secccion fecha limite para produccion
		echo"<tr height='25'></tr>";
		
		echo "<tr>";
			echo "<td align='left' width='685px' id='titulo2'>Fecha límite para producción</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='2' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		
		echo"<tr height='10'></tr>";
		
		echo "<tr>";
			echo "<td id='manualVinculo' style='padding:0px 15px 0px 30px'>$fechaLimite</td>";
		echo "</tr>";
		
		echo"<tr height='30'></tr>";
	echo "</table>";
		
	//PRIORIDAD
	echo "<table border='0' align='center' width='100%' cellspacing='0'>";
		echo"<tr>";
			echo "<td align='left' width='685px' id='titulo2'>Prioridad</td>";
			if($perfil[0] == 'Jefe de Desarrollo' || $perfil[0] == 'Asignador PDR'){
			
			}
		echo"</tr>";
	
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
		
		echo"<tr height='20'> </tr>";
	echo "</table>";

	if($perfil[0] == 'Jefe de Desarrollo' || $perfil[0] == 'Asignador PDR'){
		echo "<div id='contPU' style='display:block'>";
			echo "<table border='0' align='center' width='100%'>";
				echo "<tr>";
					echo "<td id='iconosTexto' style='padding:0px 15px 0px 30px; font-size:20px'>$prioridad</td>";
					echo"<td align='left' valign='bottom' style='padding:0px 0px 0px 10px' colspan='2'>";
					echo "</td>";
					echo"<td align='left' valign='bottom' style='padding:0px 0px 0px 10px' colspan='2'></td>";
				echo "</tr>";
	
				echo"<tr height='10'> </tr>";
	
				echo "<tr>";
					echo "<td colspan='2' style='padding:0px 0px 0px 60px' id='fileItem'>$justificacionS</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='2' style='padding:0px 0px 0px 60px' id='fileItem'>";
						?>
						<div align="right" id="btn1" ><a style="cursor:pointer" id="insertaP"  onClick="activaCP()"><font color='#007CBD'>Modificar</font></a></div> 
						<?php                                              
					echo "</td>";
				echo "</tr>";
	
				echo"<tr height='30'> </tr>";
			echo "</table>";
		echo "</div>";
		
		echo "<div id='contCambiaP' style='display:none'>";
			echo "<table border='0' align='center' width='100%' cellspacing='0'>";
				echo "<tr id='contPrioridad'>";
		 			$arrPrioridades = array('Normal', 'Urgente', 'Emergencia');
		 			echo "<td style='padding:0px 15px 0px 30px'>";
						echo "<select name='prioridadAsignada' id='prioridadAsignada'>";
							//echo "<option value=''>Elegir......</option>";
							//$r = $INTRANET->Execute("SELECT xt_administrador FROM SGI_Backlog_Administradores_de_Sistemas WHERE xt_sistema= '$sistema'");
						   for($a = 0; $a < 3; $a ++){
								
								if($arrPrioridades[$a] == "$prioridad"){
									 echo "<option value='".$arrPrioridades[$a]."' SELECTED>$arrPrioridades[$a]</option>";
								}else {
									
									echo "<option value='".$arrPrioridades[$a]."'>$arrPrioridades[$a]</option>";
								}
							}
            			echo "</select>";
					echo "</td>";
    			echo "</tr>";
		
				echo "<tr height='20px'></tr>";
		
				echo "<tr id='justificacion1' style='display:block'>";
					echo "<td width='650' style='padding:0px 15px 0px 45px' id='fileItem'>$justificacionS</td>";
				echo "</tr>";
		
		
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
		
			echo "<div id='justificacionP' style='display:none'>";
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
							$tipoSolicitud = $INTRANET->getOne("SELECT xt_tipoSolicitud FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$codigoS'");
							
							?>
							<div id="btn1" ><a style="cursor:pointer" id="insertaP"  onClick="cambiaPrioridad('<?php echo $prioridad; ?>')"><font color='#007CBD'>Modificar</font></a></div>
							<?php
													  
						//echo "<input type='submit' name='Enviar' src = '../Imagenes/ICN_BotonAgregar.png'>";
						echo"</td>";
					echo"</tr>";	
				echo "</table>";
			echo "</div>";
		echo "</div>";
	}else{
		echo "<table border='0' align='center' width='100%'>";
			echo "<tr>";
				echo "<td id='iconosTexto' colspan='2'  style='padding:0px 15px 0px 30px;font-size:20px;'>$prioridad</td>";
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
	
	
			echo "<table border='0' width='100%'>";
				echo"<tr height='25'></tr>";
			
				echo "<tr>";
					echo "<td align='left' id='titulo2'>Ubicación</td>";
				echo "</tr>";
			
				echo "<tr>";
					echo "<td colspan='2' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
			
				echo"<tr height='10'></tr>";
				
			echo "</table>";
			
			//div donde muestr gif de cargando
			echo "<table width='100%'>";
			  echo "<div id='cargaUbicacion' style='display:none' align='center'>";
				  echo "<img src='../../../INTRANET_GEA/Imagenes/img_load.gif' />";
			  echo "</div>";
			echo "</table>";
			
			//secccion ubicación
			echo "<div id='divUbicacion' style='display:block'>";
			//consulto si ya tiene una ubicacion asignada, porque deacuerdo a esto sabre donde se mandaron los ducumentos
			$consultaU = $INTRANET->Execute("SELECT xt_proceso, xt_rol, xt_actividad, xt_funcionalidad, xt_casodeuso FROM SGI_Backlog_Ubicacion WHERE xt_quejaSolicitud = '$solicitudID'");
			
			while($datosU = $consultaU->fetchRow()){
				
				$codPro = $datosU[0];
				$codRol = $datosU[1];
				$codActv = $datosU[2];
				$codFun = $datosU[3];
				$codCU = $datosU[4];
				
			}
			
			$Proceso = $INTRANET->getOne("SELECT kp_codigo FROM SGI_Procesos WHERE xt_codigoCorto = '$codPro'");
			//obtengo codigo no compuesto del rol
			$arrRol = explode("_", $codRol);
			$totalRol = count($arrRol);
			$rolCod = $arrRol[$totalRol -1];
				
			 $nombreRol = $INTRANET->getOne("SELECT xt_nombre FROM SGI_Roles WHERE kp_codigo = '$rolCod'");
			
			//Los documentos se registraron en actividad
			if($codActv != '' && $codFun == ''){ 
			
				//obtengo codigo de la actividad
				$arrActv = explode("_", $codActv);
				$totalActv = count($arrActv);
				$actividadCod = $arrActv[$totalActv -1];
				
				echo "<table boder='0'>";
				
				echo "<td id='iconosTexto' style='padding:0px 15px 0px 30px;font-size:20px;'><a style='cursor:pointer' href='http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/fichaActividadFuncionalidad.php?proceso=$Proceso&actividad=$actividadCod&rol=$nombreRol'>$codActv</a></td>";
				echo "</table>";
				
				
			}
			
			//Los documentos se registraron en Funcionalidad
			if($codActv != '' && $codFun != '' && $codCU == ''){ 
				
				echo "<table boder='0'>";
				
				echo "<td id='iconosTexto' style='padding:0px 15px 0px 30px;font-size:20px;'><a style='cursor:pointer' href='http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/fichaFuncionalidadCasoUso.php?codigo=$codFun'>$codFun</a></td>";
				echo "</table>";
				
			}
			
			if($codActv != '' && $codFun != '' && $codCU != ''){ 
			
				echo "<table boder='0'>";
				echo "<td id='iconosTexto' style='padding:0px 15px 0px 30px;font-size:20px;'><a style='cursor:pointer' href='http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/fichaCasosdeUso.php?codigo=$codCU'>$codCU</a></td>";
				echo "</table>";
				
				
			}
			
			
			if($codPro == '' && $codActv == '' && $codFun == ''){
				
				if($usuarioId == 'Lizbeth_Guadarrama' || $usuarioId == 'Rodrigo_Romo' || $usuarioId == 'Ricardo_Garcia' || $usuarioId == 'Alberto_Martinez' || $usuarioId == 'cozy' || $usuarioId == 'Emmanuel_Crisanto' || $usuarioId == 'Cuauhtemoc_Ugalde' || $usuarioId == 'Abel_Castillo'){

					echo "<table width='100%'>";
					
						echo "<tr>";
							echo "<td width='150px' id='manualVinculo' style='padding:0px 15px 0px 30px'>";
								echo "Sistema:";
							echo "</td>";
						
							echo "<td>";
								//obtengo la ubicacion
								echo "<select name='sistema'>";
									//echo "<option value=''>Elegir......</option>";
									$r = $INTRANET->Execute("SELECT xt_sistema FROM PERFILES.CATALOGO_SISTEMAS");
									while($fila = $r->fetchRow()){
										if($fila[0] == "$sistemaUbicacion"){
											 echo "<option value='".$fila[0]."' SELECTED>$fila[0]</option>";
										}else {
											echo "<option value='".$fila[0]."'>$fila[0]</option>";
										}
									}
								echo "</select>";
							echo "</td>";
						echo "</tr>";
					
						echo"<tr height='10'></tr>";
						
						echo "<tr>";
							echo "<td width='150px' id='manualVinculo' style='padding:0px 15px 0px 30px'>";
								echo "Proceso:";
							echo "</td>";
							
							echo "<td>";
								echo "<select name='proceso' id='proceso' onChange='cargaContenido(1)'>";
									echo "<option value=''>Elegir......</option>";
									$p = $INTRANET->Execute("SELECT xt_codigoCorto, xt_nombre FROM IntranetGEA.SGI_Procesos");
									while($filaP = $p->fetchRow()){	
										echo "<option value='".$filaP[0]."'>".utf8_encode($filaP[1])."</option>";
									}
								echo "</select>";				  
							echo "</td>";
						echo "</tr>";
					
						echo"<tr height='10'></tr>";
						
						echo "<tr>";
							echo "<td width='150px' id='manualVinculo' style='padding:0px 15px 0px 30px'>";
								echo "Rol:";
							echo "</td>";
							
							echo "<td>";
								echo "<select name='rol' id='contRol' onChange='cargaContenido(2)'>";
									
								echo "</select>";	
							echo "</td>";
						echo "</tr>";
					
						echo"<tr height='10'></tr>";
						
						echo "<tr>";
							echo "<td width='150px' id='manualVinculo' style='padding:0px 15px 0px 30px'>";
								echo "Actividad:";
							echo "</td>";
							
							echo "<td>";
								echo "<select name='actividad' id='contActividad' onChange='cargaContenido(3)'>";
									
								echo "</select>";
							echo "</td>";
						echo "</tr>";
					
						echo"<tr height='10'></tr>";
						
						echo "<tr>";
							echo "<td width='150px' id='manualVinculo' style='padding:0px 15px 0px 30px'>";
								echo "Funcionalidad:";
							echo "</td>";
							
							echo "<td>";
								echo "<select name='funcionalidad' id='contFuncionalidad' onChange='cargaContenido(4)'>";
									/*echo "<option value=''>Elegir......</option>";
									$fun = $BACKLOG->Execute("SELECT kp_codigo, xt_nombre FROM IntranetGEA.SGI_Funcionalidades");
									while($filaF = $fun->fetchRow()){
										
										echo "<option value='".$filaF[0]."'>$filaF[1]</option>";
									}*/
								echo "</select>";
							echo "</td>";
							
						echo "</tr>";
						echo"<tr height='10'></tr>";
						
						echo "<tr>";
							echo "<td width='150px' id='manualVinculo' style='padding:0px 15px 0px 30px'>";
								echo "Caso de Uso:";
							echo "</td>";
							
							echo "<td>";
								echo "<select name='casoDeuso' id='contCasoUso'>";
									/*echo "<option value=''>Elegir......</option>";
									$fun = $BACKLOG->Execute("SELECT kp_codigo, xt_nombre FROM IntranetGEA.SGI_Funcionalidades");
									while($filaF = $fun->fetchRow()){
										
										echo "<option value='".$filaF[0]."'>$filaF[1]</option>";
									}*/
								echo "</select>";
							echo "</td>";
						echo "</tr>";
						
					echo "</table>";
					
					//muestro la opcion de cargar los archivos si existe documentacion
					$banderaExistenDoctos = 0;
					$l = $INTRANET->Execute("SELECT xt_tipoDocumento, xt_ruta FROM SGI_Backlog_Documentos WHERE xt_quejaSolicitud = '$solicitudID'");
	
					while($doctos = $l->fetchRow()){
		
					   $tipoDoc = $doctos[0];
					   $rutaA = $doctos[1];
					  
					  if($rutaA != ''){
						  
						  $banderaExistenDoctos = 1;
						  break;
					  }
		 
					}
					
					if($banderaExistenDoctos == 1){
					
						echo "<table border='0' width='100%'>";
								echo "<tr>";
									
									echo "<td colspan='2'><div  align='right'><a style='cursor:pointer'  onClick='mueveArchivosSGI()'><font color='#007CBD'>Mover archivos</font></a></div></td>";
					
								echo "</tr>";
								
								echo "<tr height='25px'></tr>";
						echo "</table>";
					
					}
					
				}//fin del if de validacion de usuarios
			
			}//fin del if donde verifica que no tiene asignados documentos a lguna ubicación
			
		echo "</div>";	// fin del div de seccion de ubicacion
		
		
	
	//seccion de catalogacion
	/*echo "<table width='100%'>";
		echo "<tr height='25px'></tr>";
		echo "<tr>";
			echo "<td align='left' id='titulo2'>Catalogación</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='2' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		
		echo"<tr height='10'></tr>";
		
		echo "<tr>";
			echo "<td style='padding:0px 15px 0px 30px'>";
				//$a = $BOCAR->Execute('SELECT xt_prioridad FROM RADAR_CATALOGO_PRIORIDADES');
				echo "<select style='width: 250px;' name='prioridad' id='prioridad'>";
					//while($b = $a->fetchRow()){
						// $prioridadC = $b[0];
						// if($prioridadC == "NORMAL"){
							//  echo "<option value='$prioridadC' SELECTED>$prioridadC</option>";
						//}else{
							echo "<option value='$prioridadC'>Elegir...</option>";
						//}
					 //}
			 	 echo "</select>";
			echo "</td>";
		echo "</tr>";
		
		echo"<tr height='10'></tr>";
		
		echo "<tr>";
			echo "<td style='padding:0px 15px 0px 30px'>";
				//$a = $BOCAR->Execute('SELECT xt_prioridad FROM RADAR_CATALOGO_PRIORIDADES');
				echo "<select style='width: 250px;' name='prioridad' id='prioridad'>";
					//while($b = $a->fetchRow()){
						//$prioridadC = $b[0];
						//if($prioridadC == "NORMAL"){
							//echo "<option value='$prioridadC' SELECTED>$prioridadC</option>";
						//}else{
							  echo "<option value='$prioridadC'>Elegir...</option>";
						//}
					 //}
			  	echo "</select>";
			echo "</td>";
		echo "</tr>";
		
		echo"<tr height='10'></tr>";
		
		echo "<tr>";
			echo "<td style='padding:0px 15px 0px 30px'>";
				//$a = $BOCAR->Execute('SELECT xt_prioridad FROM RADAR_CATALOGO_PRIORIDADES');
				echo "<select style='width: 250px;' name='prioridad' id='prioridad'>";
					//while($b = $a->fetchRow()){
						//$prioridadC = $b[0];
						//if($prioridadC == "NORMAL"){
							//echo "<option value='$prioridadC' SELECTED>$prioridadC</option>";
						//}else{
							echo "<option value='$prioridadC'>Elegir...</option>";
						//}
					//}
				echo "</select>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='35px'></tr>";
	echo "</table>";*/
	
	//seccion de Documentación
	//obtengo datos de validación tecnica
	echo "<table border='0' width='100%'>";
		echo "<tr height='25px'></tr>";
		
		echo "<tr>";
			echo "<td align='left' id='titulo2'>Documentación</td>";
			echo "<td width='15px'><a href='tipoDoctosBacklogPopUp.php?codigo=$solicitudID&usuario=$usuarioId' target='popup' onclick=\"window.open(this.href,this.target,'width=350,height=600,scrollbars=yes')\"><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a></td>";	
		echo "</tr>";
		
		echo "<tr>";
			echo "<td colspan='2' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		
		echo"<tr height='10'></tr>";
		
	echo "</table>";
		
	//Listo todos los tipos de documentación
	//echo "SELECT xt_tipoDocumento FROM SG_Backlog_Documentos WHERE xt_quejaSolicitud = '$solicitudID'";
	$s = $INTRANET->Execute("SELECT DISTINCT xt_tipoDocumento FROM SGI_Backlog_Documentos WHERE xt_quejaSolicitud = '$solicitudID' and xt_tipoDocumento not in ('Traslado a usuario')");
	
	$indexTotalDoc = 0;
	$trPos = 0;
	while($row = $s->fetchRow()){	
		$trPos ++;
		$trPosF = "trFile".$trPos;
		
		echo "<table border='0' width='100%'>";
		
			echo "<tr>";
				echo "<td>";
						echo "<input type='hidden' name='tipoDoc' id='tipoDoc' value='$row[0]'>";
						//echo "<b> $row[0] </b>";
						echo "<br>";
					echo "</td>";
			echo "</tr>";
		
			echo "<tr>";
				echo "<td width='30px'></td>";
				if($row[0] == "Parametros de Reporte"){
					echo "<td align='left' style='font-size:16px;color:#007CBD;'>Parámetros de Reporte</td>";
				}else{
				echo "<td align='left' style='font-size:16px;color:#007CBD;'>$row[0]</td>";
				}
				echo "<td width='15px'></td>";
				echo "<td width='15px'>";
				
				//valido si es "Parametros de Reporte" para no dar la opcion de subir archivo sino mostrar el formulario
				if($row[0] == "Parametros de Reporte"){
					
				}else{
				?>
					<a onClick="activaFile('<?php echo $trPosF; ?>')"><img  src="../../Imagenes/ICN_NuevoDoc.png" height='15' width='15'/></a>	
				<?php
				}
				echo "</td>";
			echo "</tr>";
		
			echo "<tr>";
				echo "<td width='30px'></td>";
				echo "<td colspan='3' 	style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='10'></tr>";
			
			if($row[0] == "Parametros de Reporte"){
				//no muestro la seccion de archivos
			}else{
		
			//consulto archivo correspondiente al tipo de documento
			$doc = $INTRANET->Execute("SELECT  xt_nombreArchivo, xt_usuario, xd_fecha, xt_ruta FROM SGI_Backlog_Documentos WHERE xt_tipoDocumento = '$row[0]' AND xt_quejaSolicitud = '$solicitudID'");
		
				$numDoc = 0;
				while ($listA = $doc -> fetchRow()){
					if(!empty($listA[0])){
						echo "<table border='0' width='100%'>";
							echo "<tr>";
								echo "<td width='30px'></td>";
								echo "<td style='padding:0px 0px 0px 15px;'><font size=2>$listA[0]</font></td>";
								//echo "<td><a href='eliminaDoctosCU.php?codigo=$solicitudID&elimina=$listA[3]&tipoDoc=$row[0]&usuario=$usuarioId'><img src='../../Imagenes/ICN_NoOK.png' height='13' width='13'/></a></td>";
								echo "<td><a href='http://71.144.19.155/INTRANET_GEA/Backlog/extraccionDoctosReporte.php?nombreA=$listA[0]&ruta=$listA[3]'><img src='../../Imagenes/ICN_Archivo.png' height='15' width='12' /></a></td>";
							echo "</tr>";
			
							echo "<tr>";
								echo "<td width='30px'></td>";
					
								echo "<td style='color:#636262; padding:0px 0px 0px 30px'><i><font size=2>$listA[1], $listA[2]</font></i></td>";
							//echo "<td>[Nombre Usuario] 2015-11-22 14:28:00</td>";
							echo "</tr>";
							
							echo "<tr height='10'></tr>";
						echo "</table>";
					}//fin del if de verificaion de que exite archivo
					$numDoc ++;
				}//fin del while de archivos
			}
		echo "</table>";
		
		//fila del formulario para subir archivo
		echo "<table border='0' style='width: 100%' cellspacing='0'>";
			echo "<tr id='$trPosF' style='display: none'>";
				echo "<td width='250px'></td>";
				echo "<td>";
					echo "<div id='divFile'>";
						echo "<iframe src='http://71.144.19.155/Sistemas/uploadArchivosLaredo.php?codigoSolicitud=$solicitudID&tipoArchivo=$row[0]&usuario=$usuarioId&nombrephp=$nombrephp' frameborder='0'></iframe><br>";
					echo "</div>";
				echo"</td>";
			echo "</tr>";
		echo "</table>";
		
		//muestro formulario para la opcion de parametros de reporte
		if($row[0] == "Parametros de Reporte"){
			
			//verifico si ya existe registro
			$existeRegistro = $INTRANET->getOne("SELECT xt_quejaSolicitud  FROM SGI_Backlog_Informacion_Reportes WHERE xt_quejaSolicitud = '$solicitudID'");

			if($existeRegistro == ''){
				echo "<table border='0' style='width: 100%' cellspacing='0' align='center'>";
					echo "<td width='60px'> </td>";
					echo "<td> </td>";
					echo "<td>";
					
						echo "<iframe onresize='reSize();' id='ifrm' marginwidth='0' marginheight='0' frameborder='0'  width='730px' height='1055px'onresize='reSize();' id='ifrm' src='http://71.144.19.155/INTRANET_GEA/Backlog/formularioReporte.php?codigoSolicitud=$solicitudID&tipoArchivo=$row[0]&usuario=$usuarioId' ></iframe><br>";
						
					echo "</td>";
					
				echo "</table>";
			}else{
				
				echo "<table border='0' style='width: 100%' cellspacing='0' align='center'>";
					echo "<td width='60px'> </td>";
					echo "<td> </td>";
					echo "<td>";
					
						echo "<iframe id='ifrm' src='http://71.144.19.155/INTRANET_GEA/Backlog/formularioReporte.php?codigoSolicitud=$solicitudID&tipoArchivo=$row[0]&usuario=$usuarioId' marginwidth='0' marginheight='0' frameborder='0'  width='730px' height='1055px'></iframe><br>";
						
					echo "</td>";
					
				echo "</table>";
			}
			
			
		}//fin del if donde veifico que se de tipo parametros de reporte para mostrar formulario
	}//fin del while de tipo de docuemntos
	//iframe de Documentacion
	/*
	echo "<iframe id='miFrame'  src='http://71.144.19.155/INTRANET_GEA/Backlog/manipuladorDocumentosBacklog.php?codigo=$solicitudID&usuario=$usuarioId' frameborder='0'  width='100%' height='500'></iframe>";
	*/
	
	//obtengo datos de validación tecnica
	$datosVT = $INTRANET->Execute("SELECT xt_status, xt_usuario, xd_fecha, xt_comentario, xt_ruta FROM  SGI_Backlog_Validaciones WHERE 
			xt_quejaSolicitud = '$solicitudID' AND xt_tipoValidacion = 'TECNICA'");		
	while($listaVT = $datosVT->fetchRow()){	
		$statusVT = $listaVT[0];
		$usuarioVT = $listaVT[1];
		$fechaVT = $listaVT[2];
		$comentarioVT = $listaVT[3];
		$rutaVT = $listaVT[4];
	}
	
	if($statusVT == ""){
		if($usuarioId == "Rodrigo_Romo"){
			echo "<table width='100%'>";
				echo "<tr height='25px'></tr>";
				
				echo "<tr>";
					echo "<td align='left' id='titulo2'>Validación técnica</td>";
					echo "<td width='25px'>";
						/*
						echo "<a href='http://71.144.19.155/INTRANET_GEA/Backlog/backlogVTPopUp.php?codigo=$solicitudID&usuario=$usuarioId' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=550,scrollbars=yes')\"><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";
						*/
					echo "</td>";		
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='3' 	style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
			
			//div donde muestr gif de cargando
			echo "<div id='cargaValidaT' style='display:none' align='center'>";
    			echo "<img src='../../../INTRANET_GEA/Imagenes/img_load.gif' />";
  			echo "</div>";
			
			echo "<div id='contValidaT' style='display:block'>";
			
			echo "<div id='validacionTecnica'>";
				echo "<table align='center' width='20%'>";
					echo "<tr height='20px'></tr>";
					?>
					<tr height="25px" align="center">
						<td id="valTecnicaProcede" style="width: 35%; cursor:pointer" align="center" bgcolor="#42CB27"  onclick="ilumina('valTecnicaProcede', 'ValidacionTecnica')"><font color="white">Procede</font></td>
					</tr>
				
					<tr height="10px"></tr>
				
					<tr height="25px" align="center">
						<td id="valTecnicaNoProcede" style="width: 35%; cursor:pointer" align="center"  bgcolor="red" onClick="ilumina('valTecnicaNoProcede', 'ValidacionTecnica')"><font color="white">No procede</font></td>
					</tr>
					<?php 
				echo "</table>";
				
				echo "<div id='valTecnicaComentario'>";
					echo "<table  border='0' align='center' width='80%'>";
						echo "<tr>";
							echo "<td style='color:#007CBD;'>Comentarios</td>";
						echo "</tr>";
			
						echo "<tr>";
							echo "<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr align='center'>";
							echo "<td><textarea id='valTecnicaComentarioVerif' rows='4' cols='70'>$comentarioVT</textarea></td>";
						echo "</tr>";
			
						echo "<tr>";
							echo "<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr height='25px'></tr>";
					echo "</table>";
				echo "</div>";
			echo "</div>";
			echo "</div>"; //fin del div que engloba al comentario y a la decision
			
		}
	}else if($statusVT == "ACEPTADA"){
		echo "<table width='100%'>";
			echo "<tr height='25px'></tr>";
			
			echo "<tr>";
				echo "<td align='left' id='titulo2'>Validación técnica</td>";
				echo "<td width='25px'>";
					/*
					echo "<a href='http://71.144.19.155/INTRANET_GEA/Backlog/backlogVTPopUp.php?codigo=$solicitudID&usuario=$usuarioId' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=550,scrollbars=yes')\"><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";
					*/
				echo "</td>";		
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='3' 	style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		
		echo "<div id='validacionTecnica'>";
			?>
			<table align='center' width='20%'>
				<tr height='20px'></tr>
				<tr id='trValidacion' style="display:block">
					<td id="valTecnicaProcede" style="width: 20%" align="center" bgcolor="#42CB27"><font 	
					color="white">Procede</font></td> 
				</tr>
			</table>
			
			<div id='contCambioV' style="display:none">
				<table border='0' align='center' width='30%'>	
					 <tr>
						 <td id="tdProcede" style="width: 35%" align="center" bgcolor="#42CB27" onClick="ilumina2('tdProcede', 'white')"><font color="black">Procede</font></td>	
					 </tr>
				
					 <tr height="10px"></tr>
						 
					 <tr>
						<td id="tdNoProcede" style="width: 35%" align="center"  bgcolor="red" onClick="ilumina2('tdNoProcede', 'white')"><font color="white">No procede</font></td>
					 </tr>
				 </table>
			</div>
			
			<?php
			 
			echo "<table  border='0' align='center' width='50%'>";
				echo "<tr height='10px'><td></td></tr>";
			
				echo "<tr>";
					$nombreVT = $INTRANET->getOne("SELECT xt_nombre FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioVT'");
					echo "<td align='center'>$nombreVT aprobó la solicitud</td>";
				echo "</tr>";
			
				echo "<tr align='center'>";
					echo "<td>$fechaVT</td>";
				echo "</tr>";
				
				echo "<tr height='15px'></tr>";
				
			echo "</table>";
			
			//comentarios 
			if($comentarioVT != ''){
				echo "<table  border='0' align='center' width='80%'>";
					echo "<tr>";
						echo "<td style='color:#007CBD;'>Comentarios</td>";
					echo "</tr>";
		
					echo "<tr>";
						echo "<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
						echo "</td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td style='padding:0px 0px 0px 15px'>$comentarioVT</td>";
					echo "</tr>";
		
					echo "<tr>";
						echo "<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
						echo "</td>";
					echo "</tr>";
					
					echo "<tr height='25px'></tr>";
				echo "</table>";
			}
		echo "</div>";
	}else if($statusVT == "RECHAZADA"){
		echo "<table width='100%'>";
			echo "<tr height='25px'></tr>";
			
			echo "<tr>";
				echo "<td align='left' id='titulo2'>Validación técnica</td>";
				echo "<td width='25px'>";
					/*
					echo "<a href='http://71.144.19.155/INTRANET_GEA/Backlog/backlogVTPopUp.php?codigo=$solicitudID&usuario=$usuarioId' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=550,scrollbars=yes')\"><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";
					*/
				echo "</td>";		
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='3' 	style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		
		echo "<div id='validacionTecnica'>";
			?>
			<table align='center' width='20%'>
				<tr height='20px'></tr>
				<tr id='trValidacion' style="display:block">
					<td id="tdNoProcede" style="width: 20%" align="center"  bgcolor="red"><font color="white">No procede</font></td>
				</tr>
			</table>
			
			<div id='contCambioV' style="display:none">
				<table border='0' align='center' width='30%'>	
					 <tr>
						 <td id="tdProcede" style="width: 35%" align="center" bgcolor="#42CB27" onClick="ilumina2('tdProcede', 'white')"><font color="black">Procede</font></td>	
					 </tr>
				
					 <tr height="10px"></tr>
						 
					 <tr>
						<td id="tdNoProcede" style="width: 35%" align="center"  bgcolor="red" onClick="ilumina2('tdNoProcede', 'white')"><font color="white">No procede</font></td>
					 </tr>
				 </table>
			</div>
			 
			<?php
			 
			echo "<table border='0' align='center' width='50%'>";
				echo "<tr height='10px'></tr>";
			
				echo "<tr>";
					$nombreVT = $INTRANET->getOne("SELECT xt_nombre FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioVT'");
					echo "<td align='center'>$nombreVT rechazó la solicitud</td>";
				echo "</tr>";
			
				echo "<tr align='center'>";
					echo "<td>$fechaVT</td>";
				echo "</tr>";
				
				echo "<tr height='15px'></tr>";
			echo "</table>";
			//comentarios 
				
			if($comentarioVT != ''){
				echo "<table  border='0' align='center' width='80%'>";
					echo "<tr>";
						echo "<td style='color:#007CBD;'>Comentarios</td>";
					echo "</tr>";
		
					echo "<tr>";
						echo "<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
						echo "</td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td colspan='2' style='padding:0px 0px 0px 15px'>$comentarioVT</td>";
					echo "</tr>";
		
					echo "<tr>";
						echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
						echo "</td>";
					echo "</tr>";
					
					echo "<tr height='25px'></tr>";
				echo "</table>";
			}
		echo "</div>";
	}
	
	
	//Seccion de Validación de negocio
	if($statusVT == "ACEPTADA"){	
		//verifico validacion de negocio
		$j = $INTRANET->Execute("SELECT xt_status, xd_fecha, xt_usuario, xt_comentario FROM SGI_Backlog_Validaciones where 
	 xt_quejaSolicitud ='$solicitudID' and xt_tipoValidacion = 'NEGOCIO'");
		while($s = $j -> fetchRow()){
			$statusValidacionN = $s[0];
			$fechaVN = $s[1];
			$usuarioVN = $s[2];
			$comentarioVN = $s[3];
		}
		
		if($statusValidacionN == ''){
			if($usuarioId == "Rodrigo_Romo" || $usuarioId == "antonio" || $usuarioId == "gabriel" || $usuarioId == "julio" || $usuarioId == "sdelap"){
				echo "<table width='100%'>";
					echo "<tr height='25px'></tr>";
					
					echo "<tr>";
						echo "<td align='left' id='titulo2'>Validación de negocio</td>";	
						?>
						<td align="right" style="width: 10%">
							<!--
							<div id="btn1" >
								<a style="cursor:pointer"  id="insertaP"  onClick="muestraCambioV()"><font color='#007CBD'>Modificar</font></a>
							</div>
							-->
						</td>
						<?php
					echo "</tr>";
					
					echo "<tr>";
						echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
				
				//div donde muestr gif de cargando
			echo "<div id='cargaValidaN' style='display:none' align='center'>";
    			echo "<img src='../../../INTRANET_GEA/Imagenes/img_load.gif' />";
  			echo "</div>";
			
			echo "<div id='contValidaN' style='display:block'>";
				
				echo "<div id='validacionNegocio'>";
					echo "<table align='center' width='20%'>";
						echo "<tr height='20px'></tr>";
						?>
						<tr height="25px" align="center">
							<td id="valNegocioProcede" style="width: 35%; cursor:pointer" align="center" bgcolor="#42CB27"  onclick="ilumina('valNegocioProcede', 'ValidacionNegocio')"><font color="white">Procede</font></td>
						</tr>
					
						<tr height="10px"></tr>
					
						<tr height="25px" align="center">
							<td id="valNegocioNoProcede" style="width: 35%; cursor:pointer" align="center"  bgcolor="red" onClick="ilumina('valNegocioNoProcede', 'ValidacionNegocio')"><font color="white">No procede</font></td>
						</tr>
						<?php 
					echo "</table>";
					
					echo "<div id='comentarioVN'>";
						echo "<table  border='0' align='center' width='80%'>";
						echo "<tr>";
							echo "<td style='color:#007CBD;'>Comentarios</td>";
						echo "</tr>";
			
						echo "<tr>";
							echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr align='center'>";
							echo "<td><textarea id='valNegocioComentarioVerif' rows='4' cols='70'>$comentarioVN</textarea></td>";
						echo "</tr>";
			
						echo "<tr>";
							echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr height='25px'></tr>";
					echo "</table>";
					echo "</div>";
				echo "</div>";
			echo "</div>"; //fin del div que engloba el comentario y la decision en validacion de negocio
			}
		}else if($statusValidacionN == 'ACEPTADA'){
			echo "<table width='100%'>";
				echo "<tr height='25px'></tr>";
				
				echo "<tr>";
					echo "<td align='left' id='titulo2'>Validación de negocio</td>";	
					?>
					<td align="right" style="width: 10%">
						<!--
						<div id="btn1" >
							<a style="cursor:pointer"  id="insertaP"  onClick="muestraCambioV()"><font color='#007CBD'>Modificar</font></a>
						</div>
						-->
					</td>
					<?php
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
			
			echo "<div id='validacionNegocio'>";
				echo "<table align='center' width='20%'>";
					echo "<tr height='20px'></tr>";
					?>
					<tr id='trValidacion' style="display:block">
					   <td id="tdProcede" style="width: 20%" align="center" bgcolor="#42CB27"><font color="white">Procede</font></td> 
					</tr>
				</table>
			   
				<div id='contCambioV' style="display:none">
					<table border='0' align='center' width='30%'>	
						<tr>
							<td id="valNegocioProcede" style="width: 35%" align="center" bgcolor="#42CB27"  onclick="ilumina('valNegocioProcede', 'ValidacionNegocio')"><font color="white">Procede</font></td>
						</tr>
			  
						<tr height="10px"></tr>
			  
						<tr>
							<td id="valNegocioNoProcede" style="width: 35%" align="center"  bgcolor="red" onClick="ilumina('valNegocioNoProcede', 'white')"><font color="black">No procede</font></td>
						</tr> 
					</table>
				</div>
				<?php
			   
				echo "<table  border='0' align='center' width='50%'>";
					echo "<tr height='10px'><td></td></tr>";
				
					echo "<tr>";
						$nombreVN = $INTRANET->getOne("SELECT xt_nombre FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioVN'");
						echo "<td align='center'>$nombreVN aprobó la solicitud</td>";
					echo "</tr>";
				
					echo "<tr align='center'>";
						echo "<td>$fechaVN</td>";
					echo "</tr>";
					
					echo "<tr height='15px'></tr>";
					
				echo "</table>";
				
				//comentarios 
				if($comentarioVN != ''){
					echo "<table  border='0' align='center' width='80%'>";
						echo "<tr>";
							echo "<td style='color:#007CBD;'>Comentarios</td>";
						echo "</tr>";
			
						echo "<tr>";
							echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td colspan='2' style='padding:0px 0px 0px 15px'>$comentarioVN</td>";
						echo "</tr>";
			
						echo "<tr>";
							echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr height='25px'></tr>";
					echo "</table>";
				}
			echo "</div>";	 
		}else if($statusValidacionN == 'RECHAZADA'){
			echo "<table width='100%'>";
				echo "<tr height='25px'></tr>";
				
				echo "<tr>";
					echo "<td align='left' id='titulo2'>Validación de negocio</td>";	
					?>
					<td align="right" style="width: 10%">
						<!--
						<div id="btn1" >
							<a style="cursor:pointer"  id="insertaP"  onClick="muestraCambioV()"><font color='#007CBD'>Modificar</font></a>
						</div>
						-->
					</td>
					<?php
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
			
			echo "<div id='validacionNegocio'>";
				?>
				<table align='center' width='20%'>
					<tr height='20px'></tr>
					<tr id='trValidacion' style="display:block">
						<td id="tdNoProcede" style="width: 20%" align="center"  bgcolor="red"><font color="white">No procede</font></td>
					</tr>
				</table>
				
				<div id='contCambioV' style="display:none">
					<table border='0' align='center' width='30%'>	
						 <tr>
							 <td id="valNegocioProcede" style="width: 35%" align="center" bgcolor="#42CB27" onClick="ilumina('valNegocioProcede', 'ValidacionNegocio')"><font color="black">Procede</font></td>	
						 </tr>
					
						 <tr height="10px"></tr>
							 
						 <tr>
							<td id="valNegocioNoProcede" style="width: 35%" align="center"  bgcolor="red" onClick="ilumina('valNegocioNoProcede', 'white')"><font color="white">No procede</font></td>
						 </tr>
					 </table>
				</div>
				 
				<?php
				 
				echo "<table border='0' align='center' width='50%'>";
					echo "<tr height='10px'></tr>";
				
					echo "<tr>";
						$nombreVN = $INTRANET->getOne("SELECT xt_nombre FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioVN'");
						echo "<td align='center'>$nombreVN rechazó la solicitud</td>";
					echo "</tr>";
				
					echo "<tr align='center'>";
						echo "<td>$fechaVN</td>";
					echo "</tr>";
					
					echo "<tr height='15px'></tr>";
				echo "</table>";
				//comentarios 
					
				if($comentarioVN != ''){
					echo "<table  border='0' align='center' width='80%'>";
					echo "<tr>";
						echo "<td style='color:#007CBD;'>Comentarios</td>";
					echo "</tr>";
		
					echo "<tr>";
						echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
						echo "</td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td colspan='2' style='padding:0px 0px 0px 15px'>$comentarioVN</td>";
					echo "</tr>";
		
					echo "<tr>";
						echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
						echo "</td>";
					echo "</tr>";
					
					echo "<tr height='25px'></tr>";
				echo "</table>";
				}
			echo "</div>";
		}
	}
	
	//seccion validación final del requerimiento
	if($statusValidacionN == "ACEPTADA"){
		
		//sección donde agrega los datos de validacion final
		$datosVF = $INTRANET->Execute("SELECT xt_status, xt_usuario, xd_fecha, xt_comentario, xt_ruta FROM  SGI_Backlog_Validaciones WHERE xt_quejaSolicitud = '$solicitudID' AND xt_tipoValidacion = 'FINAL'");
		while($listaVF = $datosVF->fetchRow()){	
			$statusVF = $listaVF[0];
			$usuarioVF = $listaVF[1];
			$fechaVF = $listaVF[2];
			$comentarioVF = $listaVF[3];
			$rutaVF = $listaVF[4];
		}
		
		if($statusVF == ""){
			if($usuarioId == "Rodrigo_Romo"){
				echo "<table width='100%'>";
					echo "<tr height='25px'></tr>";
					
					echo "<tr>";
						echo "<td align='left' id='titulo2'>Validación final del requerimiento</td>";
						echo "<td width='15px'>";
							/*
							echo "<a href='http://71.144.19.155/INTRANET_GEA/Backlog/backlogVFPopUp.php?codigo=$solicitudID&usuario=$usuarioId' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=500,scrollbars=yes')\"><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";
							*/
						echo "</td>";	
					echo "</tr>";
					
					echo "<tr>";
						echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
				
				//div donde muestr gif de cargando
			echo "<div id='cargaValidaF' style='display:none' align='center'>";
    			echo "<img src='../../../INTRANET_GEA/Imagenes/img_load.gif' />";
  			echo "</div>";
			
			echo "<div id='contValidaF' style='display:block'>";
			
				echo "<div id='validacionFinal'>";
					echo "<table align='center' width='20%'>";
						echo "<tr height='20px'></tr>";
						?>
						<tr height="25px" align="center">
							<td id="valFinalProcede" style="width: 35%; cursor:pointer" align="center" bgcolor="#42CB27"  onclick="ilumina('valFinalProcede', 'ValidacionFinal')"><font color="white">Procede</font></td>
						</tr>
					
						<tr height="10px"></tr>
					
						<tr height="25px" align="center">
							<td id="valFinalNoProcede" style="width: 35%; cursor:pointer" align="center"  bgcolor="red" onClick="ilumina('valFinalNoProcede', 'ValidacionFinal')"><font color="white">No procede</font></td>
						</tr>
						<?php 
					echo "</table>";
					
					echo "<div id='valFinalComentario'>";
						echo "<table  border='0' align='center' width='80%'>";
							echo "<tr>";
								echo "<td style='color:#007CBD;'>Comentarios</td>";
							echo "</tr>";
				
							echo "<tr>";
								echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
								echo "</td>";
							echo "</tr>";
							
							echo "<tr align='center'>";
								echo "<td><textarea id='valFinalComentarioVerif' rows='4' cols='70'>$comentarioVF</textarea></td>";
							echo "</tr>";
				
							echo "<tr>";
								echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
								echo "</td>";
							echo "</tr>";
							
							echo "<tr height='25px'></tr>";
						echo "</table>";
					echo "</div>";
				echo "</div>";
			echo "</div>"; //fin del div que engloba el comenatario y la seleccion
			}
		}else if($statusVF == "ACEPTADA"){
			
			echo "<table width='100%'>";
				echo "<tr height='25px'></tr>";
				
				echo "<tr>";
					echo "<td align='left' id='titulo2'>Validación final del requerimiento</td>";
					echo "<td width='15px'>";
						/*
						echo "<a href='http://71.144.19.155/INTRANET_GEA/Backlog/backlogVFPopUp.php?codigo=$solicitudID&usuario=$usuarioId' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=500,scrollbars=yes')\"><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";
						*/
					echo "</td>";	
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
			
			echo "<div id='validacionFinal'>";
				?>
				<table align='center' width='20%'>
					<tr height='20px'></tr>
					<tr id='trValidacion' style="display:block">
						<td id="valFinalProcede" style="width: 20%" align="center" bgcolor="#42CB27"><font 	
						color="white">Procede</font></td> 
					</tr>
				</table>
				
				<div id='contCambioV' style="display:none">
					<table border='0' align='center' width='30%'>	
						 <tr>
							 <td id="valFinalProcede" style="width: 35%" align="center" bgcolor="#42CB27" onClick="ilumina('valFinalProcede', 'ValidacionFinal')"><font color="black">Procede</font></td>	
						 </tr>
					
						 <tr height="10px"></tr>
							 
						 <tr>
							<td id="valFinalNoProcede" style="width: 35%" align="center"  bgcolor="red" onClick="ilumina('valFinalNoProcede', 'ValidacionFinal')"><font color="white">No procede</font></td>
						 </tr>
					 </table>
				</div>
				
				<?php
				 
				echo "<table  border='0' align='center' width='50%'>";
					echo "<tr height='10px'><td></td></tr>";
				
					echo "<tr>";
						$nombreVFR = $INTRANET->getOne("SELECT xt_nombre FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioVF'");
						echo "<td align='center'>$nombreVFR aprobó la solicitud</td>";
					echo "</tr>";
				
					echo "<tr align='center'>";
						echo "<td>$fechaVF</td>";
					echo "</tr>";
					
					echo "<tr height='15px'></tr>";
					
				echo "</table>";
				
				//comentarios 
				if($comentarioVF != ''){
					echo "<table  border='0' align='center' width='80%'>";
						echo "<tr>";
							echo "<td style='color:#007CBD;'>Comentarios</td>";
						echo "</tr>";
			
						echo "<tr>";
							echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td colspan='2' style='padding:0px 0px 0px 15px'>$comentarioVF</td>";
						echo "</tr>";
			
						echo "<tr>";
							echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr height='25px'></tr>";
					echo "</table>";
				}
			echo "</div>";
		}else if($statusVF == "RECHAZADA"){
			
			echo "<table width='100%'>";
				echo "<tr height='25px'></tr>";
				
				echo "<tr>";
					echo "<td align='left' id='titulo2'>Validación final del requerimiento</td>";
					echo "<td width='15px'>";
						/*
						echo "<a href='http://71.144.19.155/INTRANET_GEA/Backlog/backlogVFPopUp.php?codigo=$solicitudID&usuario=$usuarioId' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=500,scrollbars=yes')\"><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";
						*/
					echo "</td>";	
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
			
			echo "<div id='validacionFinal'>";
				?>
				<table align='center' width='20%'>
					<tr height='20px'></tr>
					<tr id='trValidacion' style="display:block">
						<td id="valFinalNoProcede" style="width: 20%" align="center"  bgcolor="red"><font color="white">No procede</font></td>
					</tr>
				</table>
				
				<div id='contCambioV' style="display:none">
					<table border='0' align='center' width='30%'>	
						 <tr>
							 <td id="valFinalProcede" style="width: 35%" align="center" bgcolor="#42CB27" onClick="ilumina('valFinalProcede', 'ValidacionFinal')"><font color="black">Procede</font></td>	
						 </tr>
					
						 <tr height="10px"></tr>
							 
						 <tr>
							<td id="valFinalNoProcede" style="width: 35%" align="center"  bgcolor="red" onClick="ilumina('valFinalNoProcede', 'white')"><font color="white">No procede</font></td>
						 </tr>
					 </table>
				</div>
				 
				<?php
				 
				echo "<table border='0' align='center' width='50%'>";
					echo "<tr height='10px'></tr>";
				
					echo "<tr>";
						$nombreVFR = $INTRANET->getOne("SELECT xt_nombre FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioVF'");
						echo "<td align='center'>$nombreVFR rechazó la solicitud</td>";
					echo "</tr>";
				
					echo "<tr align='center'>";
						echo "<td>$fechaVF</td>";
					echo "</tr>";
					
					echo "<tr height='15px'></tr>";
				echo "</table>";
				//comentarios 
					
				if($comentarioVF != ''){
					echo "<table  border='0' align='center' width='80%'>";
						echo "<tr>";
							echo "<td style='color:#007CBD;'>Comentarios</td>";
						echo "</tr>";
			
						echo "<tr>";
							echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td colspan='2' style='padding:0px 0px 0px 15px'>$comentarioVF</td>";
						echo "</tr>";
			
						echo "<tr>";
							echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr height='25px'></tr>";
					echo "</table>";
				}
			echo "</div>";
		}
		
		/*
		//sección donde agrega los datos de validacion
		echo "<table border='0' width='100%'>";
			echo "<tr height='10px'></tr>";
			
			echo "<tr>";
				echo "<td style='color:#007CBD;' width='60px'></td>";
				echo "<td style='color:#007CBD;' width='30%'>Status</td>";
				echo "<td style='color:#007CBD;' width='35%'>User</td>";
				echo "<td style='color:#007CBD;' width='30%'>Fecha</td>";
				echo "<td style='color:#007CBD;' width='15px'></td>";
			echo "</tr>";
		
			echo "<tr>";
				echo "<td style='color:#007CBD;' width='30px'></td>";
				echo "<td colspan='4' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
				echo "</td>";
			echo "</tr>";
		
			echo "<tr>";
				echo "<td width='60px'></td>";
				if($statusVF == 'ACEPTADA'){
					echo "<td width='30%'>ACEPTADO</td>";
				}
				if($statusVF == 'RECHAZADA'){
					echo "<td width='30%'>RECHAZADO</td>";
				}
				
				echo "<td width='35%'>$usuarioVF</td>";
				echo "<td width='30%'>$fechaVF</td>";
				echo "<td width='15px'></td>";
			echo "</tr>";
			
			echo "<tr height='10px'></tr>";
		
			echo "<tr>";
				echo "<td width='60px'></td>";
				echo "<td></td>";
				echo "<td style='color:#007CBD;'>Comentarios</td>";
			echo "</tr>";
		
			echo "<tr>";
				echo "<td style='color:#007CBD;' width='30px'></td>";
				echo "<td></td>";
				
				echo "<td colspan='3' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
				echo "</td>";
			echo "</tr>";
		
			echo "<tr>";
				echo "<td style='color:#007CBD;' width='30px'></td>";
				echo "<td></td>";
				echo "<td colspan='2'>$comentarioVF</td>";
				if($rutaVF != ''){
					echo "<td>";
						echo "<a href='http://71.144.19.155/INTRANET_GEA/Backlog/extraccionDoctos.php?codigo=$solicitudID&ruta=$rutaVF'><img src='../../Imagenes/ICN_Archivo.png' height='15' width='12' /></a>";
					echo "</td>";
				}
				//echo "<td><img src='../../Imagenes/ICN_Archivo.png' height='15' width='12'></td>";
			echo "</tr>";
		
			echo "<tr>";
				echo "<td style='color:#007CBD;' width='30px'></td>";
				echo "<td></td>";
				echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'></td>";
			echo "</tr>";
		echo "</table>";
		*/
	}
	
	//SECCION DE ENTREGABLES
	$numeroEntregables=0;
	$porcientoEntregablesCompletos = 100;
	$porcientoEntregablesActuales = 0;
	if($statusVF == "ACEPTADA"){	
		//Seccion de entregables
		echo "<table width='100%'>";
			echo "<tr height='25px'></tr>";
		
			echo "<tr>";
				//obtengo tipo de solicitud
				$tipoS = $INTRANET->getOne("SELECT xt_tipoSolicitud FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$solicitudID'");
				echo "<td align='left' id='titulo2'>Entregables</td>";
				echo "<td width='15px'>";
					echo "<a href='backlogEntregablesPopUp.php?codigo=$solicitudID&tipoS=$tipoS&ciudad=$ciudadSolicitud&prioridad=$prioridad' target='popup' onclick=\"window.open(this.href,this.target,'width=470,height=400,scrollbars=yes')\"><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";
				echo "</td>";	
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'></td>";
			echo "</tr>";
		echo "</table>";
		
		
		//consulta para obtener los entregables de una solicitud
		$entg = $INTRANET->Execute("SELECT xt_codigoEntregable, xt_tipo, xt_titulo, xt_descripcion, xn_progreso FROM BACKLOG.ENTREGABLES WHERE xt_solicitud='$solicitudID'");
		while($lisEntg = $entg->fetchRow()){
			$numeroEntregables++;
			$porcientoEntregablesActuales += $lisEntg[4];
			echo "<table width='100%'>";
				echo "<tr height='20px'></tr>";
			
				echo "<tr>";
					echo "<td width='30px'></td>";
					echo "<td align='left' id='manualVinculo' style='font-size:18px;color:#007CBD;'>$lisEntg[2]</td>";
					echo "<td width='15px'></td>";
					echo "<td width='15px'><a href='backlogAsignaPdrPopUp.php?codigoE=$lisEntg[0]&codigoS=$solicitudID' target='popup' onclick=\"window.open(this.href,this.target,'width=450,height=370,scrollbars=yes')\"><img src='../../Imagenes/ICN_NuevoDoc.png' height='15' width='15'> </a></td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td width='30px'></td>";
					echo "<td colspan='3' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
			echo "</table>"; //cierro tabla de de entregables
			
			//sección donde agrega los campos del tipo de documento
			//verifico si tiene asignado un pdr en la tabla de historial (no en la de pdr) ya que cuando se elimina el entregable en el PDR se pierden los datos
			$programadorAsignado = $INTRANET->getOne("SELECT xt_programador FROM BACKLOG.HISTORIAL_ENTREGABLE WHERE xt_codigoEntregable = '$lisEntg[0]' ORDER BY xd_fecha DESC");
			$posicionAsignada = $INTRANET->getOne("SELECT xn_posicion FROM BACKLOG.HISTORIAL_ENTREGABLE WHERE xt_codigoEntregable = '$lisEntg[0]' ORDER BY xd_fecha DESC");
			//$verPdr = $INTRANET->Execute("SELECT xt_programador, xn_posicion FROM BACKLOG.PDR WHERE xt_codigoEntregable = '$lisEntg[0]'");
			//while($listPDR = $verPdr->fetchRow()){
				$etapa = $INTRANET->getOne("SELECT xt_etapa FROM BACKLOG.ETAPAS WHERE xt_codigoEntregable = '$lisEntg[0]' ORDER BY xd_fecha DESC");
				if($programadorAsignado != ''){
					echo "<table border='0' width='100%'>";
						echo "<tr height='10px'></tr>";
						
						echo "<tr>";
							echo "<td style='color:#007CBD;' width='60px'></td>";
							echo "<td style='color:#007CBD;' width='35%'>PDR</td>";
							echo "<td style='color:#007CBD;' width='30%'>Código</td>";
							echo "<td style='color:#007CBD;' width='20%'>Status</td>";
							echo "<td style='color:#007CBD;' width='15px'></td>";
						echo "</tr>";
				
						echo "<tr>";
							echo "<td width='30px'></td>";
							echo "<td colspan='5' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
							echo "</td>";
						echo "</tr>";
					
						echo "<tr>";
							echo "<td width='60px'></td>";
							echo "<td>$programadorAsignado</td>";
							
							if($etapa == 'TERMINADA'){
								
								//envio parametros necesarios
								$prioriE = $INTRANET->getOne("SELECT xt_prioridad FROM BACKLOG.ENTREGABLES WHERE xt_codigoEntregable = '$lisEntg[0]'");
								echo "<td>";
								echo "<a href=https://escalante.com.mx/Sistemas/BackLog/iniciaSesion.php?codE=".base64_encode($lisEntg[0])."&prioridad=".base64_encode($prioriE)."&codS=".base64_encode($solicitudID)."&usu=".base64_encode($usuarioId)."> $lisEntg[0]</a>";
								echo "</td>";
							
							}else{
								
								echo "<td>";
								echo "<a href='https://escalante.com.mx/Sistemas/BackLog/iniciaSesion.php'> $lisEntg[0]</a>";
								echo "</td>";
								
							}
							
							//echo "<td>$lisEntg[0]</td>";
							if($etapa != ''){
								if($etapa == 'TERMINADA'){
									echo "<td>TERMINADO</td>";
								}else{
									echo "<td>$etapa</td>";	
								}								
							}else{
								echo "<td>Lugar: $posicionAsignada</td>";
							}
							echo "<td width='15px'></td>";
						echo "</tr>";
						
						//Comentario del programador cuando el entrgable esta terminado
						if($etapa == 'TERMINADA'){
							echo "<tr height='10'></tr>";
							echo "<tr>";
								echo "<td width='15px'></td>";
								echo "<td style='color:#636262;' colspan='4' >";
									echo "Comentario:";
								echo "</td>";
							echo "</tr>";
							//obtengo el comentario del entregable (el que pone el programador cuando finaliza su entregable)
							$comentarioProgra = $INTRANET->getOne("SELECT xt_comentario FROM BACKLOG.ETAPAS WHERE xt_codigoEntregable = '$lisEntg[0]' AND xt_etapa = 'EN PRUEBAS'");
							echo "<tr>";
								echo "<td width='15px'></td>";
								echo "<td colspan='4' style='color:#636262;'>";
									echo "$comentarioProgra";
								echo "</td>";
							echo "</tr>";
						}
						
				
						echo "<tr>";
							echo "<td width='30px'></td>";
							echo "<td colspan='5' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
							echo "</td>";
						echo "</tr>";
					
					echo "</table>";
				}//fin del if de verficacion si tiene asignado un pdr
			//}//fin del while de datos del pdr en documentación
		}//fin del while de entregables
		
		/*$d = $INTRANET->getOne("SELECT xt_etapa FROM ETAPAS WHERE xt_codigoEntregable = '$lisEntg[0]' AND xt_etapa = 'TERMINADA'");
		if($d != ''){$w += 1;}*/
		if($numeroEntregables>0){
			$porcientoEntregablesCompletos *= $numeroEntregables;
		}
	}
	
	
	//seccion de liberación de funcionalidad
	if($porcientoEntregablesCompletos == $porcientoEntregablesActuales){
		//verifico si habilito la seccion de reportes
		 $existeReporte = $INTRANET->getOne("SELECT xt_tipoDocumento FROM SGI_Backlog_Documentos WHERE xt_quejaSolicitud = '$solicitudID' AND  xt_tipoDocumento = 'Parametros de Reporte'");
		if($existeReporte == ''){
			
			$s = $INTRANET->Execute("SELECT xt_status, xd_fecha, xt_usuario, xt_comentarios FROM SGI_Backlog_Liberacion_Funcionalidad where xt_quejaSolicitud ='$solicitudID' and xt_status = 'LIBERADA'");	
			while ($j = $s->fetchRow()){
				$statusLiberacion = $j[0];
				$fechaLiberacion = $j[1];
				$usuarioLiberacion = $j[2];
				$comentarioLiberacion = $j[3];
			}
				
			if($statusLiberacion == ''){
				if ($usuarioId == "Rodrigo_Romo" || $usuarioId == $usuarioSolicitud){
					echo "<table width='100%'>";
						echo "<tr height='60px'></tr>";
						
						echo "<tr>";
							echo "<td align='left' id='titulo2'>Liberación de funcionalidad</td>";	
						echo "</tr>";
						
						echo "<tr>";
							echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
					
					//div donde muestr gif de cargando
			echo "<div id='cargaValidaL' style='display:none' align='center'>";
    			echo "<img src='../../../INTRANET_GEA/Imagenes/img_load.gif' />";
  			echo "</div>";
			
			echo "<div id='contValidaL' style='display:block'>";
					echo "<div id='liberaFuncionalidad'>";
						//seccion aprobado o no aprobado
						echo "<table align='center' border='0' width='20%'>";
							//hago consulta para verificar el estado de liberación
							echo "<tr height='20px'></tr>";
							?>
							<tr>
								<td id="tdLibera" style="width: 35%; cursor:pointer" align="center" bgcolor="#42CB27" onClick="iluminaLibera('tdLibera', 'white')"><font color="white">LIBERAR</font> </td>
							</tr>
							<?php
						echo "</table>";
						
						echo "<div id='comentarioLiberacion'>";
							echo "<table width='60%' align='center'>";
								echo "<tr height='15px'></tr>";
							
								echo "<tr align='center'>";
									echo "<td>Comentarios:</td>";
								echo "</tr>";
							
								echo "<tr>";
									echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'></td>";
								echo "</tr>";
								
								echo "<tr align='center'>";
									echo "<td> <textarea id='comentarioLibera' rows='4' cols='70'>$comentarioLiberacion</textarea> </td>";
								echo "</tr>";
								
								echo "<tr>";
									echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'></td>";
								echo "</tr>";
								
								echo "<tr height='50px'></tr>";
							echo "</table>";
						echo "</div>";
					echo "</div>";
				echo "</div>"; // fin del div de liberacion de funcionalidad
				}	
			}else if($statusLiberacion == 'LIBERADA'){
				echo "<table width='100%'>";
					echo "<tr height='60px'></tr>";
					
					echo "<tr>";
						echo "<td align='left' id='titulo2'>Liberación de funcionalidad</td>";	
					echo "</tr>";
					
					echo "<tr>";
						echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			
				//seccion aprobado o no aprobado
				echo "<table align='center' border='0' width='20%'>";
					//hago consulta para verificar el estado de liberación
					echo "<tr height='20px'></tr>";
					?>
					<tr>
						<td id="tdLibera" style="width: 35%" align="center" bgcolor="#42CB27"><font color="white">LIBERADA</font></td>
					</tr>
					<?php
				echo "</table>";
				
				echo "<table align='center' border='0' width='60%'>";
					echo "<tr height='10px'></tr>";
					
					echo "<tr>";
						echo "<td align='center' style='padding:0px 0px 0px 10px' width='35%'>$usuarioLiberacion Liberó funcionalidad</td>";
					echo "</tr>";
					
					echo "<tr align='center'>";
						echo "<td>$fechaLiberacion</td>";
					echo "</tr>";
					
				if($comentarioLiberacion != ''){
					echo "<tr height='15px'></tr>";
				
					echo "<tr align='center'>";
						echo "<td>Comentarios:</td>";
					echo "</tr>";
			
					echo "<tr>";
						echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
						echo "</td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td align='center'>";
							echo $comentarioLiberacion;
						echo "</td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
						echo "</td>";
					echo "</tr>";
					
					echo "<tr height='55px'></tr>";
				}
				
				echo "</table>";
			}
		
		}else{
			//verifico que todos los campos de parametros de reportes esten dados de alta
			//muestro los datos
			$datos = $INTRANET->Execute("SELECT xt_codigoReporte, xt_cliente, xt_solicitanteOriginal, xt_responsableEnvio, xt_responsableReenvio, xt_descripcion, xt_periodicidad, xt_parametros, xt_listaDistribucion, xt_modoEnvio, xt_nombreArchivo, xt_ruta, xt_sistema FROM SGI_Backlog_Informacion_Reportes WHERE xt_quejaSolicitud = '$solicitudID'");
			
			while($listDatos = $datos->fetchRow()){
				
				$codigoReporte = $listDatos[0];
				$clienteR = $listDatos[1];
				$solicitanteR = $listDatos[2];
				$responsableEnvioR = $listDatos[3];
				$responsableReenvioR = $listDatos[4];
				$descripcionR = $listDatos[5];
				$periodicidadR = $listDatos[6];
				$parametrosR = $listDatos[7];
				$listaDisR = $listDatos[8];
				$modoEnvioR = $listDatos[9];
				$nombreArchivoR = $listDatos[10];
				$rutaR = $listDatos[11];
				$sistemaR = $listDatos[12];
				
			}//fin del while
			
			//si todos los atributos estan registrados permito la liberación del entregable
			if($codigoReporte != '' && $clienteR != '' && $responsableEnvioR != '' && $responsableReenvioR != '' && $descripcionR != '' && $periodicidadR != '' && $parametrosR != '' && $listaDisR != '' && $modoEnvioR != '' && $nombreArchivoR != '' && $rutaR != '' && $sistemaR != ''){
				
				
				$s = $INTRANET->Execute("SELECT xt_status, xd_fecha, xt_usuario, xt_comentarios FROM SGI_Backlog_Liberacion_Funcionalidad where xt_quejaSolicitud ='$solicitudID' and xt_status = 'LIBERADA'");	
				while ($j = $s->fetchRow()){
					$statusLiberacion = $j[0];
					$fechaLiberacion = $j[1];
					$usuarioLiberacion = $j[2];
					$comentarioLiberacion = $j[3];
				}
					
				if($statusLiberacion == ''){
					if ($usuarioId == "Rodrigo_Romo"){
						echo "<table width='100%'>";
							echo "<tr height='60px'></tr>";
							
							echo "<tr>";
								echo "<td align='left' id='titulo2'>Liberación de funcionalidad</td>";	
							echo "</tr>";
							
							echo "<tr>";
								echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
								echo "</td>";
							echo "</tr>";
						echo "</table>";
						
						echo "<div id='liberaFuncionalidad'>";
							//seccion aprobado o no aprobado
							echo "<table align='center' border='0' width='20%'>";
								//hago consulta para verificar el estado de liberación
								echo "<tr height='20px'></tr>";
								?>
								<tr>
									<td id="tdLibera" style="width: 35%" align="center" bgcolor="#42CB27" onClick="iluminaLibera('tdLibera', 'white')"><font color="white">LIBERAR</font> </td>
								</tr>
								<?php
							echo "</table>";
							
							echo "<div id='comentarioLiberacion'>";
								echo "<table width='60%' align='center'>";
									echo "<tr height='15px'></tr>";
								
									echo "<tr align='center'>";
										echo "<td>Comentarios:</td>";
									echo "</tr>";
								
									echo "<tr>";
										echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'></td>";
									echo "</tr>";
									
									echo "<tr align='center'>";
										echo "<td> <textarea id='comentarioLibera' rows='4' cols='70'>$comentarioLiberacion</textarea> </td>";
									echo "</tr>";
									
									echo "<tr>";
										echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'></td>";
									echo "</tr>";
									
									echo "<tr height='50px'></tr>";
								echo "</table>";
							echo "</div>";
						echo "</div>";
					}	
				}else if($statusLiberacion == 'LIBERADA'){
					echo "<table width='100%'>";
						echo "<tr height='60px'></tr>";
						
						echo "<tr>";
							echo "<td align='left' id='titulo2'>Liberación de funcionalidad</td>";	
						echo "</tr>";
						
						echo "<tr>";
							echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
							echo "</td>";
						echo "</tr>";
					echo "</table>";
				
					//seccion aprobado o no aprobado
					echo "<table align='center' border='0' width='20%'>";
						//hago consulta para verificar el estado de liberación
						echo "<tr height='20px'></tr>";
						?>
						<tr>
							<td id="tdLibera" style="width: 35%" align="center" bgcolor="#42CB27"><font color="white">LIBERADA</font></td>
						</tr>
						<?php
					echo "</table>";
					
					echo "<table align='center' border='0' width='60%'>";
						echo "<tr height='10px'></tr>";
						
						echo "<tr>";
							echo "<td align='center' style='padding:0px 0px 0px 10px' width='35%'>$usuarioLiberacion Liberó funcionalidad</td>";
						echo "</tr>";
						
						echo "<tr align='center'>";
							echo "<td>$fechaLiberacion</td>";
						echo "</tr>";
						
					if($comentarioLiberacion != ''){
						echo "<tr height='15px'></tr>";
					
						echo "<tr align='center'>";
							echo "<td>Comentarios:</td>";
						echo "</tr>";
				
						echo "<tr>";
							echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td align='center'>";
								echo $comentarioLiberacion;
							echo "</td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr height='55px'></tr>";
					}
					
					echo "</table>";
				}
			
		
				
			}
			
		}//fin del else donde se tienen parametros de reporte
	}
		
		
	//seccion de traslado al usuario final
	if($statusLiberacion == "LIBERADA"){
		
		//sección donde agrega los datos de traslado al usuario final
		$datosTUF = $INTRANET->Execute("SELECT xt_status, xt_usuario, xd_fecha, xt_comentario, xt_ruta FROM SGI_Backlog_Traslado_Usuario WHERE xt_quejaSolicitud = '$solicitudID'");
		while($listaTUF = $datosTUF->fetchRow()){	
			$statusTUF = $listaTUF[0];
			$usuarioTUF = $listaTUF[1];
			$fechaTUF = $listaTUF[2];
			$comentarioTUF = $listaTUF[3];
			$rutaTUF = $listaTUF[4];
		}
		
		if($statusTUF == ""){
			if($usuarioId == "Rodrigo_Romo"){
				echo "<table width='100%'>";
					echo "<tr height='60px'></tr>";
					
					echo "<tr>";
						echo "<td align='left' id='titulo2'>Traslado al usuario final</td>";
						echo "<td width='15px'>";
							/*
							echo "<a href='http://71.144.19.155/INTRANET_GEA/Backlog/backlogTUFPopUp.php?codigo=$solicitudID&usuario=$usuarioId' target='popup' onclick=\"window.open(this.href,this.target,'width=400,height=500,scrollbars=yes')\"><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'></a>";
							*/
						echo "</td>";	
					echo "</tr>";
					
					echo "<tr>";
						echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
				
				echo "<div id='transladoUsuario'>";
					echo "<table align='center' width='20%'>";
						echo "<tr height='20px'></tr>";
						?>
						<tr height="25px" align="center">
							<td id="transladoUsuarioProcede" style="width: 35%" align="center" bgcolor="#42CB27"  onclick="ilumina('transladoUsuarioProcede', 'TransladoUsuario')"><font color="white">Procede</font></td>
						</tr>
					
						<tr height="10px"></tr>
					
						<tr height="25px" align="center">
							<td id="transladoUsuarioNoProcede" style="width: 35%" align="center"  bgcolor="red" onClick="ilumina('transladoUsuarioNoProcede', 'TransladoUsuario')"><font color="white">No procede</font></td>
						</tr>
						<?php 
					echo "</table>";
					
					echo "<div id='transladoUsuarioComentario'>";
						echo "<table  border='0' align='center' width='80%'>";
							echo "<tr>";
								echo "<td style='color:#007CBD;'>Comentarios</td>";
							echo "</tr>";
				
							echo "<tr>";
								echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
								echo "</td>";
							echo "</tr>";
							
							echo "<tr align='center'>";
								echo "<td><textarea id='transladoUsuarioComentarioVerif' rows='4' cols='70'>$comentarioTUF</textarea></td>";
							echo "</tr>";
				
							echo "<tr>";
								echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
								echo "</td>";
							echo "</tr>";
							
							echo "<tr height='25px'></tr>";
						echo "</table>";
					echo "</div>";
				echo "</div>";
			}
		}else if($statusTUF == "ACEPTADA"){
			echo "<table width='100%'>";
				echo "<tr height='60px'></tr>";
				
				echo "<tr>";
					echo "<td align='left' id='titulo2'>Traslado al usuario final</td>";
					echo "<td width='15px'>";
						/*
						echo "<a href='http://71.144.19.155/INTRANET_GEA/Backlog/backlogTUFPopUp.php?codigo=$solicitudID&usuario=$usuarioId' target='popup' onclick=\"window.open(this.href,this.target,'width=400,height=500,scrollbars=yes')\"><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'></a>";
						*/
					echo "</td>";	
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
			
			echo "<div id='transladoUsuario'>";
				?>
				<table align='center' width='20%'>
					<tr height='20px'></tr>
					<tr id='trValidacion' style="display:block">
						<td id="transladoUsuarioProcede" style="width: 20%" align="center" bgcolor="#42CB27"><font 	
						color="white">Procede</font></td> 
					</tr>
				</table>
				
				<div id='contCambioV' style="display:none">
					<table border='0' align='center' width='30%'>	
						 <tr>
							 <td id="transladoUsuarioProcede" style="width: 35%" align="center" bgcolor="#42CB27" onClick="ilumina('transladoUsuarioProcede', 'TransladoUsuario')"><font color="black">Procede</font></td>	
						 </tr>
					
						 <tr height="10px"></tr>
							 
						 <tr>
							<td id="transladoUsuarioNoProcede" style="width: 35%" align="center"  bgcolor="red" onClick="ilumina('transladoUsuarioNoProcede', 'TransladoUsuario')"><font color="white">No procede</font></td>
						 </tr>
					 </table>
				</div>
				
				<?php
				 
				echo "<table  border='0' align='center' width='50%'>";
					echo "<tr height='10px'><td></td></tr>";
				
					echo "<tr>";
						echo "<td align='center'>$usuarioTUF aprobó la solicitud</td>";
					echo "</tr>";
				
					echo "<tr align='center'>";
						echo "<td>$fechaTUF</td>";
					echo "</tr>";
					
					echo "<tr height='15px'></tr>";
					
				echo "</table>";
				
				//comentarios 
				if($comentarioVF != ''){
					echo "<table  border='0' align='center' width='80%'>";
						echo "<tr>";
							echo "<td style='color:#007CBD;'>Comentarios</td>";
						echo "</tr>";
			
						echo "<tr>";
							echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr>";
							echo "<td colspan='2' style='padding:0px 0px 0px 15px'>$comentarioTUF</td>";
						echo "</tr>";
			
						echo "<tr>";
							echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
							echo "</td>";
						echo "</tr>";
						
						echo "<tr height='25px'></tr>";
					echo "</table>";
				}
				
				//Evidencia
				echo "<table  border='0' align='center' width='80%'>";
					echo "<tr height='25px'></tr>";
					
					echo "<tr>";
						echo "<td style='color:#007CBD;'>Evidencia</td>";
						?>
						<td width='15px'><a href='javascript:void(0);' onclick='activaFile("trEvidencia");'><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a></td>
						<?php
					echo "</tr>";
					
					echo "<tr>";
						echo "<td colspan='2' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
						echo "</td>";
					echo "</tr>";
					
					echo"<tr height='10'></tr>";
					
				echo "</table>";
					
				//consulto archivo correspondiente al tipo de documento
				$doc = $INTRANET->Execute("SELECT  xt_nombreArchivo, xt_usuario, xd_fecha, xt_ruta FROM SGI_Backlog_Documentos WHERE xt_tipoDocumento = 'Traslado a usuario' AND xt_quejaSolicitud = '$solicitudID'");
			
				$numDoc = 0;
				while ($listA = $doc -> fetchRow()){
					if(!empty($listA[0])){
						echo "<table  border='0' align='center' width='80%'>";
							echo "<tr>";
								echo "<td width='30px'></td>";
								echo "<td style='padding:0px 0px 0px 15px;'><font size=2>$listA[0]</font></td>";
								//echo "<td><a href='eliminaDoctosCU.php?codigo=$solicitudID&elimina=$listA[3]&tipoDoc=$row[0]&usuario=$usuarioId'><img src='Imagenes/ICN_NoOK.png' height='13' width='13'/></a></td>";
								echo "<td><a href='http://71.144.19.155/INTRANET_GEA/Backlog/extraccionDoctosReporte.php?nombreA=$listA[0]&ruta=$listA[3]'><img src='../../Imagenes/ICN_Archivo.png' height='15' width='12' /></a></td>";
							echo "</tr>";
			
							echo "<tr>";
								echo "<td width='30px'></td>";
								echo "<td style='color:#636262; padding:0px 0px 0px 30px'><i><font size=2>$listA[1], $listA[2]</font></i></td>";
							echo "</tr>";
							
							echo "<tr height='10'></tr>";
						echo "</table>";
					}//fin del if de verificaion de que exite archivo
					$numDoc ++;
				}//fin del while de archivos
			
				//fila del formulario para subir archivo
				echo "<table border='0' style='width: 100%' cellspacing='0'>";
					echo "<tr id='trEvidencia' style=' display:none'>";
						echo "<td width='250px'></td>";
						echo "<td>";
							echo "<div id='divFile'>";
								echo "<iframe src='http://71.144.19.155/Sistemas/uploadArchivosLaredo.php?codigoSolicitud=$solicitudID&tipoArchivo=Traslado a usuario&usuario=$usuarioId&nombrephp=$nombrephp' frameborder='0'></iframe><br>";
							echo "</div>";
						echo"</td>";
					echo "</tr>";
				echo "</table>";
			echo "</div>";
		}
		
		
		
		/*
		//sección donde agrega los datos de validacion
		echo "<table border='0' width='100%'>";
			echo "<tr height='10px'></tr>";
			
			echo "<tr>";
				echo "<td style='color:#007CBD;' width='60px'></td>";
				echo "<td style='color:#007CBD;' width='30%'>Status</td>";
				echo "<td style='color:#007CBD;' width='35%'>User</td>";
				echo "<td style='color:#007CBD;' width='30%'>Fecha</td>";
				echo "<td style='color:#007CBD;' width='15px'></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td style='color:#007CBD;' width='30px'></td>";
				echo "<td colspan='4' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td width='60px'></td>";
				if($statusTUF == 'ACEPTADA'){
					echo "<td width='30%'>ACEPTADO</td>";
				}
				if($statusTUF == 'RECHAZADA'){
					echo "<td width='30%'>RECHAZADO</td>";
				}
				echo "<td width='35%'>$usuarioTUF</td>";
				echo "<td width='30%'>$fechaTUF</td>";
				echo "<td width='15px'></td>";
			echo "</tr>";
			
			echo "<tr height='10px'></tr>";
			
			echo "<tr>";
				echo "<td width='60px'></td>";
				echo "<td colspan='4' style='color:#007CBD;'>Comentarios</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td style='color:#007CBD;' width='30px'></td>";
				echo "<td colspan='4' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td style='color:#007CBD;' width='30px'></td>";
				echo "<td colspan='3'>$comentarioTUF</td>";
				if($rutaTUF != ''){
					echo "<td>";
						echo "<a href='http://71.144.19.155/INTRANET_GEA/Backlog/extraccionDoctos.php?codigo=$solicitudID&ruta=$rutaTUF'><img src='../../Imagenes/ICN_Archivo.png' height='15' width='12' /></a></td>";
					
				}
				//echo "<td><img src='../../Imagenes/ICN_Archivo.png' height='15' width='12'></td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td style='color:#007CBD;' width='30px'></td>";
				echo "<td colspan='4'style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		*/
	}
	
	//cierre de la interfaz
	echo "<table width='100%' align='center'>";
		echo "<tr height='55px'></tr>";
		echo "<tr>";
			echo "<td colspan='4' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
	
		echo "<tr align='center'>";
			echo "<td align='center'>";
				echo "<td style='color:#636262;'>Created by: Grupo Escalante Agencias Aduanales, 2015.</td>";
				echo "";
			echo "<td>";
		echo "</tr>";
	
		echo "<tr height='45px'></tr>";
	
	echo "</table>";
echo "</div>";
	
?>
</body>
</html>

