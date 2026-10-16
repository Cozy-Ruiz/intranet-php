<?php error_reporting(0); ?>
<?php
$nombrephp = 'altaBaja_Usuario.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("MailSolicitudAsignar.php");


$ciudades[1] = "Distrito Federal";
$ciudades[2] = "Nuevo Laredo";
$ciudades[3] = "Cancún";
$ciudades[4] = "Veracruz";
$ciudades[5] = "Toluca";
$ciudades[6] = "Laredo";

$cdValor[1] = "DF";
$cdValor[2] = "NLR";
$cdValor[3] = "CUN";
$cdValor[4] = "VER";
$cdValor[5] = "TOL";
$cdValor[6] = "LAR";

//obtengo la(s) ciudad del usuario
$indice = 0;
$s = $INTRANET->Execute("SELECT xt_codigoCiudad FROM IntranetGEA_Usuarios_Oficina WHERE kf_usuarioId = '$usuarioId' ORDER BY xt_codigoCiudad ");

while($r = $s->fetchRow()){
	$ciudadesDisponibles[$indice] = $r[0];
	$indice++;
	
} unset($r); unset($s); unset($indice);


//Defino estilo
if($estiloUsuario == 1){
	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
}else if($estiloUsuario == 2){
    echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
}
?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Alta baja Usuario</title> 
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
                    function muestraUsuario(){
                        var tipoSolicitud = document.getElementsByName("tipoSolicitud")[0].value;
						 var ciudad = document.getElementsByName("ciudad")[0].value;
						
                        if(tipoSolicitud == 'ALTA'){

                            $('#altaFrame1').show();
                            $('#bajaFrame1').hide();
                            $('#altaFrame2').show();
                            $('#bajaFrame2').hide();
                            $('#altaFrame3').show();
							$('#bajaFrame3DF').hide();
							$('#bajaFrame3NLR').hide();
							$('#bajaFrame3CUN').hide();
							$('#bajaFrame3VER').hide();
							$('#bajaFrame3TOL').hide();
							$('#bajaFrame3LAR').hide();
                            $('#muestraActuales1').hide();
                            $('#muestraActuales2').hide();
												
							
							
                        }else if(tipoSolicitud == 'BAJA'){
                            $('#altaFrame1').hide();
                            $('#bajaFrame1').show();
                            $('#altaFrame2').hide();
                            $('#bajaFrame2').show();
							
							
							
							if(ciudad == 'DF'){
								
								$('#altaFrame3').hide();
								$('#bajaFrame3NLR').hide();
								$('#bajaFrame3CUN').hide();
								$('#bajaFrame3VER').hide();
								$('#bajaFrame3LAR').hide();
								$('#bajaFrame3TOL').hide();
								
                            	$('#bajaFrame3DF').show();
								
							}
							
							if(ciudad == 'NLR'){
								$('#altaFrame3').hide();
								$('#bajaFrame3DF').hide();
								$('#bajaFrame3CUN').hide();
								$('#bajaFrame3VER').hide();
								$('#bajaFrame3LAR').hide();
								$('#bajaFrame3TOL').hide();
								
                            	$('#bajaFrame3NLR').show();
							}
							
							if(ciudad == 'CUN'){
								$('#altaFrame3').hide();
								$('#bajaFrame3DF').hide();
								$('#bajaFrame3NLR').hide();
								$('#bajaFrame3VER').hide();
								$('#bajaFrame3LAR').hide();
								$('#bajaFrame3TOL').hide();
								
                            	$('#bajaFrame3CUN').show();
							}
							
							if(ciudad == 'VER'){
								$('#altaFrame3').hide();
								$('#bajaFrame3DF').hide();
								$('#bajaFrame3NLR').hide();
								$('#bajaFrame3CUN').hide();
								$('#bajaFrame3LAR').hide();
								$('#bajaFrame3TOL').hide();
								
                            	$('#bajaFrame3VER').show();
							
							}
							
							if(ciudad == 'TOL'){
								$('#altaFrame3').hide();
								$('#bajaFrame3DF').hide();
								$('#bajaFrame3NLR').hide();
								$('#bajaFrame3CUN').hide();
								$('#bajaFrame3LAR').hide();
								$('#bajaFrame3VER').hide();
								
                            	$('#bajaFrame3TOL').show();
								
							}
							
							if(ciudad == 'LAR'){
								$('#altaFrame3').hide();
								$('#bajaFrame3DF').hide();
								$('#bajaFrame3NLR').hide();
								$('#bajaFrame3CUN').hide();
								$('#bajaFrame3TOL').hide();
								$('#bajaFrame3VER').hide();
								
                            	$('#bajaFrame3LAR').show();
						
							}
                            
							
                        }
                    }
					
                    function muestraSistemas(tipo){
						
						if(tipo == 'DF'){
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
						
                        jsShowWindowLoad("Cargando Sistemas del Usuario");
                        $.post('muestraSistemasUsuario1.php',{nombre : nombre},function (data){
                          
                            $('muestraActuales1').show();
                            $('muestraActuales2').show();
                            $('#altaFrame1').hide();
                            $('#altaFrame2').hide();
                            $('#altaFrame3').hide();
                            $("#muestraActuales2").html(data);
                            var nombreUsuario = $('input:hidden[name=nombreUsuario]').val();
                            var correoUsuario = $('input:hidden[name=correoUsuario]').val();
                            document.getElementById("titulo").value="Baja de Sistemas";
                            document.getElementById("descripcion").value=nombreUsuario + "," + correoUsuario;
                            jsRemoveWindowLoad();
                        });
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
			<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/solicitudesBacklog/tableroSolicitudesyQuejasv2.php' id='breadcrumbs'> Solicitudes </a>";
			
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
				
	
				//echo "<a href='$archivo' >Archivo</a>";
			
				?>
					<table border='0' align='center' id='breadcrumbs' style='border:1px solid #007cbd;'>
                        <tr>
                            <td valign='top'>
                                <a href='../../ComunicacionInterna/comunicacionInterna.php' id='breadcrumbs'>
                                    Comunicación Interna
                                </a><br />
                                
                                <ul style='list-style-type:square;'>
                                    <li>
                                        <a href='../../ComunicacionInterna/TableroBoletines.php' id='breadcrumbs'>
                                            Boletines
                                        </a>
                                    </li>
                                    <li>
                                        <a href='../../ComunicacionInterna/listaQueHacer.php' id='breadcrumbs'>
                                            Qué hacer
                                        </a>
                                    </li>
                                    <li>
                                        <a href='../../ComunicacionInterna/tableroSolicitudesyQuejas.php' id='breadcrumbs'>
                                            Solicitudes y Quejas
                                        </a>
                                    </li>
                                    <li>
                                        <a href='../../ComunicacionInterna/busquedaPersonal.php' id='breadcrumbs'>
                                            Acceso Autorizado
                                        </a>
                                    </li>
                                </ul>
                            
                            </td>
                        </tr>
                        <tr>
                            <td valign='top'>
                                <a href='../../SistemaGestionIntegral/homeSGI.php' id='breadcrumbs'>
                                    Gestión Integral
                                </a><br />
                                
                                <ul style='list-style-type:square;'>
                                    <li>
                                        <a href='../../SistemaGestionIntegral/Normas.php' id='breadcrumbs'>
                                            Normas
                                        </a><br />
                                        
                                        <ul style='list-style-type: disc;'>
                                            <li>
                                                <a href='../../SistemaGestionIntegral/CapituloNorma.php?norma=ISO' id='breadcrumbs'>
                                                    ISO
                                                </a>
                                            </li>
                                            <li>
                                                <a href='../../SistemaGestionIntegral/CapituloNorma.php?norma=NMX' id='breadcrumbs'>
                                                    NMX
                                                </a>
                                            </li>
                                            <li>
                                                <a href='../../SistemaGestionIntegral/CapituloNorma.php?norma=NEEC' id='breadcrumbs'>
                                                    NEEC
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href='../../SistemaGestionIntegral/manuales.php' id='breadcrumbs'>
                                            Manuales
                                        </a><br />
                                        
                                        <ul style='list-style-type: disc;'>
                                            <li>
                                                <a href='../../SistemaGestionIntegral/Documento.php?manual=GE-MC' id='breadcrumbs'>
                                                    Manual de Gestión Integral
                                                </a>
                                            </li>
                                            <li>
                                                <a href='../../SistemaGestionIntegral/Documento.php?manual=GE-CDR' id='breadcrumbs'>
                                                    Manual de Control de Documentos y Registros
                                                </a>
                                            </li>
                                            <li>
                                                <a href='../../SistemaGestionIntegral/Documento.php?manual=GE-AI' id='breadcrumbs'>
                                                    Manual de Auditorías Internas
                                                </a>
                                            </li>
                                            <li>
                                                <a href='../../SistemaGestionIntegral/Documento.php?manual=GE-CC' id='breadcrumbs'>
                                                    Manual del Comité de Calidad
                                                </a>
                                            </li>
                                            <li>
                                                <a href='../../SistemaGestionIntegral/Documento.php?manual=GE-DG' id='breadcrumbs'>
                                                    Manual de Dirección General
                                                </a>
                                            </li>
                                            <li>
                                                <a href='../../SistemaGestionIntegral/Documento.php?manual=GE-ADM' id='breadcrumbs'>
                                                    Manual de Administración
                                                </a>
                                            </li>
                                            <li>
                                                <a href='../../SistemaGestionIntegral/Documento.php?manual=GE-RH' id='breadcrumbs'>
                                                    Manual de Recursos Humanos
                                                </a>
                                            </li>
                                            <li>
                                                <a href='../../SistemaGestionIntegral/Documento.php?manual=GE-TI' id='breadcrumbs'>
                                                    Manual de Tecnologias de la Información
                                                </a>
                                            </li>
                                            <li>
                                                <a href='../../SistemaGestionIntegral/Documento.php?manual=GE-OPE' id='breadcrumbs'>
                                                    Manual de Operaciones
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href='../../SistemaGestionIntegral/Modulos.php' id='breadcrumbs'>
                                            Módulos del SGI
                                        </a><br />
                                        
                                        <ul style='list-style-type: disc;'>
                                            <li>
                                                <a href='../../SistemaGestionIntegral/Riesgos.php' id='breadcrumbs'>
                                                    Administración de Riesgos
                                                </a>
                                            </li>
                                            <li>

                                                <a href='../../SistemaGestionIntegral/ReunionesyAcuerdos.php' id='breadcrumbs'>
                                                    Reuniones y Acuerdos
                                                </a>
                                            </li>
                                            <li>
                                                <a href='../../SistemaGestionIntegral/tableroPreventivasCorrectivas.php' id='breadcrumbs'>
                                                    Acciones Preventivas y Correctivas
                                                </a>
                                            </li>
                                            <li>
                                                <a href='../../SistemaGestionIntegral/tableroAuditorias.php' id='breadcrumbs'>
                                                    Auditorías
                                                </a>
                                            </li>
                                            <!-- -->
                                            <li>
                                                <a href='../../SistemaGestionIntegral/Procesos.php' id='breadcrumbs'>
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
                                <a href='../../Aplicaciones/aplicaciones.php' id='breadcrumbs'>
                                    Aplicaciones
                                </a><br />
                                
                                <ul style='list-style-type:square;'>
                                    <li>
                                        <a href='../../Aplicaciones/operaciones.php' id='breadcrumbs'>
                                            Operaciones
                                        </a>
                                    </li>
                                    <li>
                                        <a href='../../AdministracionProyectos/admonPro.php' id='breadcrumbs'>
                                            Administración de Proyectos
                                        </a>
                                    </li>
                                </ul>
                                
                            </td>
                        </tr>
                        <tr>
                            <td valign='top'>
                                <a href='../../Registros/Registros.php' id='breadcrumbs'>
                                    Registros
                                </a><br />
                                
                                <ul style='list-style-type:square;'>
                                    <li>
                                        <a href='../../Registros/TableroVisitas2.php' id='breadcrumbs'>
                                            Visitas
                                        </a>
                                    </li>
                                </ul>
                                
                            </td>
                        </tr>
                        <tr>
                            <td valign='top'>
                                <a href='../../Configuraciones/configuraciones.php' id='breadcrumbs'>
                                    Configuraciones
                                </a><br />
                                
                                <ul style='list-style-type:square;'>
                                    <li>
                                        <a href='../../Configuraciones/ModificaPassword.php' id='breadcrumbs'>
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
	$fecha = date("Y-m-d");
	echo "<form name='form' action='guardaAltaBaja_Usuario1.php?usuario=$usuarioId' method='POST'  enctype='multipart/form-data'>";	
	
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
			//echo "<input type='text' class='DatP' size=10 maxlength=10 name='fecha' required>";
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
				echo "<select name='ciudad' id= 'ciudad' onchange='muestraUsuario();' required>";
							echo "<option value='' selected='selected'>Elegir...</option>";	
							
							for($a = 1; $a <= 6; $a++){
								
								if(in_array($cdValor[$a], $ciudadesDisponibles)){
									
									echo "<option value='".$cdValor[$a]."'>".$ciudades[$a]."</option>";	
									
								}
								
							} unset($a);
							
						echo "</select>";

				
			echo "</td>";
	echo"</tr>";
	
	echo"<tr height='20'> </tr>";
	
	echo "<tr align='left' height='20'>";
		echo "<td width='30'> </td>";
		echo "<td width='20'> </td>";
		echo "<td id='iconosTexto' align='left' colspan='3'>Tipo</td>";
	echo "</tr>";
	
	echo"<tr height='10'> </tr>";
	
	echo "<tr align='left' height='20' >";
			echo "<td width='30'> </td>";
			echo "<td width='30'> </td>";
			echo "<td id='iconosTexto2' align='left' >";
			echo "<select name='tipoSolicitud' onchange='muestraUsuario();' required>";
					echo "<option value=''>Elegir......</option>";
						echo "<option value='ALTA'>Alta</option>";
						echo "<option value='BAJA'>Baja</option>";
				echo "</select>";
			echo "</td>";
	echo"</tr>";
	
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
			$l= $INTRANET->Execute("SELECT DISTINCT xt_sistema FROM PERFILES.SISTEMAS");
			while($i= $l->fetchRow()){
				if($i[0] == 'INTRANET' or $i[0] == 'BACKLOG'){
					echo"<input type='checkbox' name='sistema[]' value='".$i[0]."' checked='true'>$i[0]<br>";
				}else{
					echo"<input type='checkbox' name='sistema[]' value='".$i[0]."'>$i[0]<br>";
				}
			}
			echo "</td>";
	echo"</tr>";

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
            <select name="bajaUsuarios1" id="bajaUsuarios1" onchange="muestraSistemas('DF');">
            <?php
            echo "<option>Selecciona.......</option>";
        $l= $INTRANET->Execute("SELECT xt_nombre, kp_usuario FROM IntranetGEA_USUARIOS WHERE xt_ciudad = 'DF' ORDER BY xt_nombre ASC");
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
        $l= $INTRANET->Execute("SELECT xt_nombre, kp_usuario FROM IntranetGEA_USUARIOS WHERE xt_ciudad = 'NLR' ORDER BY xt_nombre ASC");
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
        $l= $INTRANET->Execute("SELECT xt_nombre, kp_usuario FROM IntranetGEA_USUARIOS WHERE xt_ciudad = 'CUN' ORDER BY xt_nombre ASC");
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
        $l= $INTRANET->Execute("SELECT xt_nombre, kp_usuario FROM IntranetGEA_USUARIOS WHERE xt_ciudad = 'VER' ORDER BY xt_nombre ASC");
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
        $l= $INTRANET->Execute("SELECT xt_nombre, kp_usuario FROM IntranetGEA_USUARIOS WHERE xt_ciudad = 'TOL' ORDER BY xt_nombre ASC");
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
        $l= $INTRANET->Execute("SELECT xt_nombre, kp_usuario FROM IntranetGEA_USUARIOS WHERE xt_ciudad = 'LAR' ORDER BY xt_nombre ASC");
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
	
	echo "<tr align='left' height='20'>";
		echo "<td width='30'> </td>";
		echo "<td width='20'> </td>";
		echo "<td id='iconosTexto2' align='left' colspan='3'>Fotografia</td>";
	echo "</tr>";		
	
		echo "<tr width='50'>";
		echo "<td width='50'> </td>";
		echo "<td width='50'> </td>";
		echo "<td width='50'colspan='4' id='titleBlueLineBottomAlta'> </td>";
	echo "</tr>";
	
	echo"<tr height='10'> </tr>";
	
	echo"<tr> ";
		echo "<td width='30'> </td>";
		echo "<td width='30'> </td>";
		echo"<td valign='bottom' align='left' colspan='2'>";
			echo "<input id='FileCron' type='file'  name='archivo'>";
		echo"</td>";
		echo "<td width='20'> </td>";
	echo"</tr>";
	
	echo"<tr height='10'> </tr>";
	
	echo "<tr width='50'>";
		echo "<td width='50'> </td>";
		echo "<td width='50'> </td>";
		echo "<td width='50'colspan='4' id='titleBlueLineBottomAlta'> </td>";
	echo "</tr>";
	
	echo"<tr height='30'> </tr>";
	
	echo "<tr>";
		echo "<td width='30'> </td>";
		echo "<td colspan='4' id='titleBlueLineBottom'> </td>";
	echo "</tr>";
	
						
	  echo"<tr height='40'>";
		  echo "<td width='30'> </td>";
		  echo"<td valign='bottom' align='right' colspan='4'>";
			echo "<input type='image' id='send' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
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

/*if(isset($_POST['Enviar'])){
	$fecha         = $_POST['fecha'];
	$grupo         = $_POST['grupo'];
	$ciudad        = $_POST['ciudad'];
	$titulo        = $_POST['titulo'];
	$descripcion   = $_POST['descripcion'];
	$sistema       = $_POST['sistema'];
	$tipoSolicitud = $_POST['tipoSolicitud'];
	$asignaPDR     = 'Alberto_Martinez';  
	
	$anio   = date('Y', strtotime($_POST['fecha']));
	$maximo = 0;
	
	$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Quejas_Solicitudesv2 WHERE YEAR(xd_fecha) = $anio AND xt_tipo = 'B' 
							 AND xt_ciudad = '$ciudad' AND xt_grupo = '$grupo' ");
	
	while($r = $s->fetchRow()){	
		$maximo = $r[0];	
	} unset($r); unset($s);
	
	$maximo++;
	$año   = date('y', strtotime($_POST['fecha']));
	
	if(strlen($maximo) == 1){
		$codigo = $codigo."-00".$maximo;
	}else if(strlen($maximo) == 2){		
		$codigo = $codigo."-0".$maximo;		
	}else if(strlen($maximo) >= 3){		
		$codigo = $codigo."-".$maximo;		
	}
	//Se crea codigo para la Solicitud
	 $codigoSolicitud = $grupo."-"."B"."-".$ciudad."-".$año.$codigo;
	 
	 if($INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudesv2(xt_tipoSolicitud, xt_tipo, xt_ciudad, xn_numero, xd_fecha, xt_quejaSolicitud, xt_titulo, xt_descripcion, kf_usuarioId, xt_grupo, xt_status, xt_pdr) VALUES('AB', 'B', '$ciudad', $maximo, '$fecha', '$codigoSolicitud', '$titulo', '$descripcion', '$usuarioId', '$grupo', 'ASIGNADA','$asignaPDR') ")){
														   
	 foreach($sistema as $sistemas) {
   		// echo"INSERT INTO SGI_Backlog_Ubicacion (xt_quejaSolicitud, xt_sistema) VALUES ('$codigoSolicitud','$sistemas') ";
		 $INTRANET->Execute("INSERT INTO SGI_Backlog_Solicitud_Sistemas_Temporal (xt_quejaSolicitud, xt_sistema, xt_tipo) VALUES ('$codigoSolicitud','$sistemas', '$tipoSolicitud') ");
	 }
	 //Envia a correo al PDR y Solicitante
	 
	if($INTRANET->Execute("INSERT INTO SGI_Quejas_Solicitudes_Estatusv2 (xt_quejaSolicitud, xn_numero, xt_estatus, xd_fecha, kf_usuario) VALUES('$codigoSolicitud', 1, 'ASIGNADA', '$fecha', '$usuarioId') ")){
													
		$correoPDRMail = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$asignaPDR' ");
		$nombrePDRMail = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '$asignaPDR' ");
		
		$correoSolicitante = $INTRANET->getOne("SELECT IUS.xt_correo FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '".$usuarioId."' ");
	    $nombreSolicitante = $INTRANET->getOne("SELECT IUS.xt_nombre FROM IntranetGEA_USUARIOS IUS WHERE IUS.kp_usuario = '".$usuarioId."' ");

		if(($correoPDRMail != "") && ($nombrePDRMail != "")){
				
			new MailSolicitudAsignar($codigoSolicitud, $correoPDRMail, $nombrePDRMail, $correoSolicitante, $nombreSolicitante, $titulo, $descripcion);
		
		 }
	
			echo"<script language='javascript'>window.location='fichaAltaBajaUsuario.php?codigo=".urlencode($codigoSolicitud)."'</script>;";	
	} else{
					
					?>
					 <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
					<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
					<script type="text/javascript" src="JS/jquery-1.6.2.min.js"></script>
					<script type="text/javascript" src="JS/jquery-ui-1.8.16.custom.min.js"></script>
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
				</head>
				<body>
			<?php
					
					echo "<div id='wrapper'>";
						echo "<table border='0' align='center'>";
							echo"<tr>"; 
								echo"<td align='center'>";
									echo $breadcrumb;
								echo"</td>";
							echo"</tr>";
							
							echo"<tr height='70'><td></td></tr>";
							
							echo"<tr>";
								echo"<td align='center' id='titulo1'>";
									echo "Error en la carga";
								echo"</td>";
							echo"</tr>";
						echo "</table>";
					echo "</div>";
			}
		}
*/
?>
    	</body>
    </html>
<?php
