<?php

$nombrephp='altaReunion.php';
require_once("../../ConexionDBT.php");
require_once("../../ConexionIntranet2.php");
require_once("../../compruebaUsuario.php");
error_reporting(E_PARSE);
$contador = 0;
$t = $INTRANET->Execute("
    SELECT
        CASE O.xt_codigoCiudad
    WHEN 'ALL' THEN
        'GRL'
    WHEN 'DF' THEN
        'CMX'
    ELSE
        O.xt_codigoCiudad
    END,
    (
        SELECT
            CASE CO.xt_descripcion
        WHEN 'Mexico DF' THEN
            'Ciudad de México'
        ELSE
            CO.xt_descripcion
        END
        FROM
            IntranetGEA.IntranetGEA_CATALOGO_OFICINA CO
        WHERE
            CO.xt_oficina = O.xt_codigoCiudad
    )
    FROM
        IntranetGEA.IntranetGEA_Usuarios_Oficina O
    WHERE
        O.kf_usuarioId = '".$usuarioId."'
");
while($p = $t->fetchRow()){
	$ciudades[$contador] = $p[1];
	$cdValor[$contador]  = $p[0];
	$contador++;	
}unset($p);unset($t);unset($contador);

$tipoRiesgos[1] = "Seguridad";
$tipoRiesgos[2] = "Calidad";
$tipoRiesgos[3] = "Proceso";

$valorTipoRiesgo[1] = "SEGURIDAD";
$valorTipoRiesgo[2] = "CALIDAD";
$valorTipoRiesgo[3] = "PROCESO";

$breadcrumb = "<a href='../../Home.php' id='breadcrumbs'> Home / </a><a href='../homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			   <a href='../Modulos.php' id='breadcrumbs'> Módulos / </a>
			   <a href='tableroSimulacros.php' id='breadcrumbs'> Tablero de Simulacros </a>";
if((empty($_POST['nombreSimulacro'])) || (empty($_POST['fechaProgramada'])) || (empty($_POST['ciudad'])) || (empty($_POST['tipo'])) || (empty($_POST['grupo']))){
	
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>Agregar Simulacro</title>
				<?php
				if($estiloUsuario == 1){
					echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
				}else if($estiloUsuario == 2){
					echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
				}
				?>
				<link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
				<link type="text/css" href="../../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
                <script type="text/javascript" src="../../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
                <script type="text/javascript" src="../../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
				
				<script type="text/javascript">;
					$(function(){
						$(".fechaProgramada").datepicker({ dateFormat: 'yy-mm-dd',
						 monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] ,
						 dayNamesMin:  ['Dom','Lun','Mar','Mie','Jue','Vie','Sab']						
						 });
						$(".fechaFinalizacion").datepicker({ dateFormat: 'yy-mm-dd',
						 monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] ,
						 dayNamesMin:  ['Dom','Lun','Mar','Mie','Jue','Vie','Sab']						
						 });						
					});
				</script>
				
				<script type="text/javascript">
					function recargarPadre(){
						opener.location.reload();
						window.close();
					}
				</script>
			</head>
			<body>
	<?php
	
	echo "<div id='wrapper'>";
	  	echo "<form method='post' action='altaSimulacro.php'>";	
		echo "<table border='0' align='center'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "Agregar Simulacro";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr>"; 
				echo"<td align='center'>";
					echo $breadcrumb;
				echo"</td>";
			echo"</tr>";
			
			echo"<tr height='70px'><td></td></tr>";
		echo "</table>";
		//CUERPO FICHA ALTA
	
		echo "<table border='0' align='center' width='500px'>";
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='4'></td>";
			echo "</tr>";
	
			echo"<tr height='20px'><td colspan='4'></td></tr>";
			
			echo "<tr>";
				echo "<td width='20px'></td>";
				echo "<td id='titulo2'>Tipo</td>";
				echo "<td id='titulo2'>Fecha programada</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td></td>";
				echo "<td>";
					echo "<select name='tipo'>";
						echo "<option value=''>Elegir...</option>";
						
						for($o = 1; $o <= 3; $o++){
							
							echo "<option value='".$valorTipoRiesgo[$o]."'>".$tipoRiesgos[$o]."</option>";
							
						} unset($o);
						
					echo "</select>";
				echo "</td>";
				echo "<td><input type='text' class='fechaProgramada' name='fechaProgramada' size='15'></td>";
			echo "</tr>";
			
			echo"<tr height='20px'><td colspan='4'></td></tr>";
			
			echo "<tr>";	
				echo "<td width='20px'></td>";
				echo "<td id='titulo2'>Grupo</td>";
				echo "<td id='titulo2'>Ciudad</td>";
				//echo "<td id='titulo2'>PDR</td>";
			echo "</tr>";
			echo "<tr>";	
				/*
				$contador = 0;
				$conjuntoRegistroEmpleados = $INTRANETV2->Execute("
						SELECT 
							CONCAT(xt_Nombre,' ',xt_ApellidoPaterno)
						FROM 
							IntranetGEA.SGI_Empleados
					");				
				while($registroEmpleados = $conjuntoRegistroEmpleados->fetchRow()){
					if ($registroEmpleados[0] != null){
						$pdr[$contador] = $registroEmpleados[0];
						$contador++;
					}					
				} unset($registroEmpleados); unset($conjuntoRegistroEmpleados);
				*/
				echo "<td width='20px'></td>";
				echo "<td>";
					echo "<select name='grupo' width='100%'>";
						echo "<option value=''>Elegir...</option>";
						echo "<option value='CRP'>CRP</option>";
						echo "<option value='GEA'>GEA</option>";
						echo "<option value='NYE'>NYE</option>";
						echo "<option value='OTF'>OTF</option>";
					echo "</select>";
				echo "</td>";	
				echo "<td>";
					$c = $INTRANETV2->Execute("SELECT DISTINCT
													CASE U.xt_codigoCiudad WHEN 'DF' THEN 'CMX' WHEN 'LRD' THEN 'LAR' ELSE U.xt_codigoCiudad END as Ciudad,
													CASE O.xt_descripcion WHEN 'Mexico DF' THEN 'Ciudad de Mexico' ELSE O.xt_descripcion END as codigo
												FROM
													IntranetGEA.IntranetGEA_Usuarios_Oficina U,
													IntranetGEA.IntranetGEA_CATALOGO_OFICINA O
												WHERE
													O.xt_oficina = U.xt_codigoCiudad");
	
					echo "<select name='ciudad'>";
						echo "<option value=''>Elegir...</option>";
			
								while($listSuc = $c->fetchRow()){
									
									echo"<option value='$listSuc[0]'>$listSuc[1]</option>";
							
								}
							
					echo "</select>";
				echo "</td>";	
				/*			
				echo "<td>";
					echo "<select name='pdr' width='100%'>";
						echo "<option value=''>Elegir...</option>";						
						for($indice = 0; $indice <count($pdr); $indice++){
							echo "<option value='".$pdr[$indice]."'>".$pdr[$indice]."</option>";							
						} //unset($indice);						
					echo "</select>";
				echo "</td>";
				*/
			echo "</tr>";
			
			echo"<tr height='20px'><td colspan='4'></td></tr>";
			
			echo "<tr>";
				echo "<td width='20px'></td>";
				echo "<td id='titulo2' colspan='3'>Nombre del Simulacro</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td width='20px'></td>";
				echo "<td colspan='3' id='iconosTexto3'>";
					echo "<input type='text' name='nombreSimulacro' size='60'>";
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='20px'><td colspan='4'></td></tr>";
			
			echo "<tr>";
				echo "<td width='20px'></td>";
				echo "<td id='titulo2' colspan='3'>Descripción del Simulacro</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td width='20px'></td>";
				echo "<td colspan='3' id='iconosTexto3'>";
					echo "<textarea name='descripcionSimulacro' style='width: 450px; height: 150px;'></textarea>";
				echo "</td>";
			echo "</tr>";
			
			echo"<tr height='20px'><td colspan='4'></td></tr>";
		echo "</table>";
		echo "<table border='0' align='center'>";
			/*
			echo "<tr>";
				echo "<td width='20px'></td>";
				echo "<td id='titulo2' colspan='5'>Riegos a tratar</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td id='titleBlueLineBottom' colspan='5'></td>";
			echo "</tr>";			
			echo"<tr height='30px'><td colspan='5'></td></tr>";
			$contador = 0;
			$conjuntoRegistrosRiesgo = $INTRANETV2->Execute("
				SELECT
					xt_codigoRiesgo, xt_tituloRiesgo
				FROM
					SGI_Riesgos
				WHERE
					xt_aplicaSimulacro = 1
			");
			while($registroRiesgo = $conjuntoRegistrosRiesgo->fetchRow()){
				$codigoRiesgo[$contador] = $registroRiesgo[0];
				$tituloRiesgo[$contador]  = $registroRiesgo[1];
				$contador++;
			}unset($conjuntoRegistrosRiesgo);unset($registroRiesgo);unset($contador);
				for($o = 0; $o <= count($codigoRiesgo) - 1; $o++){
					echo "<tr>";
						echo "<td width='20px'></td>";
						echo "<td colspan='4' id='iconosTexto3' style='margin-left:1em'>";
							echo "<input type='checkbox' name='riesgos[]' value='".$codigoRiesgo[$o]."'>".$codigoRiesgo[$o]." | ".$tituloRiesgo[$o]."<br>";
						echo "</td>";
					echo "</tr>";
				}
			echo"<tr height='10px'><td colspan='5'></td></tr>";
			*/

			echo"<tr height='40px'>";
				echo"<td valign='bottom' align='right' colspan='5'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr height='10px'><td colspan='6'></td></tr>";
					
		echo "</table>";	
        echo "<table border='0' align='center' width='500px'>";
            echo "<tr>";
                echo "<td width='15px'></td>";                    
                echo "<td colspan='6' id='titleBlueLineBottom'></td>";
            echo "</tr>";
            
            echo "<tr height='40px'><td colspan='2'></td></tr>";
        echo "</table>";    		
		echo "</form>";
	echo "</div>";
} else if((!empty($_POST['nombreSimulacro'])) && (!empty($_POST['fechaProgramada'])) && (!empty($_POST['ciudad'])) && (!empty($_POST['tipo'])) && (!empty($_POST['grupo']))) {

	$nombreSimulacro	  = $_POST['nombreSimulacro'];
	$descripcionSimulacro = $_POST['descripcionSimulacro'];
	$fechaProgramada      = date('Y-m-d', strtotime($_POST['fechaProgramada']));
	$pdrSimulacro		  = $_POST['pdr'];
	$statusSimulacro 	  = '1';
	$ciudadSimulacro	  = $_POST['ciudad'];
	$tipoSimulacro		  = $_POST['tipo'];
	$grupoSimulacro		  = $_POST['grupo'];

	if (empty($pdrSimulacro)){
		$pdrSimulacro = "";
	}
	if(empty($descripcionSimulacro)){
		$descripcionSimulacro = "";
	}

	$anio = date('Y', strtotime($_POST['fechaProgramada']));
	
	$s = $INTRANETV2->Execute("
			SELECT
				CASE
				WHEN 
					LPAD(SUBSTRING_INDEX(MAX(xt_codigoSimulacro),'-',-1), 3, '0') IS NULL 
				THEN
					'001'
				ELSE
					LPAD(SUBSTRING_INDEX(MAX(xt_codigoSimulacro),'-',-1) + 1, 3, '0')
				END			
			FROM
				SGI_Simulacros
			WHERE
				YEAR (xd_fechaProgramada) = $anio
			AND xt_ciudad = '$ciudadSimulacro'
			AND xt_grupo = '$grupoSimulacro'
		");
	
	while($r = $s->fetchRow()){
		
		$maximo = $r[0];
		
	} unset($r);
	
	
	$anio = date('y', strtotime($_POST['fechaProgramada']));
	
	
	$codigo = $grupoSimulacro."-S-".$ciudadSimulacro."-".$anio."-".$maximo;

	if($INTRANETV2->Execute("
			INSERT INTO 
				SGI_Simulacros (xt_codigoSimulacro, xt_nombreSimulacro, xt_descripcionSimulacro, xd_fechaProgramada, xt_pdrSimulacro, xt_statusSimulacro, xt_ciudad, xt_grupo, xt_tipoSimulacro) 
			VALUES 
				('$codigo', '$nombreSimulacro', '$descripcionSimulacro', '$fechaProgramada', '$pdrSimulacro', '$statusSimulacro', '$ciudadSimulacro', '$grupoSimulacro', '$tipoSimulacro')
		")){
		
		foreach($_POST['riesgos'] as $checkbox){
			
			$INTRANETV2->getOne("INSERT INTO SGI_Riesgos_Simulacros (xt_codigoSimulacro, xt_codigoRiesgo) VALUES ('$codigo', '$checkbox') ");
					
		}
		
		header("Location: simulacroElementoActualizar.php?simulacro=$codigo");
		
	} else {
		
		?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <title>Agregar Simulacro</title>
                    <?php
					if($estiloUsuario == 1){
						echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
					}else if($estiloUsuario == 2){
						echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
					}
					?>
                    <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
                    <link type="text/css" href="../../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
                	<script type="text/javascript" src="../../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
                	<script type="text/javascript" src="../../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
                </head>
                <body>
        <?php
		
		echo "<div id='wrapper'>";
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "Simulacro no agregado.";
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
					echo "<td colspan='2' id='titleBlueLineBottom'></td>";
				echo "</tr>";
		
				echo "<tr height='15px'><td colspan='2'></td></tr>";
				
				echo "<tr align='left' height='20px'>";
					echo "<td id='iconosTexto2' align='center' colspan='2'>Error</td>";
				echo "</tr>";
				
				echo "<tr align='left'>";
					echo "<td align='center' colspan='2'>No se pudo agregar el simulacro.</td>";
				echo "</tr>";
				
				echo "<tr height='10px'><td colspan='2'></td></tr>";
				
				echo "<tr height='40px'>";
					echo "<td valign='bottom' align='right' colspan='2'>";
						echo "<input type='submit' value='Finalizar' onclick=\"location.href='tableroSimulacros.php';\">";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr height='10px'><td colspan='2'></td></tr>";
				
				echo "<tr>";
					echo "<td colspan='5' id='titleBlueLineBottom'></td>";
				echo "</tr>";
				
				echo "<tr height='30px'><td colspan='6'></td></tr>";
						
			echo "</table>";
		echo "</div>";
		
	}
}

?>
    </body>
</html>
<?php
