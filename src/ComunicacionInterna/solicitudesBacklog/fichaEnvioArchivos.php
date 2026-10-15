<?php error_reporting(0); ?>
<?php
$nombrephp='fichaEnvioArchivos.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
//require_once("MailSolicitudRevisar.php");
//require_once("MailSolicitudRechazar.php");
//require_once("MailEnvioAsignar.php");
$usuarioId = $_SESSION['sesionUsuario'];

$codigo    = $_GET['codigo'];


$categoriaUsr = $INTRANET->getOne("SELECT kf_categoria FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");

//Defino estilo
if($estiloUsuario == 1){
	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
}else if($estiloUsuario == 2){
    echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
}

$s = $INTRANET->Execute("SELECT xt_quejaSolicitud, xt_titulo, xt_descripcion, xt_ruta, kf_usuarioId, xt_status, xt_pdr, xt_ciudad, xt_tipoSolicitud FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$codigo' AND xt_tipo = 'B' AND xt_tipoSolicitud = 'EA' ");
while($r = $s->fetchRow()){
	
	$clave 			= $r[0];
	$titulo 		= $r[1];
	$descripcion 	= nl2br ($r[2]);
	$ruta 			= $r[3];
	$solicitanteID 	= $r[4];
	$status         = $r[5];
	$pdr            = $r[6];
	$ciudad         = $r[7];
	$tipoSolicitud  = $r[8];
}

$prioridadSol = $INTRANET->getOne("SELECT xt_prioridad FROM SGI_Backlog_Prioridad WHERE xt_quejaSolicitud = '$codigo'");
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
<title>Ficha Envio Archivos</title>
    <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
    <link type="text/css" href="../../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
    <script type="text/javascript" src="../../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="../../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
    <style>
		#WindowLoad
			{
				position:fixed;
				top:0px;
				left:0px;
				z-index:3200;
				/*filter:alpha(opacity=10);   
			   -moz-opacity:10;   
				opacity:0.10;
				background:#999;*/
			}
    </style>
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
    
    <script language="javascript">
            function SubeImagen(cual) {
               var elElemento=document.getElementById(cual);
               if(elElemento.style.display == 'block') {
                  elElemento.style.display = 'none';
               } else {
                  elElemento.style.display = 'block';
               }
            }
     </script>
    
    <script language="javascript">
	  function SINO(cual) {
		 var elElemento=document.getElementById(cual);
		 if(elElemento.style.display == 'block') {
			elElemento.style.display = 'none';
		 } else {
			elElemento.style.display = 'block';
		 }
	  }
  	</script>
    
    <script type="text/javascript">
			function cambiaPDR(){
				
				var codigo ="<?php echo $codigo;?>";
				
				var pdr             = $("#divPDR").val();
				//var codigoE         = $("#codigoE").val();
				var tipoS         = $("#tipoSol").val();
				var ciudad          = $("#ciudad").val();
				var titulo          = $("#tituloSoli").val();
				var descripcion     = $("#descripcionSoli").val();

				//alert(pdr+codigoS+codigoE+tipoSolicitud);
				
				jsShowWindowLoad('Espere un momento');
				$('#divPDR').load("asignarPDR.php", {pdr: pdr, codigo: codigo, tipoS: tipoS, ciudad: ciudad, titulo: titulo, descripcion:descripcion}, function(data){
				//$('#divPDR').load("../../../BackLog/cambiaPDREntregable.php", {pdr: pdr, codigoS: codigoS, codigoE: codigoE, tipoSolicitud:tipoSolicitud}, function(data){
				jsRemoveWindowLoad();	
	
				});
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
            	jsShowWindowLoad('Espere un momento');
             	$('#contPrioridad').load("cambiaPrioridadSolicitud.php", {codigoS:codigoS, prioridadAnt:prioridadAnt, prioridadNueva:prioridadNueva, usuario:usuario, prioriJustifica:prioriJustifica}, function(data){
    			jsRemoveWindowLoad();
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
    <script>
		
	//Funciones que muestran el proceso de elaborar y descargar los archivos
	function jsRemoveWindowLoad() {
		// eliminamos el div que bloquea pantalla
		$("#WindowLoad").remove();
	
	}
			
	function jsShowWindowLoad(mensaje) {
		//eliminamos si existe un div ya bloqueando
		jsRemoveWindowLoad();
	   
		//si no enviamos mensaje se pondra este por defecto
		if (mensaje === undefined) mensaje = "Procesando la información<br>Espere por favor";
	   
		//centrar imagen gif
		height = 20;//El div del titulo, para que se vea mas arriba (H)
		var ancho = 0;
		var alto = 0;
		
		//obtenemos el ancho y alto de la ventana de nuestro navegador, compatible con todos los navegadores
		if (window.innerWidth == undefined) ancho = window.screen.width;
		else ancho = window.innerWidth;
		if (window.innerHeight == undefined) alto = window.screen.height;
		else alto = window.innerHeight;
		
		//operación necesaria para centrar el div que muestra el mensaje
		var heightdivsito = alto/2 - parseInt(height)/2;//Se utiliza en el margen superior, para centrar
		
	   //imagen que aparece mientras nuestro div es mostrado y da apariencia de cargando
		imgCentro = "<div style='margin:0 auto 0 auto;text-align:center;width:20%;background:rgb(255,255,255);'><div  style='color:rgb(128,128,128);margin-top:" + heightdivsito + "px; font-size:20px;font-weight:bold'>" + mensaje + "</div><img  src='loading-blue.gif'></div>";
	
			//creamos el div que bloquea grande
			div = document.createElement("div");
			div.id = "WindowLoad"
			div.style.width = ancho + "px";
			div.style.height = alto + "px";
			$("body").append(div);
	
			//creamos un input text para que el foco se plasme en este y el usuario no pueda escribir en nada de atras
			input = document.createElement("input");
			input.id = "focusInput";
			input.type = "text"
	
			//asignamos el div que bloquea
			$("#WindowLoad").append(input);
			
			//asignamos el foco y ocultamos el input text 
			$("#focusInput").focus();
			$("#focusInput").hide();
			
			//centramos el div del texto
			$("#WindowLoad").html(imgCentro);
	}
			
	</script>
    <!-- SCRIPT PARA CAMBIAR EL COLOR DE LAS CELDAS -->
    <script language="javascript" type="text/javascript">
        function ilumina(celda, color){
            celda1 = document.getElementById(celda);
            //var celda1 = document.getElementById(celda).innerHTML;
            var codigo ="<?php echo $codigo;?>";
            var usuario = "<?php echo $usuarioId;?>";
            var comentarioMS = document.getElementById('comentarioVerifMS1').value;
        
            //alert (color+celda+comentarioMS);
            if(color == 'white' && celda == 'tdProcede'){
                celda1.style.backgroundColor  = '#42CB27';
                document.getElementById('tdNoProcede').style.backgroundColor  = 'red';
    			
				
				jsShowWindowLoad('Espere un momento');
                $('#validacionMS').load("procedeMS.php", {status: 'ACEPTADA', codigo: codigo, usuario: usuario, comentario: comentarioMS}, function(data){
				jsRemoveWindowLoad();
    
                })
           
            }
    
            if(color == 'white' && celda == 'tdNoProcede'){
                celda1.style.backgroundColor  = 'red';
                document.getElementById('tdProcede').style.backgroundColor  = 'red';
				
    		   jsShowWindowLoad('Espere un momento');
               $('#validacionMS').load("procedeMS.php", {status: 'RECHAZADA', codigo: codigo, usuario: usuario, comentario: comentarioMS}, function(data){
				jsRemoveWindowLoad();
                
              })
              
           }
    
        }
    </script>
    
    <!-- SCRIPT PARA CAMBIAR EL COLOR DE LAS CELDAS -->
    <script language="javascript" type="text/javascript">
    
     function ilumina2(celda, color){
        celda1 = document.getElementById(celda);
        //var celda1 = document.getElementById(celda).innerHTML;
        var codigo ="<?php echo $codigo;?>";
        var usuario = "<?php echo $usuarioId;?>";
        var comentarioMS = "";
        
        if(color == 'white' && celda == 'tdProcede'){
        
            celda1.style.backgroundColor  = '#42CB27';
            document.getElementById('tdNoProcede').style.backgroundColor  = 'red';
            
         /*  $('#validacionMS').load("procedeMS.php", {status: 'ACEPTADA', codigo: codigo, usuario: usuario, comentario:comentarioMS}	
           , function(data){
    
           })*/
           
        }
    
        if(color == 'white' && celda == 'tdNoProcede'){
            celda1.style.backgroundColor  = 'red';
            document.getElementById('tdProcede').style.backgroundColor  = 'red';
    
          /* $('#validacionMS').load("procedeMS.php", {status: 'RECHAZADA', codigo: codigo, usuario: usuario, comentario:comentarioMS}, function(data){
                
              })*/
              
           }
    
        }
    </script>
    <!-- SCRIPT PARA GUARDAR AL COMENTARIO DE VALIDACION -->
	<script language="javascript" type="text/javascript">
     
        function comentarioMS(comentarioN){
         
            var codigo ="<?php echo $codigo;?>";
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
            
           /* $('#comentarioMS').load("comentarioMS.php", {codigo: codigo, comentario : comentarioMS, usuario : usuario, valor : valor}, function(data){
    
            })*/
        
        }
    </script>
    <style type="text/css">
		.overbox {
			display: none;
			position: absolute;
			background: white;
			width: 20%;
			height: 20%;
			top: 40%;
			left: 40%;
			border-radius: 30px;
			z-index:1002;
			overflow: auto;
		}
		.fadebox {
			display: none;
			position: absolute;
			top: 0%;
			left: 0%;
			width: 100%;
			height: 100%;
			background-color: black;
			z-index:1001;
			-moz-opacity: 0.75;
			opacity:.75;
			filter: alpha(opacity=80);
		}
		img.imgD{
			width:15px;
			height:15px;
		}
		</style>

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
			var solicitud = "<?php echo $codigo; ?>";
			if(previo != 'nuevo'){
			    var catalogo=document.getElementsByName(previo)[0].value;
			    var input = previo;
			}else{
			    var catalogo=document.getElementsByName("catalogo")[0].value;
			    var input = "";
			}
			
			alert(codE+catalogo);
			/*
			$('#loadstakeholder').load("asignarStakeholder.php",{codE:codE, catalogo : catalogo, usuario:usuario, input: input, solicitud: solicitud},function(data){
				document.getElementById("cargastakeHolder").style.display="none";    
			});
			*/

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
				echo "<font>Solicitud de envío de archivos</font>";
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
			echo "</tr>";
			

		echo"<tr height='10'> </tr>";
		
		
		echo "<tr>";
			echo "<td width='20'> </td>";
			echo "<td width='20'> </td>";
			echo "<td width='610' align='justify' id='fileItem'>$descripcion</td><td></td>";
		echo "</tr>";
		
		echo"<tr height='10'> </tr>";
		
		$t = $INTRANET->Execute("SELECT xt_descripcionEnvio, xt_rfc FROM SGI_Backlog_Envio_Archivos WHERE xt_quejaSolicitud = '$codigo'");
			while($u = $t->fetchRow()){
				$descripcionEnvio = $u[0];
				$rfc			  = $u[1];
			
			echo "<tr>";
				echo "<td width='20'> </td>";
				echo "<td width='20'> </td>";
				echo "<td width='610' align='justify' id='fileItem'>$descripcionEnvio</td><td></td>";
			echo "</tr>";
			
			echo"<tr height='10'> </tr>";
			
			echo "<tr>";
				echo "<td width='20'> </td>";
				echo "<td width='20'> </td>";
				echo "<td width='610' align='justify' id='fileItem'>$rfc</td><td></td>";
			echo "</tr>";
			
			}
		
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
	
	///PDR
	if($pdr != ""){
		echo "<table border='0' align='center' width='700'>";	
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
		
	//PRIORIDAD
	//echo"SELECT xt_prioridad, xt_justificacion, xd_fecha FROM SGI_Backlog_Prioridad WHERE xt_quejaSolicitud = '$codigo' ORDER BY xd_fecha ASC";
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
	 //if($usuarioId == 'Alberto_Martinez'){
	if(@$perfil[0] == 'Jefe de Desarrollo' || @$perfil[0] == 'Asignador PDR'){
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
		
				
				echo"<tr height='10'> </tr>";
			echo "</table>";
					
			//
			echo "<table border='0' align='center' width='700'>";
			echo "<tr>";
				
					echo"<td align='right' valign='bottom' style='padding:0px 0px 0px 10px' colspan='2'>";
					?>
					<div id="btn1" ><a style="cursor:pointer" id="insertaP"  onClick="activaCP()"><font color='#007CBD'>Editar</font></a></div>
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
				?>
                
				<script>
                    $("#prioridadAsignada").change(function(){
                        var prioridad = $(this).val()
            
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
						  $tipoSolicitud = $INTRANET->getOne("SELECT xt_tipoSolicitud FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$codigo'");
				  
						  ?>
						    	<div id="btn1" ><a style="cursor:pointer" id="insertaP"  onClick="cambiaPrioridad('<?php echo $prioridad; ?>')"><font color='#007CBD'>Guardar</font></a></div>
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
	
	
	//Seccion de Validación
	//if($usuarioId == 'Alberto_Martinez'){
	if(@$perfil[0] == 'Jefe de Desarrollo' || @$perfil[0] == 'Asignador PDR'){
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
	
		echo "<div id='validacionMS'>";
			echo "<table border='0' align='center' width='30%'>";
				echo "<tr height='10px'></tr>";
	
				//verifico validacion 
				$j = $INTRANET->Execute("SELECT xt_status, xd_fecha, xt_usuario, xt_comentario FROM SGI_Backlog_Validaciones where xt_quejaSolicitud ='$codigo' and xt_tipoValidacion = 'ENVIOS'");
	 
	 			while($s = $j->fetchRow()){
		 
		 			$statusValidacionMS = $s[0];
		 			$fecha = $s[1];
		 			$usuarioMS = $s[2];
		 			$comentarioMS = $s[3];
					
				 $nombreUsuarioMS = $INTRANET->getOne("SELECt xt_nombre FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioMS'");
		 
	 			}
	
	 			if(@$statusValidacionMS == ''){

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

		echo "<div id='comentarioMS'>";
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
					echo "<td> <textarea id='comentarioVerifMS1' rows='4' cols='70'>";
						isset($comentarioMS);
					echo"</textarea> </td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='50px'></tr>";
				
			echo "</table>";
			
		echo "</div>";
	
		}// fin del if donde no se tiene asignado status
	
		if(@$statusValidacionMS == 'ACEPTADA'){
			
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
				echo "<td align='center'>$nombreUsuarioMS aprobó la solicitud</td>";
			echo "</tr>";
		
			echo "<tr align='center'>";
				echo "<td>$fecha</td>";
			echo "</tr>";
			
			echo "<tr height='10px'></tr>";
		echo "</table>";
		
		//comentarios 
			
		if(@$comentarioMS != ''){
			
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
	
		}
	
		if(@$statusValidacionMS == 'RECHAZADA'){
	
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
					echo "<td align='center'>$nombreUsuarioMS rechazó la solicitud</td>";
				echo "</tr>";
		
				echo "<tr align='center'>";
					echo "<td>$fecha</td>";
				echo "</tr>";
			
				echo "<tr height='10px'></tr>";
			echo "</table>";
		
			//comentarios 
			
			if(@$comentarioMS != ''){
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
	
	 			$j = $INTRANET->Execute("SELECT xt_status, xd_fecha, xt_usuario, xt_comentario FROM SGI_Backlog_Validaciones where xt_quejaSolicitud ='$codigo' and xt_tipoValidacion = 'ENVIOS'");
	 
				while($s = $j->fetchRow()){
		 
		 			$statusValidacionMS = $s[0];
		 			$fecha = $s[1];
		 			$usuarioMS = $s[2];
		 			$comentarioMS = $s[3];
					
					$nombreUsuarioMS = $INTRANET->getOne("SELECt xt_nombre FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioMS'");
		 
	 			}
	
	 			if($statusValidacionMS == ''){

					?>
				</table>
				<?php
	
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
						echo "<td align='center'>$nombreUsuarioMS aprobó la solicitud</td>";
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
							echo "<td align='center'>$nombreUsuarioMS rechazó la solicitud</td>";
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
	
		echo "<table border='0' align='center' width='700'>";
		echo "<tr height='35'>";
			echo "</tr>";
		echo"</table>";
	
		$resultadoValidacion = $INTRANET->getOne("SELECT xt_status FROM SGI_Backlog_Validaciones WHERE xt_quejaSolicitud = '$codigo' AND xt_tipoValidacion = 'ENVIOS'");
		
		if($resultadoValidacion == 'ACEPTADA'){
			
				echo "<table border='0' align='center' width='700'>";	
			echo "<tr height='35'>";
				echo "<tr>";
					echo "<td align='left' id='titulo2'><b>Tipo(s) Envío(s)</b></td>";
					if($usuarioId == 'Rodrigo_Romo'){
					//if($usuarioId == 'Alberto_Martinez'){
					
					 	echo "<td align='right'><a href='backlogEntregablesPopUp.php?codigo=$codigo&tipoS=EA&ciudad=$ciudad&prioridad=$prioridadSol' target='popup' onclick=\"window.open(this.href,this.target,'width=470,height=400,scrollbars=yes')\"><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>";
					}
			
												
				echo"</tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
			echo"</table>";
			
			$l = $INTRANET->Execute("SELECT xt_tipoEnvio, xt_entregable FROM SGI_Backlog_Envio_Archivos WHERE xt_quejaSolicitud = '$codigo'");
					while($o = $l->fetchRow()){
						$tipoSoliEnvio        = $o[0];
						$entragableEnvio      = $o[1];
	
						echo "<table border='0' align='center' width='700'>";
							echo"<tr>";
									echo"<td width='50'></td>";
									echo"<td width='650'>";
										echo "<table border='0' align='center' width='650'>";			
											echo"<tr height='30'> </tr>";
											
											echo "<tr>";
												echo "<td align='left' width='250px' id='iconostexto2'><b>$tipoSoliEnvio</b></td>";
												if($usuarioId == 'Rodrigo_Romo'){
													echo "<td align='right'><a href='backlogAsignaPdrPopUp.php?codigoE=$entragableEnvio&codigoS=$codigo' target='popup' onclick=\"window.open(this.href,this.target,'width=470,height=400,scrollbars=yes')\"><img src='../../Imagenes/ICN_NuevoDoc.png' height='15' width='15'> </a>";
												}
											echo "</tr>";
											echo "<tr>";
												echo "<td id='titleBlueLineBottom' colspan='2'></td>";
											echo "</tr>";
										echo"</table>";
								echo"</td>";
							echo"</tr>";
						echo"</table>";
						
						$entregableTerminado = $INTRANET->getOne("SELECT E.xt_etapa FROM BACKLOG.ETAPAS E WHERE E.xt_codigoEntregable = '$entragableEnvio' ORDER BY E.xd_fecha DESC");
						
						if($entregableTerminado != 'TERMINADA'){
						
							$r = $INTRANET->Execute("SELECT xt_codigoEntregable, xt_programador, xn_posicion FROM BACKLOG.PDR WHERE xt_codigoEntregable = '$entragableEnvio'");
								while($p = $r->fetchRow()){
									$codigoE     = $p[0];
									$programador = $p[1];
									$posicion    = $p[2];
									
								echo "<table border='0' align='center' width='700'>";
									echo"<tr height='15'>";
										echo"<td width='100'></td>";
										echo"<td width='600'>";	
											echo "<table border='0' align='center' width='600'>";			
												echo"<tr height='10px'> </tr>";
												
												echo "<tr>";
													echo "<td align='left' width='200px' id='iconostexto2'>Administrador</td>";
													echo "<td align='left' width='200px' id='iconostexto2'>Entregable</td>";
													echo "<td align='left' width='200px' id='iconostexto2'>Status</td>";
												echo "</tr>";
							
											echo"</table>";
											
											echo "<table border='0' align='center' width='600'>";			
												echo "<tr>";
													echo "<td id='titleBlueLineBottom' colspan='2'></td>";
												echo "</tr>";
											echo"</table>";
											
											echo "<table border='0' align='center' width='600'>";													
												echo "<tr height='5px'>";
												echo "<tr>";
													echo "<td align='left' width='200px' id='iconosTexto'>".$programador."</td>";
													echo "<td align='left' width='200px' id='iconosTexto'><a href='https://escalante.com.mx/Sistemas/BackLog/iniciaSesion.php'>".$codigoE."</a></td>";
													echo "<td align='left' width='200px' id='iconosTexto'>Lugar: ".$posicion."</td>";
												echo "</tr>";
												echo "<tr height='5px'>";
											echo"</table>";
											
											echo "<table border='0' align='center' width='600'>";			
												echo "<tr>";
													echo "<td id='titleBlueLineBottom' colspan='2'></td>";
												echo "</tr>";
											echo"</table>";
											echo"</td>";
										echo"</tr>";
								echo"</table>";
		
								}
						}
						if($entregableTerminado == 'TERMINADA'){
							
							$r = $INTRANET->Execute("SELECT E.xt_etapa, (SELECT MAX(HE.xt_programador) FROM BACKLOG.HISTORIAL_ENTREGABLE HE WHERE HE.xt_codigoEntregable = E.xt_codigoEntregable ORDER BY HE.xd_fecha DESC ) as Programador 
							FROM BACKLOG.ETAPAS E WHERE E.xt_codigoEntregable = '$entragableEnvio' AND E.xt_etapa = 'TERMINADA' ORDER BY E.xd_fecha DESC");
								while($p = $r->fetchRow()){
									$etapaE    = $p[0];
									$programador = $p[1];
							
									echo "<table border='0' align='center' width='700'>";
									echo"<tr height='15'>";
										echo"<td width='100'></td>";
										echo"<td width='600'>";	
											echo "<table border='0' align='center' width='600'>";			
												echo"<tr height='10px'> </tr>";
												
												echo "<tr>";
													echo "<td align='left' width='200px' id='iconostexto2'>Administrador</td>";
													echo "<td align='left' width='200px' id='iconostexto2'>Entregable</td>";
													echo "<td align='left' width='200px' id='iconostexto2'>Status</td>";
												echo "</tr>";
							
											echo"</table>";
											
											echo "<table border='0' align='center' width='600'>";			
												echo "<tr>";
													echo "<td id='titleBlueLineBottom' colspan='2'></td>";
												echo "</tr>";
											echo"</table>";
											
											echo "<table border='0' align='center' width='600'>";													
												echo "<tr height='5px'>";
												echo "<tr>";
													echo "<td align='left' width='200px' id='iconosTexto'>".$programador."</td>";
													
													//envio parametros necesarios
													@$lisEntg0 = $lisEntg[0];
													$prioriE = $INTRANET->getOne("SELECT xt_prioridad FROM BACKLOG.ENTREGABLES WHERE xt_codigoEntregable = '$lisEntg0'");
													echo "<td align='left' width='200px' id='iconosTexto'><a href=https://escalante.com.mx/Sistemas/BackLog/iniciaSesion.php?codE=".base64_encode($entragableEnvio)."&prioridad=".base64_encode($prioriE)."&codS=".base64_encode($codigo)."&usu=".base64_encode($usuarioId).">".$entragableEnvio."</a></td>";

													//echo "<td align='left' width='200px' id='iconosTexto'><a href='https://escalante.com.mx/Sistemas/BackLog/iniciaSesion.php'>".$entragableEnvio."</a></td>";
													echo "<td align='left' width='200px' id='iconosTexto'>".$etapaE."</td>";
												echo "</tr>";
												echo "<tr height='5px'>";
											echo"</table>";
											
											echo "<table border='0' align='center' width='600'>";
											
												echo "<tr height='10'></tr>";
												
												echo "<tr>";
													
													echo "<td style='color:#636262;' colspan='4' id='iconosTexto' >";
														echo "Comentario:";
													echo "</td>";
												echo "</tr>";
												
												//obtengo el comentario del entregable (el que pone el programador cuando finaliza su entregable)
												$comentarioProgra = $INTRANET->getOne("SELECT xt_comentario FROM BACKLOG.ETAPAS WHERE xt_codigoEntregable = '$entragableEnvio' AND xt_etapa = 'EN PRUEBAS'");
												echo "<tr>";
													//echo "<td width='15px'></td>";
													echo "<td colspan='4' id='iconosTexto' style='color:#636262;'>";
														echo "$comentarioProgra";
													echo "</td>";
												echo "</tr>";
												
												echo "<tr height='10'></tr>";
														
												echo "<tr>";
													echo "<td id='titleBlueLineBottom' colspan='2'></td>";
												echo "</tr>";
											echo"</table>";
											echo"</td>";
										echo"</tr>";
								echo"</table>";
									
								}		
						}
						
					}
			
		echo "<table border='0' height='25px' align='center' width='700'>";
			echo"<tr height='30px'> </tr>";
		echo "</table>";
			
			
		}
		
		$maximoEtapaSolicitud = $INTRANET->getOne("SELECT xt_estatus FROM SGI_Quejas_Solicitudes_Estatusv2 WHERE xt_quejaSolicitud = '$codigo' order by xd_fechaCreacion DESC");
		
		
		if($maximoEtapaSolicitud != 'TERMINADA'){
			
			
		//Seguimiento
		echo "<table border='0' align='center' width='700'>";
			echo"<tr>";
				echo"<td align='left' id='titulo2' width='550'><b>Seguimiento</b></td>";
				echo"</td>";
			echo"</tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			
			echo"<tr height='20'> </tr>";
		echo "</table>";
		
		$s = $INTRANET->Execute("SELECT xt_estatus, xd_fechaCreacion FROM SGI_Quejas_Solicitudes_Estatusv2 WHERE xt_quejaSolicitud = '$codigo' AND xt_estatus = 'SIN ASIGNAR' ORDER BY xn_numero ");	
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
								
			$s = $INTRANET->Execute("SELECT xt_status, xd_fecha, xt_usuario FROM SGI_Backlog_Validaciones WHERE xt_quejaSolicitud = '$codigo' ");	
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
			$s = $INTRANET->Execute("SELECT xt_estatus, xd_fechaCreacion, kf_usuario, xt_contenido FROM SGI_Quejas_Solicitudes_Estatusv2 WHERE xt_quejaSolicitud = '$codigo' AND xt_estatus not in('SIN ASIGNAR','TERMINADA') ORDER BY xn_numero ");	
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
												echo "<td colspan='2'><font color='#636262'> Revisado por: $usuario</font></td>";
											echo "</tr>";
										}
										
										if($estatusEtapa == 'ENTREGABLE RECHAZADO'){
											echo "<tr>";
												echo "<td colspan='2'><font color='#636262'> Rechazada por: $usuario</font></td>";
											echo "</tr>";
										}
										if($comentario != ''){
											echo "<tr>";
												echo "<td colspan='2'><font color='#636262'>Comentario: $comentario</font></td>";
											echo "</tr>";
										}
										
									echo "<tr height='15px'></tr>";
										
									echo "</table>";
						
									
								}unset($r); unset($s); unset($i);
											
								
			//hago consulta de los estados que tiene asignado
			
			$banderaTerminado = 0;
			$s = $INTRANET->Execute("SELECT xt_codigoEntregable FROM BACKLOG.ENTREGABLES WHERE xt_solicitud = '$codigo'");
			while($x = $s ->fetchRow()){
				
				 $entregable = $x[0];
				
				 $terminado  = $INTRANET->getOne("SELECT xt_etapa FROM  BACKLOG.ETAPAS WHERE xt_codigoEntregable = '$entregable' AND xt_etapa = 'TERMINADA' ");
				
				if($terminado == ''){
					$banderaTerminado = 1;
				}
					
			}
			
			$maximoEstatus = $INTRANET->getOne("SELECT xt_status FROM SGI_Backlog_Validaciones WHERE xt_quejaSolicitud = '$codigo' AND xt_tipoValidacion = 'ENVIOS' AND xt_status = 'ACEPTADA' ");
			
			$maximoSolEstatus = $INTRANET->getOne("SELECT xt_estatus FROM SGI_Quejas_Solicitudes_Estatusv2 WHERE xt_quejaSolicitud = '$codigo' ORDER BY xd_fechaCreacion DESC");
			
			$etapaEntregable = $INTRANET->getOne("SELECT SBEA.xt_entregable FROM IntranetGEA.SGI_Backlog_Envio_Archivos SBEA 
											WHERE SBEA.xt_quejaSolicitud = '$codigo' AND SBEA.xt_entregable IN (SELECT E.xt_codigoEntregable FROM BACKLOG.ETAPAS E WHERE E.xt_etapa = 'TERMINADA')");
			
			$p = $INTRANET->Execute("Select xt_perfil from SGI_Backlog_Perfiles WHERE xt_nombreUsuario = '$usuarioId'");
					
					while($perfilPDR = $p -> FetchRow()){
						
						 $perfilActiva = $perfilPDR[0];
					}//fin del while
						
					if($banderaTerminado == 0){	
						
						if($maximoEstatus != '' && ($maximoSolEstatus == "ENTREGABLE RECHAZADO" || $maximoSolEstatus == "ENTREGABLE PARA REVISION" || $maximoSolEstatus == "SIN ASIGNAR") && $etapaEntregable != ''){
							
							if(@$perfilActiva == 'Jefe de Desarrollo'){
								
								
									$hoy = date("Y-m-d");
									echo "<form name='agregarSeguimiento2' method='POST' action='evaluaSolicitud.php?codigoS=$codigo&usuario=$usuarioId&fecha=$hoy'  enctype='multipart/form-data'>";
									
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
									echo "<form name='agregarSeguimiento3' method='POST' action='evaluaSolicitud.php?codigoS=$codigo&usuario=$usuarioId&fecha=$hoy'  enctype='multipart/form-data'>";
								
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
		
								//opcion para el usuario pero no para el programador
							
								if($maximoSolEstatus == "ENTREGABLE PARA REVISION" && $usuarioId == $solicitanteID){
									
									$hoy = date("Y-m-d");
									echo "<form name='agregarSeguimiento3' method='POST' action='evaluaSolicitud.php?codigoS=$codigo&usuario=$usuarioId&fecha=$hoy'  enctype='multipart/form-data'>";
								
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
						
						//Seguimiento
						echo "<table border='0' align='center' width='700'>";
							echo"<tr height='35'> </tr>";
							echo"<tr>";
								echo"<td align='left' id='titulo2' width='550'><b>Seguimiento</b></td>";
								echo"</td>";
							echo"</tr>";
							
							echo "<tr>";
								echo "<td id='titleBlueLineBottom' colspan='2'></td>";
							echo "</tr>";
							
							echo"<tr height='20'> </tr>";
						echo "</table>";
		
						
						$s = $INTRANET->Execute("SELECT xt_estatus, xd_fechaCreacion FROM SGI_Quejas_Solicitudes_Estatusv2 WHERE xt_quejaSolicitud = '$codigo' AND xt_estatus = 'SIN ASIGNAR' ORDER BY xn_numero ");	
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
								
								$s = $INTRANET->Execute("SELECT xt_status, xd_fecha, xt_usuario FROM SGI_Backlog_Validaciones WHERE xt_quejaSolicitud = '$codigo' ");	
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
								
								$s = $INTRANET->Execute("SELECT xt_estatus, xd_fechaCreacion, kf_usuario, xt_contenido FROM SGI_Quejas_Solicitudes_Estatusv2 WHERE xt_quejaSolicitud = '$codigo' AND xt_estatus not in('SIN ASIGNAR') ORDER BY xn_numero ");	
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
												echo "<td colspan='2'><font color='#636262'> Revisado por: $usuario</font></td>";
											echo "</tr>";
										}
										
										if($estatusEtapa == 'ENTREGABLE RECHAZADO'){
											echo "<tr>";
												echo "<td colspan='2'><font color='#636262'> Rechazada por: $usuario</font></td>";
											echo "</tr>";
										}
										
										if($estatusEtapa == 'TERMINADA'){
											echo "<tr>";
												echo "<td colspan='2'><font color='#636262'> Terminada por: $usuario</font></td>";
											echo "</tr>";
										}
										
										if($comentario != ''){
											echo "<tr>";
												echo "<td colspan='2'><font color='#636262'>Comentario: $comentario</font></td>";
											echo "</tr>";
										}
									echo "<tr height='15px'></tr>";
									
										
									echo "</table>";
						
								/*	if($estatusEtapa == 'TERMINADA' && $comentario != ''){
										
									
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
									}

										*/	
								}unset($r); unset($s); unset($i);
											
						
						}
							
						//cierre de la interfaz
						echo "<table width='700px' align='center'>";
							echo "<tr height='55px'></tr>";
							echo "<tr>";
								echo "<td colspan='4' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
								echo "</td>";
							echo "</tr>";
						
							echo "<tr align='center'>";
								echo "<td align='center'>";
									echo "<td style='color:#636262;'>Created by: Grupo Escalante Agencias Aduanales.</td>";
									echo "";
								echo "<td>";
							echo "</tr>";
						
							echo "<tr height='45px'></tr>";
						
						echo "</table>";
					echo "</div>";
							
				
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

	