<?php
$nombrephp = 'ReporteDocsFaltantes.php';
require_once("../conexionMasterDB.php");
require_once("../INTRANET_GEA/ConexionDBT.php");
//require_once("../compruebaUsuario.php");

function limpiar_caracter_especial($string){

    $string = trim($string);

    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Ã¡', 'Á', 'À', 'Â', 'Ä', 'Ã'),
        array('a', 'a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A', 'A'),
        $string
    );

    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'Ã©', 'É', 'È', 'Ê', 'Ë', 'Ã‰'),
        array('e', 'e', 'e', 'e', 'e', 'E', 'E', 'E', 'E', 'E'),
        $string
    );

    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Ã­', 'Í', 'Ì', 'Ï', 'Î', 'Ã'),
        array('i', 'i', 'i', 'i', 'i', 'I', 'I', 'I', 'I', 'I'),
        $string
    );

    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ã³', 'Ó', 'Ò', 'Ö', 'Ô', 'Ã“'),
        array('o', 'o', 'o', 'o', 'o', 'O', 'O', 'O', 'O', 'O'),
        $string
    );

    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ãº', 'Ú', 'Ù', 'Û', 'Ü', 'Ãš'),
        array('u', 'u', 'u', 'u', 'u', 'U', 'U', 'U', 'U', 'U'),
        $string
    );

    $string = str_replace(
        array('ñ', 'Ã±', 'Ñ', 'Ã‘', 'ç', 'Ç'),
        array('n', 'n', 'N', 'N', 'c', 'C',),
        $string
    );

    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
        array("\\", "¨", "º", "-", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             " ", "â€“", "–"),
        '',
        $string
    );
    return $string;
}
 ?>
<!DOCTYPE html>
<html>
<head>
	<link href="css/style2.css" rel="stylesheet" type="text/css" />
	<link href="css/style.css" rel="stylesheet" type="text/css" /> 
    <script src="JQuery/jquery.js"></script>

    <script type="text/javascript" src="JQuery/js/jquery-ui-1.8.17.custom.min.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	


<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">


	<title>Nuevo Usuario</title>
	<style>
	.main {
    width: 70%;
    margin: 0px auto;
}

.form-group .form-control {
    padding-left: 2.375rem;
}

.form-group .form-control-icon {
    position: absolute;
    z-index: 2;
    display: block;
    width: 2.375rem;
    height: 2.375rem;
    line-height: 2.375rem;
    text-align: center;
    pointer-events: none;
    color: #aaa;
}
	</style>

	 




	</script>
</head>
<body>
<?php
	 
    
  		echo '<div id="fondo_gris">';
   			echo '<div id="contenido">';
    				//echo '<div id="centro">';
						//echo '<div id="fondo_encabezado"></div>';
						//echo '<div id="fondo_cuerpo">';
					date_default_timezone_set('America/Los_Angeles');
							echo '<div class="container-fluid">';
									
							echo '<div class="card text-center"  style="width: 50rem;margin:0 auto 10px; auto; border: #d0d0d0 1px solid;">
								<div class="card-header" style="background:#009bda; color:white;">
							  		Nuevo Usuario
								</div>
								<div class="card-body" style="background: #e0e1e3">';
									echo "<div align='center' class='container'>";

									if(isset($_POST['siguiente'])){

											try
											{
												$archivo 	= 	$_FILES['archivo']['name'];
												$nombre 	=	ucfirst(trim($_POST['nombre'].""));
												$apaterno 	=	ucfirst(trim($_POST['apaterno']));
												$aMaterno 	=	trim($_POST['aMaterno']);
												$correo 	=	trim($_POST['correo']);
												$categoria  =	trim($_POST['categoria']);
												$oficina 	=	trim($_POST['oficinas']);
												$clientes 	=	trim($_POST['clientes']);
												$cliente 	= 	explode("-", $clientes); //0 Id  1 RFC 2 Nombre
												$nombreReal = 	explode(" ", $nombre." ");				
												$rol 		=	$_POST['perfiles'];
												$modulo 	=	$_POST['modulo']; 
												$proceso 	=	$_POST['proceso'];
												$actividad 	=	$_POST['actividad'];
												$rfc 	=	$_POST['rfc'];
												$usuario	= $nombreReal[0]."_".$apaterno;
												$nombreIdUsr= $nombre." ".$apaterno." ".$aMaterno;
if($MASTER_GE->Execute("INSERT INTO PERFILES.USUARIOS (xt_usuario, xt_password, xt_nombre, xt_categoria, xt_correo, xn_estilo, xt_estatus,xt_rfc)  VALUES ('$usuario', 'escalante123', '$nombreIdUsr', '$categoria', '$correo', 1, 'Activo', '$rfc') ")){
	echo "<div class'col-sm-12'>";
	echo "1-Usuario $usuario Creado con el password escalante123 <br>";
	echo "</div>";
	if($MASTER_GE->Execute("INSERT INTO PERFILES.OFICINAS (xt_usuario, xt_oficina) values ('$usuario', '$oficina') ")){
		echo "<div class'col-sm-12'>";
		echo "2-Usuario $usuario asignado a la oficina $oficina <br>";
		echo "</div>";
		if($MASTER_GE->Execute("INSERT INTO PERFILES.CLIENTES  (xt_usuario, xt_oficina, xn_clienteId, xt_rfc) values ('$usuario', '$oficina', '$cliente[0]','$cliente[1]')")){
			echo "<div class'col-sm-12'>";
			echo "3-Usuario $usuario asignado al cliente $cliente[2]  $cliente[1]  <br>";
			echo "</div>";
			if($MASTER_GE->Execute("INSERT INTO PERFILES.ROLES (xt_usuario, xt_oficina, xt_rol) values ('$usuario', '$oficina', '$rol')")){

				echo "<div class'col-sm-12'>";
				echo "4-Usuario $usuario asignado al rol $rol en $oficina   <br>";
				echo "</div>";
				if($MASTER_GE->Execute("INSERT INTO PERFILES.MODULOS (xt_usuario, xt_oficina, xt_rol, xt_modulo) values ('$usuario',  '$oficina', '$rol', '$modulo')  ")){
					echo "<div class'col-sm-12'>";
					echo "5-Usuario $usuario asignado al modulo $modulo  <br>";
					echo "</div>";
					if($MASTER_GE->Execute("INSERT INTO PERFILES.PROCESOS (xt_usuario, xt_oficina, xt_rol, xt_modulo, xt_proceso) values ('$usuario', '$oficina', '$rol', '$modulo', '$proceso')  ")){
						echo "<div class'col-sm-12'>";
						echo "6-Usuario $usuario asignado al proceso $proceso  <br>";
						echo "</div>";

						if($MASTER_GE->Execute("INSERT INTO PERFILES.ACTIVIDADES (xt_usuario, xt_oficina, xt_rol, xt_modulo, xt_proceso, xt_actividad) values ('$usuario', '$oficina', '$rol', '$modulo', '$proceso', '$actividad')  ")){
							echo "<div class'col-sm-12'>";
							echo "7-Usuario asignado a la actividad  $actividad  <br>";
							echo "</div>";
							$query="INSERT INTO PERFILES.FUNCIONALIDADES(xt_usuario,xt_oficina,xt_rol, xt_modulo, xt_proceso, xt_actividad, xt_funcionalidad) values ('$usuario','$oficina','$rol','$modulo','$proceso','$actividad','seleccionaSistema' )";
							//echo "$query";
							if($MASTER_GE->Execute($query)){
							echo "<div class'col-sm-12'>";
							echo "8-Usuario   Fue correctamente Creado  <br>";
							echo "</div>";
							echo "<div class'col-sm-4'> Usuario  </div>" ;
							echo "<div class'col-sm-8'> $usuario  </div>" ;
							echo "<div class'col-sm-4'> Contraseña  </div>" ;
							echo "<div class'col-sm-8'> escalante123  </div>" ;
							echo "<div class'col-sm-4'> Correo  </div>" ;
							echo "<div class'col-sm-8'> $correo  </div>" ;
							  
							    
						}


						}//end paso 7

					}//end paso 6
				}//end paso 5

			}//end paso 4
		



		}//end paso 3
	} //end paso 2


	} //end paso 1

	else
	{
	//	echo "INSERT INTO PERFILES.USUARIOS (xt_usuario, xt_password, xt_nombre, xt_categoria, xt_correo, xn_estilo, xt_estatus)  VALUES ('$usuario', 'escalante123', '$nombreIdUsr', '$categoria', '$correo', 1, 'Activo') ";
	}

if(isset($_POST['intranet'])){
	
		if($_POST['intranet']=="on")
		{
			$nombreReal = 	explode(" ", $nombre." ");
			$usuario	= $nombreReal[0]."_".$apaterno;
			$destino = "../INTRANET_GEA/ComunicacionInterna/Personal/FILES/$archivo";
			if (move_uploaded_file($_FILES['archivo']['tmp_name'],$destino))
						{	
							$destino = "FILES/$archivo";
							$query="INSERT INTO IntranetGEA.SGI_Empleados(xt_Nombre,xt_ApellidoPaterno,xt_ApellidoMaterno,xt_Estatus,xn_Foto,xt_nombreCorto,xt_tipo,kf_usuario,xt_ciudad)VALUES ('$nombre','$apaterno', '$aMaterno',1,'$destino','$usuario','E','$usuario','$oficina')";
					} 
			if($MASTER_GE->Execute($query))
			{
				echo "<div class'col-sm-12'>";
							echo "Usuario agregado a intranet <br>";
							echo "Foto cargada <br>";
							echo "</div>";
			}
			//$archivo = limpiar_caracter_especial($archivo);
		   

		}
}

}///end try

												catch (Exception $e) {
    echo 'Excepción capturada: ',  $e->getMessage(), "<br>";
}
									
									   

										 

									}

									else
									{
									echo "<FORM name='form1' ACTION='newUser.php'  METHOD='POST' lass='form-inline' enctype='multipart/form-data'>";
										$fecha_actual = date("Y-m-d");
										$fecha = date("Y-m-d",strtotime($fecha_actual."- 1 days"));
									 
											//FOTO
											echo "<div>";
												echo "<tr align='left' height='20' >";
													echo "<td id='iconosTexto2' align='left'>Foto</td>";
													echo "<td  align='left' >";
														echo "<input id='FileCron' type='file' size='35' name='archivo' accept='image/*' required>";
													echo"</td>";
												echo "</tr>";
												echo"<tr height='10'> </tr>";
											echo "</div>";
											echo "<br>";
										 
								echo '<label for="estado"  class="col-sm-4">Nombre</label>';
								echo '<label for="estado"  class="col-sm-4">Apellido Paterno</label>';
								echo '<label for="estado"  class="col-sm-4">Apellido Materno</label>';

							echo "<input id='nombre' class='col-sm-4' value='' type='text' name='nombre' required>";
							echo "<input id='aPaterno' class='col-sm-4' value='' type='text' name='apaterno'required>";
							echo "<input id='aMaterno' class='col-sm-4' value='' type='text' name='aMaterno'>";
								
							echo '<label for="correo"  class="col-sm-4 align-items-start">Correo</label>';
							echo '<label for="categoria"  class="col-sm-4 align-items-start">Categoria</label>';
							echo '<label for="tipo"  class="col-sm-4 align-items-start">Aduana</label>';

							echo "<input id='correo' class='col-sm-4'  value='' type='text' name='correo' required>";
							echo "<select class='form-control-sm col-sm-4' name='categoria' required>";
  
											echo "<option value='' SELECTED>";	
											echo "<option value='Administrador'>Administrador";
											echo "<option value='Inhouse'>Inhouse"; 
											echo "<option value='Cliente'>Cliente"; 
										echo "</select>";
							echo "<select id='oficinas' class='form-control-sm col-sm-4' name='oficinas' required>";
  
											echo "<option value='' SELECTED>";	
											echo "<option value='AICM'>AICM";
											echo "<option value='CUN'>CUN"; 
											echo "<option value='NLRD'>NLRD"; 
											echo "<option value='LRD'>LRD"; 
											echo "<option value='QRO'>QRO"; 
											echo "<option value='TOL'>TOL"; 
											echo "<option value='VER'>VER"; 

										echo "</select>";

										$clientes = $MASTER_GE->Execute("SELECT kp_clienteId, xt_rfc, xt_nombre FROM MASTER_GE.MASTER_RFC_CLIENTEID");

							echo '<label for="rfc"  class="col-sm-4 align-items-start">RFC</label>';
							echo '<label for="clientes"  class="col-sm-4 align-items-start">Clientes</label>';
							echo '<label for="perfiles"  class="col-sm-4 align-items-start">Roles</label>';
							
							echo "<input id='rfc' class='col-sm-4'  value='' type='text' name='rfc' required>";
							echo "<select id='clientes' class='form-control-sm col-sm-4' name='clientes' required>";

									  while($r = $clientes->fetchRow()){
		
		echo '<option value='.$r[0].'-'.$r[1].'-'.$r[2].'>'.$r[2].'-'.$r[1].'-'.$r[0].'</option>';
	}	 
   

										echo "</select>";

										 echo "<select id='perfiles' class='form-control-sm col-sm-4' name='perfiles' required>";
			$s = $MASTER_GE->Execute("SELECT CR.xt_rol FROM PERFILES.CATALOGO_ROLES CR ");

	echo "<option selected='selected'>Selecionar...</option>";	
		while($r = $s->fetchRow()){
			 
			 echo '<option value="'.$r[0].'">'.$r[0].'</option>';
		}
echo "</select>";

echo '<label for="otro"  class="col-sm-4 align-items-start">Intranet</label>';
		echo "&nbsp;<input id='intranet'  type='checkbox' name='intranet'>";
 	echo "<input id='modulo' value='Login' type='hidden' name='modulo'>";
	echo "<input id='proceso' value='Entrada al sistema' type='hidden' name='proceso'>";
		echo "<input id='actividad' value='Logeo' type='hidden' name='actividad'>";
									
										

										echo "<br><br>";	
												echo "<input type='submit' type='button' class='btn btn-primary mb-2' value='Crear' name='siguiente'>";	


									 
									echo "</FORM>";

								}
								echo "</div>";
								echo '</div>
								<!--div class="card-footer text-muted">
									
								</div-->
							</div>';
								

								 

									

								 
										

  
									echo "</div>";
								
								echo '</div>'; //termina contenedor
								
							/*
							echo '<div class="botones_pag">';
								echo '<div id="atras"><a href=""><img src="img/next_radar_03.png" /><br /><span>Back</span></a></div>';
								echo '<div id="siguiente"><a href=""><img src="img/radar_next_03.png" /><br /><span>Next</span></a></div>';
							echo '</div>'; //termina botones_pag
							*/
							
							//echo '<div id="pie_help" style="width:800px; clear:both"></div>';	
						//echo '</div>';//termina cuerpo_fondo 
						//echo'<div id="fondo_pie"></div>';//pie de fondo
					echo '</div>'; //termino de centro
   				echo '</div>';	//termina fondo_azul
 			echo '</div>';	//termina contenido
		echo '</div>';	//termina fondo_gris
	 echo '</div>'; //termina wrapper

	 
	 
?>

<script language="javascript">
 
</script>