<?PHP
$nombrephp="fichaPersonal.php";
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");
//require_once("MailAltaUsuario.php");

error_reporting(E_PARSE);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Datos Personal</title>
<?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
            
           <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
           
           
           
           
           
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
            
            <script>
				function show(valor){
					if(valor == 1){
						document.getElementById("Agregar").style.display="block";
						document.getElementById("mostrar").style.display="none";
						document.getElementById("ocultar").style.display="block";
					} else if (valor == 0){
						document.getElementById("Agregar").style.display="none";
						document.getElementById("mostrar").style.display="block";
						document.getElementById("ocultar").style.display="none";
					}
				}
			</script>
            
               <script>
				function show2(valor){
					if(valor == 1){
						document.getElementById("agrega").style.display="block";
						document.getElementById("activo").style.display="none";
						document.getElementById("inactivo").style.display="block";
					} else if (valor == 0){
						document.getElementById("agrega").style.display="none";
						document.getElementById("activo").style.display="block";
						document.getElementById("inactivo").style.display="none";
					}
				}
			</script>
            <script type="text/javascript">
				function reCargarPadre(){
					<?php
					echo"opener.location.href='https://escalante.com.mx/Sistemas/INTRANET_GEA/ComunicacionInterna/Personal/fichaPersonal.php?ID=$IDpersonal\';";
					?>
					window.close();
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
			   
    			function activaFile(cual){
 					var vFile=document.getElementById(cual);
  	 				if(vFile.style.display == 'block') {
      					vFile.style.display = 'none';
   	  				} else {
      					vFile.style.display = 'block';
   					}
    			}
			   
		   </script>

		   	<script>
				function confirmDelete(resguardoId){
					var confirmacion = confirm(" Se eliminará toda la información. Confirma eliminar Resguardo?");
					if (confirmacion != false) {
						
						var xhttp = new XMLHttpRequest();

						xhttp.onreadystatechange = function() {
							
							if (xhttp.readyState == 4 && xhttp.status == 200) {

								if(xhttp.responseText == ""){
									location.reload();
								}else{
									alert(xhttp.responseText);
									//actualizaReferencia(referencia);
								}
							}
						};
						
						xhttp.open("POST", "eliminaResguardoPersonal.php", true);
						xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						xhttp.send("resguardoId=" + resguardoId);
					}	
				}

				function eliminaDocumentoExpediente(usuario, ruta){
					var confirmacion = confirm("Confirma eliminar documento de expediente?");
					if (confirmacion != false) {

						var xhttp = new XMLHttpRequest();

						xhttp.onreadystatechange = function() {
							
							if (xhttp.readyState == 4 && xhttp.status == 200) {

								if(xhttp.responseText == ""){
									location.reload();
								}else{
									alert(xhttp.responseText);
									//actualizaReferencia(referencia);
								}
							}
						};
						
						xhttp.open("POST", "eliminaExpediente.php", true);
						xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						xhttp.send("evento=eliminaDocumento&usuario="+usuario+"&ruta="+ruta);
						
					}	
				}
			</script>
           
            <style>
			.enlaces { 
			FONT-SIZE: 11px; 
			font-family:Lucida Sans;
			font-size:12px;
			color:#007cbd; 
			TEXT-DECORATION: none 
			}
			</style>
  	 
				</head>

<body>
<?PHP

$breadcrumb="<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Home.php' id='breadcrumbs'>Home /</a> <a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/miCuenta.php' id='breadcrumbs'>Mi cuenta";

if($_POST["usuarioRechazaDatos"]){
	$INTRANET->Execute("
		UPDATE SGI_Empleados 
		set 
			xd_fechaActualizacionDatos = NOW(),
			xt_estatusDatosPersonales= 'Rechazado'
		WHERE kf_usuario = '".$_POST["usuarioRechazaDatos"]."' ");
}

if($_POST["usuarioAceptaDatos"]){

	$datosPersonal= $INTRANET->getRow("SELECT * FROM SGI_Empleados WHERE kf_usuario='".$_POST["usuarioAceptaDatos"]."' ORDER BY xn_Foto ");

	if ($datosPersonal["xt_calle"] != '' && 
		$datosPersonal["xt_colonia"] != '' && 
		$datosPersonal["xt_codigoPostal"] != '' && 
		$datosPersonal["xt_delegacionMunicipio"] != '' && 
		$datosPersonal["xt_datosCiudad"] != '' && 
		$datosPersonal["xt_telefonoCelular"] != '' && 
		$datosPersonal["xt_nivelEstudios"] != '' &&  
		$datosPersonal["xt_relacionFuncionariosPublicos"] != '' && 
		$datosPersonal["xt_contactoEmergenciaNombre"] != '' && 
		$datosPersonal["xt_contactoEmergenciaParentesco"] != '' && 
		$datosPersonal["xt_contactoEmergenciaTelefono"] != '' && 
		$datosPersonal["xt_contactoEmergenciaDomicilio"] != '' ) {
		

		$INTRANET->Execute("
			UPDATE SGI_Empleados 
			set 
				xd_fechaActualizacionDatos = NOW(),
				xt_estatusDatosPersonales= ''
			WHERE kf_usuario = '".$_POST["usuarioAceptaDatos"]."' 
		");
	}else{
		echo "
			<script>
				alert('Por favor, complete los datos requeridos.');
				window.location.href = 'datosPersonal.php?evento=modificar';
			</script>
		";
	}

	
}

if($_POST["usuarioAceptaCarta"]){

	$INTRANET->Execute("
		UPDATE SGI_Empleados 
		set 
		xd_aceptacionCartaCompromiso = NOW()
		WHERE kf_usuario = '".$_POST["usuarioAceptaCarta"]."' 
	");
	
}

if($_POST["kf_usuario"]){
	$INTRANET->Execute("
		UPDATE SGI_Empleados 
		set  
			xt_calle = '".$_POST["xt_calle"]."', 
			xt_entreCalles = '".$_POST["xt_entreCalles"]."', 
			xt_colonia = '".$_POST["xt_colonia"]."', 
			xt_codigoPostal = '".$_POST["xt_codigoPostal"]."', 
			xt_delegacionMunicipio = '".$_POST["xt_delegacionMunicipio"]."', 
			xt_datosCiudad = '".$_POST["xt_datosCiudad"]."', 
			xt_telefonoParticular = '".$_POST["xt_telefonoParticular"]."', 
			xt_telefonoCelular = '".$_POST["xt_telefonoCelular"]."', 
			xt_nivelEstudios = '".$_POST["xt_nivelEstudios"]."', 
			xt_estadoCivil = '".$_POST["xt_estadoCivil"]."', 
			xt_nombreEsposo = '".$_POST["xt_nombreEsposo"]."', 
			xt_nombresHijos = '".$_POST["xt_nombresHijos"]."', 
			xt_relacionFuncionariosPublicos = '".$_POST["xt_relacionFuncionariosPublicos"]."', 
			xt_tipoSangre = '".$_POST["xt_tipoSangre"]."', 
			xt_alergias = '".$_POST["xt_alergias"]."', 
			xt_enfermedades = '".$_POST["xt_enfermedades"]."', 
			xt_restrccionesSalud = '".$_POST["xt_restrccionesSalud"]."', 
			xt_seguroGastosMedicos = '".$_POST["xt_seguroGastosMedicos"]."', 
			xt_numeroPoliza = '".$_POST["xt_numeroPoliza"]."', 
			xt_aseguradora = '".$_POST["xt_aseguradora"]."', 
			xt_aseguradoraTelefono = '".$_POST["xt_aseguradoraTelefono"]."',  
			xt_contactoEmergenciaNombre = '".$_POST["xt_contactoEmergenciaNombre"]."', 
			xt_contactoEmergenciaParentesco = '".$_POST["xt_contactoEmergenciaParentesco"]."', 
			xt_contactoEmergenciaTelefono = '".$_POST["xt_contactoEmergenciaTelefono"]."', 
			xt_contactoEmergenciaDomicilio = '".$_POST["xt_contactoEmergenciaDomicilio"]."',
			xt_estatusDatosPersonales= ''
		WHERE kf_usuario = '".$_POST["kf_usuario"]."' ");
}

if($_GET["usuario"]){
	$datosPersonal= $INTRANET->getRow("SELECT * FROM SGI_Empleados WHERE kf_usuario='".$_GET["usuario"]."' ORDER BY xn_Foto ");
}else{
	$datosPersonal= $INTRANET->getRow("SELECT * FROM SGI_Empleados WHERE kf_usuario='".$_SESSION["sesionUsuario"]."' ORDER BY xn_Foto ");
}

//var_dump($datosPersonal);	

echo"<div id='wrapperFicha' align='center'>";

	echo "<table border='0' align='center' name='Encabezado'>";		
		echo"<tr height='80px'> </tr>";
		///Titulo Ficha
		echo"<tr>";
			echo"<td align='center' id='titulo1' width='700px'>";
				echo "Datos Personal";
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
		//echo"<tr height='100'> </tr>";
	echo "</table>";
	
	
	//banana de navegacion
	echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
		include("../../navegacion_banana.php");
	echo "</table>";
		

	echo "<table border='0' align='center'>";
		echo"<tr height='100'><td></td></tr>";
	echo "</table>"; 


	if($_REQUEST["evento"] != "modificar"){

		echo "<table border='0' align='center'>";
			echo"<tr height='50'><td align='center'>Ultima actualizacion ".$datosPersonal["xd_fechaActualizacionDatos"]."</td></tr>";
			if($datosPersonal["xt_estatusDatosPersonales"] == "Rechazado"){
				echo"<tr height='50'><td align='center' style='color:red;'>Estatus: Incompleto por campos obligatorios pendientes.<br>Da clic en \"Modificar\" y completa la información.</td></tr>";
			}
			echo"<tr height='50'><td align='center'>El asterisco (*) indica que el campo es obligatorio.</td></tr>";
		echo "</table>"; 

		echo "<table border='0' align='center' width='600'>";
			echo"<tr height='30px'> </tr>";
			
			echo"<tr>";
				echo"<td id='titulo2' colspan='2'>Datos Generales</td>";
			echo"</tr>";
			
		///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			echo"<tr height='30px'> </tr>";
			
		//FOTO //NUMERO DE PERSONAL

			echo "<tr align='left' height='20' >";
				echo "<td id='titulo2' align='left'>".$datosPersonal["xt_NumPersonal"]."</td>"; 
				if($datosPersonal["xn_Foto"] == ""){
					echo "<td  align='left'> <img src='FILES/sinFoto.jpg' height='117' width='100'> </td>";
				}else{
					
					echo "<td  align='left'> <img src='".$datosPersonal["xn_Foto"]."' height='117' width='100'> </td>";
				}
				
			echo "</tr>";
			
			echo"<tr height='10'> </tr>";
			
		//NOMBRE
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>Nombre: </td>";
				echo "<td id='iconosTexto' align='left'>".$datosPersonal["xt_Nombre"]."</td>";
			echo "</tr>";
			
			echo"<tr height='10'> </tr>";
			
		//APELLIDO PATERNO
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>Apellido paterno: </td>";
				echo "<td id='iconosTexto' align='left'>".$datosPersonal["xt_ApellidoPaterno"]."</td>";
			echo "</tr>";

			echo"<tr height='10'> </tr>";
			
		//APELLIDO MATERNO
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>Apellido materno: </td>";
				echo "<td id='iconosTexto' align='left'>".$datosPersonal["xt_ApellidoMaterno"]."</td>";
			echo "</tr>";
			
			echo"<tr height='10'> </tr>";

		//CALLE
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>*Calle: </td>";
				echo "<td id='iconosTexto' align='left'>".$datosPersonal["xt_calle"]."</td>";
			echo "</tr>";

			echo"<tr height='10'> </tr>";

		//ENTRE CALLES
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>Entre Calles: </td>";
				echo "<td id='iconosTexto' align='left'>".$datosPersonal["xt_entreCalles"]."</td>";
			echo "</tr>";

			echo"<tr height='10'> </tr>";

		//COLONIA
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>*Colonia: </td>";
				echo "<td id='iconosTexto' align='left'>".$datosPersonal["xt_colonia"]."</td>";
			echo "</tr>";

			echo"<tr height='10'> </tr>";

		//CODIGO POSTAL
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>*Código Postal: </td>";
				echo "<td id='iconosTexto' align='left'>".$datosPersonal["xt_codigoPostal"]."</td>";
			echo "</tr>";

			echo"<tr height='10'> </tr>";

		//DELEGACION/MUNICIPIO
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>*Delegación/Municipio: </td>";
				echo "<td id='iconosTexto' align='left'>".$datosPersonal["xt_delegacionMunicipio"]."</td>";
			echo "</tr>";

			echo"<tr height='10'> </tr>";

		//CIUDAD
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>*Ciudad: </td>";
				echo "<td id='iconosTexto' align='left'>".$datosPersonal["xt_datosCiudad"]."</td>";
			echo "</tr>";

			echo"<tr height='10'> </tr>";

		//TELEFONO PARTICULAR
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>Teléfono particular: </td>";
				echo "<td id='iconosTexto' align='left'>".$datosPersonal["xt_telefonoParticular"]."</td>";
			echo "</tr>";

			echo"<tr height='10'> </tr>";
		
		//TELEFONO CELULAR
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>*Teléfono celular: </td>";
				echo "<td id='iconosTexto' align='left'>".$datosPersonal["xt_telefonoCelular"]."</td>";
			echo "</tr>";

			echo"<tr height='10'> </tr>";

		//NIVEL ESTUDIOS
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>*Nivel de estudios: </td>";
				echo "<td id='iconosTexto' align='left'>".$datosPersonal["xt_nivelEstudios"]."</td>";
			echo "</tr>";

			echo"<tr height='10'> </tr>";

		//ESTADO CIVIL
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>Estado civil: </td>";
				echo "<td id='iconosTexto' align='left'>".$datosPersonal["xt_estadoCivil"]."</td>";
			echo "</tr>";

			echo"<tr height='10'> </tr>";

		//NOMBRE ESPOSO(A)
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>Nombre esposo(a): </td>";
				echo "<td id='iconosTexto' align='left'>".$datosPersonal["xt_nombreEsposo"]."</td>";
			echo "</tr>";

			echo"<tr height='10'> </tr>";

		//NOMNRE DE HIJOS
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>Nombre de hijos: </td>";
				echo "<td id='iconosTexto' align='left'>".$datosPersonal["xt_nombresHijos"]."</td>";
			echo "</tr>";

			echo"<tr height='10'> </tr>";


		//RELACION FUNCIONARIOS PUBLICOS
		
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left' width='264px'>*Relación familiar con funcionarios públicos de alto nivel:</td>";
				echo "<td id='iconosTexto' align='left'>".$datosPersonal["xt_relacionFuncionariosPublicos"]."</td>";
			echo "</tr>";

			echo"<tr height='10'> </tr>";
		
		echo "</table>";


				
		echo "<table border='0' align='center' width='600'>";

			echo"<tr height='30px'> </tr>";

			echo"<tr>";
				echo"<td id='titulo2' colspan='2'>Datos de salud</td>";
			echo"</tr>";
		///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			echo"<tr height='30px'> </tr>";
			
		
					
		//TIPO SANGRE
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>Tipo de sangre: </td>";
				echo "<td id='iconosTexto' align='left'>".$datosPersonal["xt_tipoSangre"]."</td>";
			echo "</tr>";
			
			echo"<tr height='10'> </tr>";
			
		//ALERGIAS
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>Alergias: </td>";
				echo "<td id='iconosTexto' align='left'>".$datosPersonal["xt_alergias"]."</td>";
			echo "</tr>";

			echo"<tr height='10'> </tr>";
			
		//ENGERMEDADES
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>Enfermedades: </td>";
				echo "<td id='iconosTexto' align='left'>".$datosPersonal["xt_enfermedades"]."</td>";
			echo "</tr>";
			
			echo"<tr height='10'> </tr>";

		//RESTRICCIONES DE SALUD
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>Restricciones de salud: </td>";
				echo "<td id='iconosTexto' align='left'>".$datosPersonal["xt_restrccionesSalud"]."</td>";
			echo "</tr>";

			echo"<tr height='10'> </tr>";

		//SEGURO DE GASTOS MEDICOS
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>Seguro de gastos médicos: </td>";
				echo "<td id='iconosTexto' align='left'>".$datosPersonal["xt_seguroGastosMedicos"]."</td>";
			echo "</tr>";

			echo"<tr height='10'> </tr>";

		


		//NUMERO POLIZA
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>Número de póliza: </td>";
				echo "<td id='iconosTexto' align='left'>".$datosPersonal["xt_numeroPoliza"]."</td>";
			echo "</tr>";

			echo"<tr height='10'> </tr>";

		//COMPAÑIA ASEGURADORA
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>Compañía aseguradora: </td>";
				echo "<td id='iconosTexto' align='left'>".$datosPersonal["xt_aseguradora"]."</td>";
			echo "</tr>";

			echo"<tr height='10'> </tr>";

		//TELEFONO
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>Teléfono aseguradora: </td>";
				echo "<td id='iconosTexto' align='left'>".$datosPersonal["xt_aseguradoraTelefono"]."</td>";
			echo "</tr>";

			echo"<tr height='10'> </tr>";

		echo "</table>";



		echo "<table border='0' align='center' width='600'>";

			echo"<tr height='30px'> </tr>";

			echo"<tr>";
				echo"<td id='titulo2' colspan='2'>En caso de emergencia comunicarse con:</td>";
			echo"</tr>";
		///Linea
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='2'></td>";
			echo "</tr>";
			echo"<tr height='30px'> </tr>";
			
		
					
		//NOMBRE
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>*Nombre: </td>";
				echo "<td id='iconosTexto' align='left'>".$datosPersonal["xt_contactoEmergenciaNombre"]."</td>";
			echo "</tr>";
			
			echo"<tr height='10'> </tr>";
			
		//PARENTESCO
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>*Parentesco: </td>";
				echo "<td id='iconosTexto' align='left'>".$datosPersonal["xt_contactoEmergenciaParentesco"]."</td>";
			echo "</tr>";

			echo"<tr height='10'> </tr>";
			
		//TELEFONO
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>*Teléfono: </td>";
				echo "<td id='iconosTexto' align='left'>".$datosPersonal["xt_contactoEmergenciaTelefono"]."</td>";
			echo "</tr>";
			
			echo"<tr height='10'> </tr>";

		//DOMICILIO
			echo "<tr align='left' height='20' >";
				echo "<td id='iconosTexto2' align='left'>*Domicilio: </td>";
				echo "<td id='iconosTexto' align='left'>".$datosPersonal["xt_contactoEmergenciaDomicilio"]."</td>";
			echo "</tr>";

			echo"<tr height='10'> </tr>";

		echo "</table>";
			
		echo "<table border='0' align='center' width='600'>";
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='3'></td>";
			echo "</tr>";
			echo"<tr height='30px'> </tr>";
			
			
			echo"<tr height='40'>";
				if($_SESSION["sesionUsuario"] == "cozy" || $_SESSION["sesionUsuario"] == "Elena_Hernandez" || $_SESSION["sesionUsuario"] == "sdelap" || $_SESSION["sesionUsuario"] == "Pedro_Moyotl" || $_SESSION["sesionUsuario"] == "Ana_Ortiz" || $_SESSION["sesionUsuario"] == "Byron_Lopez" || $_SESSION["sesionUsuario"] == "Cindy_Fuentes" || $_SESSION["sesionUsuario"] == "Daniel_Guadarrama" || $_SESSION["sesionUsuario"] == "Carlos_Jimenez"|| $_SESSION["sesionUsuario"] == "Mariana_Escalante" || $_SESSION["sesionUsuario"] == "Adlemy_Tah"|| $_SESSION["sesionUsuario"] == "Denisse_Valladares" || $_SESSION["sesionUsuario"] == "Miguel_Patiño"){
					echo"<td valign='bottom' align='right'>";
						echo "<form  method='POST' action='datosPersonal.php'>";
							echo "<input type= 'hidden' name='usuarioRechazaDatos' value='".$datosPersonal["kf_usuario"]."' >";
							echo "<input type='submit' style='background-color: red; width: 100px; height: 31px;' value='Rechazar'></input>";
							echo "</form>";
					echo"</td>";
				}

				echo"<td valign='bottom' align='right'>";
					echo "<a href='datosPersonal.php?evento=modificar'><img src='../../Imagenes/ICN_BotonModificar.png' width='90' height='29'></img></a>";
				echo"</td>";
				
				echo"<td valign='bottom' align='right'>";
					echo "<form  method='POST' action='datosPersonal.php'>";
						echo "<input type= 'hidden' name='usuarioAceptaDatos' value='".$datosPersonal["kf_usuario"]."' >";
						//echo "<input type='image'src='../../Imagenes/ICN_BotonAceptar.png' width='90' height='29'>";
						echo "<input type='submit' style='height: 31px; width: 100px; background: dodgerblue; color: white;' value='Renovar'>";
					echo "</form>";
				echo"</td>";
			echo"</tr>";
			
			
			echo"<tr height='30px'> </tr>";
			
		echo "</table>";
	
	}else{

		echo "<form  method='POST' action='datosPersonal.php'>";
		
			echo "<table border='0' align='center' width='600'>";
				echo"<tr height='30px'> </tr>";

				echo"<tr>";
					echo"<td id='titulo2' colspan='2'>Datos Generales</td>";
				echo"</tr>";
			///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				echo"<tr height='30px'> </tr>";
				
			//FOTO //NUMERO DE PERSONAL
				echo "<tr align='left' height='20' >";
					echo "<td id='titulo2' align='left'>".$datosPersonal["xt_NumPersonal"]." <input type= 'hidden' name='kf_usuario' value='".$datosPersonal["kf_usuario"]."' ></td>"; 
					if($datosPersonal["xn_Foto"] == ""){
						echo "<td  style='display:inline;' align='left'>"; 
							echo "<img src='FILES/sinFoto.jpg' height='117' width='100'>";
							//echo "<a href='CambiarFotoPopUp.php?ID=".$datosPersonal["kp_personalId"]."'  target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=500,scrollbars=yes')\"><br>
							//<img src='../../Imagenes/ICN_BotonModificar.png' height='20' width='80'></a>"; 
						echo "</td>";
					}else{
						
						echo "<td style='display:inline;' align='left'>";
							echo "<img src='".$datosPersonal["xn_Foto"]."' height='117' width='100'>";
							//echo "<a href='CambiarFotoPopUp.php?ID=".$datosPersonal["kp_personalId"]."'  target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=500,scrollbars=yes')\"><br>
							//<img src='../../Imagenes/ICN_BotonModificar.png' height='20' width='80'></a>";
						echo "</td>";
					}
					
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
						
			//NOMBRE
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left'>Nombre: </td>";
					echo "<td id='iconosTexto' align='left'>".$datosPersonal["xt_Nombre"]."</td>";
					//echo "<td id='iconosTexto' align='left'><input type='text' size='50' value='".$datosPersonal["xt_Nombre"]."' name='xt_Nombre'></td>";
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
				
			//APELLIDO PATERNO
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left'>Apellido paterno: </td>";
					echo "<td id='iconosTexto' align='left'>".$datosPersonal["xt_ApellidoPaterno"]."</td>";
					//echo "<td id='iconosTexto' align='left'><input type='text' size='50' value='".$datosPersonal["xt_ApellidoPaterno"]."' name='xt_ApellidoPaterno'></td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";
				
			//APELLIDO MATERNO
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left'>Apellido materno: </td>";
					echo "<td id='iconosTexto' align='left'>".$datosPersonal["xt_ApellidoMaterno"]."</td>";
					//echo "<td id='iconosTexto' align='left'><input type='text' size='50' value='".$datosPersonal["xt_ApellidoMaterno"]."' name='xt_ApellidoMaterno'></td>";
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";

			//CALLE
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left'>*Calle: </td>";
					echo "<td id='iconosTexto' align='left'><input type='text' size='50' value='".$datosPersonal["xt_calle"]."' name='xt_calle' required></td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";

			//ENTRE CALLES
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left'>Entre Calles: </td>";
					echo "<td id='iconosTexto' align='left'><input type='text' size='50' value='".$datosPersonal["xt_entreCalles"]."' name='xt_entreCalles'></td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";

			//COLONIA
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left'>*Colonia: </td>";
					echo "<td id='iconosTexto' align='left'><input type='text' size='50' value='".$datosPersonal["xt_colonia"]."' name='xt_colonia' required></td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";

			//CODIGO POSTAL
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left'>*Código Postal: </td>";
					echo "<td id='iconosTexto' align='left'><input type='text' size='50' value='".$datosPersonal["xt_codigoPostal"]."' name='xt_codigoPostal' required></td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";

			//DELEGACION/MUNICIPIO
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left'>*Delegación/Municipio: </td>";
					echo "<td id='iconosTexto' align='left'><input type='text' size='50' value='".$datosPersonal["xt_delegacionMunicipio"]."' name='xt_delegacionMunicipio' required></td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";

			//CIUDAD
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left'>*Ciudad: </td>";
					echo "<td id='iconosTexto' align='left'><input type='text' size='50' value='".$datosPersonal["xt_datosCiudad"]."' name='xt_datosCiudad' required></td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";

			//TELEFONO PARTICULAR
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left'>Teléfono particular: </td>";
					echo "<td id='iconosTexto' align='left'><input type='text' size='50' value='".$datosPersonal["xt_telefonoParticular"]."' name='xt_telefonoParticular'></td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";
			
			//TELEFONO CELULAR
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left'>*Teléfono celular: </td>";
					echo "<td id='iconosTexto' align='left'><input type='text' size='50' value='".$datosPersonal["xt_telefonoCelular"]."' name='xt_telefonoCelular' required></td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";

			//NIVEL ESTUDIOS
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left'>*Nivel de estudios: </td>";
					echo "<td id='iconosTexto' align='left'><input type='text' size='50' value='".$datosPersonal["xt_nivelEstudios"]."' name='xt_nivelEstudios' required></td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";

			//ESTADO CIVIL
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left'>Estado civil: </td>";
					echo "<td id='iconosTexto' align='left'><input type='text' size='50'value='".$datosPersonal["xt_estadoCivil"]."' name='xt_estadoCivil'></td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";

			//NOMBRE ESPOSO(A)
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left'>Nombre esposo(a): </td>";
					echo "<td id='iconosTexto' align='left'><input type='text' size='50' value='".$datosPersonal["xt_nombreEsposo"]."' name='xt_nombreEsposo'></td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";

			//NOMNRE DE HIJOS
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left'>Nombre de hijos: </td>";
					echo "<td id='iconosTexto' align='left'><input type='text' size='50' value='".$datosPersonal["xt_nombresHijos"]."' name='xt_nombresHijos'></td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";


			//RELACION FUNCIONARIOS PUBLICOS
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left' width='264px'>*Relación familiar con funcionarios públicos de alto nivel: </td>";
					echo "<td id='iconosTexto' align='left'><input type='text' size='50' value='".$datosPersonal["xt_relacionFuncionariosPublicos"]."' name='xt_relacionFuncionariosPublicos' required></td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";
				
			echo "</table>";



			echo "<table border='0' align='center' width='600'>";

				echo"<tr height='30px'> </tr>";

				echo"<tr>";
					echo"<td id='titulo2' colspan='2'>Datos de salud</td>";
				echo"</tr>";
			///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				echo"<tr height='30px'> </tr>";
				
			
						
			//TIPO SANGRE
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left'>Tipo de sangre: </td>";
					echo "<td id='iconosTexto' align='left'><input type='text' size='50' value='".$datosPersonal["xt_tipoSangre"]."' name='xt_tipoSangre'></td>";
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
				
			//ALERGIAS
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left'>Alergias: </td>";
					echo "<td id='iconosTexto' align='left'><input type='text' size='50' value='".$datosPersonal["xt_alergias"]."' name='xt_alergias'></td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";
				
			//ENGERMEDADES
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left'>Enfermedades: </td>";
					echo "<td id='iconosTexto' align='left'><input type='text' size='50' value='".$datosPersonal["xt_enfermedades"]."' name='xt_enfermedades'></td>";
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";

			//RESTRICCIONES DE SALUD
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left'>Restricciones de salud: </td>";
					echo "<td id='iconosTexto' align='left'><input type='text' size='50' value='".$datosPersonal["xt_restrccionesSalud"]."' name='xt_restrccionesSalud'></td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";

			//SEGURO DE GASTOS MEDICOS
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left'>Seguro de gastos médicos: </td>";
					echo "<td id='iconosTexto' align='left'><input type='text' size='50' value='".$datosPersonal["xt_seguroGastosMedicos"]."' name='xt_seguroGastosMedicos'></td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";

			


			//NUMERO POLIZA
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left'>Número de póliza: </td>";
					echo "<td id='iconosTexto' align='left'><input type='text' size='50' value='".$datosPersonal["xt_numeroPoliza"]."' name='xt_numeroPoliza'></td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";

			//COMPAÑIA ASEGURADORA
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left'>Compañía aseguradora: </td>";
					echo "<td id='iconosTexto' align='left'><input type='text' size='50' value='".$datosPersonal["xt_aseguradora"]."' name='xt_aseguradora'></td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";

			//TELEFONO
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left'>Teléfono aseguradora: </td>";
					echo "<td id='iconosTexto' align='left'><input type='text' size='50' value='".$datosPersonal["xt_aseguradoraTelefono"]."' name='xt_aseguradoraTelefono'></td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";

			echo "</table>";



			echo "<table border='0' align='center' width='600'>";

				echo"<tr height='30px'> </tr>";

				echo"<tr>";
					echo"<td id='titulo2' colspan='2'>En caso de emergencia comunicarse con:</td>";
				echo"</tr>";
			///Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				echo"<tr height='30px'> </tr>";
				
			
						
			//NOMBRE
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left'>*Nombre: </td>";
					echo "<td id='iconosTexto' align='right'><input type='text' size='50' value='".$datosPersonal["xt_contactoEmergenciaNombre"]."' name='xt_contactoEmergenciaNombre' required></td>";
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";
				
			//PARENTESCO
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left'>*Parentesco: </td>";
					echo "<td id='iconosTexto' align='right'><input type='text' size='50' value='".$datosPersonal["xt_contactoEmergenciaParentesco"]."' name='xt_contactoEmergenciaParentesco' required></td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";
				
			//TELEFONO
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left'>*Telefono: </td>";
					echo "<td id='iconosTexto' align='right'><input type='text' size='50' value='".$datosPersonal["xt_contactoEmergenciaTelefono"]."' name='xt_contactoEmergenciaTelefono' required></td>";
				echo "</tr>";
				
				echo"<tr height='10'> </tr>";

			//DOMICILIO
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left'>*Domicilio: </td>";
					echo "<td id='iconosTexto' align='right'><input type='text' size='50' value='".$datosPersonal["xt_contactoEmergenciaDomicilio"]."' name='xt_contactoEmergenciaDomicilio' required></td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";

			echo "</table>";

			
			echo "<table border='0' align='center' width='600'>";
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				echo"<tr height='30px'> </tr>";
				
				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right' colspan='2'>";
						echo "<input type='submit' value='Guardar'>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='30px'> </tr>";
			echo "</table>";

		echo "</form>";
			
	}
	

echo "</div>";

?>
</body>
</html>