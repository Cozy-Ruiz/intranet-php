<?php
ini_set( 'upload_max_filesize' , '64M' );
ini_set( 'post_max_size', '64M');
ini_set("memory_limit","500M");
$nombrephp = 'altaBaja_Usuario.php';
require_once("../../../../ConexionDBT.php");
require_once("../../../../Consultas/ConsutasGlobales.php");
require_once("../../../../ConexionIntranet2.php");
//require_once("../MailSolicitudAsignar.php");

$usuarioId = base64_decode($_GET['usuario']);

//obtengo la(s) ciudad del usuario
$indice = 0;
$s = $INTRANET->Execute("SELECT xt_codigoCiudad FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioId' ORDER BY xt_codigoCiudad ");

while($r = $s->fetchRow()){
	$ciudadesDisponibles[$indice] = $r[0];
	$indice++;
	
} unset($r); unset($s); unset($indice);

$estiloUsuario = $INTRANET->getOne("SELECT xn_estilo FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId'");

//Defino estilo
if($estiloUsuario == 1){
	echo "<link type='text/css' rel='stylesheet' href='../../../../css/styleHomePage.css'/>";
}else if($estiloUsuario == 2){
    echo "<link type='text/css' rel='stylesheet' href='../../../../css/styleHomePage2.css'/>";
}
?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Alta baja Usuario</title> 
            <link rel="shortcut icon" type="image/x-icon" href="../../../../Imagenes/ICN_PestanaWebGE.png">
            <link type="text/css" href="../../../../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
            <script type="text/javascript" src="../../../../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
            <script type="text/javascript" src="../../../../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
			
                <script type="text/javascript">
					

                    $(function(){
                        $(".DatP").datepicker({ dateFormat: 'yy-mm-dd',
                         monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] ,
                         dayNamesMin:  ['Dom','Lun','Mar','Mie','Jue','Vie','Sab']
                        
                         });
                    });
                </script>
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
						var paso = true;
                    function check() {
					  document.getElementById("INTRANET").checked = true;
					  document.getElementById("PROPROFS").checked = true;
					  sistema();
					  correo();
					}

					function uncheck() {
						var paso = true;
					  document.getElementById("INTRANET").checked = false;
					  document.getElementById("PROPROFS").checked = false;
					  sistema();
					  correo();
					}
                </script>
                <script type="text/javascript">
                    function muestraUsuario(){
                        var tipoSolicitud = document.getElementsByName("tipoSolicitud")[0].value;
						var ciudad = document.getElementsByName("ciudad")[0].value;
						var tipousu = document.getElementsByName("tipousu").value;
						
                        if(tipoSolicitud == 'ALTA'){
							if(tipousu != (''||null)){
                            $('#bajaFrame1').hide();
                            $('#altaFrame2').show();
                            $('#bajaFrame2').hide();
                            $('#altaFrame3').show();
                            $('#altaFrame4').show();
                            $('#altaFrame5').show();
							$('#bajaFrame3DF').hide();
							$('#bajaFrame3NLR').hide();
							$('#bajaFrame3CUN').hide();
							$('#bajaFrame3VER').hide();
							$('#bajaFrame3TOL').hide();
							$('#bajaFrame3LAR').hide();
							$('#bajaFrame3QRO').hide();
                            $('#muestraActuales1').hide();
                            $('#muestraActuales2').hide();	
							}else{
								alert("Seleccione tipo usuario");
                            $('#tipousu').show();	
                            $('#tipousu1').show();	
							}

                        }else if(tipoSolicitud == 'BAJA_TOTAL' || tipoSolicitud == 'BAJA'){
                            $('#altaFrame1').hide();
                            $('#bajaFrame1').show();
                            $('#altaFrame2').hide();
                            $('#bajaFrame2').show();
                            $('#altaFrame3').hide();
							$('#altaFrame4').hide();
							$('#altaFrame5').hide();
                            $('#tipousu').hide();	
                            $('#tipousu1').hide();	

                        /*}
                        else if(tipoSolicitud == 'BAJA'){
                            $('#altaFrame1').hide();
                            $('#bajaFrame1').show();
                            $('#altaFrame2').hide();
                            $('#bajaFrame2').show();*/
							
							if(ciudad == 'CMX'){
								
								$('#altaFrame3').hide();
								$('#altaFrame4').hide();
								$('#altaFrame5').hide();
								$('#bajaFrame3NLR').hide();
								$('#bajaFrame3CUN').hide();
								$('#bajaFrame3VER').hide();
								$('#bajaFrame3LAR').hide();
								$('#bajaFrame3TOL').hide();
								$('#bajaFrame3QRO').hide();
                            	$('#bajaFrame3DF').show();
								
							}
							
							if(ciudad == 'NLR'){
								$('#altaFrame3').hide();
								$('#altaFrame4').hide();
								$('#altaFrame5').hide();
								$('#bajaFrame3DF').hide();
								$('#bajaFrame3CUN').hide();
								$('#bajaFrame3VER').hide();
								$('#bajaFrame3LAR').hide();
								$('#bajaFrame3TOL').hide();
								$('#bajaFrame3QRO').hide();
                            	$('#bajaFrame3NLR').show();
							}
							
							if(ciudad == 'CUN'){
								$('#altaFrame3').hide();
								$('#altaFrame4').hide();
								$('#altaFrame5').hide();
								$('#bajaFrame3DF').hide();
								$('#bajaFrame3NLR').hide();
								$('#bajaFrame3VER').hide();
								$('#bajaFrame3LAR').hide();
								$('#bajaFrame3TOL').hide();
								$('#bajaFrame3QRO').hide();
                            	$('#bajaFrame3CUN').show();
							}
							
							if(ciudad == 'VER'){
								$('#altaFrame3').hide();
								$('#altaFrame4').hide();
								$('#altaFrame5').hide();
								$('#bajaFrame3DF').hide();
								$('#bajaFrame3NLR').hide();
								$('#bajaFrame3CUN').hide();
								$('#bajaFrame3LAR').hide();
								$('#bajaFrame3TOL').hide();
								$('#bajaFrame3QRO').hide();
                            	$('#bajaFrame3VER').show();
							
							}
							
							if(ciudad == 'TOL'){
								$('#altaFrame3').hide();
								$('#altaFrame4').hide();
								$('#altaFrame5').hide();
								$('#bajaFrame3DF').hide();
								$('#bajaFrame3NLR').hide();
								$('#bajaFrame3CUN').hide();
								$('#bajaFrame3LAR').hide();
								$('#bajaFrame3VER').hide();
								$('#bajaFrame3QRO').hide();
                            	$('#bajaFrame3TOL').show();
								
							}
							
							if(ciudad == 'LAR'){
								$('#altaFrame3').hide();
								$('#altaFrame4').hide();
								$('#altaFrame5').hide();
								$('#bajaFrame3DF').hide();
								$('#bajaFrame3NLR').hide();
								$('#bajaFrame3CUN').hide();
								$('#bajaFrame3TOL').hide();
								$('#bajaFrame3VER').hide();
								$('#bajaFrame3QRO').hide();
                            	$('#bajaFrame3LAR').show();
						
							}
							
							if(ciudad == 'QRO'){
								$('#altaFrame3').hide();
								$('#altaFrame4').hide();
								$('#altaFrame5').hide();
								$('#bajaFrame3DF').hide();
								$('#bajaFrame3NLR').hide();
								$('#bajaFrame3CUN').hide();
								$('#bajaFrame3TOL').hide();
								$('#bajaFrame3VER').hide();
								$('#bajaFrame3QRO').hide();
                            	$('#bajaFrame3LAR').show();
						
							}
                            
							
                        }
                    }
					
                    function muestraSistemas(tipo){
						
						if(tipo == 'CMX'){
							 var nombre = document.getElementsByName("bajaUsuarios1")[0].value;
						}
						if(tipo == 'NLR'){
							 var nombre = document.getElementsByName("bajaUsuarios2")[0].value;
						}
						if(tipo == 'CUN'){
							 var nombre = document.getElementsByName("bajaUsuarios3")[0].value;
						}
						if(tipo == 'VER'){
							 var nombre = document.getElementsByName("bajaUsuarios4")[0].value;
						}
						if(tipo == 'TOL'){
							 var nombre = document.getElementsByName("bajaUsuarios5")[0].value;
						}
						if(tipo == 'LAR'){
							 var nombre = document.getElementsByName("bajaUsuarios6")[0].value;
						}
						if(tipo == 'QRO'){
							 var nombre = document.getElementsByName("bajaUsuarios7")[0].value;
						}
						if(nombre == (''||null)){
						}
						tiposol =document.getElementById("tipoSolicitud").value ;
                        jsShowWindowLoad("Cargando Sistemas del Usuario");
                        $.post('muestraSistemasUsuario.php',{nombre : nombre,solicitud : tiposol },function (data){
                          
                            $('muestraActuales1').show();
                            $('muestraActuales2').show();
                            $('#altaFrame1').hide();
                            $('#altaFrame2').hide();
                            $('#altaFrame3').hide();
                            $('#altaFrame4').hide();
                            $('#altaFrame5').hide();

                            $("#muestraActuales2").html(data);
                            var nombreUsuario = $('input:hidden[name=nombreUsuario]').val();
                            var correoUsuario = $('input:hidden[name=correoUsuario]').val();
                            if(tiposol!="BAJA"){
								document.getElementById("titulo").value="Baja total de Sistemas";
                            }
                            else
                            {
                            	document.getElementById("titulo").value="Baja de Sistemas";
                            }
                            
                            document.getElementById("descripcion").value=nombreUsuario + "," + correoUsuario;
                            jsRemoveWindowLoad();
                        });
                    }
					function correo(){
						var checkBox = document.getElementById("INTRANET");
						if (checkBox.checked == true){
							$('#bajaFrame1').hide();
                            $('#altaFrame2').show();
                            $('#bajaFrame2').hide();
                            $('#altaFrame3').show();
                            $('#altaFrame4').show();
                            $('#altaFrame5').show();
                            $('#fotografiaTitulo').show();
                            $('#fotografiaTitulo1').show();	
                            $('#fotografiaTitulo2').show();	
                            $('#fotografiaTitulo3').show();	
                            $('#fotografiaTitulo4').show();	
                            $('#fotografiaTitulo5').show();								
							$('#bajaFrame3DF').hide();
							$('#bajaFrame3NLR').hide();
							$('#bajaFrame3CUN').hide();
							$('#bajaFrame3VER').hide();
							$('#bajaFrame3TOL').hide();
							$('#bajaFrame3LAR').hide();
							$('#bajaFrame3QRO').hide();
                            $('#muestraActuales1').hide();
                            $('#muestraActuales2').hide();
					  	} else {
							$('#bajaFrame1').hide();
                            $('#altaFrame2').show();
                            $('#bajaFrame2').hide();
                            $('#altaFrame3').show();
                            $('#altaFrame4').hide();
                            $('#altaFrame5').hide();
                            $('#fotografiaTitulo').hide();
                            $('#fotografiaTitulo1').hide();
                            $('#fotografiaTitulo2').hide();
                            $('#fotografiaTitulo3').hide();
                            $('#fotografiaTitulo4').hide();
                            $('#fotografiaTitulo5').hide();
							$('#bajaFrame3DF').hide();
							$('#bajaFrame3NLR').hide();
							$('#bajaFrame3CUN').hide();
							$('#bajaFrame3VER').hide();
							$('#bajaFrame3TOL').hide();
							$('#bajaFrame3LAR').hide();
							$('#bajaFrame3QRO').hide();
                            $('#muestraActuales1').hide();
                            $('#muestraActuales2').hide();
					  	}
						  var checkBox1 = document.getElementById("CORREO ELECTRONICO");
							if (checkBox1.checked == true){
									alert ('-- Favor de solicitar con RH el alta de correo -- \n\n                            Gracias!');
									checkBox1.checked = false;
							}
						
					}
					function sistema(){
					  	var checkBox = document.getElementById("INTRANET");
					  	if (checkBox.checked == true){
							$('#bajaFrame1').hide();
                            $('#altaFrame2').show();
                            $('#bajaFrame2').hide();
                            $('#altaFrame3').show();
                            $('#altaFrame4').show();
                            $('#altaFrame5').show();
                            $('#fotografiaTitulo').show();
                            $('#fotografiaTitulo1').show();	
                            $('#fotografiaTitulo2').show();	
                            $('#fotografiaTitulo3').show();	
                            $('#fotografiaTitulo4').show();	
                            $('#fotografiaTitulo5').show();								
							$('#bajaFrame3DF').hide();
							$('#bajaFrame3NLR').hide();
							$('#bajaFrame3CUN').hide();
							$('#bajaFrame3VER').hide();
							$('#bajaFrame3TOL').hide();
							$('#bajaFrame3LAR').hide();
							$('#bajaFrame3QRO').hide();
                            $('#muestraActuales1').hide();
                            $('#muestraActuales2').hide();
					  	} else {
							$('#bajaFrame1').hide();
                            $('#altaFrame2').show();
                            $('#bajaFrame2').hide();
                            $('#altaFrame3').show();
                            $('#altaFrame4').hide();
                            $('#altaFrame5').hide();
                            $('#fotografiaTitulo').hide();
                            $('#fotografiaTitulo1').hide();
                            $('#fotografiaTitulo2').hide();
                            $('#fotografiaTitulo3').hide();
                            $('#fotografiaTitulo4').hide();
                            $('#fotografiaTitulo5').hide();
							$('#bajaFrame3DF').hide();
							$('#bajaFrame3NLR').hide();
							$('#bajaFrame3CUN').hide();
							$('#bajaFrame3VER').hide();
							$('#bajaFrame3TOL').hide();
							$('#bajaFrame3LAR').hide();
							$('#bajaFrame3QRO').hide();
                            $('#muestraActuales1').hide();
                            $('#muestraActuales2').hide();
					  	}
					}

					function validarFormulario() {
						var formulario = document.form;
						if(document.getElementById("INTRANET").checked){
							var todoCorrecto = true;
							if (formulario.rfc.value=='') {
									alert ('RFC no valida');
									todoCorrecto = false;
							}

							if (formulario.archivo.value=='') {
									alert ('Foto necesaria'); 
									todoCorrecto = false;
							}
						}

						if (todoCorrecto == true) {
							return true;
						}else if (todoCorrecto == false){
							return false;
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
				echo "<font>Alta y baja de usuario</font>";
			echo"</td>";
		echo"</tr>";
		echo"<tr>"; 
			echo"<td align='center' valign='top' height='20px'>";
				echo "<table border='0' align='center'>";
					echo "<tr height='20px'>";
						echo "<td valign='middle'>";
							echo "<img src='../../../../Imagenes/ICN_PointMeTo.png' id='banana1' style='display:none;' onclick='showBanana(0);'>";
							echo "<img src='../../../../Imagenes/ICN_PointMeTo.png' id='banana0' style='display:inline-block;' onclick='showBanana(1);'>";
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
		//echo"<tr height='70'> </tr>";
			
	echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
		include("../../../../navegacion_banana.php");
	echo "</table>";
		
	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 
	$fecha = date("Y-m-d");
	echo "<form name='form' onSubmit='return validarFormulario()' action='guardaAltaBaja_Usuario.php?usuario=$usuarioId' method='POST'  enctype='multipart/form-data'>";	
	
	echo "<table border='0' align='center' width='700'>";
	
	echo "<tr>";
		echo "<td width='30'> </td>";
		echo "<td colspan='4' id='iconosTexto2'><b style='font-size:16px;'>Datos iniciales</b></td>";
	echo "</tr>";
	
	echo "<tr>";
		echo "<td width='30'> </td>";
		echo "<td colspan='4' id='titleBlueLineBottom'> </td>";
	echo "</tr>";
	
	
	echo"<tr height='10'> </tr>";
	
	echo "<tr align='left' height='20'>";
		echo "<td width='30'> </td>";
		echo "<td width='20'> </td>";
		echo "<td id='iconosTexto' align='left' colspan='3'>Fecha</td>";
	echo "</tr>";
	
	echo"<tr height='10'> </tr>";
	
	echo"<tr> ";
		echo "<td width='30'> </td>";
		echo "<td width='30'> </td>";
		echo"<td valign='bottom' align='left' colspan='2'>";
			echo "<input type='text' name='fecha' size=10 value='$fecha' readonly></td>";
		echo"</td>";
		echo "<td width='20'> </td>";
	echo"</tr>";
	
	echo"<tr height='20'> </tr>";
	
	
	echo "<tr align='left' height='20'>";
		echo "<td width='30'> </td>";
		echo "<td width='20'> </td>";
		echo "<td id='iconosTexto' align='left' colspan='3'>Grupo</td>";
	echo "</tr>";
	
	echo"<tr height='10'> </tr>";
	
	echo "<tr align='left' height='20' >";
			echo "<td width='30'> </td>";
			echo "<td width='30'> </td>";
			echo "<td id='iconosTexto2' align='left' >";
				echo "<input type='text' name='grupo' style='width:10%;height:23px;' value='GE' readonly>";
				
				echo "<input type='hidden' name='status' value='ASIGNAR'>";
				
			echo "</td>";
	echo"</tr>";
	
	echo"<tr height='20'> </tr>";
	
	echo "<tr align='left' height='20'>";
		echo "<td width='30'> </td>";
		echo "<td width='20'> </td>";
		echo "<td id='iconosTexto' align='left' colspan='3'>Ciudad</td>";
	echo "</tr>";
	
	echo"<tr height='10'> </tr>";
	
	echo "<tr align='left' height='20' >";
			echo "<td width='30'> </td>";
			echo "<td width='30'> </td>";
			echo "<td id='iconosTexto2' align='left' >";
				 opcionesCiudadesAlta( "muestraUsuario()");
			echo "</td>";
	echo"</tr>";
	
	echo"<tr height='20'> </tr>";
	
	echo "<tr align='left' height='20'>";
		echo "<td width='30'> </td>";
		echo "<td width='20'> </td>";
		echo "<td id='iconosTexto' align='left' colspan='1' >Tipo</td>";
		echo "<td id='tipousu' align='left' colspan='1'>Tipo Usuario</td>";
	echo "</tr>";

	echo"<tr height='10'> </tr>";
	
	echo "<tr align='left' height='20' >";
			echo "<td width='30'> </td>";
			echo "<td width='30'> </td>";
			echo "<td id='iconosTexto2' align='left' >";
			echo "<select id='tipoSolicitud' name='tipoSolicitud' onchange='muestraUsuario();' required>";
			echo "<option value=''>Elegir......</option>";
				echo "<option value='ALTA'>Alta</option>";
				echo "<option value='BAJA'>Baja Sistema</option>";
				echo "<option value='BAJA_TOTAL'>Baja total</option>";
			echo "</select>";
			echo "</td>";
			echo "<td id='tipousu1' align='left' >";
			echo "<button onclick='check()' id='tipousu' name='tipousu' value='tipousu' required>Empleado</button>";
			echo "<button onclick='uncheck()' id='tipousu' name='tipousu' value='tipousu' required>Cliente</button>";
			echo "</td>";
	echo"</tr>";
	
	/*echo"<tr height='20'> </tr>"; 

	echo "<tr align='left' height='20'>";
		echo "<td width='30'> </td>";
		echo "<td width='20'> </td>";
		echo "<td id='iconosTexto' align='left' colspan='3'>Tipo Usuario: </td>";
	echo "</tr>";
	
	echo"<tr height='10'> </tr>";
	
	echo "<tr align='left' height='20' >";
			echo "<td width='30'> </td>";
			echo "<td width='30'> </td>";
			echo "<td id='iconosTexto2' align='left' >";
			echo "<button onclick='check()'>Empleado</button>";
			echo "<button onclick='uncheck()'>Cliente</button>";
			echo "</td>";
	echo"</tr>";*/

	echo"<tr height='20'> </tr>";
	
	echo "<tr align='left' height='20' id='altaFrame1' style='display:none;'>";
		echo "<td width='30'> </td>";
		echo "<td width='20'> </td>";
		echo "<td id='iconosTexto' align='left' colspan='3'>Sistema</td>";
	echo "</tr>";
	
	echo"<tr height='10' id='altaFrame2' style='display:none;'> </tr>";
	
	echo "<tr align='left' height='20' id='altaFrame3' style='display:none;'>";
			echo "<td width='30'> </td>";
			echo "<td width='30'> </td>";
			echo "<td id='iconosTexto2' align='left' >";
			$l= $INTRANET->Execute("SELECT DISTINCT xt_sistema FROM PERFILES.SISTEMAS WHERE xt_sistema != 'MV y HC'");
			while($i= $l->fetchRow()){
				$sistemaSolicitud = $i[0];
				if($usuarioId == 'Pedro_Moyotl'){
					echo"<input id='".$i[0]."' type='checkbox' onclick='sistema();' name='sistema[]' value='".$i[0]."'>$i[0]<br>";
				}else {
					echo"<input id='".$i[0]."' type='checkbox' onclick='correo();' name='sistema[]' value='".$i[0]."'>$i[0]<br>";
				}
			}
			echo "</td>";
	echo"</tr>";
	
	echo "<br>";
	echo "<tr align='left' height='20' id='altaFrame4' style='display:none;'>";
		echo "<td width='30'> </td>";
		echo "<td width='20'> </td>";
		echo "<td id='iconosTexto' align='left' colspan='3'>RFC</td>";
	echo "</tr>";


	echo '<tr align="left" height="20" id="altaFrame5" style="display: none;""> 
			<td width="30"> </td>
			<td width="30"> </td>
			<td align="left" colspan="2">
			<input name="rfc" style="width: 400px; height: 20px;" id="rfc" type="text" pattern="^[a-zA-Z]{3,4}[0-9]{6}[-]*[0-9A-Za-z]{3}?$" title="RFC con homoclave">
		</tr>';
		//<textarea name="rfc" style="width: 400px; height: 20px;" id="rfc" required pattern="^[a-zA-Z]{3,4}[0-9]{6}[-]*[0-9A-Za-z]{3}?$" title="RFC con homoclave"></textarea></td>
    echo "<tr align='left' height='20' id='bajaFrame1' style='display:none;'>";
        echo "<td width='30'> </td>";
        echo "<td width='20'> </td>";
        echo "<td id='iconosTexto' align='left' colspan='3'>Usuario</td>";
    echo "</tr>";
    
    echo"<tr height='10' id='bajaFrame2' style='display:none;'> </tr>";

	//lista de usuarios DF
    echo "<tr align='left' height='20' id='bajaFrame3DF' style='display:none;'>";
        echo "<td width='30'> </td>";
        echo "<td width='30'> </td>";
           echo "<td id='iconosTexto2' align='left' >";
		   ?>
            <select name="bajaUsuarios1" id="bajaUsuarios1" onchange="muestraSistemas('CMX');">
            <?php
            echo "<option>Selecciona.......</option>";
     /*  $l= $INTRANET->Execute("SELECT
									IU.xt_nombre,
									IU.kp_usuario
								FROM
									IntranetGEA_USUARIOS IU
								WHERE
									IU.xt_ciudad = 'DF' 
								AND IU.kp_usuario in(SELECT S.xt_usuario FROM PERFILES.SISTEMAS S WHERE S.xt_estatus = 'ACTIVO')
								ORDER BY
									IU.xt_nombre ASC");*/
		$l = $INTRANET->Execute("SELECT
							U.xt_nombre,
							U.xt_usuario							
						FROM
							PERFILES.USUARIOS U 
						WHERE
							U.xt_usuario IN (
						SELECT
							O.xt_usuario 
						FROM
							PERFILES.OFICINAS O,
							PERFILES.SISTEMAS S 
						WHERE
							O.xt_usuario = S.xt_usuario 
						AND
							O.xt_oficina = 'AICM'
						AND
							S.xt_estatus = 'ACTIVO' 
						)
						ORDER BY 
							U.xt_nombre ASC");

        while($i= $l->fetchRow()){
            echo "<option value='".$i[1]."'>".$i[0]."</option>";
        }
           echo "</select>";
        echo "</td>";
    echo"</tr>";
	
	//lista de usuarios NLR
    echo "<tr align='left' height='20' id='bajaFrame3NLR' style='display:none;'>";
        echo "<td width='30'> </td>";
        echo "<td width='30'> </td>";
           echo "<td id='iconosTexto2' align='left' >";
		   ?>
            <select name="bajaUsuarios2" id="bajaUsuarios2" onchange="muestraSistemas('NLR');">
            <?php
            echo "<option>Selecciona.......</option>";
        /*$l= $INTRANET->Execute("SELECT
									IU.xt_nombre,
									IU.kp_usuario
								FROM
									IntranetGEA_USUARIOS IU
								WHERE
									IU.xt_ciudad = 'NLR'
								AND IU.kp_usuario in(SELECT S.xt_usuario FROM PERFILES.SISTEMAS S WHERE S.xt_estatus = 'ACTIVO')
								ORDER BY
									IU.xt_nombre ASC");*/
		$l = $INTRANET->Execute("SELECT
									U.xt_nombre,
									U.xt_usuario							
								FROM
									PERFILES.USUARIOS U 
								WHERE
									U.xt_usuario IN (
								SELECT
									O.xt_usuario 
								FROM
									PERFILES.OFICINAS O,
									PERFILES.SISTEMAS S 
								WHERE
									O.xt_usuario = S.xt_usuario 
								AND
									O.xt_oficina = 'NLRD'
								AND
									S.xt_estatus = 'ACTIVO')
								ORDER BY 
									U.xt_nombre ASC");
        while($i= $l->fetchRow()){
            echo "<option value='".$i[1]."'>".$i[0]."</option>";
        }
           echo "</select>";
        echo "</td>";
    echo"</tr>";
	
	//lista de usuarios CUN
    echo "<tr align='left' height='20' id='bajaFrame3CUN' style='display:none;'>";
        echo "<td width='30'> </td>";
        echo "<td width='30'> </td>";
           echo "<td id='iconosTexto2' align='left' >";
            ?>
			<select name="bajaUsuarios3" id="bajaUsuarios3" onchange="muestraSistemas('CUN');">
            <?php
            echo "<option>Selecciona.......</option>";
        /*$l= $INTRANET->Execute("SELECT
									IU.xt_nombre,
									IU.kp_usuario
								FROM
									IntranetGEA_USUARIOS IU
								WHERE
									IU.xt_ciudad = 'CUN'
								AND IU.kp_usuario in(SELECT S.xt_usuario FROM PERFILES.SISTEMAS S WHERE S.xt_estatus = 'ACTIVO')
								ORDER BY
									IU.xt_nombre ASC");*/
		$l = $INTRANET->Execute("SELECT
									U.xt_nombre,
									U.xt_usuario							
								FROM
									PERFILES.USUARIOS U 
								WHERE
									U.xt_usuario IN (
								SELECT
									O.xt_usuario 
								FROM
									PERFILES.OFICINAS O,
									PERFILES.SISTEMAS S 
								WHERE
									O.xt_usuario = S.xt_usuario 
								AND
									O.xt_oficina = 'CUN'
								AND
									S.xt_estatus = 'ACTIVO')
								ORDER BY 
									U.xt_nombre ASC");
        while($i= $l->fetchRow()){
            echo "<option value='".$i[1]."'>".$i[0]."</option>";
        }
           echo "</select>";
        echo "</td>";
    echo"</tr>";
	
	//lista de usuarios VER
    echo "<tr align='left' height='20' id='bajaFrame3VER' style='display:none;'>";
        echo "<td width='30'> </td>";
        echo "<td width='30'> </td>";
           echo "<td id='iconosTexto2' align='left' >";
		   ?>
            <select name="bajaUsuarios4" id="bajaUsuarios4" onchange="muestraSistemas('VER');">
            <?php
            echo "<option>Selecciona.......</option>";
        /*$l= $INTRANET->Execute("SELECT
									IU.xt_nombre,
									IU.kp_usuario
								FROM
									IntranetGEA_USUARIOS IU
								WHERE
									IU.xt_ciudad = 'VER'
								AND IU.kp_usuario in(SELECT S.xt_usuario FROM PERFILES.SISTEMAS S WHERE S.xt_estatus = 'ACTIVO')
								ORDER BY
									IU.xt_nombre ASC");*/
		$l = $INTRANET->Execute("SELECT
									U.xt_nombre,
									U.xt_usuario							
								FROM
									PERFILES.USUARIOS U 
								WHERE
									U.xt_usuario IN (
								SELECT
									O.xt_usuario 
								FROM
									PERFILES.OFICINAS O,
									PERFILES.SISTEMAS S 
								WHERE
									O.xt_usuario = S.xt_usuario 
								AND
									O.xt_oficina = 'VER'
								AND
									S.xt_estatus = 'ACTIVO')
								ORDER BY 
									U.xt_nombre ASC");
        while($i= $l->fetchRow()){
            echo "<option value='".$i[1]."'>".$i[0]."</option>";
        }
           echo "</select>";
        echo "</td>";
    echo"</tr>";
	
	//lista de usuarios TOL
    echo "<tr align='left' height='20' id='bajaFrame3TOL' style='display:none;'>";
        echo "<td width='30'> </td>";
        echo "<td width='30'> </td>";
           echo "<td id='iconosTexto2' align='left' >";
		   ?>
           <select name="bajaUsuarios5" id="bajaUsuarios5" onchange="muestraSistemas('TOL');">
            <?php
            echo "<option>Selecciona.......</option>";
        /*$l= $INTRANET->Execute("SELECT
									IU.xt_nombre,
									IU.kp_usuario
								FROM
									IntranetGEA_USUARIOS IU
								WHERE
									IU.xt_ciudad = 'TOL'
								AND IU.kp_usuario in(SELECT S.xt_usuario FROM PERFILES.SISTEMAS S WHERE S.xt_estatus = 'ACTIVO')
								ORDER BY
									IU.xt_nombre ASC");*/
		$l = $INTRANET->Execute("SELECT
									U.xt_nombre,
									U.xt_usuario							
								FROM
									PERFILES.USUARIOS U 
								WHERE
									U.xt_usuario IN (
								SELECT
									O.xt_usuario 
								FROM
									PERFILES.OFICINAS O,
									PERFILES.SISTEMAS S 
								WHERE
									O.xt_usuario = S.xt_usuario 
								AND
									O.xt_oficina = 'TOL'
								AND
									S.xt_estatus = 'ACTIVO')
								ORDER BY 
									U.xt_nombre ASC");
        while($i= $l->fetchRow()){
            echo "<option value='".$i[1]."'>".$i[0]."</option>";
        }
           echo "</select>";
        echo "</td>";
    echo"</tr>";
	
	//lista de usuarios LAR
    echo "<tr align='left' height='20' id='bajaFrame3LAR'  style='display:none;'>";
        echo "<td width='30'> </td>";
        echo "<td width='30'> </td>";
           echo "<td id='iconosTexto2' align='left' >";
            ?>
            <select name="bajaUsuarios6" id="bajaUsuarios6" onchange="muestraSistemas('LAR');">
            <?php
            echo "<option>Selecciona.......</option>";
        /*$l= $INTRANET->Execute("SELECT
									IU.xt_nombre,
									IU.kp_usuario
								FROM
									IntranetGEA_USUARIOS IU
								WHERE
									IU.xt_ciudad = 'LAR'
								AND IU.kp_usuario in(SELECT S.xt_usuario FROM PERFILES.SISTEMAS S WHERE S.xt_estatus = 'ACTIVO')
								ORDER BY
									IU.xt_nombre ASC");*/
		$l = $INTRANET->Execute("SELECT
									U.xt_nombre,
									U.xt_usuario							
								FROM
									PERFILES.USUARIOS U 
								WHERE
									U.xt_usuario IN (
								SELECT
									O.xt_usuario 
								FROM
									PERFILES.OFICINAS O,
									PERFILES.SISTEMAS S 
								WHERE
									O.xt_usuario = S.xt_usuario 
								AND
									O.xt_oficina = 'LRD'
								AND
									S.xt_estatus = 'ACTIVO')
								ORDER BY 
									U.xt_nombre ASC");
        while($i= $l->fetchRow()){
            echo "<option value='".$i[1]."'>".$i[0]."</option>";
        }
           echo "</select>";
        echo "</td>";
    echo"</tr>";
	
	//lista de usuarios QRO
    echo "<tr align='left' height='20' id='bajaFrame3QRO'  style='display:none;'>";
        echo "<td width='30'> </td>";
        echo "<td width='30'> </td>";
           echo "<td id='iconosTexto2' align='left' >";
            ?>
            <select name="bajaUsuarios7" id="bajaUsuarios7" onchange="muestraSistemas('QRO');">
            <?php
            echo "<option>Selecciona.......</option>";
        /*$l= $INTRANET->Execute("SELECT
									IU.xt_nombre,
									IU.kp_usuario
								FROM
									IntranetGEA_USUARIOS IU
								WHERE
									IU.xt_ciudad = 'LAR'
								AND IU.kp_usuario in(SELECT S.xt_usuario FROM PERFILES.SISTEMAS S WHERE S.xt_estatus = 'ACTIVO')
								ORDER BY
									IU.xt_nombre ASC");*/
		$l = $INTRANET->Execute("SELECT
									U.xt_nombre,
									U.xt_usuario							
								FROM
									PERFILES.USUARIOS U 
								WHERE
									U.xt_usuario IN (
								SELECT
									O.xt_usuario 
								FROM
									PERFILES.OFICINAS O,
									PERFILES.SISTEMAS S 
								WHERE
									O.xt_usuario = S.xt_usuario 
								AND
									O.xt_oficina = 'QRO'
								AND
									S.xt_estatus = 'ACTIVO')
								ORDER BY 
									U.xt_nombre ASC");
        while($i= $l->fetchRow()){
            echo "<option value='".$i[1]."'>".$i[0]."</option>";
        }
           echo "</select>";
        echo "</td>";
    echo"</tr>";

    echo"<tr height='10' id='muestraActuales1' style='display:none;'> </tr>";
	echo "<tr id='muestraActuales2' style='display:none,'></tr>";
	echo"<tr height='20'> </tr>";
										  
	
	echo "<tr align='left' height='20'>";
		echo "<td width='30'> </td>";
		echo "<td width='20'> </td>";
		echo "<td id='iconosTexto' align='left' colspan='3'>Titulo</td>";
	echo "</tr>";
	
	echo"<tr height='10'> </tr>";
	
	echo"<tr> ";
		echo "<td width='30'> </td>";
		echo "<td width='30'> </td>";
		echo"<td valign='bottom' align='left' colspan='2'>";
			echo"<textarea name='titulo' style='width: 400px; height: 20px;' id='titulo' required></textarea>";
		echo"</td>";
		echo "<td width='20'> </td>";
	echo"</tr>";
	
	echo"<tr height='20'> </tr>";
	
	echo "<tr align='left' height='20'>";
		echo "<td width='30'> </td>";
		echo "<td width='20'> </td>";
		echo "<td id='iconosTexto' align='left' colspan='3'>Descripcion del Requerimiento</td>";
	echo "</tr>";					
	
	echo"<tr height='10'> </tr>";
	
	echo"<tr> ";
		echo "<td width='30'> </td>";
		echo "<td width='30'> </td>";
		echo"<td valign='bottom' align='left' colspan='2'>";
			echo"<textarea name='descripcion'  id = 'descripcion' placeholder='Nombre completo, correo, perfil' style='width: 400px; height: 80px;' id='descripcion' required></textarea>";
		echo"</td>";
		echo "<td width='20'> </td>";
	echo"</tr>";

	echo"<tr height='20'> </tr>";

	//Fotografia
			echo "<tr align='left' height='20' id = 'fotografiaTitulo'>";
				echo "<td width='30'> </td>";
				echo "<td width='20'> </td>";
				echo "<td id='iconosTexto2' align='left' colspan='3'>Fotografia</td>";
			echo "</tr>";		

				echo "<tr width='50' id = 'fotografiaTitulo1'>";
				echo "<td width='50'> </td>";
				echo "<td width='50'> </td>";
				echo "<td width='50'colspan='4' id='titleBlueLineBottomAlta'> </td>";
			echo "</tr>";

			echo"<tr height='10' id = 'fotografiaTitulo2'> </tr>";

			echo"<tr id = 'fotografiaTitulo3'> ";
				echo "<td width='30'> </td>";
				echo "<td width='30'> </td>";
				echo"<td valign='bottom' align='left' colspan='2'>";
					echo "<input id='FileCron' accept='image/*' type='file' name='archivo'>";
				echo"</td>";
				echo "<td width='20'> </td>";
			echo"</tr>";

			echo"<tr height='10' id = 'fotografiaTitulo4'> </tr>";

			echo "<tr width='50' id = 'fotografiaTitulo5'>";
				echo "<td width='50'> </td>";
				echo "<td width='50'> </td>";
				echo "<td width='50'colspan='4' id='titleBlueLineBottomAlta'> </td>";
			echo "</tr>";

			echo"<tr height='30'> </tr>";

//BOTON ENVIAR
			echo "<tr>";
				echo "<td width='30'> </td>";
				echo "<td colspan='4' id='titleBlueLineBottom'> </td>";
			echo "</tr>";

			  echo"<tr height='40'>";
				  echo "<td width='30'> </td>";
				  echo"<td valign='bottom' align='right' colspan='4'>";
					echo "<input type='image' id='send' onclick='validarFormulario()' src='../../../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
						echo "</input>";
				  echo"</td>";
			  echo"</tr>";

    		  echo"<tr height='20'> </tr>";

	echo "</table>";
	
 	echo "</form>";
echo "</div>";

?>
    	</body>
    </html>
<?php
