<?php
/*
 *@author Abaham Donoso Samantha
 *@author García Robles Octavio Francisco
 *@version 1.0
 *@copyright Copyright (c) 2013, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp = 'generaxml.php';
require_once("../../ConexionDBT.php");
//require_once("compruebaUsuario.php");

$id = $_GET['sujeto'];
$mes = intval($_GET['fecha']);
$monto = $_GET['monto'];
$INTRANET->Execute("UPDATE IntranetGEA_Renta SET 004_1_mes_reportado=$mes, 183_3_7_1_1_6_5_monto_operacion=$monto WHERE kp_rentaID=$id ");

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

$s = $INTRANET->Execute("
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
	$v183_3_7_1_1_6_5_monto_operacion =$r[138];
	
}



$doc = new DOMDocument('1.0');
$doc->formatOutput = true;
///A
$archivo = $doc->createElement('archivo');
$archivo = $doc->appendChild($archivo);
	///AA
	$informe = $doc->createElement('informe');
	$informe = $archivo->appendChild($informe);
		///1
		$t004_1_mes_reportado = $doc->createElement('mes_reportado', $mes);
		$t004_1_mes_reportado = $informe->appendChild($t004_1_mes_reportado);
		///2
		$sujeto_obligado = $doc->createElement('sujeto_obligado');
		$sujeto_obligado = $informe->appendChild($sujeto_obligado);
			///2.1
			$t006_2_1_clave_entidad_colegiada = $doc->createElement('clave_entidad_colegiada', $v006_2_1_clave_entidad_colegiada);
			$t006_2_1_clave_entidad_colegiada = $sujeto_obligado->appendChild($t006_2_1_clave_entidad_colegiada);
			///2.2
			$t007_2_2_clave_sujeto_obligado = $doc->createElement('clave_sujeto_obligado', $v007_2_2_clave_sujeto_obligado);
			$t007_2_2_clave_sujeto_obligado = $sujeto_obligado->appendChild($t007_2_2_clave_sujeto_obligado);
			///2.3
			$t008_2_3_clave_actividad = $doc->createElement('clave_actividad', $v008_2_3_clave_actividad);
			$t008_2_3_clave_actividad = $sujeto_obligado->appendChild($t008_2_3_clave_actividad);
		///3
		$aviso = $doc->createElement('aviso');
		$aviso = $informe->appendChild($aviso);
			///3.1
			$t010_3_1_referencia_aviso = $doc->createElement('referencia_aviso', $v010_3_1_referencia_aviso);
			$t010_3_1_referencia_aviso = $aviso->appendChild($t010_3_1_referencia_aviso);
			///3.2
			$modificatorio = $doc->createElement('modificatorio');
			$modificatorio = $aviso->appendChild($modificatorio);
				///3.2.1
				$t012_3_2_1_folio_modificacion = $doc->createElement('folio_modificacion', $v012_3_2_1_folio_modificacion);
				$t012_3_2_1_folio_modificacion = $modificatorio->appendChild($t012_3_2_1_folio_modificacion);
				///3.2.2
				$t013_3_2_2_descripcion_modificacion = $doc->createElement('descripcion_modificacion', $v013_3_2_2_descripcion_modificacion);
				$t013_3_2_2_descripcion_modificacion = $modificatorio->appendChild($t013_3_2_2_descripcion_modificacion);
			///3.3
			$t014_3_3_prioridad = $doc->createElement('prioridad', $v014_3_3_prioridad);
			$t014_3_3_prioridad = $aviso->appendChild($t014_3_3_prioridad);
			///3.4
			$alerta = $doc->createElement('alerta');
			$alerta = $aviso->appendChild($alerta);
				///3.4.1
				$t016_3_4_1_tipo_alerta = $doc->createElement('tipo_alerta', $v016_3_4_1_tipo_alerta);
				$t016_3_4_1_tipo_alerta = $alerta->appendChild($t016_3_4_1_tipo_alerta);
				///3.4.2
				$t017_3_4_2_descripcion_alerta = $doc->createElement('descripcion_alerta', $v017_3_4_2_descripcion_alerta);
				$t017_3_4_2_descripcion_alerta = $alerta->appendChild($t017_3_4_2_descripcion_alerta);
			///3.5
			$persona_aviso = $doc->createElement('persona_aviso');
			$persona_aviso = $aviso->appendChild($persona_aviso);
				///3.5.1
				$tipo_persona = $doc->createElement('tipo_persona');
				$tipo_persona = $persona_aviso->appendChild($tipo_persona);
					///3.5.1.1
					$persona_física = $doc->createElement('persona_física');
					$persona_física = $tipo_persona->appendChild($persona_física);
						///3.5.1.1.1
						$t021_3_5_1_1_1_nombre = $doc->createElement('nombre', $v021_3_5_1_1_1_nombre);
						$t021_3_5_1_1_1_nombre = $persona_física->appendChild($t021_3_5_1_1_1_nombre);
						///3.5.1.1.2
						$t022_3_5_1_1_2_apellido_paterno = $doc->createElement('apellido_paterno', $v022_3_5_1_1_2_apellido_paterno);
						$t022_3_5_1_1_2_apellido_paterno = $persona_física->appendChild($t022_3_5_1_1_2_apellido_paterno);
						///3.5.1.1.3
						$t023_3_5_1_1_3_apellido_materno = $doc->createElement('apellido_materno', $v023_3_5_1_1_3_apellido_materno);
						$t023_3_5_1_1_3_apellido_materno = $persona_física->appendChild($t023_3_5_1_1_3_apellido_materno);
						///3.5.1.1.4
						$t024_3_5_1_1_4_fecha_nacimiento = $doc->createElement('fecha_nacimiento', $v024_3_5_1_1_4_fecha_nacimiento);
						$t024_3_5_1_1_4_fecha_nacimiento = $persona_física->appendChild($t024_3_5_1_1_4_fecha_nacimiento);
						///3.5.1.1.5
						$t025_3_5_1_1_5_rfc = $doc->createElement('rfc', $v025_3_5_1_1_5_rfc);
						$t025_3_5_1_1_5_rfc = $persona_física->appendChild($t025_3_5_1_1_5_rfc);
						///3.5.1.1.6
						$t026_3_5_1_1_6_curp = $doc->createElement('curp', $v026_3_5_1_1_6_curp);
						$t026_3_5_1_1_6_curp = $persona_física->appendChild($t026_3_5_1_1_6_curp);
						///3.5.1.1.7
						$t027_3_5_1_1_7_pais_nacionalidad = $doc->createElement('pais_nacionalidad', $v027_3_5_1_1_7_pais_nacionalidad);
						$t027_3_5_1_1_7_pais_nacionalidad = $persona_física->appendChild($t027_3_5_1_1_7_pais_nacionalidad);
						///3.5.1.1.8
						$t028_3_5_1_1_8_pais_nacimiento = $doc->createElement('pais_nacimiento', $v028_3_5_1_1_8_pais_nacimiento);
						$t028_3_5_1_1_8_pais_nacimiento = $persona_física->appendChild($t028_3_5_1_1_8_pais_nacimiento);
						///3.5.1.1.9
						$t029_3_5_1_1_9_actividad_economica = $doc->createElement('actividad_economica', $v029_3_5_1_1_9_actividad_economica);
						$t029_3_5_1_1_9_actividad_economica = $persona_física->appendChild($t029_3_5_1_1_9_actividad_economica);
						///3.5.1.1.10
						$t030_3_5_1_1_10_tipo_identificacion = $doc->createElement('tipo_identificacion', $v030_3_5_1_1_10_tipo_identificacion);
						$t030_3_5_1_1_10_tipo_identificacion = $persona_física->appendChild($t030_3_5_1_1_10_tipo_identificacion);
						///3.5.1.1.11
						$t031_3_5_1_1_11_identificacion_otro = $doc->createElement('identificacion_otro', $v031_3_5_1_1_11_identificacion_otro);
						$t031_3_5_1_1_11_identificacion_otro = $persona_física->appendChild($t031_3_5_1_1_11_identificacion_otro);
						///3.5.1.1.12
						$t032_3_5_1_1_12_autoridad_identificacion = $doc->createElement('autoridad_identificacion', $v032_3_5_1_1_12_autoridad_identificacion);
						$t032_3_5_1_1_12_autoridad_identificacion = $persona_física->appendChild($t032_3_5_1_1_12_autoridad_identificacion);
						///3.5.1.1.13
						$t033_3_5_1_1_13_numero_identificacion = $doc->createElement('numero_identificacion', $v033_3_5_1_1_13_numero_identificacion);
						$t033_3_5_1_1_13_numero_identificacion = $persona_física->appendChild($t033_3_5_1_1_13_numero_identificacion);
					///3.5.1.2
					$persona_moral = $doc->createElement('persona_moral');
					$persona_moral = $tipo_persona->appendChild($persona_moral);
						///3.5.1.2.1
						$t035_3_5_1_2_1_denominacion_razon = $doc->createElement('denominacion_razon', $v035_3_5_1_2_1_denominacion_razon);
						$t035_3_5_1_2_1_denominacion_razon = $persona_moral->appendChild($t035_3_5_1_2_1_denominacion_razon);
						///3.5.1.2.2
						$t036_3_5_1_2_2_fecha_constitucion = $doc->createElement('fecha_constitucion', $v036_3_5_1_2_2_fecha_constitucion);
						$t036_3_5_1_2_2_fecha_constitucion = $persona_moral->appendChild($t036_3_5_1_2_2_fecha_constitucion);
						///3.5.1.2.3
						$t037_3_5_1_2_3_rfc = $doc->createElement('rfc', $v037_3_5_1_2_3_rfc);
						$t037_3_5_1_2_3_rfc = $persona_moral->appendChild($t037_3_5_1_2_3_rfc);
						///3.5.1.2.4
						$t038_3_5_1_2_4_pais_nacionalidad = $doc->createElement('pais_nacionalidad', $v038_3_5_1_2_4_pais_nacionalidad);
						$t038_3_5_1_2_4_pais_nacionalidad = $persona_moral->appendChild($t038_3_5_1_2_4_pais_nacionalidad);
						///3.5.1.2.5
						$t039_3_5_1_2_5_giro_mercantil = $doc->createElement('giro_mercantil', $v039_3_5_1_2_5_giro_mercantil);
						$t039_3_5_1_2_5_giro_mercantil = $persona_moral->appendChild($t039_3_5_1_2_5_giro_mercantil);
						///3.5.1.2.6
						$representante_apoderado = $doc->createElement('representante_apoderado');
						$representante_apoderado = $persona_moral->appendChild($representante_apoderado);
							///3.5.1.2.6.1
							$t041_3_5_1_2_6_1_nombre = $doc->createElement('nombre', $v041_3_5_1_2_6_1_nombre);
							$t041_3_5_1_2_6_1_nombre = $representante_apoderado->appendChild($t041_3_5_1_2_6_1_nombre);
							///3.5.1.2.6.2
							$t042_3_5_1_2_6_2_apellido_paterno = $doc->createElement('apellido_paterno', $v042_3_5_1_2_6_2_apellido_paterno);
							$t042_3_5_1_2_6_2_apellido_paterno = $representante_apoderado->appendChild($t042_3_5_1_2_6_2_apellido_paterno);
							///3.5.1.2.6.3
							$t043_3_5_1_2_6_3_apellido_materno = $doc->createElement('apellido_materno', $v043_3_5_1_2_6_3_apellido_materno);
							$t043_3_5_1_2_6_3_apellido_materno = $representante_apoderado->appendChild($t043_3_5_1_2_6_3_apellido_materno);
							///3.5.1.2.6.4
							$t044_3_5_1_2_6_4_fecha_nacimiento = $doc->createElement('fecha_nacimiento', $v044_3_5_1_2_6_4_fecha_nacimiento);
							$t044_3_5_1_2_6_4_fecha_nacimiento = $representante_apoderado->appendChild($t044_3_5_1_2_6_4_fecha_nacimiento);
							///3.5.1.2.6.5
							$t045_3_5_1_2_6_5_rfc = $doc->createElement('rfc', $v045_3_5_1_2_6_5_rfc);
							$t045_3_5_1_2_6_5_rfc = $representante_apoderado->appendChild($t045_3_5_1_2_6_5_rfc);
							///3.5.1.2.6.6
							$t046_3_5_1_2_6_6_curp = $doc->createElement('curp', $v046_3_5_1_2_6_6_curp);
							$t046_3_5_1_2_6_6_curp = $representante_apoderado->appendChild($t046_3_5_1_2_6_6_curp);
							///3.5.1.2.6.7
							$t047_3_5_1_2_6_7_tipo_identificacion = $doc->createElement('tipo_identificacion', $v047_3_5_1_2_6_7_tipo_identificacion);
							$t047_3_5_1_2_6_7_tipo_identificacion = $representante_apoderado->appendChild($t047_3_5_1_2_6_7_tipo_identificacion);
							///3.5.1.2.6.8
							$t048_3_5_1_2_6_8_identificacion_otro = $doc->createElement('identificacion_otro', $v048_3_5_1_2_6_8_identificacion_otro);
							$t048_3_5_1_2_6_8_identificacion_otro = $representante_apoderado->appendChild($t048_3_5_1_2_6_8_identificacion_otro);
							///3.5.1.2.6.9
							$t049_3_5_1_2_6_9_autoridad_identificacion = $doc->createElement('autoridad_identificacion', $v049_3_5_1_2_6_9_autoridad_identificacion);
							$t049_3_5_1_2_6_9_autoridad_identificacion = $representante_apoderado->appendChild($t049_3_5_1_2_6_9_autoridad_identificacion);
							///3.5.1.2.6.10
							$t050_3_5_1_2_6_10_numero_identificacion = $doc->createElement('numero_identificacion', $v050_3_5_1_2_6_10_numero_identificacion);
							$t050_3_5_1_2_6_10_numero_identificacion = $representante_apoderado->appendChild($t050_3_5_1_2_6_10_numero_identificacion);
					///3.5.1.3
					$fideicomiso = $doc->createElement('fideicomiso');
					$fideicomiso = $tipo_persona->appendChild($fideicomiso);
						///3.5.1.3.1
						$t052_3_5_1_3_1_denominacion_razon = $doc->createElement('denominacion_razon', $v052_3_5_1_3_1_denominacion_razon);
						$t052_3_5_1_3_1_denominacion_razon = $fideicomiso->appendChild($t052_3_5_1_3_1_denominacion_razon);
						///3.5.1.3.2
						$t053_3_5_1_3_2_rfc = $doc->createElement('rfc', $v053_3_5_1_3_2_rfc);
						$t053_3_5_1_3_2_rfc = $fideicomiso->appendChild($t053_3_5_1_3_2_rfc);
						///3.5.1.3.3
						$t054_3_5_1_3_3_identificador_fideicomiso = $doc->createElement('identificador_fideicomiso', $v054_3_5_1_3_3_identificador_fideicomiso);
						$t054_3_5_1_3_3_identificador_fideicomiso = $fideicomiso->appendChild($t054_3_5_1_3_3_identificador_fideicomiso);
						///3.5.1.3.4
						$apoderado_delegado = $doc->createElement('apoderado_delegado');
						$apoderado_delegado = $fideicomiso->appendChild($apoderado_delegado);
							///3.5.1.3.4.1
							$t056_3_5_1_3_4_1_nombre = $doc->createElement('nombre', $v056_3_5_1_3_4_1_nombre);
							$t056_3_5_1_3_4_1_nombre = $apoderado_delegado->appendChild($t056_3_5_1_3_4_1_nombre);
							///3.5.1.3.4.2
							$t057_3_5_1_3_4_2_apellido_paterno = $doc->createElement('apellido_paterno', $v057_3_5_1_3_4_2_apellido_paterno);
							$t057_3_5_1_3_4_2_apellido_paterno = $apoderado_delegado->appendChild($t057_3_5_1_3_4_2_apellido_paterno);
							///3.5.1.3.4.3
							$t058_3_5_1_3_4_3_apellido_materno = $doc->createElement('apellido_materno', $v058_3_5_1_3_4_3_apellido_materno);
							$t058_3_5_1_3_4_3_apellido_materno = $apoderado_delegado->appendChild($t058_3_5_1_3_4_3_apellido_materno);
							///3.5.1.3.4.4
							$t059_3_5_1_3_4_4_fecha_nacimiento = $doc->createElement('fecha_nacimiento', $v059_3_5_1_3_4_4_fecha_nacimiento);
							$t059_3_5_1_3_4_4_fecha_nacimiento = $apoderado_delegado->appendChild($t059_3_5_1_3_4_4_fecha_nacimiento);
							///3.5.1.3.4.5
							$t060_3_5_1_3_4_5_rfc = $doc->createElement('rfc', $v060_3_5_1_3_4_5_rfc);
							$t060_3_5_1_3_4_5_rfc = $apoderado_delegado->appendChild($t060_3_5_1_3_4_5_rfc);
							///3.5.1.3.4.6
							$t061_3_5_1_3_4_6_curp = $doc->createElement('curp', $v061_3_5_1_3_4_6_curp);
							$t061_3_5_1_3_4_6_curp = $apoderado_delegado->appendChild($t061_3_5_1_3_4_6_curp);
							///3.5.1.3.4.7
							$t062_3_5_1_3_4_7_tipo_identificacion = $doc->createElement('tipo_identificacion', $v062_3_5_1_3_4_7_tipo_identificacion);
							$t062_3_5_1_3_4_7_tipo_identificacion = $apoderado_delegado->appendChild($t062_3_5_1_3_4_7_tipo_identificacion);
							///3.5.1.3.4.8
							$t063_3_5_1_3_4_8_identificacion_otro = $doc->createElement('identificacion_otro', $v063_3_5_1_3_4_8_identificacion_otro);
							$t063_3_5_1_3_4_8_identificacion_otro = $apoderado_delegado->appendChild($t063_3_5_1_3_4_8_identificacion_otro);
							///3.5.1.3.4.9
							$t064_3_5_1_3_4_9_autoridad_identificacion = $doc->createElement('autoridad_identificacion', $v064_3_5_1_3_4_9_autoridad_identificacion);
							$t064_3_5_1_3_4_9_autoridad_identificacion = $apoderado_delegado->appendChild($t064_3_5_1_3_4_9_autoridad_identificacion);
							///3.5.1.3.4.10
							$t065_3_5_1_3_4_10_numero_identificacion = $doc->createElement('numero_identificacion', $v065_3_5_1_3_4_10_numero_identificacion);
							$t065_3_5_1_3_4_10_numero_identificacion = $apoderado_delegado->appendChild($t065_3_5_1_3_4_10_numero_identificacion);
				///3.5.2
				$tipo_domicilio= $doc->createElement('tipo_domicilio');
				$tipo_domicilio = $persona_aviso->appendChild($tipo_domicilio);
					///3.5.2.1
					$nacional = $doc->createElement('nacional');
					$nacional = $tipo_domicilio->appendChild($nacional);
						///3.5.2.1.1
						$t068_3_5_2_1_1_colonia = $doc->createElement('colonia', $v068_3_5_2_1_1_colonia);
						$t068_3_5_2_1_1_colonia = $nacional->appendChild($t068_3_5_2_1_1_colonia);
						///3.5.2.1.2
						$t069_3_5_2_1_2_calle = $doc->createElement('calle', $v069_3_5_2_1_2_calle);
						$t069_3_5_2_1_2_calle = $nacional->appendChild($t069_3_5_2_1_2_calle);
						///3.5.2.1.3
						$t070_3_5_2_1_3_numero_exterior = $doc->createElement('numero_exterior', $v070_3_5_2_1_3_numero_exterior);
						$t070_3_5_2_1_3_numero_exterior = $nacional->appendChild($t070_3_5_2_1_3_numero_exterior);
						///3.5.2.1.4
						$t071_3_5_2_1_4_numero_interior = $doc->createElement('numero_interior', $v071_3_5_2_1_4_numero_interior);
						$t071_3_5_2_1_4_numero_interior = $nacional->appendChild($t071_3_5_2_1_4_numero_interior);
						///3.5.2.1.5
						$t072_3_5_2_1_5_codigo_postal = $doc->createElement('codigo_postal', $v072_3_5_2_1_5_codigo_postal);
						$t072_3_5_2_1_5_codigo_postal = $nacional->appendChild($t072_3_5_2_1_5_codigo_postal);
					///3.5.2.2
					$extranjero = $doc->createElement('extranjero');
					$extranjero = $tipo_domicilio->appendChild($extranjero);
						///3.5.2.2.1
						$t074_3_5_2_2_1_pais = $doc->createElement('pais', $v074_3_5_2_2_1_pais);
						$t074_3_5_2_2_1_pais = $extranjero->appendChild($t074_3_5_2_2_1_pais);
						///3.5.2.2.2
						$t075_3_5_2_2_2_estado_provincia = $doc->createElement('estado_provincia', $v075_3_5_2_2_2_estado_provincia);
						$t075_3_5_2_2_2_estado_provincia = $extranjero->appendChild($t075_3_5_2_2_2_estado_provincia);
						///3.5.2.2.3
						$t076_3_5_2_2_3_ciudad_poblacion = $doc->createElement('ciudad_poblacion', $v076_3_5_2_2_3_ciudad_poblacion);
						$t076_3_5_2_2_3_ciudad_poblacion = $extranjero->appendChild($t076_3_5_2_2_3_ciudad_poblacion);
						///3.5.2.2.4
						$t077_3_5_2_2_4_colonia = $doc->createElement('colonia', $v077_3_5_2_2_4_colonia);
						$t077_3_5_2_2_4_colonia = $extranjero->appendChild($t077_3_5_2_2_4_colonia);
						///3.5.2.2.5
						$t078_3_5_2_2_5_calle = $doc->createElement('calle', $v078_3_5_2_2_5_calle);
						$t078_3_5_2_2_5_calle = $extranjero->appendChild($t078_3_5_2_2_5_calle);
						///3.5.2.2.6
						$t079_3_5_2_2_6_numero_exterior = $doc->createElement('numero_exterior', $v079_3_5_2_2_6_numero_exterior);
						$t079_3_5_2_2_6_numero_exterior = $extranjero->appendChild($t079_3_5_2_2_6_numero_exterior);
						///3.5.2.2.7
						$t080_3_5_2_2_7_numero_interior = $doc->createElement('numero_interior', $v080_3_5_2_2_7_numero_interior);
						$t080_3_5_2_2_7_numero_interior = $extranjero->appendChild($t080_3_5_2_2_7_numero_interior);
						///3.5.2.2.8
						$t081_3_5_2_2_8_codigo_postal = $doc->createElement('codigo_postal', $v081_3_5_2_2_8_codigo_postal);
						$t081_3_5_2_2_8_codigo_postal = $extranjero->appendChild($t081_3_5_2_2_8_codigo_postal);
				///3.5.3
				$telefono= $doc->createElement('telefono');
				$telefono = $persona_aviso->appendChild($telefono);
					///3.5.3.1
					$t083_3_5_3_1_clave_pais = $doc->createElement('clave_pais', $v083_3_5_3_1_clave_pais);
					$t083_3_5_3_1_clave_pais = $telefono->appendChild($t083_3_5_3_1_clave_pais);
					///3.5.3.2
					$t084_3_5_3_2_numero_telefono = $doc->createElement('numero_telefono', $v084_3_5_3_2_numero_telefono);
					$t084_3_5_3_2_numero_telefono = $telefono->appendChild($t084_3_5_3_2_numero_telefono);
					///3.5.3.3
					$t085_3_5_3_3_correo_electronico = $doc->createElement('correo_electronico', $v085_3_5_3_3_correo_electronico);
					$t085_3_5_3_3_correo_electronico = $telefono->appendChild($t085_3_5_3_3_correo_electronico);
			///3.6
			$dueno_beneficiario = $doc->createElement('dueno_beneficiario');
			$dueno_beneficiario = $aviso->appendChild($dueno_beneficiario);
				///3.6.1
				$tipo_persona2 = $doc->createElement('tipo_persona');
				$tipo_persona2 = $dueno_beneficiario->appendChild($tipo_persona2);
					///3.6.1.1
					$persona_física2 = $doc->createElement('persona_fisica');
					$persona_física2 = $tipo_persona2->appendChild($persona_física2);
						///3.6.1.1.1
						$t089_3_6_1_1_1_nombre = $doc->createElement('nombre', $v089_3_6_1_1_1_nombre);
						$t089_3_6_1_1_1_nombre = $persona_física2->appendChild($t089_3_6_1_1_1_nombre);
						///3.6.1.1.2
						$t090_3_6_1_1_2_apellido_paterno = $doc->createElement('apellido_paterno', $v090_3_6_1_1_2_apellido_paterno);
						$t090_3_6_1_1_2_apellido_paterno = $persona_física2->appendChild($t090_3_6_1_1_2_apellido_paterno);
						///3.6.1.1.3
						$t091_3_6_1_1_3_apellido_materno = $doc->createElement('apellido_materno', $v091_3_6_1_1_3_apellido_materno);
						$t091_3_6_1_1_3_apellido_materno = $persona_física2->appendChild($t091_3_6_1_1_3_apellido_materno);
						///3.6.1.1.4
						$t092_3_6_1_1_4_fecha_nacimiento = $doc->createElement('fecha_nacimiento', $v092_3_6_1_1_4_fecha_nacimiento);
						$t092_3_6_1_1_4_fecha_nacimiento = $persona_física2->appendChild($t092_3_6_1_1_4_fecha_nacimiento);
						///3.6.1.1.5
						$t093_3_6_1_1_5_rfc = $doc->createElement('rfc', $v093_3_6_1_1_5_rfc);
						$t093_3_6_1_1_5_rfc = $persona_física2->appendChild($t093_3_6_1_1_5_rfc);
						///3.6.1.1.6
						$t094_3_6_1_1_6_curp = $doc->createElement('curp', $v094_3_6_1_1_6_curp);
						$t094_3_6_1_1_6_curp = $persona_física2->appendChild($t094_3_6_1_1_6_curp);
						///3.6.1.1.7
						$t095_3_6_1_1_7_pais_nacionalidad = $doc->createElement('pais_nacionalidad', $v095_3_6_1_1_7_pais_nacionalidad);
						$t095_3_6_1_1_7_pais_nacionalidad = $persona_física2->appendChild($t095_3_6_1_1_7_pais_nacionalidad);
						///3.6.1.1.8
						$t096_3_6_1_1_8_pais_nacimiento = $doc->createElement('pais_nacimiento', $v096_3_6_1_1_8_pais_nacimiento);
						$t096_3_6_1_1_8_pais_nacimiento = $persona_física2->appendChild($t096_3_6_1_1_8_pais_nacimiento);
						///3.6.1.1.9
						$t097_3_6_1_1_9_actividad_economica = $doc->createElement('actividad_economica', $v097_3_6_1_1_9_actividad_economica);
						$t097_3_6_1_1_9_actividad_economica = $persona_física2->appendChild($t097_3_6_1_1_9_actividad_economica);
					///3.6.1.2
					$persona_moral2 = $doc->createElement('persona_moral');
					$persona_moral2 = $tipo_persona2->appendChild($persona_moral2);
						///3.6.1.2.1
						$t099_3_6_1_2_1_denominacion_razon = $doc->createElement('denominacion_razon', $v099_3_6_1_2_1_denominacion_razon);
						$t099_3_6_1_2_1_denominacion_razon = $persona_moral2->appendChild($t099_3_6_1_2_1_denominacion_razon);
						///3.6.1.2.2
						$t100_3_6_1_2_2_fecha_constitucion = $doc->createElement('fecha_constitucion', $v100_3_6_1_2_2_fecha_constitucion);
						$t100_3_6_1_2_2_fecha_constitucion = $persona_moral2->appendChild($t100_3_6_1_2_2_fecha_constitucion);
						///3.6.1.2.3
						$t101_3_6_1_2_3_rfc = $doc->createElement('rfc', $v101_3_6_1_2_3_rfc);
						$t101_3_6_1_2_3_rfc = $persona_moral2->appendChild($t101_3_6_1_2_3_rfc);
						///3.6.1.2.4
						$t102_3_6_1_2_4_pais_nacionalidad = $doc->createElement('pais_nacionalidad', $v102_3_6_1_2_4_pais_nacionalidad);
						$t102_3_6_1_2_4_pais_nacionalidad = $persona_moral2->appendChild($t102_3_6_1_2_4_pais_nacionalidad);
						///3.6.1.2.5
						$t103_3_6_1_2_5_giro_mercantil = $doc->createElement('giro_mercantil', $v103_3_6_1_2_5_giro_mercantil);
						$t103_3_6_1_2_5_giro_mercantil = $persona_moral2->appendChild($t103_3_6_1_2_5_giro_mercantil);
					///3.6.1.3
					$fideicomiso2 = $doc->createElement('fideicomiso');
					$fideicomiso2 = $tipo_persona2->appendChild($fideicomiso2);
						///3.6.1.3.1
						$t105_3_6_1_3_1_denominacion_razon = $doc->createElement('denominacion_razon', $v105_3_6_1_3_1_denominacion_razon);
						$t105_3_6_1_3_1_denominacion_razon = $fideicomiso2->appendChild($t105_3_6_1_3_1_denominacion_razon);
						///3.6.1.2.2
						$t106_3_6_1_3_2_rfc = $doc->createElement('rfc', $v106_3_6_1_3_2_rfc);
						$t106_3_6_1_3_2_rfc = $fideicomiso2->appendChild($t106_3_6_1_3_2_rfc);
						///3.6.1.2.3
						$t107_3_6_1_3_3_identificador_fideicomiso = $doc->createElement('identificador_fideicomiso', $v107_3_6_1_3_3_identificador_fideicomiso);
						$t107_3_6_1_3_3_identificador_fideicomiso = $fideicomiso2->appendChild($t107_3_6_1_3_3_identificador_fideicomiso);
				///3.6.2
				$tipo_domicilio2 = $doc->createElement('tipo_domicilio');
				$tipo_domicilio2 = $dueno_beneficiario->appendChild($tipo_domicilio2);
					///3.6.2.1
					$nacional2 = $doc->createElement('nacional');
					$nacional2 = $tipo_domicilio2->appendChild($nacional2);
						///3.6.2.1.1
						$t110_3_6_2_1_1_colonia = $doc->createElement('colonia', $v110_3_6_2_1_1_colonia);
						$t110_3_6_2_1_1_colonia = $nacional2->appendChild($t110_3_6_2_1_1_colonia);
						///3.6.2.1.2
						$t111_3_6_2_1_2_calle = $doc->createElement('calle', $v111_3_6_2_1_2_calle);
						$t111_3_6_2_1_2_calle = $nacional2->appendChild($t111_3_6_2_1_2_calle);
						///3.6.2.1.3
						$t112_3_6_2_1_3_numero_exterior = $doc->createElement('numero_exterior', $v112_3_6_2_1_3_numero_exterior);
						$t112_3_6_2_1_3_numero_exterior = $nacional2->appendChild($t112_3_6_2_1_3_numero_exterior);
						///3.6.2.1.4
						$t113_3_6_2_1_4_numero_interior = $doc->createElement('numero_interior', $v113_3_6_2_1_4_numero_interior);
						$t113_3_6_2_1_4_numero_interior = $nacional2->appendChild($t113_3_6_2_1_4_numero_interior);
						///3.6.2.1.5
						$t114_3_6_2_1_5_codigo_postal = $doc->createElement('codigo_postal', $v114_3_6_2_1_5_codigo_postal);
						$t114_3_6_2_1_5_codigo_postal = $nacional2->appendChild($t114_3_6_2_1_5_codigo_postal);
					///3.6.2.2
					$extranjero2 = $doc->createElement('extranjero');
					$extranjero2 = $tipo_domicilio2->appendChild($extranjero2);
						///3.6.2.2.1
						$t116_3_6_2_2_1_pais = $doc->createElement('pais', $v116_3_6_2_2_1_pais);
						$t116_3_6_2_2_1_pais = $extranjero2->appendChild($t116_3_6_2_2_1_pais);
						///3.6.2.2.2
						$t117_3_6_2_2_2_estado_provincia = $doc->createElement('estado_provincia', $v117_3_6_2_2_2_estado_provincia);
						$t117_3_6_2_2_2_estado_provincia = $extranjero2->appendChild($t117_3_6_2_2_2_estado_provincia);
						///3.6.2.2.3
						$t118_3_6_2_2_3_ciudad_poblacion = $doc->createElement('ciudad_poblacion', $v118_3_6_2_2_3_ciudad_poblacion);
						$t118_3_6_2_2_3_ciudad_poblacion = $extranjero2->appendChild($t118_3_6_2_2_3_ciudad_poblacion);
						///3.6.2.2.4
						$t119_3_6_2_2_4_colonia = $doc->createElement('colonia', $v119_3_6_2_2_4_colonia);
						$t119_3_6_2_2_4_colonia = $extranjero2->appendChild($t119_3_6_2_2_4_colonia);
						///3.6.2.2.5
						$t120_3_6_2_2_5_calle = $doc->createElement('calle', $v120_3_6_2_2_5_calle);
						$t120_3_6_2_2_5_calle = $extranjero2->appendChild($t120_3_6_2_2_5_calle);
						///3.6.2.2.6
						$t121_3_6_2_2_6_numero_exterior = $doc->createElement('numero_exterior', $v121_3_6_2_2_6_numero_exterior);
						$t121_3_6_2_2_6_numero_exterior = $extranjero2->appendChild($t121_3_6_2_2_6_numero_exterior);
						///3.6.2.2.7
						$t122_3_6_2_2_7_numero_interior = $doc->createElement('numero_interior', $v122_3_6_2_2_7_numero_interior);
						$t122_3_6_2_2_7_numero_interior = $extranjero2->appendChild($t122_3_6_2_2_7_numero_interior);
						///3.6.2.2.8
						$t123_3_6_2_2_8_codigo_postal = $doc->createElement('codigo_postal', $v123_3_6_2_2_8_codigo_postal);
						$t123_3_6_2_2_8_codigo_postal = $extranjero2->appendChild($t123_3_6_2_2_8_codigo_postal);
				///3.6.3
				$telefono2 = $doc->createElement('telefono');
				$telefono2 = $dueno_beneficiario->appendChild($telefono2);
					///3.6.3.1
					$t125_3_6_3_1_clave_pais = $doc->createElement('clave_pais', $v125_3_6_3_1_clave_pais);
					$t125_3_6_3_1_clave_pais = $telefono2->appendChild($t125_3_6_3_1_clave_pais);
					///3.6.3.2
					$t126_3_6_3_2_numero_telefono = $doc->createElement('numero_telefono', $v126_3_6_3_2_numero_telefono);
					$t126_3_6_3_2_numero_telefono = $telefono2->appendChild($t126_3_6_3_2_numero_telefono);
					///3.6.3.3
					$t127_3_6_3_3_correo_electronico = $doc->createElement('correo_electronico', $v127_3_6_3_3_correo_electronico);
					$t127_3_6_3_3_correo_electronico = $telefono2->appendChild($t127_3_6_3_3_correo_electronico);
			///3.7
			$detalle_operaciones = $doc->createElement('detalle_operaciones');
			$detalle_operaciones = $aviso->appendChild($detalle_operaciones);
				///3.7.1
				$operaciones_realizadas = $doc->createElement('operaciones_realizadas');
				$operaciones_realizadas = $detalle_operaciones->appendChild($operaciones_realizadas);
					///3.7.1.1
					$datos_operacion = $doc->createElement('datos_operacion');
					$datos_operacion = $operaciones_realizadas->appendChild($datos_operacion);
						///3.7.1.1.1
						$t131_3_7_1_1_1_fecha_operacion = $doc->createElement('fecha_operacion', $v131_3_7_1_1_1_fecha_operacion);
						$t131_3_7_1_1_1_fecha_operacion = $datos_operacion->appendChild($t131_3_7_1_1_1_fecha_operacion);
						///3.7.1.1.2
						$t132_3_7_1_1_2_tipo_operacion = $doc->createElement('tipo_operacion', $v132_3_7_1_1_2_tipo_operacion);
						$t132_3_7_1_1_2_tipo_operacion = $datos_operacion->appendChild($t132_3_7_1_1_2_tipo_operacion);
						///3.7.1.1.3
						$t133_3_7_1_1_3_fecha_inicio = $doc->createElement('fecha_inicio', $v133_3_7_1_1_3_fecha_inicio);
						$t133_3_7_1_1_3_fecha_inicio = $datos_operacion->appendChild($t133_3_7_1_1_3_fecha_inicio);
						///3.7.1.1.4
						$t134_3_7_1_1_4_fecha_termino = $doc->createElement('fecha_termino', $v134_3_7_1_1_4_fecha_termino);
						$t134_3_7_1_1_4_fecha_termino = $datos_operacion->appendChild($t134_3_7_1_1_4_fecha_termino);
						///3.7.1.1.5
						$caracteristicas = $doc->createElement('caracteristicas');
						$caracteristicas = $datos_operacion->appendChild($caracteristicas);
							///3.7.1.1.5.1
							$t136_3_7_1_1_5_1_tipo_inmueble = $doc->createElement('tipo_inmueble', $v136_3_7_1_1_5_1_tipo_inmueble);
							$t136_3_7_1_1_5_1_tipo_inmueble = $caracteristicas->appendChild($t136_3_7_1_1_5_1_tipo_inmueble);
							///3.7.1.1.5.2
							$t137_3_7_1_1_5_2_valor_avaluo_catastral = $doc->createElement('valor_avaluo_catastral', $v137_3_7_1_1_5_2_valor_avaluo_catastral);
							$t137_3_7_1_1_5_2_valor_avaluo_catastral = $caracteristicas->appendChild($t137_3_7_1_1_5_2_valor_avaluo_catastral);
							///3.7.1.1.5.3
							$t138_3_7_1_1_5_3_colonia = $doc->createElement('colonia', $v138_3_7_1_1_5_3_colonia);
							$t138_3_7_1_1_5_3_colonia = $caracteristicas->appendChild($t138_3_7_1_1_5_3_colonia);
							///3.7.1.1.5.4
							$t139_3_7_1_1_5_4_calle = $doc->createElement('calle', $v139_3_7_1_1_5_4_calle);
							$t139_3_7_1_1_5_4_calle = $caracteristicas->appendChild($t139_3_7_1_1_5_4_calle);
							///3.7.1.1.5.5
							$t140_3_7_1_1_5_5_numero_exterior = $doc->createElement('numero_exterior', $v140_3_7_1_1_5_5_numero_exterior);
							$t140_3_7_1_1_5_5_numero_exterior = $caracteristicas->appendChild($t140_3_7_1_1_5_5_numero_exterior);
							///3.7.1.1.5.6
							$t141_3_7_1_1_5_6_numero_interior = $doc->createElement('numero_interior', $v141_3_7_1_1_5_6_numero_interior);
							$t141_3_7_1_1_5_6_numero_interior = $caracteristicas->appendChild($t141_3_7_1_1_5_6_numero_interior);
							///3.7.1.1.5.7
							$t142_3_7_1_1_5_7_codigo_postal = $doc->createElement('codigo_postal', $v142_3_7_1_1_5_7_codigo_postal);
							$t142_3_7_1_1_5_7_codigo_postal = $caracteristicas->appendChild($t142_3_7_1_1_5_7_codigo_postal);
							///3.7.1.1.5.8
							$t143_3_7_1_1_5_8_blindaje = $doc->createElement('blindaje', $v143_3_7_1_1_5_8_blindaje);
							$t143_3_7_1_1_5_8_blindaje = $caracteristicas->appendChild($t143_3_7_1_1_5_8_blindaje);
							///3.7.1.1.5.9
							$t144_3_7_1_1_5_9_folio_real = $doc->createElement('folio_real', $v144_3_7_1_1_5_9_folio_real);
							$t144_3_7_1_1_5_9_folio_real = $caracteristicas->appendChild($t144_3_7_1_1_5_9_folio_real);
						///3.7.1.1.6
						$datos_liquidacion = $doc->createElement('datos_liquidacion');
						$datos_liquidacion = $datos_operacion->appendChild($datos_liquidacion);
							///3.7.1.1.6.1
							$t146_3_7_1_1_6_1_fecha_pago = $doc->createElement('fecha_pago', $v146_3_7_1_1_6_1_fecha_pago);
							$t146_3_7_1_1_6_1_fecha_pago = $datos_liquidacion->appendChild($t146_3_7_1_1_6_1_fecha_pago);
							///3.7.1.1.6.2
							$t147_3_7_1_1_6_2_instrumento_monetario = $doc->createElement('instrumento_monetario', $v147_3_7_1_1_6_2_instrumento_monetario);
							$t147_3_7_1_1_6_2_instrumento_monetario = $datos_liquidacion->appendChild($t147_3_7_1_1_6_2_instrumento_monetario);
							///3.7.1.1.6.3
							$detalle_instrumento = $doc->createElement('detalle_instrumento');
							$detalle_instrumento = $datos_liquidacion->appendChild($detalle_instrumento);
								///3.7.1.1.6.3.1
								$cheque = $doc->createElement('cheque');
								$cheque = $detalle_instrumento->appendChild($cheque);
									///3.7.1.1.6.3.1.1
									$t150_3_7_1_1_6_3_1_1_institucion_credito = $doc->createElement('institucion_credito', $v150_3_7_1_1_6_3_1_1_institucion_credito);
									$t150_3_7_1_1_6_3_1_1_institucion_credito = $cheque->appendChild($t150_3_7_1_1_6_3_1_1_institucion_credito);
									///3.7.1.1.6.3.1.2
									$t151_3_7_1_1_6_3_1_2_numero_cuenta = $doc->createElement('numero_cuenta', $v151_3_7_1_1_6_3_1_2_numero_cuenta);
									$t151_3_7_1_1_6_3_1_2_numero_cuenta = $cheque->appendChild($t151_3_7_1_1_6_3_1_2_numero_cuenta);
									///3.7.1.1.6.3.1.3
									$t152_3_7_1_1_6_3_1_3_numero_cheque = $doc->createElement('numero_cheque', $v152_3_7_1_1_6_3_1_3_numero_cheque);
									$t152_3_7_1_1_6_3_1_3_numero_cheque = $cheque->appendChild($t152_3_7_1_1_6_3_1_3_numero_cheque);
								///3.7.1.1.6.3.2
								$cheque_caja = $doc->createElement('cheque_caja');
								$cheque_caja = $detalle_instrumento->appendChild($cheque_caja);
									///3.7.1.1.6.3.2.1
									$t154_3_7_1_1_6_3_2_1_institucion_credito = $doc->createElement('institucion_credito', $v154_3_7_1_1_6_3_2_1_institucion_credito);
									$t154_3_7_1_1_6_3_2_1_institucion_credito = $cheque_caja->appendChild($t154_3_7_1_1_6_3_2_1_institucion_credito);
									///3.7.1.1.6.3.2.2
									$t155_3_7_1_1_6_3_2_2_numero_cuenta = $doc->createElement('numero_cuenta', $v155_3_7_1_1_6_3_2_2_numero_cuenta);
									$t155_3_7_1_1_6_3_2_2_numero_cuenta = $cheque_caja->appendChild($t155_3_7_1_1_6_3_2_2_numero_cuenta);
									///3.7.1.1.6.3.2.3
									$t156_3_7_1_1_6_3_2_3_numero_cheque = $doc->createElement('numero_cheque', $v156_3_7_1_1_6_3_2_3_numero_cheque);
									$t156_3_7_1_1_6_3_2_3_numero_cheque = $cheque_caja->appendChild($t156_3_7_1_1_6_3_2_3_numero_cheque);
								///3.7.1.1.6.3.3
								$cheque_viajero = $doc->createElement('cheque_viajero');
								$cheque_viajero = $detalle_instrumento->appendChild($cheque_viajero);
									///3.7.1.1.6.3.3.1
									$t158_3_7_1_1_6_3_3_1_institucion_credito = $doc->createElement('institucion_credito', $v158_3_7_1_1_6_3_3_1_institucion_credito);
									$t158_3_7_1_1_6_3_3_1_institucion_credito = $cheque_viajero->appendChild($t158_3_7_1_1_6_3_3_1_institucion_credito);
									///3.7.1.1.6.3.3.2
									$t159_3_7_1_1_6_3_3_2_numero_cheque = $doc->createElement('numero_cheque', $v159_3_7_1_1_6_3_3_2_numero_cheque);
									$t159_3_7_1_1_6_3_3_2_numero_cheque = $cheque_viajero->appendChild($t159_3_7_1_1_6_3_3_2_numero_cheque);
								///3.7.1.1.6.3.4
								$transferencia_interbancaria = $doc->createElement('transferencia_interbancaria');
								$transferencia_interbancaria = $detalle_instrumento->appendChild($transferencia_interbancaria);
									///3.7.1.1.6.3.4.1
									$t161_3_7_1_1_6_3_4_1_clave_rastreo = $doc->createElement('clave_rastreo', $v161_3_7_1_1_6_3_4_1_clave_rastreo);
									$t161_3_7_1_1_6_3_4_1_clave_rastreo = $transferencia_interbancaria->appendChild($t161_3_7_1_1_6_3_4_1_clave_rastreo);
								///3.7.1.1.6.3.5
								$transferencia_mismo_banco = $doc->createElement('transferencia_mismo_banco');
								$transferencia_mismo_banco = $detalle_instrumento->appendChild($transferencia_mismo_banco);
									///3.7.1.1.6.3.5.1
									$t163_3_7_1_1_6_3_5_1_folio_interno = $doc->createElement('folio_interno', $v163_3_7_1_1_6_3_5_1_folio_interno);
									$t163_3_7_1_1_6_3_5_1_folio_interno = $transferencia_mismo_banco->appendChild($t163_3_7_1_1_6_3_5_1_folio_interno);
								///3.7.1.1.6.3.6
								$transferencia_internacional = $doc->createElement('transferencia_internacional');
								$transferencia_internacional = $detalle_instrumento->appendChild($transferencia_internacional);
									///3.7.1.1.6.3.6.1
									$t165_3_7_1_1_6_3_6_1_institucion_ordenante = $doc->createElement('institucion_ordenante', $v165_3_7_1_1_6_3_6_1_institucion_ordenante);
									$t165_3_7_1_1_6_3_6_1_institucion_ordenante = $transferencia_internacional->appendChild($t165_3_7_1_1_6_3_6_1_institucion_ordenante);
									///3.7.1.1.6.3.6.2
									$t166_3_7_1_1_6_3_6_2_numero_cuenta = $doc->createElement('numero_cuenta', $v166_3_7_1_1_6_3_6_2_numero_cuenta);
									$t166_3_7_1_1_6_3_6_2_numero_cuenta = $transferencia_internacional->appendChild($t166_3_7_1_1_6_3_6_2_numero_cuenta);
									///3.7.1.1.6.3.6.3
									$t167_3_7_1_1_6_3_6_3_pais_origen = $doc->createElement('pais_origen', $v167_3_7_1_1_6_3_6_3_pais_origen);
									$t167_3_7_1_1_6_3_6_3_pais_origen = $transferencia_internacional->appendChild($t167_3_7_1_1_6_3_6_3_pais_origen);
								///3.7.1.1.6.3.7
								$giro = $doc->createElement('giro');
								$giro = $detalle_instrumento->appendChild($giro);
									///3.7.1.1.6.3.7.1
									$t169_3_7_1_1_6_3_7_1_institucion_ordenante = $doc->createElement('institucion_ordenante', $v169_3_7_1_1_6_3_7_1_institucion_ordenante);
									$t169_3_7_1_1_6_3_7_1_institucion_ordenante = $giro->appendChild($t169_3_7_1_1_6_3_7_1_institucion_ordenante);
									///3.7.1.1.6.3.7.2
									$t170_3_7_1_1_6_3_7_2_numero_cuenta = $doc->createElement('numero_cuenta', $v170_3_7_1_1_6_3_7_2_numero_cuenta);
									$t170_3_7_1_1_6_3_7_2_numero_cuenta = $giro->appendChild($t170_3_7_1_1_6_3_7_2_numero_cuenta);
									///3.7.1.1.6.3.7.3
									$t171_3_7_1_1_6_3_7_3_numero_giro = $doc->createElement('numero_giro', $v171_3_7_1_1_6_3_7_3_numero_giro);
									$t171_3_7_1_1_6_3_7_3_numero_giro = $giro->appendChild($t171_3_7_1_1_6_3_7_3_numero_giro);
								///3.7.1.1.6.3.8
								$orden_pago = $doc->createElement('orden_pago');
								$orden_pago = $detalle_instrumento->appendChild($orden_pago);
									///3.7.1.1.6.3.8.1
									$t173_3_7_1_1_6_3_8_1_institucion_ordenante = $doc->createElement('institucion_ordenante', $v173_3_7_1_1_6_3_8_1_institucion_ordenante);
									$t173_3_7_1_1_6_3_8_1_institucion_ordenante = $orden_pago->appendChild($t173_3_7_1_1_6_3_8_1_institucion_ordenante);
									///3.7.1.1.6.3.8.2
									$t174_3_7_1_1_6_3_8_2_numero_cuenta = $doc->createElement('numero_cuenta', $v174_3_7_1_1_6_3_8_2_numero_cuenta);
									$t174_3_7_1_1_6_3_8_2_numero_cuenta = $orden_pago->appendChild($t174_3_7_1_1_6_3_8_2_numero_cuenta);
									///3.7.1.1.6.3.8.3
									$t175_3_7_1_1_6_3_8_3_numero_orden_pago = $doc->createElement('numero_orden_pago', $v175_3_7_1_1_6_3_8_3_numero_orden_pago);
									$t175_3_7_1_1_6_3_8_3_numero_orden_pago = $orden_pago->appendChild($t175_3_7_1_1_6_3_8_3_numero_orden_pago);
								///3.7.1.1.6.3.9
								$tarjeta_credito = $doc->createElement('tarjeta_credito');
								$tarjeta_credito = $detalle_instrumento->appendChild($tarjeta_credito);
									///3.7.1.1.6.3.9.1
									$t177_3_7_1_1_6_3_9_1_numero_tarjeta = $doc->createElement('numero_tarjeta', $v177_3_7_1_1_6_3_9_1_numero_tarjeta);
									$t177_3_7_1_1_6_3_9_1_numero_tarjeta = $tarjeta_credito->appendChild($t177_3_7_1_1_6_3_9_1_numero_tarjeta);
								///3.7.1.1.6.3.10
								$tarjeta_debito = $doc->createElement('tarjeta_debito');
								$tarjeta_debito = $detalle_instrumento->appendChild($tarjeta_debito);
									///3.7.1.1.6.3.10.1
									$t179_3_7_1_1_6_3_10_1_numero_tarjeta = $doc->createElement('numero_tarjeta', $v179_3_7_1_1_6_3_10_1_numero_tarjeta);
									$t179_3_7_1_1_6_3_10_1_numero_tarjeta = $tarjeta_debito->appendChild($t179_3_7_1_1_6_3_10_1_numero_tarjeta);
								///3.7.1.1.6.3.11
								$tarjeta_prepagada = $doc->createElement('tarjeta_prepagada');
								$tarjeta_prepagada = $detalle_instrumento->appendChild($tarjeta_prepagada);
									///3.7.1.1.6.3.11.1
									$t181_3_7_1_1_6_3_11_1_numero_tarjeta = $doc->createElement('numero_tarjeta', $v181_3_7_1_1_6_3_11_1_numero_tarjeta);
									$t181_3_7_1_1_6_3_11_1_numero_tarjeta = $tarjeta_prepagada->appendChild($t181_3_7_1_1_6_3_11_1_numero_tarjeta);
							///3.7.1.1.6.4
							$t182_3_7_1_1_6_4_moneda = $doc->createElement('moneda', $v182_3_7_1_1_6_4_moneda);
							$t182_3_7_1_1_6_4_moneda = $datos_liquidacion->appendChild($t182_3_7_1_1_6_4_moneda);
							///3.7.1.1.6.5
							$t183_3_7_1_1_6_5_monto_operacion = $doc->createElement('monto_operacion', $monto);
							$t183_3_7_1_1_6_5_monto_operacion = $datos_liquidacion->appendChild($t183_3_7_1_1_6_5_monto_operacion);
							
							

header("Content-Description: File Transfer"); 
header("Content-type: text/xml"); 
header("Pragma: no-cache");
header("Expires: 0");
header("Content-Disposition: attachment; filename=\"reporteXML.xml\";" );
header("Content-Transfer-Encoding: binary");

echo $doc->saveXML();

?>