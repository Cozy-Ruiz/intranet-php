<?php
/*
 *@author Samantha Abam
 *@author Octavio Garcia
 *@version 1.0
 *@copyright Copyright (coffee) 2013, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp = "modificaRenta.php";
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
ini_set('display_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Modificar</title>
    <?php
	//$estiloUsuario = $_GET['est'];
	if($estiloUsuario == 1){
		echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
	}else if($estiloUsuario == 2){
		echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
	}
?>

    <script type="text/javascript">
		function SubmitForm(form){
			if (form.domain.value == "xxx")
				form.action = "xxx"
			else
				form.action = "zzz";
			
			form.submit(); // Submit the page
			return true;
		}
	</script>
</head>

<body>
	<?php
		if(($_POST['ID'] != (''|| NULL|| 0))){
			$id = $_POST['ID'];
			
		
			$v004_1_mes_reportado ="";
			$v006_2_1_clave_entidad_colegiada ="";
			$v007_2_2_clave_sujeto_obligado ="";
			$v008_2_3_clave_actividad ="";
			$v010_3_1_referencia_aviso ="";
			$v012_3_2_1_folio_modificacion ="";
			$v013_3_2_2_descripcion_modificacion ="";
			$v014_3_3_prioridad ="";
			$v016_3_4_1_tipo_alerta ="";
			$v017_3_4_2_descripcion_alerta ="";
			$v021_3_5_1_1_1_nombre ="";
			$v022_3_5_1_1_2_apellido_paterno ="";
			$v023_3_5_1_1_3_apellido_materno ="";
			$v024_3_5_1_1_4_fecha_nacimiento ="";
			$v025_3_5_1_1_5_rfc ="";
			$v026_3_5_1_1_6_curp ="";
			$v027_3_5_1_1_7_pais_nacionalidad ="";
			$v028_3_5_1_1_8_pais_nacimiento ="";
			$v029_3_5_1_1_9_actividad_economica ="";
			$v030_3_5_1_1_10_tipo_identificacion ="";
			$v031_3_5_1_1_11_identificacion_otro ="";
			$v032_3_5_1_1_12_autoridad_identificacion ="";
			$v033_3_5_1_1_13_numero_identificacion ="";
			$v035_3_5_1_2_1_denominacion_razon ="";
			$v036_3_5_1_2_2_fecha_constitucion ="";
			$v037_3_5_1_2_3_rfc ="";
			$v038_3_5_1_2_4_pais_nacionalidad ="";
			$v039_3_5_1_2_5_giro_mercantil ="";
			$v041_3_5_1_2_6_1_nombre ="";
			$v042_3_5_1_2_6_2_apellido_paterno ="";
			$v043_3_5_1_2_6_3_apellido_materno ="";
			$v044_3_5_1_2_6_4_fecha_nacimiento ="";
			$v045_3_5_1_2_6_5_rfc ="";
			$v046_3_5_1_2_6_6_curp ="";
			$v047_3_5_1_2_6_7_tipo_identificacion ="";
			$v048_3_5_1_2_6_8_identificacion_otro ="";
			$v049_3_5_1_2_6_9_autoridad_identificacion ="";
			$v050_3_5_1_2_6_10_numero_identificacion ="";
			$v052_3_5_1_3_1_denominacion_razon ="";
			$v053_3_5_1_3_2_rfc ="";
			$v054_3_5_1_3_3_identificador_fideicomiso ="";
			$v056_3_5_1_3_4_1_nombre ="";
			$v057_3_5_1_3_4_2_apellido_paterno ="";
			$v058_3_5_1_3_4_3_apellido_materno ="";
			$v059_3_5_1_3_4_4_fecha_nacimiento ="";
			$v060_3_5_1_3_4_5_rfc ="";
			$v061_3_5_1_3_4_6_curp ="";
			$v062_3_5_1_3_4_7_tipo_identificacion ="";
			$v063_3_5_1_3_4_8_identificacion_otro ="";
			$v064_3_5_1_3_4_9_autoridad_identificacion ="";
			$v065_3_5_1_3_4_10_numero_identificacion ="";
			$v068_3_5_2_1_1_colonia ="";
			$v069_3_5_2_1_2_calle ="";
			$v070_3_5_2_1_3_numero_exterior ="";
			$v071_3_5_2_1_4_numero_interior ="";
			$v072_3_5_2_1_5_codigo_postal ="";
			$v074_3_5_2_2_1_pais ="";
			$v075_3_5_2_2_2_estado_provincia ="";
			$v076_3_5_2_2_3_ciudad_poblacion ="";
			$v077_3_5_2_2_4_colonia ="";
			$v078_3_5_2_2_5_calle ="";
			$v079_3_5_2_2_6_numero_exterior ="";
			$v080_3_5_2_2_7_numero_interior ="";
			$v081_3_5_2_2_8_codigo_postal ="";
			$v083_3_5_3_1_clave_pais ="";
			$v084_3_5_3_2_numero_telefono ="";
			$v085_3_5_3_3_correo_electronico ="";
			$v089_3_6_1_1_1_nombre ="";
			$v090_3_6_1_1_2_apellido_paterno ="";
			$v091_3_6_1_1_3_apellido_materno ="";
			$v092_3_6_1_1_4_fecha_nacimiento ="";
			$v093_3_6_1_1_5_rfc ="";
			$v094_3_6_1_1_6_curp ="";
			$v095_3_6_1_1_7_pais_nacionalidad ="";
			$v096_3_6_1_1_8_pais_nacimiento ="";
			$v097_3_6_1_1_9_actividad_economica ="";
			$v099_3_6_1_2_1_denominacion_razon ="";
			$v100_3_6_1_2_2_fecha_constitucion ="";
			$v101_3_6_1_2_3_rfc ="";
			$v102_3_6_1_2_4_pais_nacionalidad ="";
			$v103_3_6_1_2_5_giro_mercantil ="";
			$v105_3_6_1_3_1_denominacion_razon ="";
			$v106_3_6_1_3_2_rfc ="";
			$v107_3_6_1_3_3_identificador_fideicomiso ="";
			$v110_3_6_2_1_1_colonia ="";
			$v111_3_6_2_1_2_calle ="";
			$v112_3_6_2_1_3_numero_exterior ="";
			$v113_3_6_2_1_4_numero_interior ="";
			$v114_3_6_2_1_5_codigo_postal ="";
			$v116_3_6_2_2_1_pais ="";
			$v117_3_6_2_2_2_estado_provincia ="";
			$v118_3_6_2_2_3_ciudad_poblacion ="";
			$v119_3_6_2_2_4_colonia ="";
			$v120_3_6_2_2_5_calle ="";
			$v121_3_6_2_2_6_numero_exterior ="";
			$v122_3_6_2_2_7_numero_interior ="";
			$v123_3_6_2_2_8_codigo_postal ="";
			$v125_3_6_3_1_clave_pais ="";
			$v126_3_6_3_2_numero_telefono ="";
			$v127_3_6_3_3_correo_electronico ="";
			$v131_3_7_1_1_1_fecha_operacion ="";
			$v132_3_7_1_1_2_tipo_operacion ="";
			$v133_3_7_1_1_3_fecha_inicio ="";
			$v134_3_7_1_1_4_fecha_termino ="";
			$v136_3_7_1_1_5_1_tipo_inmueble ="";
			$v137_3_7_1_1_5_2_valor_avaluo_catastral ="";
			$v138_3_7_1_1_5_3_colonia ="";
			$v139_3_7_1_1_5_4_calle ="";
			$v140_3_7_1_1_5_5_numero_exterior ="";
			$v141_3_7_1_1_5_6_numero_interior ="";
			$v142_3_7_1_1_5_7_codigo_postal ="";
			$v143_3_7_1_1_5_8_blindaje ="";
			$v144_3_7_1_1_5_9_folio_real ="";
			$v146_3_7_1_1_6_1_fecha_pago ="";
			$v147_3_7_1_1_6_2_instrumento_monetario ="";
			$v150_3_7_1_1_6_3_1_1_institucion_credito ="";
			$v151_3_7_1_1_6_3_1_2_numero_cuenta ="";
			$v152_3_7_1_1_6_3_1_3_numero_cheque ="";
			$v154_3_7_1_1_6_3_2_1_institucion_credito ="";
			$v155_3_7_1_1_6_3_2_2_numero_cuenta ="";
			$v156_3_7_1_1_6_3_2_3_numero_cheque ="";
			$v158_3_7_1_1_6_3_3_1_institucion_credito ="";
			$v159_3_7_1_1_6_3_3_2_numero_cheque ="";
			$v161_3_7_1_1_6_3_4_1_clave_rastreo ="";
			$v163_3_7_1_1_6_3_5_1_folio_interno ="";
			$v165_3_7_1_1_6_3_6_1_institucion_ordenante ="";
			$v166_3_7_1_1_6_3_6_2_numero_cuenta ="";
			$v167_3_7_1_1_6_3_6_3_pais_origen ="";
			$v169_3_7_1_1_6_3_7_1_institucion_ordenante ="";
			$v170_3_7_1_1_6_3_7_2_numero_cuenta ="";
			$v171_3_7_1_1_6_3_7_3_numero_giro ="";
			$v173_3_7_1_1_6_3_8_1_institucion_ordenante ="";
			$v174_3_7_1_1_6_3_8_2_numero_cuenta ="";
			$v175_3_7_1_1_6_3_8_3_numero_orden_pago ="";
			$v177_3_7_1_1_6_3_9_1_numero_tarjeta ="";
			$v179_3_7_1_1_6_3_10_1_numero_tarjeta ="";
			$v181_3_7_1_1_6_3_11_1_numero_tarjeta ="";
			$v182_3_7_1_1_6_4_moneda ="";
			$v183_3_7_1_1_6_5_monto_operacion ="";
			
		   $s= $INTRANET->Execute(" 
			SELECT 
			004_1_mes_reportado,
			006_2_1_clave_entidad_colegiada,
			007_2_2_clave_sujeto_obligado,
			008_2_3_clave_actividad,
			010_3_1_referencia_aviso,
			012_3_2_1_folio_modificacion,
			013_3_2_2_descripcion_modificacion,
			014_3_3_prioridad,
			016_3_4_1_tipo_alerta,
			017_3_4_2_descripcion_alerta,
			021_3_5_1_1_1_nombre,
			022_3_5_1_1_2_apellido_paterno,
			023_3_5_1_1_3_apellido_materno,
			024_3_5_1_1_4_fecha_nacimiento,
			025_3_5_1_1_5_rfc,
			026_3_5_1_1_6_curp,
			027_3_5_1_1_7_pais_nacionalidad,
			028_3_5_1_1_8_pais_nacimiento,
			029_3_5_1_1_9_actividad_economica,
			030_3_5_1_1_10_tipo_identificacion,
			031_3_5_1_1_11_identificacion_otro,
			032_3_5_1_1_12_autoridad_identificacion,
			033_3_5_1_1_13_numero_identificacion,
			035_3_5_1_2_1_denominacion_razon,
			036_3_5_1_2_2_fecha_constitucion,
			037_3_5_1_2_3_rfc,
			038_3_5_1_2_4_pais_nacionalidad,
			039_3_5_1_2_5_giro_mercantil,
			041_3_5_1_2_6_1_nombre,
			042_3_5_1_2_6_2_apellido_paterno,
			043_3_5_1_2_6_3_apellido_materno,
			044_3_5_1_2_6_4_fecha_nacimiento,
			045_3_5_1_2_6_5_rfc,
			046_3_5_1_2_6_6_curp,
			047_3_5_1_2_6_7_tipo_identificacion,
			048_3_5_1_2_6_8_identificacion_otro,
			049_3_5_1_2_6_9_autoridad_identificacion,
			050_3_5_1_2_6_10_numero_identificacion,
			052_3_5_1_3_1_denominacion_razon,
			053_3_5_1_3_2_rfc,
			054_3_5_1_3_3_identificador_fideicomiso,
			056_3_5_1_3_4_1_nombre,
			057_3_5_1_3_4_2_apellido_paterno,
			058_3_5_1_3_4_3_apellido_materno,
			059_3_5_1_3_4_4_fecha_nacimiento,
			060_3_5_1_3_4_5_rfc,
			061_3_5_1_3_4_6_curp,
			062_3_5_1_3_4_7_tipo_identificacion,
			063_3_5_1_3_4_8_identificacion_otro,
			064_3_5_1_3_4_9_autoridad_identificacion,
			065_3_5_1_3_4_10_numero_identificacion,
			068_3_5_2_1_1_colonia,
			069_3_5_2_1_2_calle,
			070_3_5_2_1_3_numero_exterior,
			071_3_5_2_1_4_numero_interior,
			072_3_5_2_1_5_codigo_postal,
			074_3_5_2_2_1_pais,
			075_3_5_2_2_2_estado_provincia,
			076_3_5_2_2_3_ciudad_poblacion,
			077_3_5_2_2_4_colonia,
			078_3_5_2_2_5_calle,
			079_3_5_2_2_6_numero_exterior,
			080_3_5_2_2_7_numero_interior,
			081_3_5_2_2_8_codigo_postal,
			083_3_5_3_1_clave_pais,
			084_3_5_3_2_numero_telefono,
			085_3_5_3_3_correo_electronico,
			089_3_6_1_1_1_nombre,
			090_3_6_1_1_2_apellido_paterno,
			091_3_6_1_1_3_apellido_materno,
			092_3_6_1_1_4_fecha_nacimiento,
			093_3_6_1_1_5_rfc,
			094_3_6_1_1_6_curp,
			095_3_6_1_1_7_pais_nacionalidad,
			096_3_6_1_1_8_pais_nacimiento,
			097_3_6_1_1_9_actividad_economica,
			099_3_6_1_2_1_denominacion_razon,
			100_3_6_1_2_2_fecha_constitucion,
			101_3_6_1_2_3_rfc,
			102_3_6_1_2_4_pais_nacionalidad,
			103_3_6_1_2_5_giro_mercantil,
			105_3_6_1_3_1_denominacion_razon,
			106_3_6_1_3_2_rfc,
			107_3_6_1_3_3_identificador_fideicomiso,
			110_3_6_2_1_1_colonia,
			111_3_6_2_1_2_calle,
			112_3_6_2_1_3_numero_exterior,
			113_3_6_2_1_4_numero_interior,
			114_3_6_2_1_5_codigo_postal,
			116_3_6_2_2_1_pais,
			117_3_6_2_2_2_estado_provincia,
			118_3_6_2_2_3_ciudad_poblacion,
			119_3_6_2_2_4_colonia,
			120_3_6_2_2_5_calle,
			121_3_6_2_2_6_numero_exterior,
			122_3_6_2_2_7_numero_interior,
			123_3_6_2_2_8_codigo_postal,
			125_3_6_3_1_clave_pais,
			126_3_6_3_2_numero_telefono,
			127_3_6_3_3_correo_electronico,
			131_3_7_1_1_1_fecha_operacion,
			132_3_7_1_1_2_tipo_operacion,
			133_3_7_1_1_3_fecha_inicio,
			134_3_7_1_1_4_fecha_termino,
			136_3_7_1_1_5_1_tipo_inmueble,
			137_3_7_1_1_5_2_valor_avaluo_catastral,
			138_3_7_1_1_5_3_colonia,
			139_3_7_1_1_5_4_calle,
			140_3_7_1_1_5_5_numero_exterior,
			141_3_7_1_1_5_6_numero_interior,
			142_3_7_1_1_5_7_codigo_postal,
			143_3_7_1_1_5_8_blindaje,
			144_3_7_1_1_5_9_folio_real,
			146_3_7_1_1_6_1_fecha_pago,
			147_3_7_1_1_6_2_instrumento_monetario,
			150_3_7_1_1_6_3_1_1_institucion_credito,
			151_3_7_1_1_6_3_1_2_numero_cuenta,
			152_3_7_1_1_6_3_1_3_numero_cheque,
			154_3_7_1_1_6_3_2_1_institucion_credito,
			155_3_7_1_1_6_3_2_2_numero_cuenta,
			156_3_7_1_1_6_3_2_3_numero_cheque,
			158_3_7_1_1_6_3_3_1_institucion_credito,
			159_3_7_1_1_6_3_3_2_numero_cheque,
			161_3_7_1_1_6_3_4_1_clave_rastreo,
			163_3_7_1_1_6_3_5_1_folio_interno,
			165_3_7_1_1_6_3_6_1_institucion_ordenante,
			166_3_7_1_1_6_3_6_2_numero_cuenta,
			167_3_7_1_1_6_3_6_3_pais_origen,
			169_3_7_1_1_6_3_7_1_institucion_ordenante,
			170_3_7_1_1_6_3_7_2_numero_cuenta,
			171_3_7_1_1_6_3_7_3_numero_giro,
			173_3_7_1_1_6_3_8_1_institucion_ordenante,
			174_3_7_1_1_6_3_8_2_numero_cuenta,
			175_3_7_1_1_6_3_8_3_numero_orden_pago,
			177_3_7_1_1_6_3_9_1_numero_tarjeta,
			179_3_7_1_1_6_3_10_1_numero_tarjeta,
			181_3_7_1_1_6_3_11_1_numero_tarjeta,
			182_3_7_1_1_6_4_moneda,
			183_3_7_1_1_6_5_monto_operacion 
			FROM IntranetGEA_Renta WHERE kp_rentaID = $id ");
			
			while($r = $s->fetchRow()){
				 $v004_1_mes_reportado =$r[0];
				 $v006_2_1_clave_entidad_colegiada =$r[1];
				 $v007_2_2_clave_sujeto_obligado =$r[2];
				 $v008_2_3_clave_actividad =$r[3];
				 $v010_3_1_referencia_aviso =$r[4];
				 $v012_3_2_1_folio_modificacion =$r[5];
				 $v013_3_2_2_descripcion_modificacion =$r[6];
				 $v014_3_3_prioridad =$r[7];
				 $v016_3_4_1_tipo_alerta =$r[8];
				 $v017_3_4_2_descripcion_alerta =$r[9];
				 $v021_3_5_1_1_1_nombre =$r[10];
				 $v022_3_5_1_1_2_apellido_paterno =$r[11];
				 $v023_3_5_1_1_3_apellido_materno =$r[12];
				 $v024_3_5_1_1_4_fecha_nacimiento =$r[13];
				 $v025_3_5_1_1_5_rfc =$r[14];
				 $v026_3_5_1_1_6_curp =$r[15];
				 $v027_3_5_1_1_7_pais_nacionalidad =$r[16];
				 $v028_3_5_1_1_8_pais_nacimiento =$r[17];
				 $v029_3_5_1_1_9_actividad_economica =$r[18];
				 $v030_3_5_1_1_10_tipo_identificacion =$r[19];
				 $v031_3_5_1_1_11_identificacion_otro =$r[20];
				 $v032_3_5_1_1_12_autoridad_identificacion =$r[21];
				 $v033_3_5_1_1_13_numero_identificacion =$r[22];
				 $v035_3_5_1_2_1_denominacion_razon =$r[23];
				 $v036_3_5_1_2_2_fecha_constitucion =$r[24];
				 $v037_3_5_1_2_3_rfc =$r[25];
				 $v038_3_5_1_2_4_pais_nacionalidad =$r[26];
				 $v039_3_5_1_2_5_giro_mercantil =$r[27];
				 $v041_3_5_1_2_6_1_nombre =$r[28];
				 $v042_3_5_1_2_6_2_apellido_paterno =$r[29];
				 $v043_3_5_1_2_6_3_apellido_materno =$r[30];
				 $v044_3_5_1_2_6_4_fecha_nacimiento =$r[31];
				 $v045_3_5_1_2_6_5_rfc =$r[32];
				 $v046_3_5_1_2_6_6_curp =$r[33];
				 $v047_3_5_1_2_6_7_tipo_identificacion =$r[34];
				 $v048_3_5_1_2_6_8_identificacion_otro =$r[35];
				 $v049_3_5_1_2_6_9_autoridad_identificacion =$r[36];
				 $v050_3_5_1_2_6_10_numero_identificacion =$r[37];
				 $v052_3_5_1_3_1_denominacion_razon =$r[38];
				 $v053_3_5_1_3_2_rfc =$r[39];
				 $v054_3_5_1_3_3_identificador_fideicomiso =$r[40];
				 $v056_3_5_1_3_4_1_nombre =$r[41];
				 $v057_3_5_1_3_4_2_apellido_paterno =$r[42];
				 $v058_3_5_1_3_4_3_apellido_materno =$r[43];
				 $v059_3_5_1_3_4_4_fecha_nacimiento =$r[44];
				 $v060_3_5_1_3_4_5_rfc =$r[45];
				 $v061_3_5_1_3_4_6_curp =$r[46];
				 $v062_3_5_1_3_4_7_tipo_identificacion =$r[47];
				 $v063_3_5_1_3_4_8_identificacion_otro =$r[48];
				 $v064_3_5_1_3_4_9_autoridad_identificacion =$r[49];
				 $v065_3_5_1_3_4_10_numero_identificacion =$r[50];
				 $v068_3_5_2_1_1_colonia =$r[51];
				 $v069_3_5_2_1_2_calle =$r[52];
				 $v070_3_5_2_1_3_numero_exterior =$r[53];
				 $v071_3_5_2_1_4_numero_interior =$r[54];
				 $v072_3_5_2_1_5_codigo_postal =$r[55];
				 $v074_3_5_2_2_1_pais =$r[56];
				 $v075_3_5_2_2_2_estado_provincia =$r[57];
				 $v076_3_5_2_2_3_ciudad_poblacion =$r[58];
				 $v077_3_5_2_2_4_colonia =$r[59];
				 $v078_3_5_2_2_5_calle =$r[60];
				 $v079_3_5_2_2_6_numero_exterior =$r[61];
				 $v080_3_5_2_2_7_numero_interior =$r[62];
				 $v081_3_5_2_2_8_codigo_postal =$r[63];
				 $v083_3_5_3_1_clave_pais =$r[64];
				 $v084_3_5_3_2_numero_telefono =$r[65];
				 $v085_3_5_3_3_correo_electronico =$r[66];
				 $v089_3_6_1_1_1_nombre =$r[67];
				 $v090_3_6_1_1_2_apellido_paterno =$r[68];
				 $v091_3_6_1_1_3_apellido_materno =$r[69];
				 $v092_3_6_1_1_4_fecha_nacimiento =$r[70];
				 $v093_3_6_1_1_5_rfc =$r[71];
				 $v094_3_6_1_1_6_curp =$r[72];
				 $v095_3_6_1_1_7_pais_nacionalidad =$r[73];
				 $v096_3_6_1_1_8_pais_nacimiento =$r[74];
				 $v097_3_6_1_1_9_actividad_economica =$r[75];
				 $v099_3_6_1_2_1_denominacion_razon =$r[76];
				 $v100_3_6_1_2_2_fecha_constitucion =$r[77];
				 $v101_3_6_1_2_3_rfc =$r[78];
				 $v102_3_6_1_2_4_pais_nacionalidad =$r[79];
				 $v103_3_6_1_2_5_giro_mercantil =$r[80];
				 $v105_3_6_1_3_1_denominacion_razon =$r[81];
				 $v106_3_6_1_3_2_rfc =$r[82];
				 $v107_3_6_1_3_3_identificador_fideicomiso =$r[83];
				 $v110_3_6_2_1_1_colonia =$r[84];
				 $v111_3_6_2_1_2_calle =$r[85];
				 $v112_3_6_2_1_3_numero_exterior =$r[86];
				 $v113_3_6_2_1_4_numero_interior =$r[87];
				 $v114_3_6_2_1_5_codigo_postal =$r[88];
				 $v116_3_6_2_2_1_pais =$r[89];
				 $v117_3_6_2_2_2_estado_provincia =$r[90];
				 $v118_3_6_2_2_3_ciudad_poblacion =$r[91];
				 $v119_3_6_2_2_4_colonia =$r[92];
				 $v120_3_6_2_2_5_calle =$r[93];
				 $v121_3_6_2_2_6_numero_exterior =$r[94];
				 $v122_3_6_2_2_7_numero_interior =$r[95];
				 $v123_3_6_2_2_8_codigo_postal =$r[96];
				 $v125_3_6_3_1_clave_pais =$r[97];
				 $v126_3_6_3_2_numero_telefono =$r[98];
				 $v127_3_6_3_3_correo_electronico =$r[99];
				 $v131_3_7_1_1_1_fecha_operacion =$r[100];
				 $v132_3_7_1_1_2_tipo_operacion =$r[101];
				 $v133_3_7_1_1_3_fecha_inicio =$r[102];
				 $v134_3_7_1_1_4_fecha_termino =$r[103];
				 $v136_3_7_1_1_5_1_tipo_inmueble =$r[104];
				 $v137_3_7_1_1_5_2_valor_avaluo_catastral =$r[105];
				 $v138_3_7_1_1_5_3_colonia =$r[106];
				 $v139_3_7_1_1_5_4_calle =$r[107];
				 $v140_3_7_1_1_5_5_numero_exterior =$r[108];
				 $v141_3_7_1_1_5_6_numero_interior =$r[109];
				 $v142_3_7_1_1_5_7_codigo_postal =$r[110];
				 $v143_3_7_1_1_5_8_blindaje =$r[111];
				 $v144_3_7_1_1_5_9_folio_real =$r[112];
				 $v146_3_7_1_1_6_1_fecha_pago =$r[113];
				 $v147_3_7_1_1_6_2_instrumento_monetario =$r[114];
				 $v150_3_7_1_1_6_3_1_1_institucion_credito =$r[115];
				 $v151_3_7_1_1_6_3_1_2_numero_cuenta =$r[116];
				 $v152_3_7_1_1_6_3_1_3_numero_cheque =$r[117];
				 $v154_3_7_1_1_6_3_2_1_institucion_credito =$r[118];
				 $v155_3_7_1_1_6_3_2_2_numero_cuenta =$r[119];
				 $v156_3_7_1_1_6_3_2_3_numero_cheque =$r[120];
				 $v158_3_7_1_1_6_3_3_1_institucion_credito =$r[121];
				 $v159_3_7_1_1_6_3_3_2_numero_cheque =$r[122];
				 $v161_3_7_1_1_6_3_4_1_clave_rastreo =$r[123];
				 $v163_3_7_1_1_6_3_5_1_folio_interno =$r[124];
				 $v165_3_7_1_1_6_3_6_1_institucion_ordenante =$r[125];
				 $v166_3_7_1_1_6_3_6_2_numero_cuenta =$r[126];
				 $v167_3_7_1_1_6_3_6_3_pais_origen =$r[127];
				 $v169_3_7_1_1_6_3_7_1_institucion_ordenante =$r[128];
				 $v170_3_7_1_1_6_3_7_2_numero_cuenta =$r[129];
				 $v171_3_7_1_1_6_3_7_3_numero_giro =$r[130];
				 $v173_3_7_1_1_6_3_8_1_institucion_ordenante =$r[131];
				 $v174_3_7_1_1_6_3_8_2_numero_cuenta =$r[132];
				 $v175_3_7_1_1_6_3_8_3_numero_orden_pago =$r[133];
				 $v177_3_7_1_1_6_3_9_1_numero_tarjeta =$r[134];
				 $v179_3_7_1_1_6_3_10_1_numero_tarjeta =$r[135];
				 $v181_3_7_1_1_6_3_11_1_numero_tarjeta =$r[136];
				 $v182_3_7_1_1_6_4_moneda =$r[137];
				 $v183_3_7_1_1_6_5_monto_operacion = $r[138];
			}
			
			unset($r); unset($s);
			if ($id==1){
				$nombre='Julio Antonio Escalante Bourillon';	
			}else if($id==2){
				$nombre='Gabriel Roberto Escalante Bourillon';
			}
				echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr height='20'> </tr>";
				echo"<tr>";
					echo"<td align='center' id='titulo12'>";
						echo "$nombre";
					echo"</td>";
				echo"</tr>";
				echo"<tr height='20'> </tr>";
			echo "</table>"; 
			
			echo "<h2 style='margin-left:40%;' id='titulo2'>Modificación de datos</h2>";
			echo "<form name='form1' action='update.php?ID=$id' METHOD='POST'>"; 
				echo "<table align='center' border='1' id='iconosTexto'>";
				
					echo "<tr id='iconosTexto'>";
						echo "<td><b>Mes Reportado 004 :</b></td>";
						echo "<td><INPUT TYPE='text' NAME='mes_reportado004' value='$v004_1_mes_reportado'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Clave Entidad Colegiada 006 :</b></td>";
						echo "<td><INPUT TYPE='text' NAME='clave_entidad_colegiada006' value=' $v006_2_1_clave_entidad_colegiada'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Clave Sujeto Obligado 007:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='clave_sujeto_obligado007' value='$v007_2_2_clave_sujeto_obligado'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Clave Actividad 008:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='clave_actividad008' value='$v008_2_3_clave_actividad'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Referencia Aviso 010:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='referencia_aviso010' value='$v010_3_1_referencia_aviso'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Folio Modificacion 012:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='folio_modificacion012' value='$v012_3_2_1_folio_modificacion'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Descripcion Modificacion 013:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='descripcion_modificacion013' value='$v013_3_2_2_descripcion_modificacion'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Prioridad 014:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='prioridad014' value='$v014_3_3_prioridad'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Tipo Alerta 016:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='tipo_alerta016' value='$v016_3_4_1_tipo_alerta'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Descripcion Alerta 017:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='descripcion_alerta017' value='$v017_3_4_2_descripcion_alerta'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Nombre 021:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='nombre021' value='$v021_3_5_1_1_1_nombre'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Apellido Paterno 022:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='apellido_paterno022' value='$v022_3_5_1_1_2_apellido_paterno'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Apellido Materno 023:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='apellido_materno023' value='$v023_3_5_1_1_3_apellido_materno'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Fecha Nacimiento 024:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='fecha_nacimiento024' value='$v024_3_5_1_1_4_fecha_nacimiento'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>RFC 025:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='rfc025' value='$v025_3_5_1_1_5_rfc'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>CURP 026:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='curp026' value='$v026_3_5_1_1_6_curp'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>País Nacionalidad 027:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='pais_nacionalidad027' value='$v027_3_5_1_1_7_pais_nacionalidad'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>País Nacimiento 028:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='pais_nacimiento028' value='$v028_3_5_1_1_8_pais_nacimiento'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Actividad Economica 029:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='actividad_economica029' value='$v029_3_5_1_1_9_actividad_economica'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Tipo Identificación 030:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='tipo_identificacion030' value='$v030_3_5_1_1_10_tipo_identificacion'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Identificación otro 031:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='identificacion_otro031' value='$v031_3_5_1_1_11_identificacion_otro'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Autoridad Identificación 032:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='autoridad_identificacion032' value='$v032_3_5_1_1_12_autoridad_identificacion'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Numero Identificación 033:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='numero_identificacion033' value='$v033_3_5_1_1_13_numero_identificacion'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Denominacion Razon 035:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='denominacion_razon035' value='$v035_3_5_1_2_1_denominacion_razon'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Fecha Constitución 036:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='fecha_constitucion036' value='$v036_3_5_1_2_2_fecha_constitucion'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>RFC 037:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='rfc037' value='$v037_3_5_1_2_3_rfc'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>País Nacionalidad 038:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='pais_nacionalidad038' value='$v038_3_5_1_2_4_pais_nacionalidad'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Giro Mercantil 039:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='giro_mercantil039' value='$v039_3_5_1_2_5_giro_mercantil'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Nombre 041:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='nombre041' value='$v041_3_5_1_2_6_1_nombre'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Apellido Paterno 042:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='apellido_paterno042' value='$v042_3_5_1_2_6_2_apellido_paterno'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Apellido Materno 043:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='apellido_materno043' value='$v043_3_5_1_2_6_3_apellido_materno'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Fecha Nacimiento 044:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='fecha_nacimiento044' value='$v044_3_5_1_2_6_4_fecha_nacimiento'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>RFC 045:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='rfc045' value='$v045_3_5_1_2_6_5_rfc'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>CURP 046:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='curp046' value='$v046_3_5_1_2_6_6_curp'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Tipo de Identificación 047:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='tipo_identificacion047' value='$v047_3_5_1_2_6_7_tipo_identificacion'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Identificación Otro 048:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='identificacion_otro048' value='$v048_3_5_1_2_6_8_identificacion_otro'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Autoridad Identificación 049:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='autoridad_identificacion049' value='$v049_3_5_1_2_6_9_autoridad_identificacion'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Número Identificación 050:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='numero_identificacion050' value='$v050_3_5_1_2_6_10_numero_identificacion'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Denominación Razon 052:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='denominacion_razon052' value='$v052_3_5_1_3_1_denominacion_razon'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>RFC 053:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='rfc053' value='$v053_3_5_1_3_2_rfc'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Identificador Fideicomiso 054:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='identificador_fideicomiso054' value='$v054_3_5_1_3_3_identificador_fideicomiso'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Nombre 056:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='nombre056' value='$v056_3_5_1_3_4_1_nombre'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Apellido Paterno 057:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='apellido_paterno057' value='$v057_3_5_1_3_4_2_apellido_paterno'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Apellido Materno 058:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='apellido_materno058' value='$v058_3_5_1_3_4_3_apellido_materno'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Fecha de Nacimiento 059:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='fecha_nacimiento059' value='$v059_3_5_1_3_4_4_fecha_nacimiento'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>RFC 060:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='rfc060' value='$v060_3_5_1_3_4_5_rfc'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>CURP 061:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='curp061' value='$v061_3_5_1_3_4_6_curp'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Tipo Identificación 062:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='tipo_identificacion062' value='$v062_3_5_1_3_4_7_tipo_identificacion'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Identificación Otro 063:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='identificacion_otro063' value='$v063_3_5_1_3_4_8_identificacion_otro'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Autoridad Identificación 064:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='autoridad_identificacion064' value='$v064_3_5_1_3_4_9_autoridad_identificacion'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Número Identificación 065:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='numero_identificacion065' value='$v065_3_5_1_3_4_10_numero_identificacion'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Colonia 068:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='colonia068' value='$v068_3_5_2_1_1_colonia '></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Calle 069:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='calle069' value='$v069_3_5_2_1_2_calle'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Numero Exterior 070:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='numero_exterior070' value='$v070_3_5_2_1_3_numero_exterior'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Número Interior 071:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='numero_interior071' value='$v071_3_5_2_1_4_numero_interior'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Codigo Postal 072:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='codigo_postal072' value='$v072_3_5_2_1_5_codigo_postal'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>País 074:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='pais074' value='$v074_3_5_2_2_1_pais'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Estado Provincia 075:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='estado_provincia075' value='$v075_3_5_2_2_2_estado_provincia'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Ciudad Población 076:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='ciudad_poblacion076' value='$v076_3_5_2_2_3_ciudad_poblacion'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Colonia 077:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='colonia077' value='$v077_3_5_2_2_4_colonia'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Calle 078:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='calle078' value='$v078_3_5_2_2_5_calle'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Número Exterior 079:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='numero_exterior079' value='$v079_3_5_2_2_6_numero_exterior'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Número Interior 080:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='numero_interior080' value='$v080_3_5_2_2_7_numero_interior'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Codigo Postal 081:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='codigo_postal081' value='$v081_3_5_2_2_8_codigo_postal'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Clave País 083:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='clave_pais083' value='$v083_3_5_3_1_clave_pais'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Número Telefono 084:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='numero_telefono084' value='$v084_3_5_3_2_numero_telefono'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Correo Electronico 085:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='correo_electronico085' value='$v085_3_5_3_3_correo_electronico'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Nombre 089:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='nombre089' value='$v089_3_6_1_1_1_nombre'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Apellido Paterno 090:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='apellido_paterno090' value='$v090_3_6_1_1_2_apellido_paterno'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Apellido Materno 091:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='apellido_materno091' value='$v091_3_6_1_1_3_apellido_materno'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Fecha Nacimiento 092:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='fecha_nacimiento092' value='$v092_3_6_1_1_4_fecha_nacimiento'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>RFC 093:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='rfc093' value='$v093_3_6_1_1_5_rfc'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>CURP 094:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='curp094' value='$v094_3_6_1_1_6_curp'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>País Nacionalidad 095:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='pais_nacionalidad095' value='$v095_3_6_1_1_7_pais_nacionalidad'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>País Nacimiento 096:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='pais_nacimiento096' value='$v096_3_6_1_1_8_pais_nacimiento'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Actividad Económica 097:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='actividad_economica097' value='$v097_3_6_1_1_9_actividad_economica'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Denominación Razon 099:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='denominacion_razon099' value='$v099_3_6_1_2_1_denominacion_razon'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Fecha Constitución 100:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='fecha_constitucion100' value='$v100_3_6_1_2_2_fecha_constitucion'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>RFC 101:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='rfc101' value='$v101_3_6_1_2_3_rfc '></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>País Nacionalidad 102:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='pais_nacionalidad102' value='$v102_3_6_1_2_4_pais_nacionalidad'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Giro Mercantil 103:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='giro_mercantil103' value='$v103_3_6_1_2_5_giro_mercantil'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Denominación Razon 105:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='denominacion_razon105' value='$v105_3_6_1_3_1_denominacion_razon'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>RFC 106:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='rfc106' value='$v106_3_6_1_3_2_rfc'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Identificador Fideicomiso 107:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='identificador_fideicomiso107' value='$v107_3_6_1_3_3_identificador_fideicomiso'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Colonia 110:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='colonia110' value='$v110_3_6_2_1_1_colonia'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Calle 111:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='calle111' value='$v111_3_6_2_1_2_calle'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Número Exterior 112:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='numero_exterior112' value='$v112_3_6_2_1_3_numero_exterior'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Número Interior 113:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='numero_interior113' value='$v113_3_6_2_1_4_numero_interior'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Codigo Postal 114:</b></td>";
						echo "<td><INPUT TYPE='text' NAME=codigo_postal114'' value='$v114_3_6_2_1_5_codigo_postal'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>País 116:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='pais116' value='$v116_3_6_2_2_1_pais'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b> Estado Provincia 117:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='estado_provincia117' value='$v117_3_6_2_2_2_estado_provincia'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Ciudad Población 118:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='ciudad_poblacion118' value='$v118_3_6_2_2_3_ciudad_poblacion'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Colonia 119:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='colonia119' value='$v119_3_6_2_2_4_colonia'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Calle 120:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='calle120' value='$v120_3_6_2_2_5_calle'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Número Exterior 121:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='numero_exterior121' value='$v121_3_6_2_2_6_numero_exterior'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Número Interior 122:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='numero_interior122' value='$v122_3_6_2_2_7_numero_interior'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Codigo Postal 123:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='codigo_postal123' value='$v123_3_6_2_2_8_codigo_postal'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Clave País 125:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='clave_pais125' value='$v125_3_6_3_1_clave_pais'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Número Telefono 126:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='numero_telefono126' value='$v126_3_6_3_2_numero_telefono'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Correo Electronico 127:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='correo_electronico127' value='$v127_3_6_3_3_correo_electronico'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Fecha Operación 131:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='fecha_operacion131' value='$v131_3_7_1_1_1_fecha_operacion'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Tipo Operación 132:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='tipo_operacion132' value='$v132_3_7_1_1_2_tipo_operacion'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Fecha Inicio 133:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='fecha_inicio133' value='$v133_3_7_1_1_3_fecha_inicio'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Fecha Termino 134:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='fecha_termino134' value='$v134_3_7_1_1_4_fecha_termino'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Tipo Inmueble 136:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='tipo_inmueble136' value='$v136_3_7_1_1_5_1_tipo_inmueble'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Valor Avaluo 137:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='valor_avaluo_catastral137' value='$v137_3_7_1_1_5_2_valor_avaluo_catastral'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Colonia 138:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='colonia138' value='$v138_3_7_1_1_5_3_colonia'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Calle 139:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='calle139' value='$v139_3_7_1_1_5_4_calle'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Número Exterior 140:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='numero_exterior140' value='$v140_3_7_1_1_5_5_numero_exterior'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Número Interior 141:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='numero_interior141' value='$v141_3_7_1_1_5_6_numero_interior'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Codigo Postal 142:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='codigo_postal142' value='$v142_3_7_1_1_5_7_codigo_postal'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Blindaje 143:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='blindaje143' value='$v143_3_7_1_1_5_8_blindaje'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Folio Real 144:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='folio_real144' value='$v144_3_7_1_1_5_9_folio_real'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Fecha Pago 146:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='fecha_pago146' value='$v146_3_7_1_1_6_1_fecha_pago'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Instrumento Monetario 147:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='instrumento_monetario147' value='$v147_3_7_1_1_6_2_instrumento_monetario'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Institucion Credito 150:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='institucion_credito150' value='$v150_3_7_1_1_6_3_1_1_institucion_credito'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Número Cuenta 151:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='numero_cuenta151' value='$v151_3_7_1_1_6_3_1_2_numero_cuenta'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Número Cheque 152:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='numero_cheque152' value='$v152_3_7_1_1_6_3_1_3_numero_cheque'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Institución Credito 154:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='institucion_credito154' value='$v154_3_7_1_1_6_3_2_1_institucion_credito'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Número de Cuenta 155:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='numero_cuenta155' value='$v155_3_7_1_1_6_3_2_2_numero_cuenta'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Número de Cheque 156:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='numero_cheque156' value='$v156_3_7_1_1_6_3_2_3_numero_cheque'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Institución Credito 158:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='institucion_credito158' value='$v158_3_7_1_1_6_3_3_1_institucion_credito'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Número de Cheque 159:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='numero_cheque159' value='$v159_3_7_1_1_6_3_3_2_numero_cheque'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Clave Rastreo 161:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='clave_rastreo161' value='$v161_3_7_1_1_6_3_4_1_clave_rastreo'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Folio Interno 163:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='folio_interno163' value='$v163_3_7_1_1_6_3_5_1_folio_interno'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Institución Ordenante 165:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='institucion_ordenante165' value='$v165_3_7_1_1_6_3_6_1_institucion_ordenante'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Número de Cuenta 166:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='numero_cuenta166' value='$v166_3_7_1_1_6_3_6_2_numero_cuenta'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>País de Origen 167:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='pais_origen167' value='$v167_3_7_1_1_6_3_6_3_pais_origen'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Institución Ordenante 169:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='institucion_ordenante169' value='$v169_3_7_1_1_6_3_7_1_institucion_ordenante'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Número de Cuenta 170:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='numero_cuenta170' value='$v170_3_7_1_1_6_3_7_2_numero_cuenta'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Número Giro 171:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='numero_giro171' value='$v171_3_7_1_1_6_3_7_3_numero_giro'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Institución Ordenante 173:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='institucion_ordenante173' value='$v173_3_7_1_1_6_3_8_1_institucion_ordenante '></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Número de Cuenta 174:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='numero_cuenta174' value='$v174_3_7_1_1_6_3_8_2_numero_cuenta'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Número de Orden 175:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='numero_orden_pago175' value='$v175_3_7_1_1_6_3_8_3_numero_orden_pago'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Número de Tarjeta 177:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='numero_tarjeta177' value='$v177_3_7_1_1_6_3_9_1_numero_tarjeta'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Número de Tarjeta 179:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='numero_tarjeta179' value='$v179_3_7_1_1_6_3_10_1_numero_tarjeta'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Número de Tarjeta 181:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='numero_tarjeta181' value='$v181_3_7_1_1_6_3_11_1_numero_tarjeta'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Moneda 182:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='moneda182' value='$v182_3_7_1_1_6_4_moneda'></td>";
					echo "</tr>";
					
					echo "<tr>";
						echo "<td><b>Monto Operación 183:</b></td>";
						echo "<td><INPUT TYPE='text' NAME='monto_operacion183' value='$v183_3_7_1_1_6_5_monto_operacion'></td>";
					echo "</tr>";
				echo "</table>";
			
			
			echo"<table border='0' align='center'>"; 
				echo"<tr height='50'></tr>";
				echo"<tr>";
					echo "<td> <input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png'> </td>";
				echo"</tr>";
			echo"</table>";
		echo "</form>";		
		} else{
			echo "<form action='modificaRenta.php' METHOD='POST'>"; 
				echo "<table border='0' align='center'>";
					echo "<tr height='100'></tr>";
					echo "<tr id='iconosTexto' >";
						echo "<td align='right' >";
							echo "Sujeto";
						echo "</td>";
						echo "<td align='center' width='150' >";
							echo "<select name='ID' size='1'>";
								echo "<option value='0'>Elegir</option>";
								echo "<option value='1'>Julio Antonio Escalante Bourillon</option>";
								echo "<option value='2'>Gabriel Roberto Escalante Bourillon</option>";
						   echo "</select>";
						echo "</td>";
					echo "</tr>";
					echo "<tr height='20'></tr>";
					echo "<tr>";
						echo "<td colspan='2' align='center'><input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png'></td>";
					echo "</tr>";
				echo "</table>";
			echo "</form>";
		}
	
	?>
    
    <br><br>

</body>
</html>