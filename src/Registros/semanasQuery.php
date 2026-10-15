<?php error_reporting(0); ?>
<?php
require_once "D04_conexionBD.php";
$parametros = $_REQUEST["datos"];
$parts= explode("-", $parametros);
$year = $parts[0];
$sem = $parts[1];
$month = $parts[2];
$fueraRango=0;
$valorMaximo = 0;
$datos= array();
$fechaCruce[] = array();
$fechaRevalidacion[] =array();
$numDia[]=array();
$idRef[]=array();
$nombre[]= array();
$xvalues[] = array();
$yvalues[]= array();
$indiceArray = 0;
$year = ($year == "")?date("Y"):$year;
$parametros=($parametros == "")?date("Y"):$parametros;

$existe  = $db->getOne("SELECT kf_slotId FROM GRAPHICS.graphics_contenidoslot WHERE kf_artefactoId = 13");
$usuario = $db->getOne("SELECT kp_userId FROM GRAPHICS.graphics_user WHERE xt_userName = '".$_SESSION["sesionUsuario"]."'");

if($existe != ''){
	$db1->Execute("UPDATE GRAPHICS.graphics_contenidoslot
					SET xn_year = ".$year.",
					 xt_rfc = '".$_SESSION['rfc']."'
					WHERE
						kf_userId = ".$usuario."
					AND kf_artefactoId = 13 ") or die("Error al registrar slot");
}else{
	$cont = $db1->getOne("SELECT MAX(kp_contenidoSlotId) FROM graphics_contenidoslot");
			
			$contador[0] = $cont+1;

	$db1->Execute("insert into GRAPHICS.graphics_contenidoslot  values(".$contador[0].",".$usuario.",13,1,".$year.",'".$_SESSION['rfc']."')") or die("Error de insercion slot");
}

$s = $db1 ->Execute("SELECT xd_fecha FROM graphics_calendario WHERE xn_festivo =1 and YEAR(xd_fecha)= $year ") or die ("Error de selección de feriados");
while($r=$s->fetchRow())
{
	$feriados[$indiceArray]=$r[0];
	$indiceArray ++;
}


if($year != "" &&  $sem == "" && $month == "")
{

	$indiceArray = 0;
	
	$s= $db->Execute("SELECT CONCAT(YEAR(SUBSTR(xd_fechaPago,1+1)),' ',SUBSTR(xn_aduana,1,2),' ',xn_patente,' ',SUBSTRING_INDEX(kp_pedimento, '-', -1)) as Pedimento, xd_fechaCruce, xd_fechaRevalidacion, datediff(xd_fechaCruce,xd_fechaRevalidacion), xd_fechaPago FROM MASTER_PEDIMENTOS WHERE xn_aduana = 470 AND xd_fechaRevalidacion LIKE '%$year%' 
	AND xt_rfcCausante = '".$_SESSION['rfc']."' ORDER BY xd_fechaRevalidacion") or die ("Error de selección de referencia Y");
	$valorMaximo = $s->RecordCount();
	$alias = $year;
	
	while ($r=$s->fetchRow())
	{
	  $datos[$indiceArray]             = $r[0];
	  $fechaCruce[$indiceArray]        = $r[1];
	  $fechaRevalidacion[$indiceArray] = $r[2];
	  $diferenciaDias[$indiceArray]    = $r[3];
	  $fechaPago[$indiceArray]         = $r[4];
	  $indiceArray ++;		
	}

}
else if($year != "" &&  $sem != "" && $month == "")
{
	if ($sem ==1)
	{
		$indiceArray = 0;
		
		$s= $db->Execute("SELECT CONCAT(YEAR(SUBSTR(xd_fechaPago,1+1)),' ',SUBSTR(xn_aduana,1,2),' ',xn_patente,' ',SUBSTRING_INDEX(kp_pedimento, '-', -1)) as Pedimento, xd_fechaCruce, xd_fechaRevalidacion, datediff(xd_fechaCruce,xd_fechaRevalidacion), xd_fechaPago FROM MASTER_PEDIMENTOS WHERE xn_aduana = 470 AND xd_fechaRevalidacion >= '$year-01-01' AND xd_fechaRevalidacion <= '$year-07-01' AND xt_rfcCausante = '".$_SESSION['rfc']."' ORDER BY xd_fechaRevalidacion") or die ("Error de selección de referencia Y - S -1");
		$valorMaximo = $s->RecordCount();
		$alias = "SEMESTRE 1, ".$year;
		while ($r=$s->fetchRow())
		{
			$datos[$indiceArray] = $r[0];
		    $fechaCruce[$indiceArray] = $r[1];
	        $fechaRevalidacion[$indiceArray] = $r[2];
			$diferenciaDias[$indiceArray]    = $r[3];
			$fechaPago[$indiceArray]         = $r[4];
			$indiceArray ++;		
				
		}
	}
	else
	{
		$indiceArray = 0;
		$s= $db->Execute("SELECT CONCAT(YEAR(SUBSTR(xd_fechaPago,1+1)),' ',SUBSTR(xn_aduana,1,2),' ',xn_patente,' ',SUBSTRING_INDEX(kp_pedimento, '-', -1)) as Pedimento, xd_fechaCruce, xd_fechaRevalidacion, datediff(xd_fechaCruce,xd_fechaRevalidacion), xd_fechaPago FROM MASTER_PEDIMENTOS WHERE xn_aduana = 470 AND xd_fechaRevalidacion >= '$year-07-01' AND xd_fechaRevalidacion <= '$year-12-31' AND xt_rfcCausante = '".$_SESSION['rfc']."' ORDER BY xd_fechaRevalidacion") or die ("Error de selección de referencia Y - S -2");
		$valorMaximo = $s->RecordCount();
		$alias = "SEMESTRE 2, ".$year;
		while ($r=$s->fetchRow())
		{
			$datos[$indiceArray] = $r[0];
		    $fechaCruce[$indiceArray] = $r[1];
	        $fechaRevalidacion[$indiceArray] = $r[2];
			$diferenciaDias[$indiceArray]    = $r[3];
			$fechaPago[$indiceArray]         = $r[4];
			$indiceArray ++;	
				
		}
	}
}
else if($year != "" &&  $sem != "" && $month != "")
{		
		switch ($month ){
		case 1: $alias="ENE-".$year; break;
		case 2: $alias="FEB-".$year; break;
		case 3: $alias="MAR-".$year; break;
		case 4: $alias="ABR-".$year; break;
		case 5: $alias="MAY-".$year; break;
		case 6: $alias="JUN-".$year; break;
		case 7: $alias="JUL-".$year; break;
		case 8: $alias="AGO-".$year; break;
		case 9: $alias="SEP-".$year; break;
		case 10: $alias="OCT-".$year; break;
		case 11: $alias="NOV-".$year; break;
		case 12: $alias="DIC-".$year; break;
		}

		if($month<10)
		{
			$mesf="0".$month;
		}
		else
		{
			$mesf=$month;
		}
		$indiceArray = 0;
		$s= $db->Execute("SELECT CONCAT(YEAR(SUBSTR(xd_fechaPago,1+1)),' ',SUBSTR(xn_aduana,1,2),' ',xn_patente,' ',SUBSTRING_INDEX(kp_pedimento, '-', -1)) as Pedimento, xd_fechaCruce, xd_fechaRevalidacion, datediff(xd_fechaCruce,xd_fechaRevalidacion), xd_fechaPago FROM MASTER_PEDIMENTOS WHERE xn_aduana = 470 AND xd_fechaRevalidacion LIKE '$year-$mesf-%' AND xt_rfcCausante = '".$_SESSION['rfc']."' ORDER BY xd_fechaRevalidacion") or die ("Error de selección de referencia Y-S-M");
		$valorMaximo = $s->RecordCount();
		while ($r=$s->fetchRow())
		{
			$datos[$indiceArray] = $r[0];
		    $fechaCruce[$indiceArray] = $r[1];
	        $fechaRevalidacion[$indiceArray] = $r[2];
			$diferenciaDias[$indiceArray]    = $r[3];
			$fechaPago[$indiceArray]         = $r[4];
			$indiceArray ++;	
		}
}


$contador=0;
$festivo =0;

foreach($datos as $indice => $valor)
{
	
	$filas = $diferenciaDias[$indice];
	
	$fecha = date('z', strtotime($fechaPago[$indice]));
	
	//$segundos=strtotime($fechaCruce[$indice]) - strtotime($fechaRevalidacion[$indice]);
	//$filas=intval($segundos/60/60/24);
		
	//echo "La cantidad de días entre el ".$fechaCruce[$indice]." y ".$fechaRevalidacion[$indice]." es <b>". round($filas,2)." referencia ".$referencia."</b><br>";
	
	/*$x= $db1->Execute("select datediff('$fechaCruce[$indice]','$fechaRevalidacion[$indice]')") or die("Error de selección de diferencia de fechas");
	while($y = $x->fetchRow())
	{*/
	 // $filas = $y[0];
	  for($i=0;$i<$filas; $i++)
	  {
		 
		$nuevafecha = strtotime ( '+"'.$i.'" day' , strtotime ($fechaRevalidacion[$indice]) ) ;
		$nuevafecha1 = date ( 'Y-m-d' , $nuevafecha ); 
 
		/*$h = $db1->Execute("select adddate('$fechaRevalidacion[$indice]',$i)") or die ("Error al agregar dia");
		while($d=$h->fetchRow())
		{*/
		  $validaDia = strtotime($nuevafecha1);
		  $numeroDia=date('w', $validaDia);
		  
		  if(in_array($nuevafecha1,$feriados) )
		  {
			  $festivo++;
		  }
		  
		  else if($numeroDia==0 || $numeroDia == 6)
		  {
			$festivo++;
		  }
	  
		//}
	  //}
	}


	$diferenciaFinal = $filas-$festivo;
	if ($diferenciaFinal>8)
	{
		$idRef[$fueraRango] = $datos[$contador];
		$numDia[$fueraRango] = $diferenciaFinal;
		$fueraRango++;
	}
	$festivo=0;
	$xvalues[$contador] = $fecha;//$contador;
	$yvalues[$contador]=($diferenciaFinal <0)?0:$diferenciaFinal;
	$nombre[$contador] = "$datos[$contador]";
	$contador++;
}

$totalOperaciones= $contador;
/*echo " series: [";
		echo"{
			color: 'rgba(49,99,144,.9)',
		 data: [";
		for ($i=0;$i<$valorMaximo ;$i++)
		{
		  if($i != $valorMaximo)
		  {
			echo "{name: '$nombre[$i]', x: $xvalues[$i], y: $yvalues[$i]},<br>";
		  }
		  else
		  {
 			echo "{name: '$nombre[$i]', x: $xvalues[$i], y: $yvalues[$i]}<br>";
		  }
		}
	  echo "]
	  }]";
*/
?>





