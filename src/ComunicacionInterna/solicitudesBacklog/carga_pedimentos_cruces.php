<?php error_reporting(0); ?>
<?php
$nombrephp = 'carga_pedimentos_cruce.php';
require_once("conexionMasterDB.php");
require_once("conexionMexicoDB.php");
require_once("conexionTolucaDB.php");
require_once("conexionVeracruzDB.php");


$s = $MASTER_GE->Execute("SELECT
							p.xt_referencia, p.xn_aduana
						FROM
							MASTER_PEDIMENTOS p
						WHERE
							YEAR (p.xd_fechaPago) = 2016
						AND p.xn_aduana = 800
						AND xt_referencia not LIKE '%R1%'
						AND p.xd_fechaCruce IS NULL
					");
							
$index = 1;
while($r = $s->FetchRow()){
	$referencia = $r[0];
	$aduana     = $r[1];
	//echo "$index - $referencia - $fechaCruce <BR>";
	$index++;
	
								
	$u = $SCIA->Execute("SELECT NTR_TRAFICOCRUCE REFERENCIA, 
								TO_DATE(TO_CHAR(FCR_TRAFICOCRUCE,'DD/MM/YYYY'),'DD/MM/YYYY') FECHA_1ER, 
								HC1_TRAFICOCRUCE HORA_1ER, 
								CASE WHEN SEM_TRAFICOCRUCE = 1 THEN 'VERDE' ELSE 'ROJO' END PRIMER, 
								NVL(HC2_TRAFICOCRUCE,' ') HORA_2DO, 
								CASE WHEN SE1_TRAFICOCRUCE = 1 THEN 'VERDE' ELSE 'ROJO' END SEGUNDO, 
								NVL(OBS_TRAFICOCRUCE,' ') OBSERVACIONES 
							FROM 
								SCIA.T_TRAFICOCRUCE, 
								SCIA.T_NOTGUIASDATOS, 
								SCIA.T_DIVISIONES
							WHERE  
								NTR_TRAFICOCRUCE = '".$referencia."'
								and NTR_NOTGUIASDATOS  = NTR_TRAFICOCRUCE 
								AND CVE_DIV = CLI_NOTGUIASDATOS ");
								
	while($t = $u->FetchRow()){
		$fecha = $t[1];
		$hora1 = $t[2];	
		$semaforo1 = $t[3];
		$hora2 = $t[4];	
		$semaforo2 = $t[5];
		$observaciones = $t[6];
		
		//echo "$referencia - $aduana - $fecha <BR>";
		
		//echo"update MASTER_PEDIMENTOS set xd_fechaCruce = '".$fecha."' where xt_referencia = '".$referencia."'<br>";
		
		if($MASTER_GE->Execute("update MASTER_PEDIMENTOS set xd_fechaCruce = '".$fecha."' where xt_referencia = '".$referencia."' ")){
			echo "$referencia - $fecha - Correcto <br>";
		}else{
			echo "$referencia - $fecha - fallo!! <br>";
		}
		
	}
}
?>

