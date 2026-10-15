<?php error_reporting(0); ?>
<!doctype html>
<html>
<head>

<meta charset="utf-8">
<title>Tipo de Documentos</title>
</head>
<body>
<?php
require_once("ConexionDocs.php");

$codigo    = $_GET['codigo'];
$usuarioId = $_GET['usuario'];
$proceso   = $_GET['proceso'];
/*$rol       = $_GET['rol'];
$acividad  = $_GET['actividad'];
*/
//defino estilo
$estiloUsuario=$INTRANET->getOne("SELECT xn_estilo FROM IntranetGEA.IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");

//Defino estilo
if($estiloUsuario == 1){
	echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
}else if($estiloUsuario == 2){
    echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
}
		


$index = 0;
$index2 = 0;
//Catalogo de documentos existentes
$s = $INTRANET->Execute("SELECT xt_nombreDocumento FROM SGI_Catalogo_Documentos ORDER BY xn_orden ASC");
while($r = $s->fetchRow()){
	$total[$index] = $r[0];
	$index++;
}

//documentos ya seleccionados
$seleccionado = array();
//echo"SELECT RCD.xt_nombreDocumento FROM SGI_Catalogo_Documentos RCD WHERE RCD.xt_nombreDocumento IN (SELECT RCSD.xt_tipoDocumento FROM SGI_Documentos_Actividades_Funcionalidades_CasosdeUso RCSD WHERE RCSD.xt_codigo = '$codigo')";
$a = $INTRANET->Execute("SELECT RCD.xt_nombreDocumento FROM SGI_Catalogo_Documentos RCD WHERE RCD.xt_nombreDocumento IN (SELECT RCSD.xt_tipoDocumento FROM SGI_Documentos_Procesos RCSD WHERE RCSD.xt_codigo = '$proceso')");
					
					
while($t = $a->fetchRow()){
	$seleccionado[$index2] = $t[0];
	$index2++;
}

echo "<table border='0' align='center' name='Cuerpo' width='100%'>";
    echo "<tr>";
        echo "<td width='100%' align='center' id='titulo2'>Tipo de Documentación</td>";
       // echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px'></td>";
    echo "</tr>";                
    //Linea
    echo "<tr>";
        echo "<td id='titleBlueLineBottom' colspan='3' width='100%'></td>";
    echo "</tr>";            
    echo "<tr height='25'></tr>";            
echo"</table>";

echo "<form method='POST' action='tipoDoctosPopUp.php?proceso=$proceso&usuario=$usuarioId'>";
	echo "<input type='hidden' name='proceso' value='$proceso'>";
for($i=0;$i<count($total);$i++){
	echo "<table border='0'>";
	if(count($seleccionado) > 0){
		if(in_array($total[$i], $seleccionado)){
			
			echo "<tr>";
			echo "<td align='right' style='padding:0px 0px 0px 35px'><input type='checkbox' name='solicitud[]' checked='true' value='$total[$i]'/><label>$total[$i]</label></td>";
			echo "</tr>";
			
			echo "<br>";
			
		}else{
			
			echo "<tr>";
			echo "<td align='right' style='padding:0px 0px 0px 35px'><input type='checkbox' name='solicitud[]' value='$total[$i]'/><label>$total[$i]</label></td>";
			echo "</tr>";
			
			
			echo "<br>";
		}
		
	}else{
	
	
		echo "<tr>";
			echo "<td align='right' style='padding:0px 0px 0px 35px'><input type='checkbox' name='solicitud[]' value='$total[$i]'/><label>$total[$i]</label></td>";
		echo "</tr>";
	
			echo "<br>";
	}
	
	
	echo "</table>";
	
}

echo "<br>";
echo "<table>";
echo "<tr>";
//echo "<td style='padding:0px 0px 0px 170px'><input type='image' onclick='SubmitForm(this.form);' src='../INTRANET_GEA/Imagenes/ICN_BotonEnviar.png' width='90' height='29'></td>";
echo "<td style='padding:0px 0px 0px 170px'><input  type='submit' name='enviar' value='Enviar'></td>";
echo "</tr>";
echo "</table>";
echo "</form>";

if(isset($_POST['enviar'])){

	$index1 = 0;
	$index2 = 0;
	$solicitud = $_POST['solicitud'];
	$proceso = $_POST['proceso'];
	$usuario = $_GET['usuario'];
	$fecha = date('Y-m-d H:i:s');
	
	$item = $INTRANET->getOne("SELECT kp_itemID FROM SGI_Item WHERE xt_codigo = '$proceso'");
	
	/*$a = $INTRANET->Execute("SELECT RCD.xt_nombreDocumento FROM SGI_Catalogo_Documentos RCD WHERE
					RCD.xt_nombreDocumento NOT IN (SELECT DISTINCT RCSD.xt_tipoDocumento FROM SGI_Documentos_Actividades_Funcionalidades_CasosdeUso RCSD WHERE RCSD.xt_codigo = '$codigo')");*/
	$a = $INTRANET->Execute("SELECT RCD.xt_nombreDocumento FROM SGI_Catalogo_Documentos RCD WHERE
					RCD.xt_nombreDocumento NOT IN (SELECT DISTINCT RCSD.xt_tipoDocumento FROM SGI_Documentos_Procesos RCSD WHERE RCSD.xt_codigo = '$proceso')");
	while($p = $a->fetchRow()){
		$permitidos[$index1] = $p[0];
		$index1++;
	}
	/*$b = $INTRANET->Execute("SELECT RCD.xt_nombreDocumento FROM SGI_Catalogo_Documentos RCD WHERE
					RCD.xt_nombreDocumento IN (SELECT DISTINCT RCSD.xt_tipoDocumento FROM SGI_Documentos_Actividades_Funcionalidades_CasosdeUso RCSD WHERE RCSD.xt_codigo = '$codigo')");*/
	$b = $INTRANET->Execute("SELECT RCD.xt_nombreDocumento FROM SGI_Catalogo_Documentos RCD WHERE
					RCD.xt_nombreDocumento IN (SELECT DISTINCT RCSD.xt_tipoDocumento FROM SGI_Documentos_Procesos RCSD WHERE RCSD.xt_codigo = '$proceso')");
					
	$bloqueados = array();
					
	while($t = $b->fetchRow()){
		$bloqueados[$index2] = $t[0];
		$index2++;
	}
	
	//Agregar tipo de documentos
	if(count($bloqueados)>0){
		for($i=0;$i<count($solicitud);$i++){
			if(in_array($solicitud[$i],$bloqueados)){
				//echo "INSERT INTO RADAR_CATALOGO_SIN_DOCUMENTOS VALUES('$referencia',$permitidos[$e])";
				
				//echo "DELETE FROM RADAR_CATALOGO_CON_DOCUMENTOS WHERE xt_referencia = '$referencia' AND xt_nombreDocumento = '$solicitud[$e]'";
		
		//$BOCAR->Execute("DELETE FROM RADAR_CATALOGO_CON_DOCUMENTOS WHERE xt_referencia = '$referencia' AND xt_nombreDocumento = '$solicitud[$i]'");
				
			}
		}
	}
	//Quitar tipo de documentos
	for($e = 0;$e<count($permitidos);$e++){
		if(in_array($permitidos[$e],$solicitud)){
			
			//echo "DELETE FROM RADAR_CATALOGO_SIN_DOCUMENTOS WHERE xt_referenci = '$referencia' AND xt_nombreDocumento = '$solicitud[$i]'";
			
			//echo "INSERT INTO RADAR_CATALOGO_CON_DOCUMENTOS VALUES('$referencia','$permitidos[$e]','40665345140')";
				/*$INTRANET->Execute("INSERT INTO SGI_Documentos_Actividades_Funcionalidades_CasosdeUso (xt_codigo, xt_tipoDocumento,xt_nombreArchivo,xt_rutaArchivo, xt_usuario, xd_fecha) VALUES ('$codigo', '$permitidos[$e]', '' ,'', '$usuario','$fecha')");
				*/
				$INTRANET->Execute("INSERT INTO SGI_Documentos_Procesos (xt_codigo, xt_tipoDocumento,xt_nombreArchivo,xt_rutaArchivo, xt_usuario, xd_fecha) VALUES ('$proceso', '$permitidos[$e]', '' ,'', '$usuario','$fecha')");
				
		
			
		}
	} 
	
	?>
	<script type="text/javascript">
	//window.opener.location.reload("http://escalante.com.mx/Sistemas/BackLog/fichaEntregable.php?codigoE=<?php echo $entregableID ?>&codigoS=<?php echo $codS; ?>&prioridad=<?php echo $prioridad ?>&usuario=<?php echo $usuario; ?>");
	window.opener.location.reload("http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/FichaItem.php?id=$item")
	alert("Modificaciones Realizadas correctamente");
	this.close();
	</script> 

<?php
}

?>




</body>
</html>