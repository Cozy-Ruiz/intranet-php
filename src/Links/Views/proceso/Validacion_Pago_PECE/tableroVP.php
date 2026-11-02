<?php

class TableroVP{
	
	function iniciaTablero(){
		$html = "
		<link rel='stylesheet' type='text/css' href='../Views/css/tableroValidacion.css' media='screen' />
		<link rel='stylesheet' type='text/css' href='../Views/css/XMLDisplay.css'>
		<div id='tablero'></div>";
		
		return $html;
	}

	function generaRegistro($datos, $index){

		$html  = '';

		$color = "Blanco";
		
		for($a = 0; $a<count($datos); $a++){

			$referencia = $datos[$a][0];
			$usuario = $datos[$a][1];
			$status = $datos[$a][2];
			$archivoM = $datos[$a][3];
			$archivoE = $datos[$a][4];
			$fecha = new DateTime($datos[$a][5]);
			$detalle = $datos[$a][7];

			$fechaActual = new DateTime(date("d-m-Y"));

			$interval = $fecha->diff($fechaActual);
			$interval =  $interval->format('%a');

				$html .= "<td class='datos' id='index-".$referencia."' name='".$index."' align='center'><font color='gray'>".($index).".-</font></td>";
				$html .= "<td class=\"datos\" align=\"center\"><a id='detalle-".$referencia."' href=\"javascript:void(0)\" onClick=\"muestraDetalle('".$detalle."', '".$referencia."')\">".$referencia."</a></td>";
				$html .= "<td class='datos' align='center'>".$archivoM."</td>";
				$html .= "<td class='datos' align='center'>".$archivoE."</td>";
				$html .= "<td class='datos' align='center'>";
					if($status != "Liberado"){
						$html .= "<img onclick=\"eliminaReferencia('".$referencia."')\" src='../Views/img/ICN_BotonEliminarGris.png'>";
					}
				$html .= "</td>";
				$html .= "<td class='datos' align='center'>".$usuario."</td>";

				if($status == "Para generar M"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>GENERA M</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>
					";

				}else if($status == "Para generar M Desistimiento"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>GENERA DESISTIMIENTO</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>
					";

				}else if($status == "Para prevalidar"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"enviaPrevalidar('".$referencia."')\" style='background-color:rgb(0,249,0); width:60%; border:none; cursor:pointer;'>
					<font color='black'><b>PREVALIDAR</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>
					";

				}else if($status == "Para validar"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"enviaValidar('".$referencia."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>VALIDAR</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>
					";

				}else if($status == "Para desistir"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"enviaDesistir('".$referencia."')\" style='background-color:rgb(0,249,0); width:60%; border:none; cursor:pointer;'>
					<font color='black'><b>DESISTIR</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>
					";

				}else if($status == "Para generar cancelacion"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>GENERA CANCELACION</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>
					";

				}else if($status == "Para generar E"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>GENERA E</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>
					";

				}else if($status == "Para pagar"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>PAGAR</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>
					";

				}else if($status == "Esperando prevalidador"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>PREVALIDAR</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'>esperando...</td>
					";

				}else if($status == "Esperando validador"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>VALIDAR</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'>esperando...</td>
					";

				}else if($status == "Esperando cancelacion"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>CANCELACIÓN</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'>esperando...</td>
					";

				}else if($status == "Esperando pago"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>PAGAR</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'>esperando...</td>
					";

				}else if($status == "Esperando desistimiento"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>DESISTIMIENTO</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'>esperando...</td>
					";

				}else if($status == "Para generar Simplificado"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"enviaGenerarSimplificado('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='black'><b>Genera Simplificado</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>
					";

				}else if($status == "Para liberar"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"enviaLiberar('".$referencia."')\" style='background-color:#92f442; width:60%; border:none; cursor:pointer;'>
					<font color='black'><b>LIBERAR</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>
					";

				}else if($status == "Liberado"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'></td>
					<td class='datos' align='center'><img src='../Views/img/ICN_BotonVerde.png'></img></td>
					";

				}else if($status == "Error prevalidar"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick='' style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>PREVALIDAR</b></font>	
					</button></td>
					<td class='datos' id='estatus-".$referencia."' align='center'><img src='../Views/img/ICN_BotonRojo.png'></img></td>
					";

				}else if($status == "Error validar"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick='' style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>VALIDAR</b></font>	
					</button></td>
					<td class='datos' id='estatus-".$referencia."' align='center'><img src='../Views/img/ICN_BotonRojo.png'></img></td>
					";

				}else if($status == "Error cancelacion"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick='' style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>CANCELACION</b></font>	
					</button></td>
					<td class='datos' id='estatus-".$referencia."' align='center'><img src='../Views/img/ICN_BotonRojo.png'></img></td>
					";

				}else if($status == "Error pagar"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick='' style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>PAGAR</b></font>	
					</button></td>
					<td class='datos' id='estatus-".$referencia."' align='center'><img src='../Views/img/ICN_BotonRojo.png'></img></td>
					";

				}else if($status == "Pago realizado" || $status == "Desistimiento realizado"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>Documentos</b></font>	
					</button></td>
					<td class='datos' id='estatus-".$referencia."' align='center'><img src=''></img></td>
					";

				}else if($status == "Para cerrar consolidado"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>CERRAR C.</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>
					";

				}else if($status == "Consolidado cerrado"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>C. Cerrado</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>
					";

				}else if($status == "Validacion Contabilidad"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($session))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>Validacion Cont.</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>
					";

				}else if($status == "Carga evidencia SOIA"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>Evidencia SOIA</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>

					";

				}else if($status == "Completar datos pago"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>Datos pago</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>

					";

				}else if($status == "Completar datos pago sin A"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>Datos pago</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>

					";

				}else if($status == "Datos pago completado"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>Procesando Datos pago</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>

					";

				}


				$index++;
			
		}
		
		echo $html;
		
	}
	
	function generaTablero($titulo, $campos, $datos, $session){
		
		$html = "<div class='contenido' >";
			$html .= "<table border='0' width='100%' cellspacing='0'>";

				$html .= "<tr id='tituloTablero'>";
						$html .= "<td colspan='2'>".$titulo."</td>";
				$html .= "</tr>";

				$html .= "<tr>";
					$html .= "<td colspan='2' id='titleBlueLineBottom'></td>";
				$html .= "</tr>";

				$html .= "<tr>";

					$html .= "<td valign='top' align='center'>";
						$html .= "<table border='0' cellspacing='0'>";
							$html .= "<tr height='70' id='nombreCampos' align='center'>";
								$html .= "<td>Añadir</td>";
			            	$html .= "</tr>";
			            	$html .= "<tr height='70' align='center'>";
								$html .= "<td><textarea id='referencias' rows='20' style='width:120px;'></textarea></td>";
			            	$html .= "</tr>";

							$html .= "<tr align='center'>";
								$html .= "<td><input type='checkbox' id='estatusDesistimiento'>Desistimiento</input></td>";
			            	$html .= "</tr>";

			            	$html .= "<tr height='70' align='center'>";
								$html .= "<td><button type='button' onClick=\"cargaReferencias('".str_replace('"',"\'", json_encode($session))."')\">Enviar</button></td>";
			            	$html .= "</tr>";
						$html .= "</table>";
					$html .= "</td>";

					$html .= "<td valign='top' id='registros'>";
						$html .= "<table border='0' id='TblTablero' width='95%' style='margin-left:1em;' cellspacing='0'>";

							$html .= "<tr height='70' id='nombreCampos' align='center'>";
								$html .= "<td></td>";
								for($a = 0; $a<count($campos); $a++){
									$html .= "<td>".$campos[$a]."</td>";
								}
			            	$html .= "</tr>";
							
							$color = "Blanco";
							$index = 1;
							for($a = 0; $a<count($datos); $a++){

								$referencia = $datos[$a][0];
								$usuario = $datos[$a][1];
								$status = $datos[$a][2];
								$archivoM = $datos[$a][3];
								$archivoE = $datos[$a][4];
								$fecha = new DateTime($datos[$a][5]);
								$detalle = $datos[$a][7];

								$fechaActual = new DateTime(date("d-m-Y"));

								$interval = $fecha->diff($fechaActual);
								$interval =  $interval->format('%a');

								//if($status != "Liberado" || ($status == "Liberado" && $interval == 0)){

									if($color == "Blanco"){
										$html .= "<tr id='registro-".$referencia."'>";
										$color = "Gris";
									}else if($color == "Gris"){
										$html .= "<tr id='registro-".$referencia."' style='background-color:rgb(249,249,249); height:35px'>";
										$color = "Blanco";
									}

									$html .= "<td class='datos' id='index-".$referencia."' name='".$index."' align='center'><font color='gray'>".($index).".-</font></td>";
									$html .= "<td class=\"datos\" align=\"center\"><a id='detalle-".$referencia."' href=\"javascript:void(0)\" onClick=\"muestraDetalle('".$detalle."', '".$referencia."')\">".$referencia."</a></td>";
									$html .= "<td class='datos' align='center'>".$archivoM."</td>";
									$html .= "<td class='datos' align='center'>".$archivoE."</td>";
									$html .= "<td class='datos' align='center'>";
										if($status != "Liberado"){
											$html .= "<img onclick=\"eliminaReferencia('".$referencia."')\" src='../Views/img/ICN_BotonEliminarGris.png'>";
										}
									$html .= "</td>";
									$html .= "<td class='datos' align='center'>".$usuario."</td>";

									if($status == "Para generar M"){

										$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."' align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($session))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
										<font color='white'><b>GENERA M</b></font>	
										</button> </td>
										<td class='datos' id='estatus-".$referencia."' align='center'></td>
										";

									}else if($status == "Para generar M Desistimiento"){

										$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."' align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($session))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
										<font color='white'><b>GENERA DESISTIMIENTO</b></font>	
										</button> </td>
										<td class='datos' id='estatus-".$referencia."' align='center'></td>
										";

									}else if($status == "Para prevalidar"){

										$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"enviaPrevalidar('".$referencia."')\" style='background-color:rgb(0,249,0); width:60%; border:none; cursor:pointer;'>
										<font color='black'><b>PREVALIDAR</b></font>	
										</button> </td>
										<td class='datos' id='estatus-".$referencia."' align='center'></td>
										";

									}else if($status == "Para validar"){

										$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"enviaValidar('".$referencia."', '".str_replace('"',"\'", json_encode($session))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
										<font color='white'><b>VALIDAR</b></font>	
										</button> </td>
										<td class='datos' id='estatus-".$referencia."' align='center'></td>
										";

									}else if($status == "Para desistir"){

										$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"enviaDesistir('".$referencia."')\" style='background-color:rgb(0,249,0); width:60%; border:none; cursor:pointer;'>
										<font color='black'><b>DESISTIR</b></font>	
										</button> </td>
										<td class='datos' id='estatus-".$referencia."' align='center'></td>
										";

									}else if($status == "Para generar cancelacion"){

										$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($session))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
										<font color='white'><b>GENERA CANCELACION</b></font>	
										</button> </td>
										<td class='datos' id='estatus-".$referencia."' align='center'></td>
										";
					
									}else if($status == "Para generar E"){

										$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($session))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
										<font color='white'><b>GENERA E</b></font>	
										</button> </td>
										<td class='datos' id='estatus-".$referencia."' align='center'></td>
										";

									}else if($status == "Para pagar"){

										$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($session))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
										<font color='white'><b>PAGAR</b></font>	
										</button> </td>
										<td class='datos' id='estatus-".$referencia."' align='center'></td>
										";

									}else if($status == "Esperando prevalidador"){

										$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
										<font color='white'><b>PREVALIDAR</b></font>	
										</button> </td>
										<td class='datos' id='estatus-".$referencia."' align='center'>esperando...</td>
										";

									}else if($status == "Esperando validador"){

										$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
										<font color='white'><b>VALIDAR</b></font>	
										</button> </td>
										<td class='datos' id='estatus-".$referencia."' align='center'>esperando...</td>
										";

									}else if($status == "Esperando cancelacion"){

										$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
										<font color='white'><b>CANCELACIÓN</b></font>	
										</button> </td>
										<td class='datos' id='estatus-".$referencia."' align='center'>esperando...</td>
										";

									}else if($status == "Esperando pago"){

										$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
										<font color='white'><b>PAGAR</b></font>	
										</button> </td>
										<td class='datos' id='estatus-".$referencia."' align='center'>esperando...</td>
										";

									}else if($status == "Esperando desistimiento"){

										$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
										<font color='white'><b>DESISTIMIENTO</b></font>	
										</button> </td>
										<td class='datos' id='estatus-".$referencia."' align='center'>esperando...</td>
										";

									}else if($status == "Para generar Simplificado"){

										$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"enviaGenerarSimplificado('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($session))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
										<font color='black'><b>Genera Simplificado</b></font>	
										</button> </td>
										<td class='datos' id='estatus-".$referencia."' align='center'></td>
										";

									}else if($status == "Para liberar"){

										$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"enviaLiberar('".$referencia."', '".str_replace('"',"\'", json_encode($session))."')\" style='background-color:#92f442; width:60%; border:none; cursor:pointer;'>
										<font color='black'><b>LIBERAR</b></font>	
										</button> </td>
										<td class='datos' id='estatus-".$referencia."' align='center'></td>
										";

									}else if($status == "Liberado"){

										$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'></td>
										<td class='datos' id='estatus-".$referencia."' align='center'><img src='../Views/img/ICN_BotonVerde.png'></img></td>
										";

									}else if($status == "Error prevalidar"){

										$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick='' style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
										<font color='white'><b>PREVALIDAR</b></font>	
										</button></td>
										<td class='datos' id='estatus-".$referencia."' align='center'><img src='../Views/img/ICN_BotonRojo.png'></img></td>
										";

									}else if($status == "Error validar"){

										$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick='' style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
										<font color='white'><b>VALIDAR</b></font>	
										</button></td>
										<td class='datos' id='estatus-".$referencia."' align='center'><img src='../Views/img/ICN_BotonRojo.png'></img></td>
										";

									}else if($status == "Error cancelacion"){

										$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick='' style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
										<font color='white'><b>CANCELACION</b></font>	
										</button></td>
										<td class='datos' id='estatus-".$referencia."' align='center'><img src='../Views/img/ICN_BotonRojo.png'></img></td>
										";
					
									}else if($status == "Error pagar"){

										$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick='' style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
										<font color='white'><b>PAGAR</b></font>	
										</button></td>
										<td class='datos' id='estatus-".$referencia."' align='center'><img src='../Views/img/ICN_BotonRojo.png'></img></td>
										";

									}else if($status == "Pago realizado" || $status == "Desistimiento realizado"){

										$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($session))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
										<font color='white'><b>Documentos</b></font>	
										</button></td>
										<td class='datos' id='estatus-".$referencia."' align='center'><img src=''></img></td>
										";

									}else if($status == "Para cerrar consolidado"){

										$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
										<font color='white'><b>CERRAR C.</b></font>	
										</button> </td>
										<td class='datos' id='estatus-".$referencia."' align='center'></td>
										";

									}else if($status == "Consolidado cerrado"){

										$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
										<font color='white'><b>C. Cerrado</b></font>	
										</button> </td>
										<td class='datos' id='estatus-".$referencia."' align='center'></td>
										";

									}else if($status == "Validacion Contabilidad"){

										$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($session))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
										<font color='white'><b>Validacion Cont.</b></font>	
										</button> </td>
										<td class='datos' id='estatus-".$referencia."' align='center'></td>
										";

									}else if($status == "Carga evidencia SOIA"){

										$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
										<font color='white'><b>Evidencia SOIA</b></font>	
										</button> </td>
										<td class='datos' id='estatus-".$referencia."' align='center'></td>
										";

									}else if($status == "Completar datos pago"){

										$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
										<font color='white'><b>Datos pago</b></font>	
										</button> </td>
										<td class='datos' id='estatus-".$referencia."' align='center'></td>

										";

									}else if($status == "Completar datos pago sin A"){

										$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
										<font color='white'><b>Datos pago</b></font>	
										</button> </td>
										<td class='datos' id='estatus-".$referencia."' align='center'></td>

										";

									}else if($status == "Datos pago completado"){

										$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
										<font color='white'><b>Procesando Datos pago</b></font>	
										</button> </td>
										<td class='datos' id='estatus-".$referencia."' align='center'></td>

										";

									}

									$html .= "</tr>";

									$index++;
								//	}
								
							}
			        	$html .= "</table>";
					$html .= "</td>";

				$html .= "</tr>";
				$html .= "<tr height='15'></tr>";
				$html .= "<tr>";
					$html .= "<td colspan='2' id='titleBlueLineBottom'></td>";
				$html .= "</tr>";
				$html .= "<tr height='15'></tr>";
			$html .= "</table>";

    		
			
			$html .= "
			<div id='xml' class='modal'>
				<div class='modal-content'>
					<div class='header'>
						<table align='center' border='0'>
							<tr>
								<td style='font-size:24px; font color:#B08182'>
									
								</td>
							</tr>
						</table>  
					</div>
					<span class='close'>Cerrar</span>
					<p><br/></p>
					<p>
					<div id='XMLHolder' align='left'></div>
					
					</p>
					<p><br/><br/><br/><br/></p>
				</div>
			</div>";
			
    	$html .= "</div>";
		
		echo $html;

	}

	function actualizaTabla($titulo, $campos, $datos, $session){

		$html = "<table border='0' id='TblTablero' width='95%' style='margin-left:1em;' cellspacing='0'>";

		$html .= "<tr height='70' id='nombreCampos' align='center'>";
		$html .= "<td></td>";
		for($a = 0; $a<count($campos); $a++){
			$html .= "<td>".$campos[$a]."</td>";
		}
		$html .= "</tr>";

		$color = "Blanco";
		$index = 1;
		for($a = 0; $a<count($datos); $a++){

			$referencia = $datos[$a][0];
			$usuario = $datos[$a][1];
			$status = $datos[$a][2];
			$archivoM = $datos[$a][3];
			$archivoE = $datos[$a][4];
			$fecha = new DateTime($datos[$a][5]);

			$fechaActual = new DateTime(date("d-m-Y"));

			$interval = $fecha->diff($fechaActual);
			$interval =  $interval->format('%a');

			if($status != "Liberado" || ($status == "Liberado" && $interval == 0)){

				if($color == "Blanco"){
					$html .= "<tr id='registro-".$referencia."'>";
					$color = "Gris";
				}else if($color == "Gris"){
					$html .= "<tr id='registro-".$referencia."' style='background-color:rgb(249,249,249); height:35px'>";
					$color = "Blanco";
				}

				$html .= "<td class='datos' id='index-".$referencia."' name='".$index."' align='center'><font color='gray'>".($index).".-</font></td>";
				$html .= "<td class=\"datos\" align=\"center\"><a href=\"javascript:void(0)\" onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($session))."')\">".$referencia."</a></td>";
				$html .= "<td class='datos' align='center'>".$archivoM."</td>";
				$html .= "<td class='datos' align='center'>".$archivoE."</td>";
				$html .= "<td class='datos' align='center'>";
					if($status != "Liberado"){
						$html .= "<img onclick=\"eliminaReferencia('".$referencia."')\" src='../Views/img/ICN_BotonEliminarGris.png'>";
					}
				$html .= "</td>";
				$html .= "<td class='datos' align='center'>".$usuario."</td>";

				if($status == "Para generar M"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($session))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>GENERA M</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>
					";

				}else if($status == "Para generar M Desistimiento"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($session))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>GENERA DESISTIMIENTO</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>
					";

				}else if($status == "Para prevalidar"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"enviaPrevalidar('".$referencia."')\" style='background-color:rgb(0,249,0); width:60%; border:none; cursor:pointer;'>
					<font color='black'><b>PREVALIDAR</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>
					";

				}else if($status == "Para validar"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"enviaValidar('".$referencia."', '".str_replace('"',"\'", json_encode($session))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>VALIDAR</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>
					";

				}else if($status == "Para desistir"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"enviaDesistir('".$referencia."')\" style='background-color:rgb(0,249,0); width:60%; border:none; cursor:pointer;'>
					<font color='black'><b>DESISTIR</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>
					";

				}else if($status == "Para generar cancelacion"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($session))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>GENERA CANCELACION</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>
					";

				}else if($status == "Para generar E"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($session))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>GENERA E</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>
					";

				}else if($status == "Para pagar"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($session))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>PAGAR</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>
					";

				}else if($status == "Esperando prevalidador"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>PREVALIDAR</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'>esperando...</td>
					";

				}else if($status == "Esperando validador"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>VALIDAR</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'>esperando...</td>
					";

				}else if($status == "Esperando cancelacion"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>CANCELACIÓN</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'>esperando...</td>
					";

				}else if($status == "Esperando pago"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>PAGAR</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'>esperando...</td>
					";

				}else if($status == "Esperando desistimiento"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>DISISTIMIENTO</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'>esperando...</td>
					";

				}else if($status == "Para generar Simplificado"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"enviaGenerarSimplificado('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($session))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='black'><b>Genera Simplificado</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>
					";

				}else if($status == "Para liberar"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"enviaLiberar('".$referencia."', '".str_replace('"',"\'", json_encode($session))."')\" style='background-color:#92f442; width:60%; border:none; cursor:pointer;'>
					<font color='black'><b>LIBERAR</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>
					";

				}else if($status == "Liberado"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'></td>
					<td class='datos' align='center'><img src='../Views/img/ICN_BotonVerde.png'></img></td>
					";

				}else if($status == "Error prevalidar"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick='' style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>PREVALIDAR</b></font>	
					</button></td>
					<td class='datos' id='estatus-".$referencia."' align='center'><img src='../Views/img/ICN_BotonRojo.png'></img></td>
					";

				}else if($status == "Error validar"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick='' style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>VALIDAR</b></font>	
					</button></td>
					<td class='datos' id='estatus-".$referencia."' align='center'><img src='../Views/img/ICN_BotonRojo.png'></img></td>
					";

				}else if($status == "Error cancelacion"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick='' style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>CANCELACION</b></font>	
					</button></td>
					<td class='datos' id='estatus-".$referencia."' align='center'><img src='../Views/img/ICN_BotonRojo.png'></img></td>
					";

				}else if($status == "Error pagar"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick='' style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>PAGAR</b></font>	
					</button></td>
					<td class='datos' id='estatus-".$referencia."' align='center'><img src='../Views/img/ICN_BotonRojo.png'></img></td>
					";

				}else if($status == "Pago realizado" || $status == "Desistimiento realizado"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($session))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>Documentos</b></font>	
					</button></td>
					<td class='datos' id='estatus-".$referencia."' align='center'><img src=''></img></td>
					";

				}else if($status == "Para cerrar consolidado"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>CERRAR C.</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>
					";

				}else if($status == "Consolidado cerrado"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>C. Cerrado</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>
					";

				}else if($status == "Validacion Contabilidad"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($session))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>Validacion Cont.</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>
					";

				}else if($status == "Carga evidencia SOIA"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>Evidencia SOIA</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>
					";
				}else if($status == "Completar datos pago"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>Datos pago</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>

					";

				}else if($status == "Completar datos pago sin A"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>Datos pago</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>

					";

				}else if($status == "Datos pago completado"){

					$html .= "<td class='datos' id='accion-".$referencia."' name='".$status."'  align='center'><button onClick=\"generaDetalle('".str_replace('"',"\'", json_encode($datos[$a]))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" style='background-color:#0586E2; width:60%; border:none; cursor:pointer;'>
					<font color='white'><b>Procesando Datos pago</b></font>	
					</button> </td>
					<td class='datos' id='estatus-".$referencia."' align='center'></td>

					";

				}


				$html .= "</tr>";

				$index++;
			}

		}
		$html .= "<tr height='15'></tr>";
		$html .= "</table>";
		
		echo $html;
		
	}
}

?>
