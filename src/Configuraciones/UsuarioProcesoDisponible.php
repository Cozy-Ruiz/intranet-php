<?php error_reporting(0); ?>
<?php
require_once("../conexionMasterDB.php");
require_once("../compruebaUsuario.php");

$usuario = $_POST['nombre'];
//$usuario = "Rodrigo_Barrera-AICM-cliente-Login";;
$usuario = trim($usuario);
$datos = explode("-", $usuario);
strtoupper($datos[0]."-".$datos[1]."-".$datos[2]."-".$datos[3]);


$options="";

/*echo"SELECT
	CP.xt_proceso
FROM
	PERFILES.CATALOGO_PROCESOS CP
WHERE
	CP.xt_modulo IN (
		SELECT
			M.xt_modulo
		FROM
			PERFILES.MODULOS M
		WHERE
			M.xt_usuario = '$datos[0]'
		AND M.xt_oficina = '$datos[1]'
		AND M.xt_rol = '$datos[2]'
		AND M.xt_modulo = '$datos[3]'
	)
AND CP.xt_proceso NOT IN (SELECT xt_proceso FROM PERFILES.PROCESOS P WHERE P.xt_usuario = '$datos[0]' AND P.xt_oficina = '$datos[1]' ANd P.xt_rol = '$datos[2]' AND P.xt_modulo = '$datos[3]') "; 
*/
$s = $MASTER_GE->Execute("SELECT
	CP.xt_proceso
FROM
	PERFILES.CATALOGO_PROCESOS CP
WHERE
	CP.xt_modulo IN (
		SELECT
			M.xt_modulo
		FROM
			PERFILES.MODULOS M
		WHERE
			M.xt_usuario = '$datos[0]'
		AND M.xt_oficina = '$datos[1]'
		AND M.xt_rol = '$datos[2]'
		AND M.xt_modulo = '$datos[3]'
	)
AND CP.xt_proceso NOT IN (
	SELECT
		P.xt_proceso
	FROM
		PERFILES.PROCESOS P
	WHERE
		P.xt_usuario = '$datos[0]'
	AND P.xt_oficina = '$datos[1]'
	AND P.xt_rol = '$datos[2]'
	AND P.xt_modulo = '$datos[3]'
)");

	echo "<option selected='selected'>Selecionar...</option>";	
		while($r = $s->fetchRow()){
			 
			 $options.= '<option value="'.$r[0].'">'.$r[0].'</option>';
		}
		echo $options;


?>

