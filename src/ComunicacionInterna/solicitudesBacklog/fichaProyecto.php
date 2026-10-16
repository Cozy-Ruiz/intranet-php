<?php error_reporting(0); ?>
<?php

header('Content-Type: text/html; charset=UTF-8');

$nombrephp='fichaMantenimiento_Sistema.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
$solicitudID = $_GET['codigo'];


//declaro variables global
$tipoSolicitud = "";

?>
<!doctype html>
<html>
<head>
<title>Ficha de Mantenimiento de Sistemas</title>
<!-- SECCION DE JAVASCRIPT LIBRERIAS-->
<script type="text/javascript" src="../../JS/jquery-1.9.1.js"></script>

<link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
<link type="text/css" href="../../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
<script type="text/javascript" src="../../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="../../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
    
<script>
	$('#prioridadAsignada').change(function(){
 		var ciudad = $(this).val()
 		alert('Has seleccionado ' + ciudad);
 	});
</script>

<!-- SCRIPT PARA CAMBIAR EL COLOR DE LAS CELDAS -->
<script language="javascript" type="text/javascript">
	function ilumina(celda, color){
		celda1 = document.getElementById(celda);
 		//var celda1 = document.getElementById(celda).innerHTML;
  		var codigo ="<?php echo $solicitudID;?>";
		var usuario = "<?php echo $usuarioId;?>";
		var comentarioMS = document.getElementById('comentarioVerifMS1').value;
	
  		//alert (color+celda+comentarioMS);
    	if(color == 'white' && celda == 'tdProcede'){
			celda1.style.backgroundColor  = '#42CB27';
        	document.getElementById('tdNoProcede').style.backgroundColor  = 'red';

			document.getElementById("comentarioMS").style.display="none";
			document.getElementById("validacionMS").style.display="none";
	   		document.getElementById("cargaARV").style.display="block";
		
      	 	$('#validacionMS').load("procedeMS.php", {status: 'ACEPTADA', codigo: codigo, usuario: usuario, comentario:	
			 comentarioMS}, function(data){

       		})
       
		}

    	if(color == 'white' && celda == 'tdNoProcede'){
        	celda1.style.backgroundColor  = 'red';
           	document.getElementById('tdProcede').style.backgroundColor  = 'red';

			document.getElementById("comentarioMS").style.display="none";
			document.getElementById("validacionMS").style.display="none";
	   		document.getElementById("cargaARV").style.display="block";
			
      		$('#validacionMS').load("procedeMS.php", {status: 'RECHAZADA', codigo: codigo, usuario: usuario, comentario:	
			comentarioMS}, function(data){
			
          })
		  
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
	
    if(color == 'white' && celda == 'tdProcede'){
	
		celda1.style.backgroundColor  = '#42CB27';
        document.getElementById('tdNoProcede').style.backgroundColor  = 'red';
		
		document.getElementById("comentarioMS").style.display="none";
		document.getElementById("validacionMS").style.display="none";
	   	document.getElementById("cargaARV").style.display="block";
			
       $('#validacionMS').load("procedeMS.php", {status: 'ACEPTADA', codigo: codigo, usuario: usuario, comentario:comentarioMS}	
	   , function(data){

       })
       
	}

    if(color == 'white' && celda == 'tdNoProcede'){
    	celda1.style.backgroundColor  = 'red';
        document.getElementById('tdProcede').style.backgroundColor  = 'red';

		document.getElementById("comentarioMS").style.display="none";
		document.getElementById("validacionMS").style.display="none";
	   	document.getElementById("cargaARV").style.display="block";
			
       $('#validacionMS').load("procedeMS.php", {status: 'RECHAZADA', codigo: codigo, usuario: usuario, comentario:comentarioMS}, function(data){
			
          })
		  
       }

    }
</script>

<!-- SCRIPT PARA GUARDAR AL COMENTARIO DE VALIDACION -->
<script language="javascript" type="text/javascript">
 
	function comentarioMS(comentarioN){
	 
		var codigo ="<?php echo $solicitudID;?>";
		var usuario = "<?php echo $usuarioId;?>";
	 
		var comentarioMS = document.getElementById(comentarioN).value;
		var verAcepta = document.getElementById("trProcede");
   	 	var verRechaza = document.getElementById("trNoProcede");
		//alert(comentarioMS);
	
		if(verAcepta.style.display == "block"){
			var valor = "ACEPTADA";
		}
	
		if(verRechaza.style.display == "block"){
			var valor = "RECHAZADA";
		}
		
		$('#comentarioMS').load("comentarioMS.php", {codigo: codigo, comentario : comentarioMS, usuario : usuario, valor : valor}, function(data){

        })
	
 	}
</script>


<!-- SCRIPT PARA GUARDAR EL PDR -->
<script language="javascript" type="text/javascript">
	function asignaPDR(sistema, titulo, descripcion, ciudad, tipoS){
	  
		var codigo ="<?php echo $solicitudID;?>";
		var pdr=$("#pdrAsignado").val();
	
		var sistemaPdr = sistema;
		var tituloMT = titulo;
		var descripcionMT = descripcion;
		var ciudadMT = ciudad;
		var tipoSMT = tipoS;
	
		document.getElementById("contPDR").style.display="none";
	   	document.getElementById("cargaPDR").style.display="block";
	   
		if(pdr != ''){
		
			$('#contPDR').load("asignarPDR.php", {codigo:codigo, pdr:pdr, sistema:sistemaPdr, titulo:tituloMT, descripcion:descripcionMT, ciudad:ciudadMT, tipoS:tipoSMT}, function(data){

       	 })
		
		}
	 
 	}
 
</script>
 
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
 
 <!-- SCRIPT PARA MOSTRAR EL DIV DE CAMBIO DE VALIDACION -->
<script language="javascript" type="text/javascript">
	function muestraCambioV2(){

		var validacion2 = document.getElementById("trValidacion2");
   		var cambiaV2 = document.getElementById("contCambioV2");
	
		if(validacion2.style.display == "block"){
		
			validacion2.style.display = "none";
			cambiaV2.style.display = "block";
		
		}
		if(cambiaV2.style.display == "block"){
		
			validacion2.style.display = "none";
			cambiaV2.style.display = "block";
		
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
 
 <!-- SCRIPT PARA MOSTRAR EL DIV DE CAMBIO DE PDR -->
<script language="javascript" type="text/javascript">
	function activaCPDR(){
 
 		var div1P = document.getElementById("divPDR");
		var div2P = document.getElementById("contPDR");
 
 		if(div1P.style.display == "block"){
		
			div1P.style.display = "none";
			div2P.style.display = "block";
		
		}
 
	 }
 
</script>



<script type="text/javascript">
	function PopUp(){
		window.open("http://71.144.19.155/INTRANET_GEA/Backlog/cierreMantenimiento_Sistema.php?codigo=<?php echo $solicitudID; ?>&usuario=<?php echo $usuarioId; ?>","_blank", "toolbar=yes, scrollbars=no, resizable=yes, top=500, left=500,width=800, height=800");
 	}
</script>   

    
<?php
	if($estiloUsuario == 1){
    	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
	}else if($estiloUsuario == 2){
        echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
	}
?>

<script type="text/javascript">;
	$(function(){
		$(".DatP").datepicker({ dateFormat: 'yy-mm-dd',
			 monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] ,
			 dayNamesMin:  ['Dom','Lun','Mar','Mie','Jue','Vie','Sab']
				
		});
	});
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

 </script>
 
<script type="text/javascript">
	function activaStakeHolder(valida){

		var stakeholder1 = document.getElementById(valida+1+"");
		var stakeholder2 = document.getElementById(valida);

		if(stakeholder1.style.display == 'block'){
			stakeholder1.style.display = "none";
			stakeholder2.style.display = "block";
		}
	}

    function guardaStakeHolder(previo, codigo){
		document.getElementById("cargastakeHolder").style.display="block"; 
		var codE = codigo;         
		//alert(codE);
		var usuario = "<?php echo $usuarioId;?>";
		var solicitud = "<?php echo $solicitudID; ?>";
		if(previo != 'nuevo'){
		    var catalogo=document.getElementsByName(previo)[0].value;
		    var input = previo;
		}else{
		    var catalogo=document.getElementsByName("catalogo")[0].value;
		    var input = "";
		}

		$('#loadstakeholder').load("asignarStakeholder.php",{codE:codE, catalogo : catalogo, usuario:usuario, input: input, solicitud: solicitud},function(data){
			document.getElementById("cargastakeHolder").style.display="none";         
		});
	}

	function agregastakeholder(){

		var vCambio=document.getElementById("nuevostakeholder");
			if(vCambio.style.display == 'block') {
				 vCambio.style.display = 'none';
			} else {
				 vCambio.style.display = 'block';
			}
		//$('#nuevostakeholder').show();

	}

</script>
 
  

<body>

<?PHP
$breadcrumb="<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Home.php' id='breadcrumbs'>Home / </a><a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/comunicacionInterna.php' id='breadcrumbs'>Comunicación Interna / </a>
			<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/tableroSolicitudesyQuejasv2.php' id='breadcrumbs'> Solicitudes </a>";

echo "<div id='wrapper'>";
 // echo "<form name='fichaMantenimiento_Sistema' method='post' action='fichaMantenimiento_Sistema.php'>";	
	
	echo "<table border='0' align='center' width='1160px' style='margin-top:-110px;'>";
		echo "<tr>";
			echo "<td id='breadcrumbs' width='1160px' align='left'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		echo "<tr height='80px'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center'>";
		echo"<tr height='80px'> </tr>";
		
		echo "<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>Solicitud de mantenimiento de sistemas</font>";
			echo"</td>";
			
		echo "</tr>";
		
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

	echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
  		echo "<tr>";
	 		 echo "<td align='center'>";
		  
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
			  
			  $subirDir = $subirDir."../../";
			  
		  } unset($o);
		  
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
		
echo "<table border='0' align='center'>";
	echo"<tr height='100'><td></td></tr>";
echo "</table>"; 
	

$s = $INTRANET->Execute("SELECT xt_quejaSolicitud, xt_titulo, xt_grupo, xt_ciudad, xd_fecha, xt_descripcion, xt_ruta, kf_usuarioId, xt_status, xt_tipoSolicitud FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$solicitudID'");
  while($r = $s->fetchRow()){
	$titulo = $r[1];
	$solicitudID = $r[0];
	$descripcion = $r[5];
	$solicitante = $r[7];
	$estatus = $r[8];
	$rutaDocumento = $r[6];
	$fechaSolicitud = $r[4];
	//$pdr = $r[9];
	$ciudad = $r[3];
	$tipoSolicitud = $r[9];
}

//echo"SELECT xt_prioridad, xt_justificacion, xd_fecha FROM SGI_Backlog_Prioridad WHERE xt_quejaSolicitud = '$solicitudID'";
$ss = $INTRANET->Execute("SELECT xt_prioridad, xt_justificacion, xd_fecha FROM SGI_Backlog_Prioridad WHERE xt_quejaSolicitud = '$solicitudID' ORDER BY xd_fecha ASC");
 
while($rr = $ss->fetchRow()){
    $prioridad = $rr[0];
    $justificacion = $rr[1];
    $fechaPrioridad = $rr[2];

}

$perfil = array();
//OBTENER LOS PERFILES DEL USUARIO CON LA SESION INICIADA
$indexPerfil = 0;
$r = $INTRANET->Execute("SELECT xt_perfil FROM SGI_Backlog_Perfiles WHERE xt_nombreUsuario = '$usuarioId'");

while($s = $r->fetchRow()){
	$perfil[$indexPerfil] = $s[0];
	$indexPerfil++;
}


$sistema = $INTRANET->getOne("SELECT xt_sistema FROM SGI_Backlog_Ubicacion WHERE xt_quejaSolicitud = '$solicitudID'");


$e = $INTRANET->execute("SELECT xt_status, xt_usuario FROM SGI_Backlog_Validaciones where xt_quejaSolicitud ='$solicitudID' and xt_tipoValidacion = 'MANTENIMIENTO'");
while($f = $e->fetchRow()){
	$statusValidacion = $f[0];
	$usuarioValidacion = $f[1];
}

//CUERPO SOLICITUD
echo "<table border='0' align='center' width='700'>";
	echo"<tr>";
		echo"<td align='left' id='titulo2' width='550'><b>$solicitudID</b></td>";
		echo"<td align='right' id='iconosTexto2' width='150'>";
			echo "<b>Status: ".ucwords(strtolower($estatus))."</b>";
		echo"</td>";
	echo"</tr>";
		
	echo "<tr>";
		echo "<td id='titleBlueLineBottom' colspan='2'></td>";
	echo "</tr>";
		
	echo"<tr height='20'> </tr>";
echo "</table>";
	
echo "<table border='0' align='center' width='700'>";
	echo "<tr>";
		echo "<td> </td>";
		echo "<td id='iconosTexto' colspan='2' align='left'><b>$titulo</b></td>";
	echo "</tr>";
		
	echo"<tr height='10'> </tr>";
		
	//Descripcion de la Solicitud
	echo "<tr>";
		echo "<td width='20'> </td>";
		echo "<td width='20'> </td>";
		echo "<td width='610' align='justify' id='fileItem'>$descripcion</td>";
			if($rutaDocumento != ''){
				//Archivo de la Solicitud
				echo"<td valign='top' id='iconosTexto' width='50' align='right'><a href='http://71.144.19.155/INTRANET_GEA/Backlog/extraccionDoctos.php?codigo=$solicitudID&ruta=$rutaDocumento'><img src='../../Imagenes/ICN_Archivo.png'></a> </td>";
			}else{
				echo "<td></td>";
			}
				
	echo "</tr>";
		
	echo"<tr height='30'> </tr>";
		
echo "</table>";
	
//Solicitante
echo "<table border='0' align='center' width='700'>";	
	echo "<tr>";
		echo "<td align='left' id='titulo2' colspan='2'><b>Solicitante</b></td>";
	echo"</tr>";
			
	echo "<tr>";
		echo "<td id='titleBlueLineBottom' colspan='2'></td>";
	echo "</tr>";
			
	echo"<tr height='30'> </tr>";
			
	echo "<tr>";
		echo "<td width='20px'></td>";
		echo "<td align='left' width='680px' id='iconosTexto'><b>$solicitante</b></td>";
	echo "</tr>";
			
	echo"<tr height='20'> </tr>";
			
echo "</table>";
		
//Sistema
echo "<table border='0' align='center' width='700'>";	
	echo "<tr>";
		echo "<td align='left' id='titulo2' colspan='2'><b>Sistema</b></td>";
	echo"</tr>";
		
	echo "<tr>";
		echo "<td id='titleBlueLineBottom' colspan='2'></td>";
	echo "</tr>";
		
	echo"<tr height='30'> </tr>";
		
	echo "<tr>";
		echo "<td width='20px'></td>";
		echo "<td align='left' width='680px' id='iconosTexto'><b>$sistema</b></td>";
	echo "</tr>";
		
	echo"<tr height='20'> </tr>";
		
echo "</table>";

//PDR
echo "<table border='0' align='center' width='700'>";	
	echo "<tr>";
		echo "<td align='left' id='titulo2' colspan='2'><b>PDR</b></td>";
	echo"</tr>";
		
	echo "<tr>";
		echo "<td id='titleBlueLineBottom' colspan='2'></td>";
	echo "</tr>";
		
	echo"<tr height='30'> </tr>";
		
	echo "<tr>";
		echo "<td width='20px'></td>";
		$pdrAsignadoS = $INTRANET->getOne("SELECT xt_pdr FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$solicitudID'");
		echo "<td align='left' width='680px' id='iconosTexto'><b>$pdrAsignadoS</b></td>";
	echo "</tr>";
		
	echo"<tr height='20'> </tr>";
		
echo "</table>";
		
//PRIORIDAD
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
				echo "<td id='iconosTexto' width='40px' style='padding:0px 0px 0px 30px'><b>$prioridad</b></td>";
		
			echo "</tr>";
	
			echo"<tr height='10'> </tr>";
	
			echo "<tr>";
				echo "<td colspan='2' style='padding:0px 0px 0px 45px' id='fileItem'>$justificacion</td>";
			echo "</tr>";
	
			echo "<tr>";
				echo"<td align='right' height='20px' valign='bottom' style='padding:0px 0px 0px 15px' colspan='2'>";
					?>
						<div id="btn1" ><a style="cursor:pointer" id="insertaP"  onClick="activaCP()"><font color='#007CBD'>Modificar</font></a></div>
					<?php
			
				echo "</td>";
			echo "</tr>";
	
			echo"<tr height='30'> </tr>";
				
		echo "</table>";
	echo "</div>";
		
	echo "<div id='contCambiaP' style='display:none'>";
		echo "<table border='0' align='center' width='700'>";
			echo "<tr id='contPrioridad'>";
				$arrPrioridades = array('Normal', 'Urgente', 'Emergencia');
				echo "<td style='padding:0px 15px 0px 30px'>";
					echo "<select name='prioridadAsignada' id='prioridadAsignada'>";
					 //echo "<option value=''>Elegir......</option>";
				
						// $r = $INTRANET->Execute("SELECT xt_administrador FROM SGI_Backlog_Administradores_de_Sistemas WHERE xt_sistema= '$sistema'");
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
		
			//funcion para determinar si muestra seccion de justificacion (no mover)
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
					echo "<td height='10px;'>";				
					echo"</td>";
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
	
	//Seccion de Validación
	if($perfil[0] == 'Jefe de Desarrollo' || $perfil[0] == 'Asignador PDR'){
		echo "<table border='0' align='center' width='700'>";	
			echo "<tr height='10px'></tr>";
			echo "<tr>";
				echo "<td align='left' id='titulo2'><b>Aprobación</b></td>";
			echo "</tr>";
		
			echo "<tr>";
				echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	
		echo "<div id='validacionMS' style='display:block'>";
			echo "<table border='0' align='center' width='30%'>";
				echo "<tr height='10px'></tr>";
	
				//verifico validacion 
				$j = $INTRANET->Execute("SELECT xt_status, xd_fecha, xt_usuario, xt_comentario FROM SGI_Backlog_Validaciones where xt_quejaSolicitud ='$solicitudID' and xt_tipoValidacion = 'MANTENIMIENTO'");
	 
	 			while($s = $j->fetchRow()){
		 
		 			$statusValidacionMS = $s[0];
		 			$fecha = $s[1];
		 			$usuarioMS = $s[2];
		 			$comentarioMS = $s[3];
		 
	 			}
	
	 			if($statusValidacionMS == ''){

					?>
					<tr>
     	 				<td id="tdProcede" style="width: 35%; cursor:pointer;" align="center" bgcolor="#42CB27"  onclick="ilumina('tdProcede', 'white')"><font color="white">Procede</font></td>
    				</tr>
    	
        			<tr height="10px"></tr>
        
	 				<tr>
      					<td id="tdNoProcede" style="width: 35%; cursor:pointer;" align="center"  bgcolor="red" onClick="ilumina('tdNoProcede', 'white')"><font color="white">No procede</font></td>
   					</tr> 
				</table>

			<?php
		echo "</div>";
		
		echo "<div id='cargaARV' style='display:none' align='center'>";
    		echo "<img src='../../Imagenes/img_load.gif' height='30' width='30'/>";
  		echo "</div>";

		echo "<div id='comentarioMS' style='display:block'>";
			echo "<table width='80%' align='center'>";
				echo "<tr height='15px'></tr>";
				
				echo "<tr align='center'>";
					echo "<td>Comentarios:</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr align='center'>";
					echo "<td> <textarea id='comentarioVerifMS1' rows='4' cols='70'>$comentarioMS</textarea> </td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='50px'></tr>";
				
			echo "</table>";
			
		echo "</div>";
	
		}// fin del if donde no se tiene asignado status
	
		if($statusValidacionMS == 'ACEPTADA'){
			
		 	?>
         
         	<tr id='trValidacion' align="center"  style="display:block">
     	 		<td id="tdProcede" style="width: 25%"  align="center" bgcolor="#42CB27"><font 	
         		color="white">Procede</font></td>
   			</tr>
	
         </table>
         
         <div id='contCambioV' style="display:none">
         	<table border='0' align='center' width='30%'>	
         
				<tr>
     	 			<td id="tdProcede" style="width: 35%; cursor:pointer;" align="center" bgcolor="#42CB27"  onclick="ilumina2('tdProcede', 	
                    'white')"><font color="white">Procede</font></td>
    			</tr>
    	
        		<tr height="10px"></tr>
        
	 			<tr>
      				<td id="tdNoProcede" style="width: 35%; cursor:pointer;" align="center"  bgcolor="red" onClick="ilumina2('tdNoProcede', 	
                    'white')"><font color="black">No procede</font></td>
   				</tr> 
   
    		</table>
	
		</div>

		<?php
		 
		echo "<table  border='0' align='center' width='50%'>";
			echo "<tr height='10px'><td></td></tr>";
				
			echo "<tr>";
				echo "<td align='center'>$usuarioMS aprobó la solicitud</td>";
			echo "</tr>";
		
			echo "<tr align='center'>";
				echo "<td>$fecha</td>";
			echo "</tr>";
			
			echo "<tr height='10px'></tr>";
		echo "</table>";
		
		//comentarios 
			
		if($comentarioMS != ''){
			
			echo "<table  border='0' align='center' width='70%'>";
				echo "<tr>";
					
					echo "<td style='color:#007CBD;'>Comentarios</td>";
				echo "</tr>";
	
				echo "<tr>";
					
		
					echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
	
				echo "<tr>";
					
					echo "<td colspan='2' style='padding:0px 0px 0px 15px'>$comentarioMS</td>";
				echo "</tr>";
	
				echo "<tr>";
					
					echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='55px'></tr>";
			echo "</table>";
		}
		 
		/* 
		echo "<table  border='0' align='center' width='700px'>";
			?>
        	<tr>
				<td align="right" style="width: 20%">
            		<div id="btn1" ><a style="cursor:pointer"  id="insertaP"  onClick="muestraCambioV()"><font color='#007CBD'>
                    Modificar</font></a></div>
                    
            	</td>
            </tr>
            
            <tr height='30px'></tr>
            <?php
		echo "</table>";
		*/
	
		}
	
		if($statusValidacionMS == 'RECHAZADA'){
	
			?>
       	 	<tr id='trValidacion' align='center' style="display:block">
        		<td id="tdNoProcede"  style="width: 25%"  align="center"  bgcolor="red"><font color="white">No procede</font></td>
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
					echo "<td align='center'>$usuarioMS rechazó la solicitud</td>";
				echo "</tr>";
		
				echo "<tr align='center'>";
					echo "<td>$fecha</td>";
				echo "</tr>";
			
				echo "<tr height='10px'></tr>";
			echo "</table>";
		
			//comentarios 
			
			if($comentarioMS != ''){
				echo "<table  border='0' align='center' width='70%'>";
		
					echo "<tr>";
						
						echo "<td style='color:#007CBD;'>Comentarios</td>";
					echo "</tr>";
	
					echo "<tr>";
						
						echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
						echo "</td>";
					echo "</tr>";
	
					echo "<tr>";
						
						echo "<td colspan='2' style='padding:0px 0px 0px 15px'>$comentarioMS</td>";
					echo "</tr>";
	
					echo "<tr>";
						
						echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
						echo "</td>";
					echo "</tr>";
				
					echo "<tr height='55px'></tr>";
				echo "</table>";
			}
		
			echo "<table  border='0' align='center' width='700px'>";
				?>
        		<tr>
					<td align="right" style="width: 20%"><div id="btn1" ><a style="cursor:pointer"  id="insertaP"  onClick="muestraCambioV()"><font color='#007CBD'>Modificar</font></a></div>
                    
            		</td>
            	</tr>
            
            	<tr height='30px'></tr>
           	 <?php
			
			echo "</table>";

		}
	
	}else{
		echo "<table border='0' align='center' width='700'>";
			echo "<tr height='60px'></tr>";
			echo "<tr>";
				echo "<td align='left' id='titulo2'><b>Aprobación</b></td>";
			echo "</tr>";
		
			echo "<tr>";
				echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	
		echo "<div id='validacionMS'>";
		
			echo "<table align='center' width='20%'>";
				echo "<tr height='10px'></tr>";
	
				//verifico validacion 
	
	 			$j = $INTRANET->Execute("SELECT xt_status, xd_fecha, xt_usuario, xt_comentario FROM SGI_Backlog_Validaciones where xt_quejaSolicitud ='$solicitudID' and xt_tipoValidacion = 'MANTENIMIENTO'");
	 
				while($s = $j->fetchRow()){
		 
		 			$statusValidacionMS = $s[0];
		 			$fecha = $s[1];
		 			$usuarioMS = $s[2];
		 			$comentarioMS = $s[3];
		 
	 			}
	
	 			if($statusValidacionMS == ''){

					
				}
	
				if($statusValidacionMS == 'ACEPTADA'){
	
		 			?>
					<tr>
      					<td id="tdProcede" style="width: 35%" align="center" bgcolor="#42CB27"><font color="white">Procede</font></td>
    				</tr>

				</table>
				<?php
		 
				echo "<table  border='0' align='center' width='50%'>";
					echo "<tr height='10px'><td></td></tr>";
		
					echo "<tr>";
						echo "<td align='center'>$usuarioMS aprobó la solicitud</td>";
					echo "</tr>";
		
					echo "<tr align='center'>";
						echo "<td>$fecha</td>";
					echo "</tr>";
				echo "</table>";
					//comentarios 
			
					if($comentarioMS != ''){
						echo "<table  border='0' align='center' width='70%'>";
			 				echo "<tr height='15px'></tr>";
		
							echo "<tr align='left'>";
								echo "<td style='color:#007CBD;'>Comentarios:</td>";
							echo "</tr>";
		
							echo "<tr>";
								echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
								echo "</td>";
							echo "</tr>";
				
							echo "<tr>";
								echo "<td style='padding:0px 0px 0px 15px'>";
									echo $comentarioMS;
								echo "</td>";
							echo "</tr>";
				
							echo "<tr>";
								echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
								echo "</td>";
							echo "</tr>";
				
							echo "<tr height='35px'></tr>";
						echo "</table>";
					}
		
				
	
				}
	
				if($statusValidacionMS == 'RECHAZADA'){
	
					?>
					<tr>
      					<td id="tdNoProcede" style="width: 35%" align="center"  bgcolor="red" ><font color="white">No procede</font></td>
    				</tr>
				</table>
				<?php
		 
					echo "<table border='0' align='center' width='50%'>";
						echo "<tr height='10px'></tr>";
		
						echo "<tr>";
							echo "<td align='center'>$usuarioMS rechazó la solicitud</td>";
						echo "</tr>";
		
						echo "<tr align='center'>";
							echo "<td>$fecha</td>";
						echo "</tr>";
					echo "</table>";
						//comentarios 
			
						if($comentarioMS != ''){
							echo "<table  border='0' align='center' width='70%'>";
			 					echo "<tr height='15px'></tr>";
		
								echo "<tr align='left'>";
									echo "<td style='color:#007CBD;'>Comentarios:</td>";
								echo "</tr>";
		
								echo "<tr>";
									echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
									echo "</td>";
								echo "</tr>";
				
								echo "<tr>";
									echo "<td style='padding:0px 0px 0px 15px'>";
									echo $comentarioMS;
									echo "</td>";
								echo "</tr>";
				
								echo "<tr>";
									echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
									echo "</td>";
								echo "</tr>";
				
								echo "<tr height='35px'></tr>";
							
							echo "</table>";
						}
		
					
		 		}
		}

	if($statusValidacionMS == 'ACEPTADA'){
		
		//SECCION DE ENTREGABLES
	$numeroEntregables=0;
	$porcientoEntregablesCompletos = 100;
	$porcientoEntregablesActuales = 0;
	//if($statusVF == "ACEPTADA"){	
		//Seccion de entregables
		echo "<table border='0' align='center' width='700'>";
			echo "<tr height='25px'></tr>";
		
			echo "<tr>";
				//obtengo tipo de solicitud
				$tipoS = $INTRANET->getOne("SELECT xt_tipoSolicitud FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$solicitudID'");
				echo "<td align='left' id='titulo2'><b>Entregables</b></td>";
				$ciudadSolicitud = $INTRANET->getOne("SELECT xt_ciudad FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$solicitudID'");
				echo "<td width='15px'>";
					echo "<a href='backlogEntregablesPopUp.php?codigo=$solicitudID&tipoS=$tipoS&ciudad=$ciudadSolicitud&prioridad=$prioridad' target='popup' onclick=\"window.open(this.href,this.target,'width=470,height=400,scrollbars=yes')\"><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";
				echo "</td>";	
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='3' 		style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'></td>";
			echo "</tr>";
		echo "</table>";
		
		
		//consulta para obtener los entregables de una solicitud
		$entg = $INTRANET->Execute("SELECT xt_codigoEntregable, xt_tipo, xt_titulo, xt_descripcion, xn_progreso FROM BACKLOG.ENTREGABLES WHERE xt_solicitud='$solicitudID'");
		while($lisEntg = $entg->fetchRow()){
			$numeroEntregables++;
			$porcientoEntregablesActuales += $lisEntg[4];
			echo "<table border='0' align='center' width='700'>";
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
					echo "<table border='0' align='center' width='700'>";
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
							echo "<td>";
							echo "<a href='https://escalante.com.mx/Sistemas/BackLog/iniciaSesion.php'> $lisEntg[0]</a>";
							echo "</td>";
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
	//}
	}//fin del if de validacion donde fue aceptada la solicitud
	
	
	/*echo "<table align='center' border='0'>";
				echo "<tr>";
					echo "<td>";
						echo "<div id='cargastakeHolder' style='display:none; align=center;'>";
						echo "<img src='../../Imagenes/img_load.gif' />";
						echo "</div>";
					echo "</td>";
				echo "</tr>";
			echo "</table>";*/
	//Catalogacion (no se ha defino)
	/*echo "<table border='0' align='center' width='700'>";
		echo "<tr height='35px'></tr>";	
		echo "<tr>";
			echo "<td align='left' id='titulo2' colspan='2'><b>Catalogación</b></td>";
		echo"</tr>";
			
		echo "<tr>";
			echo "<td id='titleBlueLineBottom' colspan='2'></td>";
		echo "</tr>";
			
		echo"<tr height='30'> </tr>";
			
		echo "<tr>";
			echo "<td width='20px'></td>";	
			echo "<td align='left' width='680px' id='iconosTexto'>";
				echo "<select name='pdr' size='1' >";
					echo "<option value=''>Elegir</option>";
					
						$s= $INTRANET->Execute("SELECT EMPA.kf_personalID, EMP.xt_Nombre, EMP.xt_ApellidoPaterno FROM SGI_EmpleadosActividad EMPA, SGI_Empleados EMP WHERE EMP.kp_personalId = EMPA.kf_personalID AND EMPA.xt_actividad='PDR' ORDER BY EMP.xt_Nombre ");
						
						while($r= $s -> fetchRow()){
							echo"<option value='".$r[0]."'>".$r[1]." ".$r[2]."</option>";
						} unset($r); unset ($s);
					
				echo"</select>";
			echo"</td>";
		echo "</tr>";
			
		echo"<tr height='10'> </tr>";
			
		echo "<tr>";
			echo "<td width='20px'></td>";	
			echo "<td align='left' width='680px' id='iconosTexto'>";
				echo "<select name='pdr' size='1' >";
					echo "<option value=''>Elegir</option>";
					
					$s= $INTRANET->Execute("SELECT EMPA.kf_personalID, EMP.xt_Nombre, EMP.xt_ApellidoPaterno FROM SGI_EmpleadosActividad EMPA, SGI_Empleados EMP WHERE EMP.kp_personalId = EMPA.kf_personalID AND EMPA.xt_actividad='PDR' ORDER BY EMP.xt_Nombre ");
						
					while($r= $s -> fetchRow()){
						echo"<option value='".$r[0]."'>".$r[1]." ".$r[2]."</option>";
					} unset($r); unset ($s);
					
				echo"</select>";
			echo"</td>";
		echo "</tr>";
			
		echo"<tr height='10'> </tr>";
			
		echo "<tr>";
			echo "<td width='20px'></td>";	
			echo "<td align='left' width='680px' id='iconosTexto'>";
				echo "<select name='pdr' size='1' >";
					echo "<option value=''>Elegir</option>";
					
					$s= $INTRANET->Execute("SELECT EMPA.kf_personalID, EMP.xt_Nombre, EMP.xt_ApellidoPaterno FROM SGI_EmpleadosActividad EMPA, SGI_Empleados EMP WHERE EMP.kp_personalId = EMPA.kf_personalID AND EMPA.xt_actividad='PDR' ORDER BY EMP.xt_Nombre ");
						
					while($r= $s -> fetchRow()){
						
						echo"<option value='".$r[0]."'>".$r[1]." ".$r[2]."</option>";
						
					} unset($r); unset ($s);
					
				echo"</select>";
			echo"</td>";
		echo "</tr>";
			
		echo"<tr height='20'> </tr>";
			
		echo"<tr height='40'>";
			echo "<td width='30'> </td>";
		 	echo"<td valign='bottom' align='right' colspan='4'>";
				echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
		 	echo"</td>";
	 	echo"</tr>";
			
		echo"<tr height='25'> </tr>";
			
	echo "</table>";*/
	
		  
	echo "</div>";

		
	
	
	$maximoEtapaSolicitud = $INTRANET->getOne("SELECT xt_estatus FROM SGI_Quejas_Solicitudes_Estatusv2 WHERE xt_quejaSolicitud = '$solicitudID' order by xd_fechaCreacion DESC");
	
		
		if($maximoEtapaSolicitud != 'TERMINADA'){
			
			
			//Seguimiento
		echo "<table border='0' align='center' width='700'>";
		echo "<tr height='35px'></tr>";
			echo"<tr>";
				echo"<td align='left' id='titulo2' width='550'><b>Seguimiento</b></td>";
				echo"</td>";
			echo"</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			
			echo"<tr height='20'> </tr>";
		echo "</table>";
		
		$s = $INTRANET->Execute("SELECT xt_estatus, xd_fechaCreacion FROM SGI_Quejas_Solicitudes_Estatusv2 WHERE xt_quejaSolicitud = '$solicitudID' AND xt_estatus = 'SIN ASIGNAR' ORDER BY xn_numero ");	
								while($r = $s->fetchRow()){
									$estatusEtapa	= $r[0];
									$fechaEtapa	= date('Y-m-d H:i:s', strtotime($r[1]));
		
									echo "<table border='0' align='center' width='700'>";
										echo "<tr>";
											//echo "<td> </td>";
												echo "<td id='iconosTexto' colspan='2' align='left'>$fechaEtapa <b>$estatusEtapa</b></td>";
												echo "<td id='iconosTexto' width='50' align='right'></td>";	
								
										echo "</tr>";
										
										echo "<tr>";
												echo "<td colspan='2'><font color='#636262'> Sin asignar</font></td>";
										echo "</tr>";
										
										
										echo"<tr height='10'> </tr>";
									echo "</table>";
											
								}unset($r); unset($s); unset($i);
								
			$s = $INTRANET->Execute("SELECT xt_status, xd_fecha, xt_usuario FROM SGI_Backlog_Validaciones WHERE xt_quejaSolicitud = '$solicitudID' ");	
								while($r = $s->fetchRow()){
									$estatusEtapa	= $r[0];
									$fechaEtapa	    = date('Y-m-d H:i:s', strtotime($r[1]));
									$usuario        = $r[2];
						
									echo "<table border='0' align='center' width='700'>";
										echo "<tr>";
											//echo "<td> </td>";
												echo "<td id='iconosTexto' colspan='2' align='left'>$fechaEtapa <b>$estatusEtapa</b></td>";
												echo "<td id='iconosTexto' width='50' align='right'></td>";	
								
										echo "</tr>";
										
										
										if($estatusEtapa == 'ACEPTADA'){
											echo "<tr>";
												echo "<td colspan='2'><font color='#636262'> Aceptada por: $usuario</font></td>";
											echo "</tr>";
										}
											
										
										echo"<tr height='10'> </tr>";
							
									echo "</table>";
											
								}unset($r); unset($s); unset($i);
			$s = $INTRANET->Execute("SELECT xt_estatus, xd_fechaCreacion, kf_usuario, xt_contenido FROM SGI_Quejas_Solicitudes_Estatusv2 WHERE xt_quejaSolicitud = '$solicitudID' AND xt_estatus not in('SIN ASIGNAR','TERMINADA') ORDER BY xn_numero ");	
								while($r = $s->fetchRow()){
									$estatusEtapa	= $r[0];
									$fechaEtapa	= date('Y-m-d H:i:s', strtotime($r[1]));
									$usuario        = $r[2];
									$comentario     = $r[3];
						
									echo "<table border='0' align='center' width='700'>";
										echo "<tr>";
											//echo "<td> </td>";
												echo "<td id='iconosTexto' colspan='2' align='left'>$fechaEtapa <b>$estatusEtapa</b></td>";
												echo "<td id='iconosTexto' width='50' align='right'></td>";	
								
										echo "</tr>";
										
										if($estatusEtapa == 'ENTREGABLE PARA REVISION'){
											echo "<tr>";
												echo "<td colspan='2'><font color='#636262'> Revisado por: $usuario <br> Comentario: $comentario</font></td>";
											echo "</tr>";
										}
										
										if($estatusEtapa == 'ENTREGABLE RECHAZADO'){
											echo "<tr>";
												echo "<td colspan='2'><font color='#636262'> Rechazada por: $usuario <br> Comentario: $comentario</font></td>";
											echo "</tr>";
										}
										
									echo "<tr height='15px'></tr>";
										
									echo "</table>";
						
									
								}unset($r); unset($s); unset($i);
											
								
			//hago consulta de los estados que tiene asignado
			
			$banderaTerminado = 0;
			$s = $INTRANET->Execute("SELECT xt_codigoEntregable FROM BACKLOG.ENTREGABLES WHERE xt_solicitud = '$solicitudID'");
			while($x = $s ->fetchRow()){
				
				 $entregable = $x[0];
				
				 $terminado  = $INTRANET->getOne("SELECT xt_etapa FROM  BACKLOG.ETAPAS WHERE xt_codigoEntregable = '$entregable' AND xt_etapa = 'TERMINADA' ");
				
				if($terminado == ''){
					$banderaTerminado = 1;
				}
					
			}
			
			$maximoEstatus = $INTRANET->getOne("SELECT xt_status FROM SGI_Backlog_Validaciones WHERE xt_quejaSolicitud = '$solicitudID' AND xt_tipoValidacion = 'MANTENIMIENTO' AND xt_status = 'ACEPTADA' ");
			
			$maximoSolEstatus = $INTRANET->getOne("SELECT xt_estatus FROM SGI_Quejas_Solicitudes_Estatusv2 WHERE xt_quejaSolicitud = '$solicitudID' ORDER BY xd_fechaCreacion DESC");
			
			$p = $INTRANET->Execute("Select xt_perfil from SGI_Backlog_Perfiles WHERE xt_nombreUsuario = '$usuarioId'");
					
					while($perfilPDR = $p -> FetchRow()){
						
						 $perfilActiva = $perfilPDR[0];
					}//fin del while
						
					if($banderaTerminado == 0){	
						
						if($maximoEstatus != '' && ($maximoSolEstatus == "ENTREGABLE RECHAZADO" || $maximoSolEstatus == "ENTREGABLE PARA REVISION" || $maximoSolEstatus == "ACEPTADA")){
							
							if($perfilActiva == 'Jefe de Desarrollo' || $perfilActiva == 'Asignador PDR'){
								
								
									$hoy = date("Y-m-d");
									echo "<form name='agregarSeguimiento2' method='POST' action='evaluaSolicitud.php?codigoS=$solicitudID&usuario=$usuarioId&fecha=$hoy'  enctype='multipart/form-data'>";
									
										echo "<table border='0' align='center' width='700'>";
											echo "<tr height='20px'></tr>";
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
												echo "<td width='30'><input type='hidden' name='datoOculto' value='revision'> </td>";
												echo "<td width='20'> </td>";
												echo "<td id='iconosTexto2' align='left'>Fecha</td>";
												
												echo "<td width='20'> </td>";
											echo "</tr>";
											
											echo"<tr height='15'>";
												echo "<td width='30'> </td>";
												echo "<td width='20'> </td>";
												echo "<td  align='left'>";
												//echo "<input type='text' class='DatP' size=10 maxlength=10 name='fechaEvaluacion'>";
												echo date("Y-m-d");
											echo"</td>";
											
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
												
											echo "</tr>";
											
											echo "<tr>";
												echo "<td width='30'> </td>";
												echo "<td width='20'> </td>";
												echo "<td colspan='3'>";
													//echo "<input type='file' name='archivoEvaluacion'>";
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
								echo "</table>";
					
								$hoy = date("Y-m-d");
									echo "<form name='agregarSeguimiento3' method='POST' action='evaluaSolicitud.php?codigoS=$solicitudID&usuario=$usuarioId&fecha=$hoy'  enctype='multipart/form-data'>";
								
										echo "<table border='0' align='center' width='700'>";
											echo "<tr height='20px'></tr>";
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
												//mando dato oculto para identificar si estan evaluando (usuario)
												echo "<td width='30'><input type='hidden' name='datoOculto' value='tipEvaluacion'></td>";
												echo "<td width='20'> </td>";
												echo "<td id='iconosTexto2' align='left'>Fecha</td>";
												echo "<td id='iconosTexto2' align='left'>Evaluación</td>";
												echo "<td width='20'> </td>";
											echo "</tr>";
											
											echo"<tr align='left'>";
												echo "<td width='30'> </td>";
												echo "<td width='20'> </td>";
												echo "<td  align='left'>";
													//echo "<input type='text' class='DatP' size=10 maxlength=10 name='fechaEvaluacion'>";
													echo date("Y-m-d");
												echo"</td>";
												echo "<td align='left'>";
													echo "<select name='evaluacion'>";
														echo "<option value=''>Elegir...</option>";
														echo "<option value='TERMINADA'>Terminada</option>";
														echo "<option value='RECHAZADA'>Rechazada</option>";
														
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
												
											echo "</tr>";
											
											echo "<tr>";
												echo "<td width='30'> </td>";
												echo "<td width='20'> </td>";
												echo "<td colspan='3'>";
													//echo "<input type='file' name='archivoEvaluacion'>";
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
							}
						}//fin del if de verificacion donde entregable esta terminado y sin definicion de estatus
		
								//opcion para el usuario 
							
								if($maximoSolEstatus == "ENTREGABLE PARA REVISION" && $usuarioId == $solicitante){
									
									$hoy = date("Y-m-d");
									echo "<form name='agregarSeguimiento3' method='POST' action='evaluaSolicitud.php?codigoS=$solicitudID&usuario=$usuarioId&fecha=$hoy'  enctype='multipart/form-data'>";
								
										echo "<table border='0' align='center' width='700'>";
											echo "<tr height='20px'></tr>";
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
												//mando dato oculto para identificar si estan evaluando (usuario)
												echo "<td width='30'><input type='hidden' name='datoOculto' value='tipEvaluacion'></td>";
												echo "<td width='20'> </td>";
												echo "<td id='iconosTexto2' align='left'>Fecha</td>";
												echo "<td id='iconosTexto2' align='left'>Evaluación</td>";
												echo "<td width='20'> </td>";
											echo "</tr>";
											
											echo"<tr align='left'>";
												echo "<td width='30'> </td>";
												echo "<td width='20'> </td>";
												echo "<td  align='left'>";
													//echo "<input type='text' class='DatP' size=10 maxlength=10 name='fechaEvaluacion'>";
													echo date("Y-m-d");
												echo"</td>";
												echo "<td align='left'>";
													echo "<select name='evaluacion'>";
														echo "<option value=''>Elegir...</option>";
														echo "<option value='TERMINADA'>Terminada</option>";
														echo "<option value='RECHAZADA'>Rechazada</option>";
														
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
												
											echo "</tr>";
											
											echo "<tr>";
												echo "<td width='30'> </td>";
												echo "<td width='20'> </td>";
												echo "<td colspan='3'>";
													//echo "<input type='file' name='archivoEvaluacion'>";
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
										
							}
						}//fin del if de verificacion donde los entregables estan terminados
					}else{
						
						echo "<table border='0' align='center' width='700'>";
							echo "<tr height='35px'></tr>";
								echo"<tr>";
									echo"<td align='left' id='titulo2' width='550'><b>Seguimiento</b></td>";
									echo"</td>";
								echo"</tr>";
								
								echo "<tr>";
									echo "<td id='titleBlueLineBottom' colspan='2'></td>";
								echo "</tr>";
								
								echo"<tr height='20'> </tr>";
						echo "</table>";
						
						$s = $INTRANET->Execute("SELECT xt_estatus, xd_fechaCreacion FROM SGI_Quejas_Solicitudes_Estatusv2 WHERE xt_quejaSolicitud = '$solicitudID' AND xt_estatus = 'SIN ASIGNAR' ORDER BY xn_numero ");	
								while($r = $s->fetchRow()){
									$estatusEtapa	= $r[0];
									$fechaEtapa	= date('Y-m-d H:i:s', strtotime($r[1]));
		
									echo "<table border='0' align='center' width='700'>";
										echo "<tr>";
											//echo "<td> </td>";
												echo "<td id='iconosTexto' colspan='2' align='left'>$fechaEtapa <b>$estatusEtapa</b></td>";
												echo "<td id='iconosTexto' width='50' align='right'></td>";	
								
										echo "</tr>";
										
										
										echo "<tr>";
												echo "<td colspan='2'><font color='#636262'> Sin asignar</font></td>";
										echo "</tr>";
											
										
										echo"<tr height='10'> </tr>";
									echo "</table>";
											
								}unset($r); unset($s); unset($i);
								
								$s = $INTRANET->Execute("SELECT xt_status, xd_fecha, xt_usuario FROM SGI_Backlog_Validaciones WHERE xt_quejaSolicitud = '$solicitudID' ");	
								while($r = $s->fetchRow()){
									$estatusEtapa	= $r[0];
									$fechaEtapa	    = date('Y-m-d H:i:s', strtotime($r[1]));
									$usuario        = $r[2];
						
									echo "<table border='0' align='center' width='700'>";
										echo "<tr>";
											//echo "<td> </td>";
												echo "<td id='iconosTexto' colspan='2' align='left'>$fechaEtapa <b>$estatusEtapa</b></td>";
												echo "<td id='iconosTexto' width='50' align='right'></td>";	
								
										echo "</tr>";
										
										
										if($estatusEtapa == 'ACEPTADA'){
											echo "<tr>";
												echo "<td colspan='2'><font color='#636262'> Aceptada por: $usuario</font></td>";
											echo "</tr>";
										}
											
										
										echo"<tr height='10'> </tr>";
							
									echo "</table>";
											
								}unset($r); unset($s); unset($i); 
								
								$s = $INTRANET->Execute("SELECT xt_estatus, xd_fechaCreacion, kf_usuario, xt_contenido FROM SGI_Quejas_Solicitudes_Estatusv2 WHERE xt_quejaSolicitud = '$solicitudID' AND xt_estatus not in('SIN ASIGNAR') ORDER BY xn_numero ");	
								while($r = $s->fetchRow()){
									$estatusEtapa	= $r[0];
									$fechaEtapa	= date('Y-m-d H:i:s', strtotime($r[1]));
									$usuario        = $r[2];
									$comentario     = $r[3];
						
									echo "<table border='0' align='center' width='700'>";
										echo "<tr>";
											//echo "<td> </td>";
												echo "<td id='iconosTexto' colspan='2' align='left'>$fechaEtapa <b>$estatusEtapa</b></td>";
												echo "<td id='iconosTexto' width='50' align='right'></td>";	
								
										echo "</tr>";
										
										if($estatusEtapa == 'ENTREGABLE PARA REVISION'){
											echo "<tr>";
												echo "<td colspan='2'><font color='#636262'> Revisado por: $usuario <br> Comentario: $comentario</font></td>";
												
											echo "</tr>";
										}
										
										if($estatusEtapa == 'ENTREGABLE RECHAZADO'){
											echo "<tr>";
												echo "<td colspan='2'><font color='#636262'> Rechazada por: $usuario <br> Comentario: $comentario</font></td>";
											echo "</tr>";
										}
										
										if($estatusEtapa == 'TERMINADA'){
											echo "<tr>";
												echo "<td colspan='2'><font color='#636262'> Terminada por: $usuario <br> Comentario: $comentario</font></td>";
											echo "</tr>";
										}
									echo "<tr height='15px'></tr>";
										
									echo "</table>";
						
									/*if($estatusEtapa == 'TERMINADA' && $comentario != ''){
										
									
										echo "<table border='0' align='center' width='700'>";
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
													echo $comentario;
												echo"</td>"; 
						
											echo"</tr>";	
									
								
											echo "<tr><td height='3px;'></td</tr>"; 
											echo "<tr>";
								   
												echo "<td width='100px;'></td>";
												echo "<td id='titleBlueLineBottom' colspan='2'></td>";
											echo "</tr>";  
										echo"</table>";	
									}*/

											
								}unset($r); unset($s); unset($i);
											
						
						}

	
		
		
	//cierro la ficha
	echo "<table border='0' align='center' width='700'>";	

		echo "<tr height='20px'></tr>";
		 echo "<tr>";
        	echo "<td id='titleBlueLineBottom' colspan='2'></td>";
    	 echo "</tr>";
		 
		 echo "<tr>";
	 		echo "<td align='center'><font color='#636262'>Created by: Grupo Escalante Agencias Aduanales, 2015</font></td>";
		 echo "</tr>";
	 
	 	echo "<tr height='20px'></tr>";  
	
	echo "</table>";
	
//echo "</form>";
echo "</div>";

?>
</body>
</html>

	