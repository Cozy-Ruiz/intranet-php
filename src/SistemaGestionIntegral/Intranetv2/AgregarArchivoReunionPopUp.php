<?php

$nombrephp='AgregarArchivoReunionPopUp.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");

error_reporting(E_PARSE);


 $reunionID = $_GET['reunionID'];
 $elemento = $_GET['elemento'];
$subelemento = $_GET['sub']; 

$bandera = 0;

if($_REQUEST['bandera'] == 1){
	$bandera =1;
	
}

if( $_FILES['archivo']['name'] == ("" || NULL)){
	
	
				
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
				<script type="text/javascript">
					function reCargarPadre(){
						opener.location.reload();
						window.close();
					}
				</script>
			</head>
			<body>
	<?php

	echo "<div id='wrapperPopUp'>";
		echo "<form name='fichaSubir' method='POST' action='AgregarArchivoReunionPopUp.php' enctype='multipart/form-data'>";	
		echo "<table border='0' align='center' name='Encabezado'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "Agregar Archivo";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr height='50px'><td></td></tr>";
		echo "</table>";
		
		echo "<table border='0' align='center' width='450px'>";
			echo "<tr>";
				echo "<td id='titleBlueLineTop'></td>";
			echo "</tr>";
	
			echo"<tr height='15px'><td></td></tr>";
			
			echo "<tr align='left' height='20px'>";
				echo "<td id='iconosTexto2' align='left'>Seleccione un archivo:</td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td></td></tr>";
			
			echo "<tr>";
				echo "<td>";
					echo "<input type='file' name='archivo'>";
					echo "<input type='hidden' name='reunion' value='".$reunionID."'>";
					echo "<input type='hidden' name='elemento' value='".$elemento."'>";
					echo "<input type='hidden' name='sub' value='".$subelemento."'>";
					echo "<input type='hidden' name='bandera' value='1'>";
				echo "</td>";
			echo "</tr>";
			
			
			echo"<tr height='30px'><td></td></tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineTop'></td>";
			echo "</tr>";
			
			echo"<tr height='40'>";
				echo"<td valign='bottom' align='right'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				echo"</td>";
			echo"</tr>";
			
		echo "</table>";
		
		echo "</form>";
	echo "</div>";
	
	

} else if($_POST['reunion'] != ""){
	
	$reunion 		= $_POST['reunion'];
	$elemento 		= $_POST['elemento'];
	$subelemento 	= $_POST['sub'];
	
	$archivo 		= $_FILES['archivo']['name'];
	$archivo 		= $archivo;
	
	
	if($archivo != ""){
		
		$destino = "../ReunionArchivo/".$archivo;
		//echo "TEMP: ".$_FILES['archivo']['tmp_name']." , DEST: $destino";
		if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)){
			
			if($elemento == 'tema'){
				$insertaElemento = "UPDATE SGI_Reunion_Temas SET xt_ruta = '$archivo' WHERE xt_codigoReunion = '$reunion' AND xn_numeroTema = $subelemento";
			}else if($elemento == 'revision'){
				$insertaElemento = "UPDATE SGI_Reunion_Revisiones SET xt_ruta = '$archivo' WHERE xt_codigoReunion = '$reunion'";
			}
			echo"$insertaElemento";
			if($INTRANETV2->Execute($insertaElemento)){
				
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
                            <script type="text/javascript">
                                function reCargarPadre(){
                                    opener.location.reload();
                                    window.close();
                                }
                            </script>
                        </head>
                        <body>
                <?php
				
				echo "<script type='text/javascript'>reCargarPadre()</script>";
				
				
                
						
			} else{
				
				
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
                            <script type="text/javascript">
                                function reCargarPadre(){
                                    opener.location.reload();
                                    window.close();
                                }
                            </script>
                        </head>
                        <body>
                <?php
				
				echo "<div id='wrapperPopUp'>";
					echo "<table border='0' align='center' name='Encabezado'>";
					
						echo"<tr>";
							echo"<td align='center' id='titulo1'>";
								echo "<font>Error en la carga</font>";
							echo"</td>";
						echo"</tr>";
						
					echo "</table>";
				echo "</div>";
				
				
			}
			
		} else{
			
			
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
			}
			?>
                        <script type="text/javascript">
                            function reCargarPadre(){
                                opener.location.reload();
                                window.close();
                            }
                        </script>
                    </head>
                    <body>
            <?php
			
			echo "<div id='wrapperPopUp'>";
				echo "<table border='0' align='center' name='Encabezado'>";
				
					echo"<tr>";
						echo"<td align='center' id='titulo1'>";
							echo "<font>Error en la carga</font>";
						echo"</td>";
					echo"</tr>";
					
				echo "</table>";
			echo "</div>";
			
			
		}
	}
}

?>
