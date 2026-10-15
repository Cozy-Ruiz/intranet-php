<?php error_reporting(0); ?>
<?php
require_once("../conexionMasterDB.php");
require_once("../compruebaUsuario.php");

$usuario = $_POST['nombre'];
//$usuario = "Rodrigo_Barrera-AICM-cliente-Login-Entrada al Sistema";
$usuario = trim($usuario);
$datos = explode("-", $usuario);
strtoupper($datos[0]."-".$datos[1]."-".$datos[2]."-".$datos[3]."-".$datos[4]);


$options="";
/*
echo"SELECT
	CA.xt_actividad
FROM
	PERFILES.CATALOGO_ACTIVIDADES CA
WHERE
	CA.xt_proceso IN (
		SELECT
			A.xt_proceso
		FROM
			PERFILES.PROCESOS A
		WHERE
			A.xt_usuario = '$datos[0]'
			AND A.xt_oficina = '$datos[1]'
			AND A.xt_rol = '$datos[2]'
			AND A.xt_modulo = '$datos[3]'
		 	 AND A.xt_proceso = '$datos[4]'
	)
AND CA.xt_actividad NOT IN (
	SELECT
		A.xt_actividad
	FROM
		PERFILES.ACTIVIDADES A
	WHERE
		A.xt_usuario = '$datos[0]'
	AND A.xt_oficina = '$datos[1]'
	AND A.xt_rol = '$datos[2]'
	AND A.xt_modulo = '$datos[3]'
  AND A.xt_proceso = '$datos[4]'
) ";
*/
$s = $MASTER_GE->Execute("SELECT
	CA.xt_actividad
FROM
	PERFILES.CATALOGO_ACTIVIDADES CA
WHERE
	CA.xt_proceso IN (
		SELECT
			A.xt_proceso
		FROM
			PERFILES.PROCESOS A
		WHERE
			A.xt_usuario = '$datos[0]'
			AND A.xt_oficina = '$datos[1]'
			AND A.xt_rol = '$datos[2]'
			AND A.xt_modulo = '$datos[3]'
		 	 AND A.xt_proceso = '$datos[4]'
	)
AND CA.xt_actividad NOT IN (
	SELECT
		A.xt_actividad
	FROM
		PERFILES.ACTIVIDADES A
	WHERE
		A.xt_usuario = '$datos[0]'
	AND A.xt_oficina = '$datos[1]'
	AND A.xt_rol = '$datos[2]'
	AND A.xt_modulo = '$datos[3]'
  AND A.xt_proceso = '$datos[4]'
) ");

	echo "<option selected='selected'>Selecionar...</option>";	
		while($r = $s->fetchRow()){
			 
			 $options.= '<option value='.$r[0].'>'.$r[0].'</option>';
		}
		echo $options;


?>

