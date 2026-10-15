<?php

$nombrephp = 'fichaRiesgo.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
//require_once("../../ConexionIntranet2.php");
 error_reporting(E_PARSE);

$breadcrumb = "<a href='../../Home.php' id='breadcrumbs'> Home / </a><a href='../homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			   <a href='../Modulos.php' id='breadcrumbs'> Módulos / </a><a href='../Riesgos.php' id='breadcrumbs'> Riesgos / </a>
			   <a href='tableroRiesgosv2.php' id='breadcrumbs'> Tablero de Riesgos </a>";

$idRiesgo = $_GET['id'];

$probabValue[0] = "Nula";
$probabValue[1] = "Muy Baja";
$probabValue[2] = "Baja";
$probabValue[3] = "Media";
$probabValue[4] = "Alta";
$probabValue[5] = "Muy Alta";

$categoriaIValue[1] = "Operacionales";
$categoriaIValue[2] = "Personales";
$categoriaIValue[3] = "Organización";
$categoriaIValue[4] = "Estratégicos";

$categoriaEValue[1] = "Catástofres naturales";
$categoriaEValue[2] = "Políticos";
$categoriaEValue[3] = "Legales";
$categoriaEValue[4] = "Mercado";
$categoriaEValue[5] = "Económicos";
$categoriaEValue[6] = "Entorno";


$s = $INTRANETV2->Execute("SELECT xt_tituloRiesgo, xt_descripcion, xn_probabilidad, xd_fecha, xt_codigoRiesgo, xt_categoriaOpcion, xn_categoria, 
						xt_estrategia, xn_impacto, xt_amenaza, xn_proteccion, xt_vulnerabilidad, xt_descripcionEstrategia, xt_descripcionPreventiva, xt_descripcionEmergencia, xt_ciudad FROM SGI_Riesgos WHERE xt_codigoRiesgo = '$idRiesgo' ");

while($r= $s->fetchRow()){
	
	$tituloRiesgo 		= $r[0];
	$descripcionRiesgo 	= nl2br($r[1]);
	$probabilidad 		= $r[2];
	$fecha 				= $r[3];
	$codigo 			= $r[4];
	$categoriaOpcion 	= $r[5];
	$estrategia 		= $r[7];
	$impacto 			= $r[8];
	$amenaza 			= $r[9];
	$proteccion 		= $r[10];
	$vulnerabilidad 	= $r[11];
	$descripcionEst		= $r[12];
	$descripcionPreven	= nl2br($r[13]);
	$descripcionEmerg	= nl2br($r[14]);
	$ciudad             = $r[15];
	
	$fechaCambio = $INTRANET->getOne("SELECT MAX(xd_fechaCambio) FROM SGI_Control_Cambios_Riesgos WHERE kf_riesgoId=$idRiesgo ");
	
	if($probabilidad != ""){
		
		$probabilidadDesc = $probabValue[$probabilidad];
		
	}
	
	$descripcionProbabilidad = $INTRANETV2->getOne("SELECT xt_descripcionProbabilidadRiesgo FROM SGI_Nivel_Riesgos 
												  WHERE xn_probabilidadRiesgo = $probabilidad ");
	
	//CHECAR
	$fechaCambio = $INTRANET->getOne("SELECT MAX(xd_fechaCambio) FROM SGI_Control_Cambios_Riesgos WHERE kf_riesgoId=$idRiesgo ");
	
	if($fechaCambio == ""){
		
		$fechaCambio = $r[3];
		
	}else{
		
		$tempo = $INTRANET->getOne("SELECT MAX(xd_fechaCambio) FROM SGI_Control_Cambios_Riesgos WHERE kf_riesgoId = $idRiesgo ");
		
		$fechaCambio=date("Y-m-d", strtotime($tempo));
		
	}
	
	

	if($categoriaOpcion == 'Interno'){
		
		$categoria = $r[6];
		$categoria = $categoriaIValue[$categoria];
		
	}else if($categoriaOpcion == 'Externo'){
		
		$categoria = $r[6];
		$categoria = $categoriaEValue[$categoria];
		
	}
	
	if($impacto != ""){
		
		$impactoDespliegue = $probabValue[$impacto];
		
	}
	
	if($proteccion != ""){
		
		$proteccionDespliegue = $probabValue[$proteccion];
		
	}
	
	$descripcionImpacto 	= $INTRANETV2->getOne("SELECT xt_descripcionImpactoRiesgo FROM SGI_Nivel_Riesgos WHERE xn_impactoRiesgo = $impacto ");
	$descripcionProteccion 	= $INTRANETV2->getOne("SELECT xt_descripcionProteccionRiesgo FROM SGI_Nivel_Riesgos WHERE xn_proteccionRiesgo = $proteccion ");

	$s = $INTRANETV2->Execute("SELECT * from SGI_Riesgos_Consecuencias  where xt_codigoRiesgo = '$idRiesgo' ");

while($r= $s->fetchRow()){
	$rTiempo 		= $r[1];
	$rEconomico 	= $r[2];
	$rHumano 		= $r[3];
	$rOperacional	= $r[4];
	$rImagen 		= $r[5];
	$rInformacion 	= $r[6];
	if ($rTiempo != "0")
	{ 
		$descripcionConsecuencia.= $INTRANETV2->getOne("SELECT xt_descripcion FROM SGI_Riesgos_Consecuencias_Catalgo WHERE xn_impacto  = '$rTiempo' ")."; ";
	}
	if ($rEconomico != "0")
	{ 
		$descripcionConsecuencia.= $INTRANETV2->getOne("SELECT xt_descripcion FROM SGI_Riesgos_Consecuencias_Catalgo WHERE xn_impacto  = '$rEconomico' ")."; ";
	}
	if ($rHumano != "0")
	{ 
		$descripcionConsecuencia.= $INTRANETV2->getOne("SELECT xt_descripcion FROM SGI_Riesgos_Consecuencias_Catalgo WHERE xn_impacto  = '$rHumano' ")."; ";
	}
	if ($rOperacional != "0")
	{ 
		$descripcionConsecuencia.= $INTRANETV2->getOne("SELECT xt_descripcion FROM SGI_Riesgos_Consecuencias_Catalgo WHERE xn_impacto  = '$rOperacional' ")."; ";
	}
	if ($rImagen != "0")
	{ 
		$descripcionConsecuencia.= $INTRANETV2->getOne("SELECT xt_descripcion FROM SGI_Riesgos_Consecuencias_Catalgo WHERE xn_impacto  = '$rImagen' ")."; ";
	}
	if ($rInformacion != "0")
	{ 
		$descripcionConsecuencia.= $INTRANETV2->getOne("SELECT xt_descripcion FROM SGI_Riesgos_Consecuencias_Catalgo WHERE xn_impacto  = '$rInformacion' ")."; ";
	}
	 

	
	}
	
}unset($r);

$s1 = $INTRANETV2->Execute("SELECT DATE_FORMAT(MAX(xd_fechaCambio),'%d-%m-%Y') FROM SGI_Riesgos_Control_Cambios WHERE xt_codigoRiesgo = '$codigo'");
			
			while($u1 = $s1->fetchRow()){
				
				$cambioFech = $u1[0];
				
			}
//CHECAR
$s = $INTRANETV2->Execute("SELECT xn_numero FROM SGI_Riesgos_Control_Cambios WHERE xt_codigoRiesgo = '$codigo'");
			
			while($u = $s->fetchRow()){
				
				$versionControl 	= $u[0];
				
			}unset($s);unset($u);
			
//INSERCION DE LA DESCRIPCION DEL PLAN DE PREVENCION
//echo"".$_POST['descripcionPrevencion']."";

if($_POST['descripcionPrevencion'] != ""){
	
	$descripcionUpdatePreven = $_POST['descripcionPrevencion'];
	$INTRANETV2->Execute("UPDATE SGI_Riesgos SET xt_descripcionPreventiva = '$descripcionUpdatePreven' WHERE xt_codigoRiesgo = '$idRiesgo'");
	
	header("Location: fichaRiesgov2.php?id=$idRiesgo");
}

//INSERCION DE LA DESCRIPCION DEL PLAN DE EMERGENCIA

if($_POST['descripcionEmergencias'] != ""){
	
	$descripcionUpdateEmer = $_POST['descripcionEmergencias'];
	$INTRANETV2->Execute("UPDATE SGI_Riesgos SET xt_descripcionEmergencia = '$descripcionUpdateEmer' WHERE xt_codigoRiesgo = '$idRiesgo'");
	
	header("Location: fichaRiesgov2.php?id=$idRiesgo");
}

////INSERCION DE UN CODIGO DOCUMENTO PREVENTIVO PARA UN PLAN DE TRATAMIENTO
if($_POST['codigoPREV'] != ""){
	
	$codigoInsert 	= $_POST['codigoPREV'];
	$validarTipoDoc = substr($codigoInsert, 0, 1);
	if($validarTipoDoc == 'F'){
		
		$validarTipoDoc = 'F';
		
	}else{
		
		$validarTipoDoc = 'D';
	}
	//$idInsert 		= $idRiesgo;
	$tituloInsert 	= "Se tratará con el siguiente item";
	$fechaInsert 	= date("Y-m-d");
	
	//CHECAR NUEVA TABLA
	
	$s = $INTRANETV2->Execute("SELECT MAX(xn_numero) FROM SGI_Riesgos_Documentos WHERE xt_codigoRiesgo = '$idRiesgo'");

	while($r = $s->fetchRow()){
		
		$maximo = $r[0];
		
	} unset($r); unset($s);
	
	$maximo++;
	
	//echo"SELECT kp_itemID FROM SGI_Item WHERE xt_codigo = '$codigoInsert' <br><br>";
	//$idItem = $INTRANET->getOne("SELECT kp_itemID FROM SGI_Item WHERE xt_codigo = '$codigoInsert' ");
	
	//echo"INSERT INTO SGI_Acciones_Riesgos (kf_riesgoId, xn_numero, xd_fecha, xt_titulo, xt_tipoTratamiento, xt_tipo, xt_etiqueta) 
		//										  VALUES ($idRiesgo, $maximo, '$fechaInsert', '$tituloInsert', '$idItem', 'ITEM', 'PREVENCION') <br>";
	$INTRANETV2->Execute("INSERT INTO SGI_Riesgos_Documentos (xt_codigoRiesgo, xn_numero, xt_titulo, xt_codigoDocumento, xt_etiqueta, xt_tipoDocumento, xt_tipo, xd_fecha) VALUES ('$idRiesgo', $maximo, '$tituloInsert', '$codigoInsert', 'PREVENCION', '$validarTipoDoc', 'ITEM', '$fechaInsert') ");
	
	header("Location: fichaRiesgov2.php?id=$idRiesgo");
	
}

//INSERTO DESICION DE SIMULACRO
if($_POST['simulacroDecide'] != ""){

	$decideSimulacro = $_POST['simulacroDecide'];

	$INTRANETV2->Execute("UPDATE SGI_Riesgos SET xt_aplicaSimulacro = '".$decideSimulacro."' WHERE  xt_codigoRiesgo = '".$idRiesgo."'");
	
}


///INSERCION DE UN CODIGO DOCUMENTO DE CONTROL PARA UN PLAN DE EMERGENCIA
if($_POST['codigoCTRL'] != ""){
	
	$codigoInsert 	= $_POST['codigoCTRL'];
	$idInsert 		= $idRiesgo;
	$tituloInsert 	= "Se tratará con el siguiente item";
	$fechaInsert 	= date("Y-m-d");
	
	$s = $INTRANETV2->Execute("SELECT MAX(xn_numero) FROM SGI_Riesgos_Documentos WHERE xt_codigoRiesgo = '$idInsert'");

	while($r = $s->fetchRow()){
		
		$maximo = $r[0];
		
	} unset($r); unset($s);
	
	$maximo++;
	
	
	$validarTipoDoc = substr($codigoInsert, 0, 1);
	if($validarTipoDoc == 'F'){
		
		$validarTipoDoc = 'F';
		
	}else{
		
		$validarTipoDoc = 'D';
	}
	
	//$idItem = $INTRANET->getOne("SELECT kp_itemID FROM SGI_Item WHERE xt_codigo = '$codigoInsert' ");
	
	
	$INTRANETV2->Execute("INSERT INTO SGI_Riesgos_Documentos (xt_codigoRiesgo, xn_numero, xt_titulo, xt_codigoDocumento, xt_etiqueta, xt_tipoDocumento, xt_tipo, xd_fecha) VALUES ('$idRiesgo', $maximo, '$tituloInsert', '$codigoInsert', 'CONTROL', '$validarTipoDoc', 'ITEM', '$fechaInsert')");
	
	header("Location: fichaRiesgov2.php?id=$idRiesgo");
	
}

///INSERCION DE UN CODIGO DOCUMENTO POST-EVENTO PAR AUN PLAN DE EMERGENCIA
if($_POST['codigoPSEVN'] != ""){
	
	$codigoInsert 	= $_POST['codigoPSEVN'];
	$idInsert 		= $idRiesgo;
	$tituloInsert 	= "Se tratará con el siguiente item";
	$fechaInsert 	= date("Y-m-d");

	$s = $INTRANETV2->Execute("SELECT MAX(xn_numero) FROM SGI_Riesgos_Documentos WHERE xt_codigoRiesgo = '$idInsert'");

	while($r = $s->fetchRow()){
		
		$maximo = $r[0];
		
	} unset($r); unset($s);
	
	$maximo++;
	
	
	$validarTipoDoc = substr($codigoInsert, 0, 1);
	if($validarTipoDoc == 'F'){
		
		$validarTipoDoc = 'F';
		
	}else{
		
		$validarTipoDoc = 'D';
	}
	
	//$idItem = $INTRANET->getOne("SELECT kp_itemID FROM SGI_Item WHERE xt_codigo = '$codigoInsert' ");
	
	$INTRANETV2->Execute("INSERT INTO SGI_Riesgos_Documentos (xt_codigoRiesgo, xn_numero, xt_titulo, xt_codigoDocumento, xt_etiqueta, xt_tipoDocumento, xt_tipo, xd_fecha) VALUES ('$idRiesgo', $maximo, '$tituloInsert', '$codigoInsert', 'POST-EVENTO', '$validarTipoDoc', 'ITEM', '$fechaInsert') ");
	
	header("Location: fichaRiesgov2.php?id=$idRiesgo");
	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8">
            <title>Riesgo</title>
            <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
 			<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
			<script type="text/javascript" src="../../Librerias/JQuery/js/jquery-1.7.1.min.js"></script>
           
           
           <script>
           	
			$(document).ready(function(){
				
				$("#listCodPreven").change(function(){
					$("#listCodPreven option:selected").each(function(){
						var nombre=$(this).val();
						$.post("listaTiposDocumento.php", {nombre: nombre}, function(data){
						$("#codigoPREV").html(data);
						});            
					});
				});
				
				
				$("#listDocCtrl").change(function(){
					$("#listDocCtrl option:selected").each(function(){
						var nombre=$(this).val();
						$.post("listaTiposDocumento.php", {nombre: nombre}, function(data){
						$("#codigoCTRL").html(data);
						});            
					});
				});
				
				
				$("#listPosEv").change(function(){
					$("#listPosEv option:selected").each(function(){
						var nombre=$(this).val();
						$.post("listaTiposDocumento.php", {nombre: nombre}, function(data){
						$("#codigoPSEVN").html(data);
						});            
					});
				});
				
				
				
			})
           
         </script>  
           
           
            <script>
                function showCtrl(valor){
                    if(valor == 1){
                        document.getElementById("controlINS").style.display="block";
                        document.getElementById("masControl").style.display="none";
                        document.getElementById("masControl2").style.display="block";
                    } else if (valor == 2){
                        document.getElementById("controlINS").style.display="none";
                        document.getElementById("masControl").style.display="block";
                        document.getElementById("masControl2").style.display="none";
                    }
                }
                
                function showPSEVN(valor){
                    if(valor == 1){
                        document.getElementById("posteventoINS").style.display="block";
                        document.getElementById("masControl3").style.display="none";
                        document.getElementById("masControl4").style.display="block";
                    } else if (valor == 2){
                        document.getElementById("posteventoINS").style.display="none";
                        document.getElementById("masControl3").style.display="block";
                        document.getElementById("masControl4").style.display="none";
                    }
                }
                
                function showPREV(valor){
                    if(valor == 1){
                        document.getElementById("prevencionINS").style.display="block";
                        document.getElementById("masControl5").style.display="none";
                        document.getElementById("masControl6").style.display="block";
                    } else if (valor == 2){
                        document.getElementById("prevencionINS").style.display="none";
                        document.getElementById("masControl5").style.display="block";
                        document.getElementById("masControl6").style.display="none";
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
echo "<div id='wrapperRiesgos'>";
	echo "<table border='0' align='center'>";
		
		echo "<tr height='12px'>";
			echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId." </td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td align='left' id='breadcrumbs'>Fecha de última actualización: ".($cambioFech == '' ? $fecha : $cambioFech)."</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td align='left' id='breadcrumbs'>Fecha de revisión: 2026-01-13</td>";
		echo "</tr>";
		
		if($versionControl != ''){
			echo "<tr>";
				echo "<td align='left' id='breadcrumbs'>Versión: ".$versionControl."</td>";
			echo "</tr>";
		}else{
			echo "<tr>";
				echo "<td align='left' id='breadcrumbs'>Versión: 0</td>";
			echo "</tr>";
		}
		
		echo "<tr height='40px'><td></td></tr>";
		
		echo "<tr>";
			echo "<td align='center' id='titulo1' width='950px'>";
				echo "Riesgo";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td align='center' id='titulo1'>".$codigo."</td>";
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
		
		//echo "<tr height='70'><td></td></tr>";
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
					<table border='0' align='center' id='breadcrumbs' style='border:1px solid %23007cbd;'>
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
                                            <!-- -->
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
                <?php*/
				
				//banana de navegacion itranet
			echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
					include("../../navegacion_banana.php");
				echo "</table>";
				
			echo "</td>";
		echo "</tr>";
		
	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 
	
	echo "<table border='0' align='center' width='950px'>";
		echo "<tr >";
			echo "<td id='titulo2' align='left'>";
				echo "Identificación";
				echo "<input type='hidden' name='id' value='".$idRiesgo."'>";
			echo "</td> ";
		echo "</tr>";

		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
	echo "</table>";
	
	//TITULO
	echo "<table border='0' align='center' width='950px'>";
		echo "<tr height='15px'><td></td></tr>";
		
		echo "<tr>";
			echo "<td id='titulo12'>".$tituloRiesgo."</td>";
		echo "</tr>";
	echo "</table>";
	
	//DESCRIPCION
	echo "<table border='0' align='center' width='800px'>";	
		echo "<tr height='20px'><td colsapn='2'></td></tr>";
		
		echo "<tr>";
			echo "<td id='iconosTexto2' colspan='2'>Descripción</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td id='iconosTexto' align='left' width='100px'></td>";
			echo "<td id='iconosTexto' align='justify' width='650px'>".$descripcionRiesgo."</td>";
		echo "</tr>";
		
		echo "<tr height='20px'><td colspan='2'></td></tr>";
		
		echo "<tr>";
			echo "<td id='iconosTexto2' colspan='2'>Categoria</td>";
		echo "</tr>";
		
		echo "<tr>";
			echo "<td id='iconosTexto' align='left'>".$categoriaOpcion."</td>";
			echo "<td id='iconosTexto' align='justify'>".$categoria."</td>";
		echo "</tr>";
			
		echo "<tr height='20px'><td colspan='2'></td></tr>";
	echo "</table>";
	
	//PROBABILIDAD
	echo "<table border='0' align='center' width='800px'>";
		echo "<tr>";
			echo "<td id='iconosTexto2' colspan='2'>Probabilidad</td>";
		echo "</tr>";
		
		echo "<tr >";
			echo "<td id='iconosTexto' align='left' width='100px'>".$probabilidadDesc."</td>";
			echo "<td id='iconosTexto' align='justify' width='650px'>".$descripcionProbabilidad."</td>";
		echo "</tr>";
		
		echo "<tr height='30px'><td colspan='2'></td></tr>";
	echo "</table>";
	
	//ANALISIS
	echo "<table border='0' align='center' width='950px'>";
		echo "<tr >";
			echo "<td id='titulo2' align='left'>Análisis</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr height='20px'><td></td></tr>";
	echo "</table>";

	//IMPACTO
	echo "<table border='0' align='center' width='800px'>";
		echo "<tr>";
			echo "<td id='iconosTexto2' align='left'>Consecuencia</td>";
		echo "</tr>";
	
		echo "<tr height='20px'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='800px'>";
		echo "<tr>";
			echo "<td id='iconosTexto' align='left' width='100px'>".$impactoDespliegue."</td>";
			echo "<td id='iconosTexto' align='left' width='650px'>".$descripcionImpacto."</td>";
		//	echo "<td id='iconosTexto' align='left' width='650px'>".utf8_encode($descripcionConsecuencia)."</td>";

		echo "</tr>";
		
		echo "<tr height='30px'><td colspan='2'></td></tr>";
	echo "</table>";
	
	//AMENAZA
	echo "<table border='0' align='center' width='800px'>";
		echo "<tr>";
			echo "<td id='iconosTexto2' align='left'>Amenaza</td>";
		echo "</tr>";
	
		echo "<tr height='20px'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='800px'>";
		echo "<tr>";
			echo "<td id='iconosTexto' align='left' width='100px'>".$amenaza."<input type='hidden' name='amenaza' value='".$amenaza."'></td>";
			
			if($amenaza == 'Nula' ){
				
				echo "<td width='50px'></td>";
				echo "<td width='650px'></td>";
				
			}else if($amenaza == 'Muy Baja'){
				
				echo "<td align='left' width='50px' id='ico_info'>";
					echo "<img src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' border='0' width='15px' height='15px' id='imgInfo'>";
				echo "</td>";
				
				echo "<td align='left' width='650px' id='infoGeneral'>";
					echo "<img src='../../Imagenes/IMG_MatrizAmenaza.png' border='0'/>";
				echo "</td>";
				
			}else if($amenaza == 'Baja'){
				
				echo "<td align='left' width='50px' id='ico_info'>";
					echo "<img src='../../Imagenes/ICN_SemaforoVerdeClaro.png' border='0' width='15px' height='15px' id='imgInfo'>";
				echo "</td>";
				
				echo "<td align='left' width='650px' id='infoGeneral'>";
					echo "<img src='../../Imagenes/IMG_MatrizAmenaza.png' border='0'/>";
				echo "</td>";
				
			}else if($amenaza == 'Media'){
				
				echo "<td align='left' width='50px' id='ico_info'>";
					echo "<img src='../../Imagenes/ICN_SemaforoAmarillo.png' border='0' width='15px' height='15px' id='imgInfo'>";
				echo "</td>";
				
				echo "<td align='left' width='650px' id='infoGeneral'>";
					echo "<img src='../../Imagenes/IMG_MatrizAmenaza.png' border='0'/>";
				echo "</td>";
				
			}else if($amenaza == 'Alta' ){
				
				echo "<td align='left' width='50px' id='ico_info'>";
					echo "<img src='../../Imagenes/ICN_SemaforoRojoClaro.png' border='0' width='15px' height='15px' id='imgInfo'>";
				echo "</td>";
				
				echo "<td align='left' width='650px' id='infoGeneral'>";
					echo "<img src='../../Imagenes/IMG_MatrizAmenaza.png' border='0'/>";
				echo "</td>";
				
			}else if( $amenaza =='Muy Alta'){
				
				echo "<td align='left' width='50px' id='ico_info'>";
					echo "<img src='../../Imagenes/ICN_SemaforoRojoOscuro.png' border='0' width='15px' height='15px' id='imgInfo'>";
				echo "</td>";
				
				echo "<td align='left' width='650px' id='infoGeneral'>";
					echo "<img src='../../Imagenes/IMG_MatrizAmenaza.png' border='0'/>";
				echo "</td>";
				
			}
			
		echo "</tr>";
		
		echo "<tr height='30px'><td colspan='3'></td></tr>";
	echo "</table>";
	
	//TRATAMIENTO
	echo "<table border='0' align='center' width='950px'>";
		echo "<tr>";
			echo "<td id='titulo2' align='left'>Tratamiento</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr height='20px'><td></td></tr>";
	echo "</table>";
	
	//TRATAMIENTO CONTENIDO ESTRATEGIA
	echo "<table border='0' align='center' width='800px'>";
		echo "<tr>";
			echo "<td id='iconosTexto'>".$estrategia."</td>";
		echo "</tr>";
		
		echo "<tr height='10px'><td></td></tr>";
		
		echo "<tr>";
			echo "<td id='iconosTexto' align='justify' width='650px'>".$descripcionEst."</td>";
		echo "</tr>";
		
		echo "<tr height='10px'><td></td></tr>";
	echo "</table>";
	
	if(($estrategia != "" ) && ($estrategia != "Aceptar el riesgo") && ($estrategia != "Niveles del riesgo residual son tolerables")){
		 // PLAN DE PREVENCION Y DESCRIPCION
		echo "<form method='post' action='fichaRiesgov2.php?id=".$idRiesgo."'>";	
		 echo "<table border='0' align='center' width='950px'>";
			echo "<tr>";
				echo "<td id='titulo2' align='left' width='930px'>Plan de Prevención</td>";
				echo "<td id='titulo2' align='right' width='20px'>";
					//echo "<a href='AgregaPrevencionRiesgo.php?id=$idRiesgo' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=730,scrollbars=yes')\">";
					
					//Comentado para desplegar abajo de prevencion
         			//echo "<img src='../Imagenes/ICN_BotonMas.png' height='15px' width='15px' onclick='showPREV(1);' id='masControl5' style='display:block;'>";
					//echo "<img src='../Imagenes/ICN_BotonMas.png' height='15px' width='15px' onclick='showPREV(2);' id='masControl6' style='display:none;'>";
					//echo "</a>";
				echo "</td> ";
			echo "</tr>";
	
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			
			echo "<tr height='20px'><td colspan='2'></tr>";
			
			if($descripcionPreven == "" || NULL){	
				
				echo "<tr>";
					
					echo "<td id='iconosTexto'>";
						echo "<textarea name='descripcionPrevencion' style='width:800px; height:60px;'></textarea>";
					echo "</td>";
					
					echo"<td align='right' width='150' valign='bottom'>";
						echo"<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_Certif.png' width='18' height='15'>";
					echo"</td>";
						
				echo "</tr>";
				
			}else if ($descripcionPreven != "" || NULL){
				
				echo "<tr>";
					echo "<td id='iconosTexto' align='justify' width='650px' colspan='2'>".$descripcionPreven."</td>";	
				echo "</tr>";
				
			}
			echo "<tr height='20px'><td colspan='2'></td></tr>";
			
		echo "</table>";
	echo"</form>";
		/*AHORA NO SE MOSTRATAN LAS ACCIONES CORRECTIVAS POR QUE SOLO SERAN DOCUMENTOS (PARTE NORMATIVA)
		$indice=0;
		
		$s=$INTRANET->Execute("
		SELECT SAR.xt_tipoTratamiento,SAR.xt_titulo,SAR.xd_fecha,SAPC.xt_ruta,SAPC.kp_accionesID FROM SGI_Acciones_Riesgos SAR, SGI_Acciones_Preventivas_Correctivas SAPC 
		WHERE SAR.kf_riesgoId=$idRiesgo AND SAPC.xt_claveAccion=SAR.xt_tipoTratamiento AND SAR.xt_tipo = 'D'");
		
		while($r=$s->fetchRow()){
			$indice ++;
			
			if($indice == 1){
			
				echo "<table border='0' align='center' width='650px'>";
					echo "<tr >";
						echo "<td id='iconosTexto2' align='left' width='130'>Código</td> ";
						echo "<td id='iconosTexto2' align='left' width='440'> Acciones Preventivas </td>";
						echo "<td id='iconosTexto2' align='left' width='80'>Fecha</td> ";
						echo "<td id='iconosTexto2' align='left' width='50px'> </td> ";
					echo "</tr>";
					
					echo "<tr height='20'></tr>";
			}
			
			echo "<tr >";
				echo "<td id='iconosTexto' align='left'><a id='iconosTexto' href='fichaPreventiva.php?id=$r[4]'>$r[0]</a></td> ";
				echo "<td id='iconosTexto' align='left'>$r[1]</td>";
				echo "<td id='iconosTexto' align='left'>$r[2]</td> ";
				if($r[3]!=""){
					echo "<td id='iconosTexto' align='center'><a href='downloadPreventivasCorrectivas.php?file=$r[3]'><img src='../Imagenes/ICN_Archivo.png'></a></td> ";
				}else{
					echo "<td id='iconosTexto' align='center'> </a></td> ";
				}
			echo "</tr>";
			
			echo "<tr height='5'></tr>";
		}unset($r);
		if($indice >=1){
				echo "<tr height='20'></tr>";
			echo "</table>";
		}
		*/
		
			
		//Prevención
		echo "<table border='0' align='center' width='750px'>";
			echo "<tr>";
				echo "<td id='iconosTexto2' align='left' width='630px'>Prevención</td>";
				echo "<td id='titulo2' align='right' width='20px'>";
					//echo "<a href='AgregarItemPopUp.php' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=730,scrollbars=yes')\">";
					echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15px' width='15px' onclick='showPREV(1);' id='masControl5' style='display:block;'>";
					echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15px' width='15px' onclick='showPREV(2);' id='masControl6' style='display:none;'>";
					//echo "</a>";
				echo "</td>";
			echo "</tr>";
	
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
		
			echo "<tr height='20px'><td colspan='2'></td></tr>";
		echo "</table>";

		//PREVENCION
		$indice = 0;
		
		$s = $INTRANETV2->Execute("SELECT
									SIT.xt_codigoCompleto,
									SIT.xt_nombre,
									SIT.xt_grupo,
									SIT.xt_codigoManual,
									SIT.xt_tipoDocumento,
									SIT.xd_fechaCreacion,
									SIT.xt_codigoDocumento
								FROM
									SGI_Manuales_Documentos SIT,
									SGI_Riesgos_Documentos SAR
								WHERE
									SAR.xt_codigoDocumento = SIT.xt_codigoDocumento
								AND SAR.xt_codigoRiesgo = '$codigo'
								AND SAR.xt_etiqueta = 'PREVENCION'
								AND SAR.xt_tipoDocumento = 'D'
								AND SAR.xb_status=1
								ORDER BY
									SAR.xn_numero");
		
		$ss = $INTRANETV2->Execute("SELECT
									SIT.xt_codigo,
									SIT.xt_nombre,
									SAR.xd_fecha
								FROM
									SGI_Catalogo_Funcionalidades SIT,
									SGI_Riesgos_Documentos SAR
								WHERE
									SAR.xt_codigoDocumento = SIT.xt_codigo
								AND SAR.xt_codigoRiesgo = '$codigo'
								AND SAR.xt_etiqueta = 'PREVENCION'
								AND SAR.xt_tipoDocumento = 'F'
								AND SAR.xb_status=1
								ORDER BY
									SAR.xn_numero");
		
		
		
		$banderaExistenDoc = 0;
		while($r = $s->fetchRow()){
			
			$indice++;
			$banderaExistenDoc = 1;
			
			if($indice == 1){
				
				echo "<table border='0' align='center' width='650px'>";
					echo "<tr id='iconosTexto2'>";
						echo "<td align='left' width='160px'>Código</td>";
						echo "<td align='left' width='440px'>Documentos</td>";
						echo "<td align='left' width='80px'>Fecha</td>";
						echo "<td align='left' width='50px'></td>";
					echo "</tr>";
				
					echo "<tr height='20px'><td colspan='4'></td></tr>";
			}
			
			echo "<tr id='iconosTexto'>";
				echo "<td align='left'>";
					echo "<a id='iconosTexto' href='fichaDocumentov3.php?id=".$r[6]."'>".$r[0]."</a>";
				echo "</td>";
				
				echo "<td align='left'>".$r[1]."</td>";
				
				echo "<td align='left'>".date('Y-m-d', strtotime($r[5]))."</td> ";
				
				echo "<td></td>";
			echo "</tr>";
			
			echo "<tr height='5px'><td colspan='4'></td></tr>";
			
		}unset($r);
		
		while($rr = $ss->fetchRow()){
			
			if($banderaExistenDoc == 1){
				
				echo "<tr id='iconosTexto'>";
					echo "<td align='left'>";
						echo "<a id='iconosTexto' href='fichaDocumentov3.php?id=".$rr[0]."'>".$rr[0]."</a>";
					echo "</td>";

					echo "<td align='left'>".$rr[4]."</td>";

					echo "<td align='left'>".date('Y-m-d', strtotime($rr[5]))."</td> ";

					echo "<td></td>";
				echo "</tr>";
			
				echo "<tr height='5px'><td colspan='4'></td></tr>";
				
			}else{
				
				$indice++;
				
				if($indice == 1){
				
					echo "<table border='0' align='center' width='650px'>";
						echo "<tr id='iconosTexto2'>";
							echo "<td align='left' width='160px'>Código</td>";
							echo "<td align='left' width='440px'>Documentos</td>";
							echo "<td align='left' width='80px'>Fecha</td>";
							echo "<td align='left' width='50px'></td>";
						echo "</tr>";

						echo "<tr height='20px'><td colspan='4'></td></tr>";
				}
			
				echo "<tr id='iconosTexto'>";
					echo "<td align='left'>";
						echo "<a id='iconosTexto' href='fichaDocumentov3.php?id=".$rr[0]."'>".$rr[0]."</a>";
					echo "</td>";

					echo "<td align='left'>".$rr[4]."</td>";

					echo "<td align='left'>".date('Y-m-d', strtotime($r[5]))."</td> ";

					echo "<td></td>";
				echo "</tr>";

				echo "<tr height='5px'><td colspan='4'></td></tr>";

				}
		
		}unset($rr);
		
		
		if($indice >=1){
			
			echo "<tr height='20px'><td colspan='4'></td></tr>";
			echo "</table>";
			
		}
		//SE MUESTRA CODIGO Y DESCRIPCION PARA PLAN DE PREVENCION CAPTURA DE DATOS
		if(($usuarioId == 'cozy') || ($usuarioId == 'Adlemy_Tah') || ($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'Alberto_Martinez') || ($usuarioId == 'sdelap') || ($usuarioId == 'Jorge_Doring')|| ($usuarioId == 'Daniel_Guadarrama') || ($usuarioId == 'Lizbeth_Guadarrama') || ($usuarioId == 'Dalia_Mosqueda')){
			
		echo "<form method='post' action='fichaRiesgov2.php?id=".$idRiesgo."'>";	
			echo "<table border='0' align='center' width='450px' id='prevencionINS' style='display:none;'>";
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'></td>";
				echo "</tr>";
				
				echo "<tr height='20px'><td></td></tr>";
				
				echo "<tr>";
					echo "<td id='iconosTexto2' align='left' width='450px'>Código</td>";
				echo "</tr>";
				
				echo "<tr>";
				
				echo "<td align='left'>";
					//obtengo documentos
				$d = array('Documentos', 'Funcionalidades');
			
					echo "<select name='listCodPreven' id='listCodPreven'>";
			
					echo "<option value='0'>Selecciona...</option>";
			
					for($p = 0; $p < count($d); $p++){
						
						echo "<option value='$d[$p]'>$d[$p]</option>";
					}
					//echo "<td align='left'>";
					//	echo "<input type='text' size='20' maxlength='100' name='codigoPREV'>";
					echo "</select>";
					//select para los tipos de documentos
					echo "</td>";
				echo "</tr>";
			
				echo "<tr height='5px'></tr>";
				echo "<tr>
					<td><select name='codigoPREV' id='codigoPREV'></select></td>
				</tr>";
			
				
			
				echo "<tr height='20px'><td></td></tr>";

				echo "<tr>";
					echo "<td id='titleBlueLineBottom'></td>";
				echo "</tr>";
				
				echo "<tr height='10px'><td></td></tr>";
				
				echo "<tr height='40px'>";
					echo "<td valign='bottom' align='right'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='30px'><td></td></tr>";
			echo "</table>";
		echo "</form>";
		}
		/*
				
		$indice = 0;
	
		$s = $INTRANET->Execute("SELECT SIT.xt_codigo, SIT.xt_nombre, SIT.xt_grupo, SIT.xt_area, SIT.xt_tipo, SIT.xn_consecutivo, 
								 SIT.xd_fechaCreacion, SIT.kp_itemID FROM SGI_Item SIT, SGI_Acciones_Riesgos SAR WHERE SAR.xt_tipoTratamiento = SIT.kp_itemID 
								 AND SAR.kf_riesgoId = $idRiesgo AND xt_etiqueta = 'PREVENCION' AND SIT.xt_ciudad = '$ciudad' ORDER BY SAR.xn_numero ");
		
		while($r = $s->fetchRow()){
			
			$indice++;
			
			if($indice == 1){
				
				echo "<table border='0' align='center' width='650px'>";
					echo "<tr id='iconosTexto2'>";
						echo "<td align='left' width='150px'>Código</td>";
						echo "<td align='left' width='440px'>Documentos</td>";
						echo "<td align='left' width='80px'>Fecha</td>";
						echo "<td align='left' width='50px'></td>";
					echo "</tr>";
				
					echo "<tr height='20px'><td colspan='4'></td></tr>";
					
			}
			
			echo "<tr>";
				echo "<td id='iconosTexto' align='left'>";
					echo "<a id='iconosTexto' href='FichaItem.php?id=".$r[7]."'>".$r[0]."</a>";
				echo "</td>";
				
				echo "<td id='iconosTexto' align='left'>".$r[1]."</td>";
				
				echo "<td id='iconosTexto' align='left'>".date('Y-m-d', strtotime($r[6]))."</td>";
				
				echo "<td></td>";
			echo "</tr>";
			
			echo "<tr height='5px'><td colspan='4'></td></tr>";
			
		}unset($r); unset($s);
		
		if($indice >= 1){
			
				echo "<tr height='20px'><td colspan='4'></td></tr>";
			echo "</table>";
		}
		
		*/
		/*TAMBIEN SE OCULTA LA PARTE DE SIMULACROS POR QUE SOLO SERAN DOCUMENTOS PARA LA OPCION DE PLAN DE TRATAMIENTO
		$indice=0;
		$s=$INTRANET->Execute("SELECT xt_titulo,xd_fecha,xt_ruta FROM SGI_Simulacros WHERE kf_riesgoId = $idRiesgo");
		while($r=$s->fetchRow()){
			$indice++;
			if($indice == 1){
				echo "<table border='0' align='center' width='650px'>";
					echo "<tr >";
						echo "<td id='iconosTexto2' align='left' width='80'></td> ";
						echo "<td id='iconosTexto2' align='left' width='490'> Simulacros </td>";
						echo "<td id='iconosTexto2' align='left' width='80'>Fecha</td> ";
						echo "<td id='iconosTexto2' align='left' width='50px'> </td> ";
					echo "</tr>";
				
					echo "<tr height='20'></tr>";
			}
			echo "<tr >";
				echo "<td id='iconosTexto2' align='left'></td> ";
				echo "<td id='iconosTexto' align='left'>$r[0] </td>";
				echo "<td id='iconosTexto' align='left'>$r[1] </td> ";
				if($r[2]!=""){
					echo "<td id='iconosTexto' align='center'><a href='downloadRiesgo.php?file=$r[2]'><img src='../Imagenes/ICN_Archivo.png'></a></td> ";
				}else{
					echo "<td id='iconosTexto' align='center'> </td> ";
				}
			echo "</tr>";
			
			echo "<tr height='5'></tr>";
		}unset($r);
		if($indice >=1){
				echo "<tr height='20'></tr>";
			echo "</table>";
		}
		*/
			
		// PLAN DE EMERGENCIA Y DESCRIPCION
	echo "<form method='post' action='fichaRiesgov2.php?id=".$idRiesgo."'>";
		echo "<table border='0' align='center' width='950px'>";
			echo "<tr>";
				echo "<td id='titulo2' align='left' colspan='2'>Plan de Emergencia</td> ";
			echo "</tr>";
	
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			
			echo "<tr height='20px'></tr>";
			
			if ($descripcionEmerg == "" || NULL ){
				
				echo "<tr>";
					echo "<td id='iconosTexto' >";
						echo "<textarea name='descripcionEmergencias' style='width:800px; height:60px;'></textarea>";
					echo "</td>";
					
					echo"<td align='right' width='150' valign='bottom'>";
						echo"<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_Certif.png' width='18' height='15'>";
					echo"</td>";
						
				echo "</tr>";
				
			}else if ($descripcionEmerg != "" || NULL){
				
				echo "<tr>";
					echo "<td id='iconosTexto' align='justify' width='650px' colspan='2'>".$descripcionEmerg."</td>";	
				echo "</tr>";
				
			}
			echo "<tr height='20px'><td></td></tr>";
		echo "</table>";
	echo"</form>";
	
		echo "<table border='0' align='center' width='750px'>";
			echo "<tr>";
				echo "<td id='iconosTexto2' align='left' width='630px'>Control</td>";
				echo "<td id='titulo2' align='right' width='20px'>";
					//echo "<a href='AgregarItemPopUp.php' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=730,scrollbars=yes')\">";
					echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15px' width='15px' onclick='showCtrl(1);' id='masControl' style='display:block;'>";
					echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15px' width='15px' onclick='showCtrl(2);' id='masControl2' style='display:none;'>";
					//echo "</a>";
				echo "</td>";
			echo "</tr>";
	
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
		
			echo "<tr height='20px'><td colspan='2'></td></tr>";
		echo "</table>";

		//CONTROL
		$indice = 0;
		
		$s = $INTRANETV2->Execute("SELECT
									SIT.xt_codigoCompleto,
									SIT.xt_nombre,
									SIT.xt_grupo,
									SIT.xt_codigoManual,
									SIT.xt_tipoDocumento,
									SIT.xd_fechaCreacion,
									SIT.xt_codigoDocumento
								FROM
									SGI_Manuales_Documentos SIT,
									SGI_Riesgos_Documentos SAR
								WHERE
									SAR.xt_codigoDocumento = SIT.xt_codigoDocumento
								AND SAR.xt_codigoRiesgo = '$codigo'
								AND SAR.xt_etiqueta = 'CONTROL'
								AND SAR.xt_tipoDocumento = 'D'
								ORDER BY
									SAR.xn_numero");
		
		
		$ss = $INTRANETV2->Execute("SELECT
									SIT.xt_codigo,
									SIT.xt_nombre,
									SAR.xd_fecha
								FROM
									SGI_Catalogo_Funcionalidades SIT,
									SGI_Riesgos_Documentos SAR
								WHERE
									SAR.xt_codigoDocumento = SIT.xt_codigo
								AND SAR.xt_codigoRiesgo = '$codigo'
								AND SAR.xt_etiqueta = 'CONTROL'
								AND SAR.xt_tipoDocumento = 'F'
								ORDER BY
									SAR.xn_numero");
		
		
		
		$banderaExistenDoc = 0;
		while($r = $s->fetchRow()){
			
			$indice++;
			$banderaExistenDoc = 1;
			
			if($indice == 1){
				
				echo "<table border='0' align='center' width='650px'>";
					echo "<tr id='iconosTexto2'>";
						echo "<td align='left' width='160px'>Código</td>";
						echo "<td align='left' width='440px'>Documentos</td>";
						echo "<td align='left' width='80px'>Fecha</td>";
						echo "<td align='left' width='50px'></td>";
					echo "</tr>";
				
					echo "<tr height='20px'><td colspan='4'></td></tr>";
			}
			
			echo "<tr id='iconosTexto'>";
				echo "<td align='left'>";
					echo "<a id='iconosTexto' href='fichaDocumentov3.php?id=".$r[6]."'>".$r[0]."</a>";
				echo "</td>";
				
				echo "<td align='left'>".$r[1]."</td>";
				
				echo "<td align='left'>".date('Y-m-d', strtotime($r[5]))."</td> ";
				
				echo "<td></td>";
			echo "</tr>";
			
			echo "<tr height='5px'><td colspan='4'></td></tr>";
			
		}unset($r);
		
		while($rr = $ss->fetchRow()){
			
			if($banderaExistenDoc == 1){
				
				echo "<tr id='iconosTexto'>";
					echo "<td align='left'>";
						echo "<a id='iconosTexto' href='fichaDocumentov3.php?id=".$rr[0]."'>".$rr[0]."</a>";
					echo "</td>";

					echo "<td align='left'>".$rr[4]."</td>";

					echo "<td align='left'>".date('Y-m-d', strtotime($rr[5]))."</td> ";

					echo "<td></td>";
				echo "</tr>";
			
				echo "<tr height='5px'><td colspan='4'></td></tr>";
				
			}else{
				
				$indice++;
				
				if($indice == 1){
				
					echo "<table border='0' align='center' width='650px'>";
						echo "<tr id='iconosTexto2'>";
							echo "<td align='left' width='160px'>Código</td>";
							echo "<td align='left' width='440px'>Documentos</td>";
							echo "<td align='left' width='80px'>Fecha</td>";
							echo "<td align='left' width='50px'></td>";
						echo "</tr>";

						echo "<tr height='20px'><td colspan='4'></td></tr>";
				}
			
				echo "<tr id='iconosTexto'>";
					echo "<td align='left'>";
						echo "<a id='iconosTexto' href='fichaDocumentov3.php?id=".$rr[0]."'>".$rr[0]."</a>";
					echo "</td>";

					echo "<td align='left'>".$rr[4]."</td>";

					echo "<td align='left'>".date('Y-m-d', strtotime($r[5]))."</td> ";

					echo "<td></td>";
				echo "</tr>";

				echo "<tr height='5px'><td colspan='4'></td></tr>";

				}
		
		}unset($rr);
		
		
		if($indice >=1){
			
			echo "<tr height='20px'><td colspan='4'></td></tr>";
			echo "</table>";
			
		}
		if(($usuarioId == 'Alberto_Martinez') || ($usuarioId == 'Rodrigo_Romo') ||  ($usuarioId == 'sdelap') || ($usuarioId == 'Jorge_Doring')|| ($usuarioId == 'Daniel_Guadarrama') || ($usuarioId == 'Lizbeth_Guadarrama') || ($usuarioId == 'Dalia_Mosqueda')){
			
			echo "<form method='post' action='fichaRiesgov2.php?id=".$idRiesgo."'>";	
			echo "<table border='0' align='center' width='450px' id='controlINS' style='display:none;'>";
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'></td>";
				echo "</tr>";
				
				echo "<tr height='20px'><td></td></tr>";
				
				echo "<tr>";
					echo "<td id='iconosTexto2' align='left' width='450px'>Código</td>";
				echo "</tr>";
				
				echo "<tr>";
			
					echo "<td align='left'>";
						//obtengo documentos
						//$d = $INTRANETV2 ->Execute("SELECT xt_codigoDocumento, xt_nombre FROM SGI_Manuales_Documentos");
						echo "<select name='listDocCtrl' id='listDocCtrl'>";
			
							echo "<option value='0'>Selecciona...</option>";
			
								for($p = 0; $p < count($d); $p++){
						
									echo "<option value='$d[$p]'>$d[$p]</option>";
							}
					//echo "<td align='left'>";
					//	echo "<input type='text' size='20' maxlength='100' name='codigoPREV'>";
						echo "</select>";
					echo "</td>";
				echo "</tr>";
				echo "<tr height='10px'></tr>";
			
				echo "<tr><td><select name='codigoCTRL' id='codigoCTRL'></select></td></tr>";
				
				echo "<tr height='20px'><td></td></tr>";
	
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'></td>";
				echo "</tr>";
				
				echo "<tr height='5px'><td></td></tr>";
				
				echo "<tr height='40px'>";
					echo "<td valign='bottom' align='right'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='30px'><td></td></tr>";
			echo "</table>";
			echo "</form>";
			
		}
		
	
		
		/*
		$i=1;
		$s=$INTRANET->Execute("SELECT xt_grupo,xt_area,xt_tipo,xn_consecutivo,xt_codigo,xt_nombre,xd_fechaCreacion FROM SGI_Item WHERE xt_tipo= 'M'");
		while($r=$s->fetchRow()){
				$link[$i]= "<a id='iconosTexto' href='FichaItem.php?grupo=$r[0]&area=$r[1]&tipo=$r[2]&consecutivo=$r[3]'>$r[4]</a>";
				$nombre[$i] = $r[5];
				$fechaCreacion[$i] = date('Y-m-d',strtotime($r[6]));
				$i++;
			
		}unset($r);
		if(count($link) >=1 ){
			echo "<table border='0' align='center' width='650px'>";
				
				echo "<tr >"; 
					echo "<td id='iconosTexto2' align='left' width='130'>Código</td> ";
					echo "<td id='iconosTexto2' align='left' width='440'> Protocolo </td>";
					echo "<td id='iconosTexto2' align='left' width='80'>Fecha</td> ";
					echo "<td id='iconosTexto2' align='left' width='50px'></td> ";
				echo "</tr>";
				
				echo "<tr height='20'></tr>";
		}
		for($a=1;$a<=count($nombre);$a++){
			echo "<tr >";
				echo "<td id='iconosTexto' align='left'>$link[$a]</td> ";
				echo "<td id='iconosTexto' align='left'>$nombre[$a]</td>";
				echo "<td id='iconosTexto' align='left'>$fechaCreacion[$a]</td> ";
				
			echo "</tr>";
			
			echo "<tr height='5'></tr>";
		}
		if(count($link) >=1 ){
				echo "<tr height='20'></tr>";
			echo "</table>";
		}
		*/
		
		
		//POST-EVENTO
		echo "<table border='0' align='center' width='750px'>";
			echo "<tr>";
				echo "<td id='iconosTexto2' align='left' width='730px'>Post-Evento</td>";
				echo "<td id='titulo2' align='right' width='20px'>";
					//echo "<a href='AgregaAccionRiesgo.php?id=$idRiesgo' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=730,scrollbars=yes')\">"; 
					echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15px' width='15px' onclick='showPSEVN(1);' id='masControl3' style='display:block;'>";
					echo "<img src='../../Imagenes/ICN_BotonMas.png' height='15px' width='15px' onclick='showPSEVN(2);' id='masControl4' style='display:none;'>";
					//echo "</a>";
				echo "</td>";
			echo "</tr>";
	
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			
			echo "<tr height='20px'><td colspan='2'></td></tr>";
		echo "</table>";
		
		/*
		 $bandera=0;
			
		$s=$INTRANET->Execute("
		SELECT SAR.xt_tipoTratamiento,SAR.xt_titulo,SAR.xd_fecha,SAPC.xt_ruta,SAPC.kp_accionesID FROM SGI_Acciones_Riesgos SAR, SGI_Acciones_Preventivas_Correctivas SAPC 
		WHERE SAR.kf_riesgoId=$idRiesgo AND SAPC.xt_claveAccion=SAR.xt_tipoTratamiento AND SAR.xt_tipo = 'E' ");
		while($r=$s->fetchRow()){
			$bandera++;
			if($bandera == 1){
				
				echo "<table border='0' align='center' width='650px'>";
					
					echo "<tr >";
						echo "<td id='iconosTexto2' align='left' width='130'>Código</td> ";
						echo "<td id='iconosTexto2' align='left' width='440'> Acciones Correctivas </td>";
						echo "<td id='iconosTexto2' align='left' width='80'>Fecha</td> ";
						echo "<td id='iconosTexto2' align='left' width='50px'> </td> ";
					echo "</tr>";
					
					echo "<tr height='20'></tr>";
			}
			echo "<tr >";
				echo "<td id='iconosTexto' align='left'><a id='iconosTexto' href='fichaCorrectiva.php?id=$r[4]'>$r[0]</a></td> ";
				echo "<td id='iconosTexto' align='left'>$r[1]</td>";
				echo "<td id='iconosTexto' align='left'>$r[2]</td> ";
				if($r[3]!=""){
					echo "<td id='iconosTexto' align='center'><a href='downloadPreventivasCorrectivas.php?file=$r[3]'><img src='../Imagenes/ICN_Archivo.png'></a></td> ";
				}else{
					echo "<td id='iconosTexto' align='center'> </a></td> ";
				}
			echo "</tr>";
			
			echo "<tr height='5'></tr>";
		}unset($r);
		if($bandera>0){
				echo "<tr height='20'></tr>";
			echo "</table>";
		}
		*/
		
		$indice = 0;
		
		$s = $INTRANETV2->Execute("SELECT
									SIT.xt_codigoCompleto,
									SIT.xt_nombre,
									SIT.xt_grupo,
									SIT.xt_codigoManual,
									SIT.xt_tipoDocumento,
									SIT.xd_fechaCreacion,
									SIT.xt_codigoDocumento
								FROM
									SGI_Manuales_Documentos SIT,
									SGI_Riesgos_Documentos SAR
								WHERE
									SAR.xt_codigoDocumento = SIT.xt_codigoDocumento
								AND SAR.xt_codigoRiesgo = '$codigo'
								AND SAR.xt_etiqueta = 'POST-EVENTO'
								AND SAR.xt_tipoDocumento = 'D'
								ORDER BY
									SAR.xn_numero");
		
		
		$ss = $INTRANETV2->Execute("SELECT
									SIT.xt_codigo,
									SIT.xt_nombre,
									SAR.xd_fecha
								FROM
									SGI_Catalogo_Funcionalidades SIT,
									SGI_Riesgos_Documentos SAR
								WHERE
									SAR.xt_codigoDocumento = SIT.xt_codigo
								AND SAR.xt_codigoRiesgo = '$codigo'
								AND SAR.xt_etiqueta = 'POST-EVENTO'
								AND SAR.xt_tipoDocumento = 'F'
								ORDER BY
									SAR.xn_numero");
		
		
		
		$banderaExistenDoc = 0;
		while($r = $s->fetchRow()){
			
			$indice++;
			$banderaExistenDoc = 1;
			
			if($indice == 1){
				
				echo "<table border='0' align='center' width='650px'>";
					echo "<tr id='iconosTexto2'>";
						echo "<td align='left' width='160px'>Código</td>";
						echo "<td align='left' width='440px'>Documentos</td>";
						echo "<td align='left' width='80px'>Fecha</td>";
						echo "<td align='left' width='50px'></td>";
					echo "</tr>";
				
					echo "<tr height='20px'><td colspan='4'></td></tr>";
			}
			
			echo "<tr id='iconosTexto'>";
				echo "<td align='left'>";
					echo "<a id='iconosTexto' href='fichaDocumentov3.php?id=".$r[6]."'>".$r[0]."</a>";
				echo "</td>";
				
				echo "<td align='left'>".$r[1]."</td>";
				
				echo "<td align='left'>".date('Y-m-d', strtotime($r[5]))."</td> ";
				
				echo "<td></td>";
			echo "</tr>";
			
			echo "<tr height='5px'><td colspan='4'></td></tr>";
			
		}unset($r);
		
		while($rr = $ss->fetchRow()){
			
			if($banderaExistenDoc == 1){
				
				echo "<tr id='iconosTexto'>";
					echo "<td align='left'>";
						echo "<a id='iconosTexto' href='fichaDocumentov3.php?id=".$rr[0]."'>".$rr[0]."</a>";
					echo "</td>";

					echo "<td align='left'>".$rr[4]."</td>";

					echo "<td align='left'>".date('Y-m-d', strtotime($rr[5]))."</td> ";

					echo "<td></td>";
				echo "</tr>";
			
				echo "<tr height='5px'><td colspan='4'></td></tr>";
				
			}else{
				
				$indice++;
				
				if($indice == 1){
				
					echo "<table border='0' align='center' width='650px'>";
						echo "<tr id='iconosTexto2'>";
							echo "<td align='left' width='160px'>Código</td>";
							echo "<td align='left' width='440px'>Documentos</td>";
							echo "<td align='left' width='80px'>Fecha</td>";
							echo "<td align='left' width='50px'></td>";
						echo "</tr>";

						echo "<tr height='20px'><td colspan='4'></td></tr>";
				}
			
				echo "<tr id='iconosTexto'>";
					echo "<td align='left'>";
						echo "<a id='iconosTexto' href='fichaDocumentov3.php?id=".$rr[0]."'>".$rr[0]."</a>";
					echo "</td>";

					echo "<td align='left'>".$rr[4]."</td>";

					echo "<td align='left'>".date('Y-m-d', strtotime($r[5]))."</td> ";

					echo "<td></td>";
				echo "</tr>";

				echo "<tr height='5px'><td colspan='4'></td></tr>";

				}
		
		}unset($rr);
		
		
		if($indice >=1){
			
			echo "<tr height='20px'><td colspan='4'></td></tr>";
			echo "</table>";
			
		}
		
		if(($usuarioId == 'Alberto_Martinez') || ($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'sdelap') || ($usuarioId == 'Jorge_Doring')|| ($usuarioId == 'Daniel_Guadarrama') || ($usuarioId == 'Lizbeth_Guadarrama') || ($usuarioId == 'Dalia_Mosqueda')){
			
			echo "<form method='post' action='fichaRiesgov2.php?id=".$idRiesgo."'>";	
			echo "<table border='0' align='center' width='450' id='posteventoINS' style='display:none;'>";
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'></td>";
				echo "</tr>";
				
				echo "<tr height='20px'><td></td></tr>";
				
				echo "<tr>";
					echo "<td id='iconosTexto2' align='left' width='450px'>Código</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td align='left'>";
					//obtengo documentos
				//$d = $INTRANETV2 ->Execute("SELECT xt_codigoDocumento, xt_nombre FROM SGI_Manuales_Documentos");
			
					
					echo "<select name='listPosEv' id='listPosEv'>";
			
					echo "<option value='0'>Selecciona...</option>";
			
								for($p = 0; $p < count($d); $p++){
						
									echo "<option value='$d[$p]'>$d[$p]</option>";
							}
					//echo "<td align='left'>";
					//	echo "<input type='text' size='20' maxlength='100' name='codigoPREV'>";
						echo "</select>";
					echo "</td>";
				echo "</tr>";
				echo "<tr height='5px'></tr>";
			
				echo "<tr><td><select name='codigoPSEVN' id='codigoPSEVN'></select></td></tr>";
				
				echo "<tr height='20px'><td></td></tr>";
	
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'></td>";
				echo "</tr>";
				
				echo "<tr height='10px'><td></td></tr>";
				
				echo "<tr height='40px'>";
					echo "<td valign='bottom' align='right'>";
						echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='30px'><td></td></tr>";
			echo "</table>";
			echo "</form>";
		}
		
	} 
	
	//EVALUACIÓN
	echo "<table border='0' align='center' width='950px'>";
		echo "<tr>";
			echo "<td id='titulo2' align='left'>Evaluación</td>";
		echo "</tr>";

		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr height='20px'><td></td></tr>";
	echo "</table>";
	
	//PROTECCION
	echo "<table border='0' align='center' width='800px'>";
		echo "<tr>";
			echo "<td id='iconosTexto2' align='left'>Protección</td>";
		echo "</tr>";
	
		echo "<tr height='20px'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='800px'>";
		echo "<tr id='iconosTexto'>";
			echo "<td align='left' width='100px'>".$proteccionDespliegue."</td> ";
			echo "<td align='left' width='650px'>".$descripcionProteccion."</td> ";
		echo "</tr>";
		
		echo "<tr height='30px'><td colspan='2'></td></tr>";
	echo "</table>";
	
	//VULNERABILIDAD
	echo "<table border='0' align='center' width='800px'>";
		echo "<tr>";
			echo "<td id='iconosTexto2' align='left'>Vulnerabilidad</td>";
		echo "</tr>";
	
		echo "<tr height='20px'><td></td></tr>";
	echo "</table>";

	echo "<table border='0' align='center' width='800px'>";
		echo "<tr >";
			echo "<td id='iconosTexto' align='left' width='100px'>";
				echo $vulnerabilidad;
				echo "<input type='hidden' name='vulnerabilidad' value='".$vulnerabilidad."'>";
			echo "</td>";
			
			if($vulnerabilidad == 'Nula'){
				
				echo "<td width='50px'></td>";
				echo "<td width='650px'></td>";
				
			}else if($vulnerabilidad == 'Muy Baja' ){
				
				echo "<td align='left' width='50px' id='ico_info'>";
					echo "<img src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' border='0' width='15px' height='15px' id='imgInfo1'>";
				echo "</td>";
				
				echo "<td align='left' width='650px' id='infoGeneral1'>";
					echo "<img src='../../Imagenes/IMG_MatrizVulnerabilidad.png' border='0'/>";
				echo "</td>";
				
			}else if($vulnerabilidad == 'Baja' ){
				
				echo "<td align='left' width='50px' id='ico_info'>";
					echo "<img src='../../Imagenes/ICN_SemaforoVerdeClaro.png' border='0' width='15px' height='15px' id='imgInfo1'>";
				echo "</td>";
				
				echo "<td align='left' width='650px' id='infoGeneral1'>";
					echo "<img src='../../Imagenes/IMG_MatrizVulnerabilidad.png' border='0'/>";
				echo "</td>";	
				
			}else if($vulnerabilidad == 'Media' ){
				
				echo "<td align='left' width='50px' id='ico_info'>";
				echo "<img src='../../Imagenes/ICN_SemaforoAmarillo.png' border='0' width='15px' height='15px' id='imgInfo1'>";
				echo "</td> ";
				
				echo "<td align='left' width='650px' id='infoGeneral1'>";
					echo "<img src='../../Imagenes/IMG_MatrizVulnerabilidad.png' border='0'/>";
				echo "</td>";
				
			}else if($vulnerabilidad == 'Alta'){
				
				echo "<td align='left' width='50px' id='ico_info'>";
					echo "<img src='../../Imagenes/ICN_SemaforoRojoClaro.png' border='0' width='15px' height='15px' id='imgInfo1'>";
				echo "</td> ";
				
				echo "<td align='left' width='650px' id='infoGeneral1'>";
					echo "<img src='../../Imagenes/IMG_MatrizVulnerabilidad.png' border='0'/>";
				echo "</td>";
				
			}else if($vulnerabilidad =='Muy Alta'){
				
				echo "<td align='left' width='50px' id='ico_info'>";
					echo "<img src='../../Imagenes/ICN_SemaforoRojoOscuro.png' border='0' width='15px' height='15px' id='imgInfo1'>";
				echo "</td> ";
				
				echo "<td align='left' width='650px' id='infoGeneral1'>";
					echo "<img src='../../Imagenes/IMG_MatrizVulnerabilidad.png' border='0'/>";
				echo "</td>";
				
			}
			
		echo "</tr>";
		
		echo "<tr height='30'><td colspan='3'></td></tr>";
	echo "</table>";
	
	


	//EVENTOS RELACIONADOS CON EL RIESGO
	echo "<table border='0' align='center' width='950px'>";
		echo "<tr >";
			echo "<td id='titulo2'  align='left'>Eventos relacionados</td> ";
		echo "</tr>";

		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr height='30px'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='800px'>";
		echo "<tr id='iconosTexto2'>";
			echo "<td align='left' width='160px'>Código</td>";
			echo "<td align='left' width='350px'>Título</td>";
			echo "<td align='center' width='100px'>Fecha</td>";
			echo "<td align='right' width='100px'>Consecuencia</td>";
			echo "<td align='left' width='20px'></td>";
		echo "</tr>";
			
		echo "<tr height='10px'><td colspan='5'></td></tr>";
			
		$s = $INTRANETV2->Execute("SELECT xt_codigoEvento FROM SGI_Riesgos_Eventos WHERE xt_codigoRiesgo = '$codigo' ");
		
		while($r = $s->fetchRow()){
			
			$eventoID 		    = $r[0];
			
			$u = $INTRANETV2->Execute("SELECT xt_titulo, xd_fecha, xn_impacto FROM SGI_Eventos WHERE xt_codigoEvento = '$eventoID'");
			
			while($t = $u->fetchRow()){
			
				
				$tituloEvento	 	= $t[0];
				$fechaEvento		= $t[1];
				$impacto			= $t[2];
				
			//} unset($r); unset($s);
			
			if($impacto != ""){
				
				$impactoDespliegue = $probabValue[$impacto];
				
			}
		
			echo "<tr>";
				echo "<td width='130' id='iconosTexto' align='left'>";
					echo "<a id='iconosTexto' href='fichaEventov2.php?evento=".$eventoID."'>".$eventoID."</a>";
				echo "</td>";
				
				echo "<td align='left' width='350' id='iconosTexto'>".$tituloEvento."</td>";
				echo "<td align='center' width='100' id='iconosTexto'>".$fechaEvento."</td>";
				echo "<td align='center' width='100' id='iconosTexto'>".$impactoDespliegue."</td>";
				
				echo "<td align='left' width='20'>";
				
					if($impactoDespliegue == 'Nula'){
						
						
					}else if($impactoDespliegue == 'Muy Baja' ){
						
						echo "<img src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' border='0' width='15px' height='15px' id='imgInfo1'>";
						
					}else if($impactoDespliegue == 'Baja' ){
						
						echo "<img src='../../Imagenes/ICN_SemaforoVerdeClaro.png' border='0' width='15px' height='15px' id='imgInfo1'>";
						
					}else if($impactoDespliegue == 'Media' ){
						
						echo "<img src='../../Imagenes/ICN_SemaforoAmarillo.png' border='0' width='15px' height='15px' id='imgInfo1'>";
						
					}else if($impactoDespliegue == 'Alta'){
						
						echo "<img src='../../Imagenes/ICN_SemaforoRojoClaro.png' border='0' width='15px' height='15px' id='imgInfo1'>";
						
					}else if($impactoDespliegue =='Muy Alta'){
						
						echo "<img src='../../Imagenes/ICN_SemaforoRojoOscuro.png' border='0' width='15px' height='15px' id='imgInfo1'>";
					
					}
				
				echo "</td>";
			echo "</tr>";
			
			} unset($t); unset($u);
		
		} unset($r); unset($s);
		
		echo "<tr height='20px'><td colspan='5'></td></tr>";
	echo "</table>";


	//SIMULACROS
	echo "<table border='0' align='center' width='950px'>";
		echo "<tr >";
			echo "<td id='titulo2'  align='left'>Simulacro</td> ";
		echo "</tr>";

		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr height='30px'><td></td></tr>";
	echo "</table>";

	$existeDecisionSim = $INTRANETV2->getOne("SELECT xt_aplicaSimulacro FROM SGI_Riesgos WHERE xt_codigoRiesgo = '".$idRiesgo."'");

	echo "<form method='post'>";

		if(!empty($existeDecisionSim)){

			echo "<table border='0' align='center' width='800px'>";

				echo "<tr><td width='100px'>".$existeDecisionSim."</td></tr><tr height='15px'></tr>";

			echo "</table>";
		}else{

		echo "<table border='0' align='center' width='800px'>";

			echo "<tr><td width='100px'><input type='radio' name='simulacroDecide' value='SI'>Si</td><td><input type='radio' name='simulacroDecide' value='NO'>No<td></td></tr>";

			echo "<tr height='40px'>";
				echo "<td></td><td></td><td valign='bottom' align='left'>";
					echo "<a href='fichaRiesgov2.php?id=".$idRiesgo."'>";
					echo "<input type='image' src='../../Imagenes/ICN_BotonEnviar.png' width='70' height='20'>";
					echo "</a>";
				echo "</td>";
			echo "</tr><tr height='15px'></tr>";

		echo "</table>";

	echo "</form>";

	}

	//SIMULACROS RELACIONADOS
	echo "<table border='0' align='center' width='950px'>";
		echo "<tr >";
			echo "<td id='titulo2'  align='left'>Simulacros relacionados</td> ";
		echo "</tr>";

		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr height='30px'><td></td></tr>";
	echo "</table>";

	echo "<table border='0' align='center' width='800px'>";
		echo "<tr>";
			echo "<td id='iconosTexto2' width='180px' align='left'>Código</td>";	
			echo "<td id='iconosTexto2' width='600px' align='left'>Simulacro</td>";
		echo "</tr>";

		//obtengo los simulacros relacionados

		

		$s = $INTRANETV2->Execute("SELECT
									A.xt_codigoSimulacro,
									B.xt_nombreSimulacro 
								FROM

									SGI_Riesgos_Simulacros A,
									SGI_Simulacros B 
									
								WHERE
									A.xt_codigoRiesgo = '".$idRiesgo."'
									AND A.xt_codigoSimulacro = B.xt_codigoSimulacro");

		while($t = $s->fetchRow()){


			echo "<tr><td><a id='iconosTexto' href='https://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/simulacroElementoActualizar.php?simulacro=".$t[0]."'>".$t[0]."</a></td><td>".$t[1]."</td></tr>";
			

		}

		echo "<tr height='25px'></tr>";

	echo "</table>";

	
	//CONTROL DE CAMBIOS
	echo "<table border='0' align='center' width='950'>";
		echo "<tr >";
			echo "<td id='titulo2' align='left'>Control de cambios</td> ";
		echo "</tr>";

		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
		
		echo "<tr height='20px'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' width='800px'>";
		echo "<tr>";
			echo "<td id='iconosTexto2' width='100px' align='left'>Versión</td>";	
			echo "<td id='iconosTexto2' width='600px' align='left'>Descripción</td>";
			echo "<td id='iconosTexto2' width='100px' align='left'>Fecha</td>";
		echo "</tr>";
	
		echo "<tr height='20'><td colspan='3'></td></tr>";
			//echo "SELECT xd_fechaCambio,xt_descripcion FROM SGI_Control_Cambios_Riesgos WHERE kf_riesgoId = $idRiesgo";
			$s = $INTRANETV2->Execute("SELECT xd_fechaCambio, xt_descripcion,xn_numero FROM SGI_Riesgos_Control_Cambios WHERE xt_codigoRiesgo = '$codigo' ORDER BY xd_fechaCambio ASC");
			
			while($u = $s->fetchRow()){
				
				echo "<tr>";
					echo "<td id='iconosTexto' align='left'>".$u[2]."</td>";
					echo "<td id='iconosTexto' align='left'>".$u[1]."</td>";
					echo "<td id='iconosTexto' align='left'>".date("Y-m-d", strtotime($u[0]))."</td>";
					
				echo "</tr>";
				
			}unset($s);unset($u);
		
		echo "<tr height='20px'><td colspan='3'></td></tr>";
	echo "</table>";
	
	//LINEA
	echo "<table border='0' align='center' width='950px'>";
		echo "<tr>";
			echo "<td id='titleBlueLineBottom'></td>";
		echo "</tr>";
	echo "</table>";
		
	//BOTON MODIFICAR
	echo "<table border='0' align='center' width='950px'>";
		echo "<tr height='40px'>";
			echo "<td valign='bottom' align='right'>";
				echo "<a href='fichaRiesgoModificarv2.php?id=".$idRiesgo."' >
					  <img src='../../Imagenes/ICN_BotonModificar.png' width='90' height='29'></a>";
				/*echo "<a href='fichaRiesgoModificarv2.php?id=".$idRiesgo."' >";
					echo "<input type='image' src='../../Imagenes/ICN_BotonModificar.png' width='90' height='29'>";
				echo "</a>";*/
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='10px'><td></td></tr>";
		///Titulo
		echo "<tr>";
			echo "<td align='center' id='nota_al_pie'>";
				echo "Creado: ".$fecha.", Salvador de la Peña";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='40px'><td></td></tr>";
	echo "</table>";
  	echo "</form>";		
echo "</div> ";

?>
        </body>
        <script>
            jQuery(document).ready(function($){
              $("#imgInfo").mouseover(function(){
            
               var posicionLeft = Math.round($("#imgInfo").offset().left)+50;
               var posicionTop = Math.round($("#imgInfo").offset().top)-120;
              
               //alert("L: "+posicionLeft+"T: "+posicionTop); 
               $("#infoGeneral").css("left",posicionLeft); 
               $("#infoGeneral").css("top",posicionTop);
               $("#infoGeneral").css("visibility","visible");
              
              });
            
             $("#imgInfo").mouseout(function(){
              $("#infoGeneral").css("visibility","hidden");
             });
             
             $("#imgInfo1").mouseover(function(){
            
               var posicionLeft = Math.round($("#imgInfo1").offset().left)+50;
               var posicionTop = Math.round($("#imgInfo1").offset().top)-250;
              
               //alert("L: "+posicionLeft+"T: "+posicionTop); 
               $("#infoGeneral1").css("left",posicionLeft); 
               $("#infoGeneral1").css("top",posicionTop);
               $("#infoGeneral1").css("visibility","visible");
              
              });
            
             $("#imgInfo1").mouseout(function(){
              $("#infoGeneral1").css("visibility","hidden");
             });
             
             
            });
        </script>
    </html>
<?php
