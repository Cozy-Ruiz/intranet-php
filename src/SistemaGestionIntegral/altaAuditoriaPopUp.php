<?php error_reporting(0); ?>
<?php
/*
 *@author Octavio García Robles 
 *@version 1.1
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
 
$nombrephp = 'altaAuditoriaPopUp.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

error_reporting(E_PARSE);

$breadcrumb = "<a href='../Home.php' id='breadcrumbs'> Home / </a><a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			   <a href='Modulos.php' id='breadcrumbs'> Módulos / </a><a href='tableroAuditorias.php' id='breadcrumbs'> Tablero Auditorías </a>";

/*
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
*/
	   
$gruposItem[1] = "GE";
$gruposItem[2] = "OT";



if(($_POST['fecha'] == "") || ($_POST['tipo'] == "") || ($_POST['grupo'] == "") || ($_POST['ciudad'] == "")){
	
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta charset="utf-8" />
                <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
                <title>Alta Auditorías</title>
                <?php
                if($estiloUsuario == 1){
                    echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
                }else if($estiloUsuario == 2){
                    echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
                }
                ?>
                <link type="text/css" href="../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
                <script type="text/javascript" src="../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
                <script type="text/javascript" src="../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
                
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
            </head>
            <body>
    <?php
	
	echo "<div id='wrapper'>";
	  	echo "<form method='post' action='altaAuditoriaPopUp.php'>";	
		echo "<table border='0' align='center'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "Agregar Auditoría";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr>";
				echo"<td align='center'>";
					echo $breadcrumb;
				echo"</td>";
			echo"</tr>";
			
			echo"<tr height='70px'><td></td></tr>";
		echo "</table>";
		
		echo "<table border='0' align='center' width='450'>";
				
			echo "<tr>";
				echo "<td colspan='4' id='titleBlueLineTop'></td>";
			echo "</tr>";
	
			echo"<tr height='15px'><td colspan='4'></td></tr>";
			
			echo "<tr>";
				echo "<td id='iconosTexto2' width='100px'>Grupo</td>";
				echo "<td id='iconosTexto2' width='150px'>Ciudad</td>";
				echo "<td id='iconosTexto2' width='110px'>Fecha</td>";
				echo "<td id='iconosTexto2' width='90px'>Tipo</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td>";
					echo "<select name='grupo'>";
						echo "<option value='' selected=''>Elegir...</option>";
						
						for($a = 1; $a <= count($gruposItem); $a++){
							
							echo "<option value='".$gruposItem[$a]."'>".$gruposItem[$a]."</option>";
							
						} unset($a);
						
					echo "</select>";
				echo "</td>";
				
				echo "<td>";
					echo "<select name='ciudad'>";
						echo "<option value=''>Elegir...</option>";
						$t = $INTRANET->Execute("SELECT U.xt_codigoCiudad, O.xt_descripcion FROM IntranetGEA_Usuarios_Oficina U, IntranetGEA_CATALOGO_OFICINA O WHERE O.xt_oficina = U.xt_codigoCiudad AND U.kf_usuarioId = '$usuarioId'");
								while($p = $t->fetchRow()){
									$ciudadess = $p[1];
									$cdValors  = $p[0];
		
									echo"<option value='".$cdValors."'>".$ciudadess."</option>";

						/*	for($a = 1; $a <= 6; $a++){
							
							echo "<option value='".$cdValor[$a]."'>".$ciudades[$a]."</option>";
							
						*/}// unset($a);
							
					echo "</select>";
				echo "</td>";
			
				echo "<td ><input type='text' class='DatP' name='fecha' size='10'></td>";
				
				echo "<td>";
					echo "<select name='tipo'>";
						echo "<option value='' selected='selected'>Elegir...</option>";
						echo "<option value='IN'>Interna</option>";
						echo "<option value='EX'>Externa</option>";
					echo "</select>";
				echo "</td>";
			echo "</tr>";
	
			echo"<tr height='20px'><td colspan='4'></td></tr>";
			
			echo "<tr>";
				echo "<td id='iconosTexto2' colspan='4'>Título</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='4'><input type='text' name='titulo' size='66'></td>";
			echo "</tr>";
			
			echo"<tr height='20px'><td colspan='4'></td></tr>";
			
			echo "<tr>";
				echo "<td colspan='4' id='iconosTexto2'>Comentario</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='4'><textarea name='descripcion' style='width:438px; height:100px;'></textarea></td>";
			echo "</tr>";
			
			echo"<tr height='30px'><td colspan='4'></td></tr>";
			
			echo"<tr height='40px'>";
				echo"<td valign='bottom' align='right' colspan='4'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr height='20px'><td colspan='4'></td></tr>";
			
			echo "<tr>";
				echo "<td colspan='4' id='titleBlueLineBottom'></td>";
			echo "</tr>";
			
			echo"<tr height='50px'><td colspan='4'></td></tr>";
		echo "</table>";
		echo "</form>";
	echo "</div>";

} else if(($_POST['fecha'] != "") && ($_POST['tipo'] != "") && ($_POST['grupo'] != "") && ($_POST['ciudad'] != "")){
	
	$fechaInsert 		= date('Y-m-d', strtotime($_POST['fecha']));
	$tipoInsert 		= $_POST['tipo'];
	$tituloInsert 		= $_POST['titulo'];
	$ciudadInsert 		= $_POST['ciudad'];
	$grupoInsert 		= $_POST['grupo'];
	
	$descripcionInsert 	= " ";
	
	if($_POST['descripcion'] != ""){
		$descripcionInsert 	= $_POST['descripcion'];
	}
	
	$anio = date('Y', strtotime($_POST['fecha']));
	
	$maximo = 0;
	
	$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Auditorias WHERE YEAR(xd_fecha) = $anio AND xt_tipo = '$tipoInsert' 
							 AND xt_grupo = '$grupoInsert' AND xt_ciudad = '$ciudadInsert' ");
	
	while($r = $s->fetchRow()){
		
		$maximo = $r[0];
		
	} unset($r); unset($s);
	
	$maximo++;
	
	//GENERACION DEL CODIGO
	//GE-F-IN-DF-14-001
	if(($ciudadInsert != "") && ($ciudadInsert != "GEN")){
		
		$codigo = $grupoInsert."-F-".$tipoInsert."-".$ciudadInsert."-";
		
	} else{
		
		$codigo = $grupoInsert."-F-".$tipoInsert."-";
		
	}
	
	$anio = date('y', strtotime($_POST['fecha']));
	
	if(strlen($maximo) == 1){
		
		$codigo = $codigo.$anio."-00".$maximo;
		
	} else if(strlen($maximo) == 2){
		
		$codigo = $codigo.$anio."-0".$maximo;
		
	} else if(strlen($maximo) == 3){
		
		$codigo = $codigo.$anio."-".$maximo;
		
	}
	
	if($INTRANET->Execute("INSERT INTO SGI_Auditorias(xt_tipo, xn_numero, xt_claveAuditoria, xt_titulo, xt_descripcion, xd_fecha, xt_status, xt_ciudad, xt_grupo) 
											   VALUES('$tipoInsert', $maximo, '$codigo', '$tituloInsert', '$descripcionInsert', '$fechaInsert', 1, '$ciudadInsert', '$grupoInsert') ")){
		
		$idAuditoria = $INTRANET->getOne("SELECT kp_auditoriaID FROM SGI_Auditorias WHERE xt_claveAuditoria = '$codigo' AND xt_titulo = '$tituloInsert' ");
		
		header("Location: AuditoriaActualizar.php?id=$idAuditoria");
		
	} else{
		
		echo "<div id='wrapper'>";
			echo "<table border='0' align='center'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "Auditoria No Agregada";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr>";
					echo"<td align='center'>";
						echo $breadcrumb;
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='70'><td></td></tr>";
			echo "</table>";
			
			echo "<table border='0' align='center' width='450px'>";
					
				echo "<tr>";
					echo "<td id='titleBlueLineTop' width='450px'></td>";
				echo "</tr>";
		
				echo "<tr height='15px'><td></td></tr>";
				
				echo "<tr align='left' height='20px'>";
					echo "<td id='iconosTexto2' align='center'>Error</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td  align='center'>";
						echo "Auditoría no agregada";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='10px'><td></td></tr>";
				
				echo "<tr height='40px'>";
					echo "<td valign='bottom' align='right'>";
						echo "<input type='submit' value='Finalizar' onclick=\"location.href='Auditorias.php';\">";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='10px'><td></td></tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom'></td>";
				echo "</tr>";
				
				echo "<tr height='30px'>";
					echo "<td align='right'></td>";
				echo "</tr>";
						
			echo "</table>";
			
			echo "</form>";
		echo "</div>";
	}
}

?>
   		</body>
    </html>
<?php
