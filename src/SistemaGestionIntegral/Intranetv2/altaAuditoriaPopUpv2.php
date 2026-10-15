<?php
 
$nombrephp = 'altaAuditoriaPopUp.php';
require_once("../../ConexionDBT.php");
require_once("../../ConexionIntranet2.php");
require_once("../../compruebaUsuario.php");

error_reporting(E_PARSE);

$breadcrumb = "<a href='../../Home.php' id='breadcrumbs'> Home / </a><a href='../homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
			   <a href='../Modulos.php' id='breadcrumbs'> Módulos / </a><a href='tableroAuditoriasv2.php' id='breadcrumbs'> Auditorías </a>";
	   
$gruposItem[1] = "GE";
$gruposItem[2] = "OT";



if(($_POST['fecha'] == "") || ($_POST['tipo'] == "") || ($_POST['grupo'] == "") || ($_POST['ciudad'] == "")){
	
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta charset="utf-8" />
                <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
                <title>Alta Auditorías</title>
                <?php
                if($estiloUsuario == 1){
                    echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
                }else if($estiloUsuario == 2){
                    echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
                }
                ?>
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
                
                <script type="text/javascript">
                    function recargarPadre(){
                        opener.location.reload();
                        window.close();
                    }
                </script> 
            </head>
            <body>
    <?php
	
	echo "<div id='wrapper' style='margin-top: 50px!important; width:700px!important;'>";
	  	echo "<form method='post' action='altaAuditoriaPopUpv2.php'>";	
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
	
					$g = $INTRANETV2->Execute("SELECT xt_codigo, xt_nombre FROM SGI_Grupos");
					echo "<select name='grupo'>";
						echo "<option value='' selected=''>Elegir...</option>";
						
						while($listGrup = $g->fetchRow()){
							echo "<option value='$listGrup[0]'>".$listGrup[1]."</option>";
							
						}
						
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
			
			echo"<tr height='30px'><td colspan='4'></td></tr>";
			
			echo"<tr height='40px'>";
				echo"<td valign='bottom' align='right' colspan='4'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
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

} else if((!empty($_POST['fecha'])) && (!empty($_POST['tipo'])) && (!empty($_POST['grupo'])) && (!empty($_POST['ciudad']))){
	
	$fechaInsert 		= date('Y-m-d', strtotime($_POST['fecha']));
	$tipoInsert 		= $_POST['tipo'];
	$tituloInsert 		= $_POST['titulo'];
	$ciudadInsert 		= $_POST['ciudad'];
	$grupoInsert 		= $_POST['grupo'];
	
	$anio = date('Y', strtotime($_POST['fecha']));
	
	$maximo = 0;
	
	
		
	$ultimoCod = $INTRANETV2->getOne("SELECT
									xt_claveAuditoria
								FROM
									SGI_Auditorias
								WHERE
									YEAR (xd_fecha) = $anio
								AND xt_tipo = '$tipoInsert'
								AND xt_grupo = '$grupoInsert'
								AND xt_ciudad = '$ciudadInsert'
								ORDER BY xd_fecha DESC, xt_claveAuditoria DESC ");
	
	
	if(!empty($ultimoCod)){
		
		//echo substr($ultimoCod, -3);
		
		$maximo = substr($ultimoCod, -3);
		$maximo++;
		
	}else{
		$maximo++;
	}
	
	
	
	//GENERACION DEL CODIGO
	//GE-F-IN-DF-14-001
	if($ciudadInsert != ""){
		
		$codigo = $grupoInsert."-".$tipoInsert."-".$ciudadInsert."-";
		
	} 
	
	$anio = date('y', strtotime($_POST['fecha']));
	
	if(strlen($maximo) == 1){
		
		$codigo = $codigo.$anio."-00".$maximo;
		
	} else if(strlen($maximo) == 2){
		
		$codigo = $codigo.$anio."-0".$maximo;
		
	} else if(strlen($maximo) == 3){
		
		$codigo = $codigo.$anio."-".$maximo;
		
	}
		
	if($INTRANETV2->Execute("INSERT INTO SGI_Auditorias(xt_claveAuditoria, xt_grupo, xt_ciudad, xt_tipo, xt_titulo, xd_fecha, xt_status) 
							 VALUES('$codigo', '$grupoInsert', '$ciudadInsert', '$tipoInsert', '$tituloInsert', '$fechaInsert', 1) ")){
								 
			$INTRANETV2->Execute("
				INSERT INTO SGI_Auditorias_Planes (xt_claveAuditoria, xt_objetivosAuditoria)
				VALUES
				('$codigo','1.Determinar el grado de conformidad del sistema de gestión integral, o de parte de él, con las disposiciones planificadas, con los criterios de auditoría y con los requisitos establecidos;
					<BR><BR>
					 2.Determinar si el sistema de gestión integral se ha implementado y se mantiene de manera eficaz; 
					 <BR><BR>
					 3.Evaluar la capacidad del sistema de gestión para asegurar el cumplimiento de los requisitos legales, reglamentarios y contractuales; 
					 <BR><BR>
					4.Identificar áreas de mejora potencial del sistema de gestión.
			");
			
			$INTRANETV2->Execute("
				INSERT INTO SGI_Auditorias_Informes (xt_claveAuditoria) 
						VALUES('$codigo') 			
			");	
			

		$INTRANETV2->Execute("
				INSERT INTO SGI_Auditorias_Documentos (xt_claveAuditoria, xt_tipoDocumento)
				VALUES
					('$codigo','PROGRAMA')	
			");	
		$INTRANETV2->Execute("
				INSERT INTO SGI_Auditorias_Documentos (xt_claveAuditoria, xt_tipoDocumento)
				VALUES
					('$codigo','INFORME')	
			");			
		?>
            <script type="text/javascript">
                opener.location.reload();
                window.close();
            </script> 
		<?php
		
	} else{
		
	echo"
		<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
        <html xmlns=\"http://www.w3.org/1999/xhtml\">
            <head>
                <meta charset=\"utf-8\" />
                <link rel=\"shortcut icon\" type=\"image/x-icon\" href=\"../../Imagenes/ICN_PestanaWebGE.png\">
                <title>Alta Auditorías</title>";
                if($estiloUsuario == 1){
                    echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
                }else if($estiloUsuario == 2){
                    echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
                }
                echo "
            </head>
            <body>	";
	
			echo "<div id='wrapper' style='margin-top: 50px!important; width:700px!important;'>";
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
							echo "<input type='button' value='Finalizar' onclick=\"window.close();\">";
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
				
			echo "</div>";
	}
}

?>
   		</body>
    </html>
<?php
