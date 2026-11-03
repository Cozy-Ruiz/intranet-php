<?php

class DetalleVP{

	function iniciaDetalle(){
		$html = "
		<link rel='stylesheet' type='text/css' href='../Views/css/historial.css' media='screen' />
		<div id='historial' align='center'></div>";
		return $html;
	}

	function generaCambioPeca($referencia){
		$html ="
			<div align='center' style='display:grid; justify-items: center; align-items: center; height:90%;'>
				Este cliente cuenta con PECE, seleccione personal que autoriza cambio de PECA/BANCO.<br>
				<select id='selectCambioPeca'>
		";

		if($_SESSION["sesionLinks"]->oficina == "CDMX"){

			$html .="
				<option>Judith Laguna</option>
			";

		}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){

			$html .="
				<option>Tomas Villarreal</option>
				<option>Carlos Jimenez</option>
				<option>Alejandro Gutierrez</option>
				<option>Gabriel Escalante</option>
			";

		}else if($_SESSION["sesionLinks"]->oficina == "CUN"){

			$html .="
				<option>Mariana Quiroz</option>	
				<option>Anakaren Vargas</option>
				<option>Christian Martinez</option>
				<option>Gameva Martinez</option>
			";

		}else if($_SESSION["sesionLinks"]->oficina == "VER"){

			$html .="
				<option>Roxana_Aguilar</option>
				<option>Annel Reyes</option>
				<option>Erika Muñoz</option>
				<option>David Morales</option>
			";

		}else if($_SESSION["sesionLinks"]->oficina == "TOL"){

			$html .="
				<option>Miguel Angel Calderon</option>
				<option>Rodrigo Mejia</option>	
			";

		}


		$html .="
				</select>

				<table>
					<tr>
						<td><button onclick=\"cancelarCambioPeca('".$referencia."')\">Cancelar</button></td>
						<td><button onclick=\"registraCambioPeca('".$referencia."')\">Registrar</button></td>
					<tr>
				</table>
				
			</div>
		";

		echo $html;
	}

	function generaCargaReciboPago($referencia){
		$html ="
			<div align='center' style='display:grid; justify-items: center; align-items: center; height:90%;'>
				<div ondrop=\"cargaReciboPago(event,'fileRecibo', '".$referencia."');\" ondragover=\"dragover_handler(event);\">

					Referencia: ".$referencia." <br>
					Importa archivo recibo pago <br><br>

					<div align='center' id='dropZone'>

						<input type='file' id='fileRecibo' name='fileRecibo' multiple>

					</div>
				</div>
			</div>
		";

		echo $html;
	}

	function generaCargaArchivoA($referencia){
		$html ="
			<div align='center' style='display:grid; justify-items: center; align-items: center; height:90%;'>
				<div ondrop=\"cargaArchivoA(event,'fileA', '".$referencia."');\" ondragover=\"dragover_handler(event);\">

					Referencia: ".$referencia." <br>
					Importa archivo A <br><br>

					<div align='center' id='dropZone'>

						<input type='file' id='fileA' name='fileA' multiple>

					</div>
				</div>
			</div>
		";

		echo $html;
	}

	function generaCargaArchivoE($referencia){
		$html ="
			<div align='center' style='display:grid; justify-items: center; align-items: center; height:90%;'>
				<div ondrop=\"cargaArchivoE(event,'fileE', '".$referencia."');\" ondragover=\"dragover_handler(event);\">

					Referencia: ".$referencia." <br>
					Importa archivo E <br><br>

					<div align='center' id='dropZone'>

						<input type='file' id='fileE' name='fileE' multiple>
						
					</div>
				</div>
			</div>
		";

		echo $html;
	}

	function generaCargaArchivoERR($referencia){
		$html ="
			<div align='center' style='display:grid; justify-items: center; align-items: center; height:90%;'>
				<div ondrop=\"cargaArchivoERR(event,'fileERR', '".$referencia."');\" ondragover=\"dragover_handler(event);\">

					Referencia: ".$referencia." <br>
					Importa archivo ERR <br><br>

					<div align='center' id='dropZone'>

						<input type='file' id='fileERR' name='fileERR' multiple>
						
					</div>
				</div>
			</div>
		";

		echo $html;
	}



	function generaCargaArchivoM($referencia){
		$html ="

			<div align='center' style='display:grid; justify-items: center; align-items: center; height:90%;'>
				<div ondrop=\"cargaArchivoM(event,'fileM', '".$referencia."');\" ondragover=\"dragover_handler(event);\">

					Referencia: ".$referencia." <br>
					Importa archivo M <br><br>

					<div align='center' id='dropZone'>

						<input type='file' id='fileM' name='fileM' multiple>

					</div>
				</div>

			</div>
		";

		echo $html;
	}

	function generaDetalle($datosReferencia, $session){

		$referencia = 0;
		$usuario = 1;
		$estatus = 2;
		$datos = 6;

		$html = '
		<div class="contenido">
			<div align="center" id="historial2" style="border-color:black;">

				<table aling="center" width="95%" height="95%">

					<tr style="font-family:Arial; color:white; font-size:20;" height="10%">
						<td>Referencia:</td>
						<td id="referenciaDetalle">'.$datosReferencia[$referencia].'</td>
					</tr>

					<tr style="font-family:Arial; color:white; font-size:20;" height="10%">
						<td >Estatus:</td>
						<td id="estatusDetalle">'.$datosReferencia[$estatus].'</td>
					</tr>';

					if($datosReferencia[$estatus] == "Para generar M"){

						$html .= '
						<tr style="font-family:Arial; color:white; font-size:20;">
							<td align="center" colspan="2">Selecciona firma:</td>
						</tr>

						<tr height="10px"></tr>

						<tr id="datHist">
							<td colspan="2" align="center">
								<font size="2">
									<select id="curp">';
										foreach($datosReferencia[$datos]["firmas"] as $firma){
											$html .= '
										 		<option value="'.$firma["XT_CURP"].'">'.$firma["XT_NOMBRE"].'</option>
										 	';
										}
						$html .= '
									</select>
								</font>
							</td>
						</tr>

						<tr height="5px"></tr>

						<tr style="font-family:Arial; color:white; font-size:20;">
							<td align="center" colspan="2">Selecciona prevalidador:</td>
						</tr>

						<tr height="5px"></tr>

						<tr id="datHist">
							<td colspan="2" align="center">
								<font size="2">
									<select id="prevalidador">';
										foreach($datosReferencia[$datos]["prevalidadores"] as $prevalidador){
											$html .= '
										 		<option value="'.$prevalidador["XT_VALIDADOR"].'">'.$prevalidador["XT_VALIDADOR"].'-'.$prevalidador["XT_NOMBRE"].'</option>
										 	';
										}
						$html .= '
									</select>
								</font>
							</td>
						</tr>

						<tr height="5px"></tr>

						<tr>
							<td colspan="2" id="lineaBlanca"></td>
						</tr>

						<tr height="15px"></tr>
						';

						if (strpos($datosReferencia[$referencia], '_R') !== false) {

							$html .= '
								<tr align="center">
									<td colspan="2" width="150px" height="33px">';
										$html .="
										<button onClick=\"enviaGenerarM_RECTI('".$datosReferencia[$referencia]."')\" style='background-color:rgb(0,249,0); border:none; cursor:pointer;''>
											<b>Genera M RECTI</b>
										</button>";

							$html .= '
									</td>
								</tr>

							';

						}else{

							$html .= '
								<tr align="center">
									<td colspan="2" width="150px" height="33px">';
										$html .="
										<button onClick=\"enviaGenerarM('".$datosReferencia[$referencia]."')\" style='background-color:rgb(0,249,0); border:none; cursor:pointer;''>
											<b>Genera M</b>
										</button>";

							$html .= '
									</td>
								</tr>

								<tr height="15px"></tr>

							';

						}


						$html .= '
						<tr align="center">
							<td colspan="2" width="150px" height="33px">';
								$html .="
								<button onClick=\"muestraCargaArchivoM('".$datosReferencia[$referencia]."')\" style='background-color:#0586E2; border:none; cursor:pointer;''>
									<b>Carga archivo M</b>
								</button>";

						$html .= '
							</td>
						</tr>

						';

						

					}
					
					if($datosReferencia[$estatus] == "Para generar M Desistimiento"){

						$html .= '
						<tr style="font-family:Arial; color:white; font-size:20;">
							<td align="center" colspan="2">Selecciona firma:</td>
						</tr>

						<tr height="10px"></tr>

						<tr id="datHist">
							<td colspan="2" align="center">
								<font size="2">
									<select id="curp">';
										foreach($datosReferencia[$datos]["firmas"] as $firma){
											$html .= '
										 		<option value="'.$firma["XT_CURP"].'">'.$firma["XT_NOMBRE"].'</option>
										 	';
										}
						$html .= '
									</select>
								</font>
							</td>
						</tr>

						<tr height="5px"></tr>

						<tr style="font-family:Arial; color:white; font-size:20;">
							<td align="center" colspan="2">Selecciona prevalidador:</td>
						</tr>

						<tr height="5px"></tr>

						<tr id="datHist">
							<td colspan="2" align="center">
								<font size="2">
									<select id="prevalidador">';
										foreach($datosReferencia[$datos]["prevalidadores"] as $prevalidador){
											$html .= '
										 		<option value="'.$prevalidador["XT_VALIDADOR"].'">'.$prevalidador["XT_VALIDADOR"].'-'.$prevalidador["XT_NOMBRE"].'</option>
										 	';
										}
						$html .= '
									</select>
								</font>
							</td>
						</tr>

						<tr height="5px"></tr>

						<tr>
							<td colspan="2" id="lineaBlanca"></td>
						</tr>

						<tr height="15px"></tr>
						';

						if (strpos($datosReferencia[$referencia], '_R') !== false) {

							$html .= '
								<tr align="center">
									<td colspan="2" width="150px" height="33px">';
										$html .="
										<button onClick=\"enviaGenerarM_RECTI('".$datosReferencia[$referencia]."')\" style='background-color:rgb(0,249,0); border:none; cursor:pointer;''>
											<b>Genera M RECTI</b>
										</button>";

							$html .= '
									</td>
								</tr>

							';

						}else{

							$html .= '
								<tr align="center">
									<td colspan="2" width="150px" height="33px">';
										$html .="
										<button onClick=\"enviaGenerarM_Desistimiento('".$datosReferencia[$referencia]."')\" style='background-color:rgb(0,249,0); border:none; cursor:pointer;''>
											<b>Genera M Desistimiento</b>
										</button>";

							$html .= '
									</td>
								</tr>

								<tr height="15px"></tr>

							';

						}
					}

					if($datosReferencia[$estatus] == "Para prevalidar"){

						$html .= '
						<tr style="font-family:Arial; color:white; font-size:20;" height="10%">
							<td colspan="2">Detalle:</td>
						</tr>

						<tr height="10px"></tr>

						<tr id="datHist">
							<td colspan="2"><font size="2">'.$datosReferencia[$datos].'</font></td>
						</tr>

						<tr height="5px"></tr>

						<tr>
							<td colspan="2" id="lineaBlanca"></td>
						</tr>

						<tr height="15px"></tr>';

						$html .= '
						<tr align="center">
							<td colspan="2" width="150px" height="33px">';
								$html .="
								<img onClick=\"muestraArchivos('".str_replace('"',"\'", json_encode($datosReferencia))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" src=\"../Views/img/ICN_PreviewGris.png\">
								</img>";

						$html .= '
							</td>
						</tr>

						<tr height="15px"></tr>

						<tr>
							<td colspan="2" id="lineaBlanca"></td>
						</tr>

						<tr height="15px"></tr>';

						$html .= '
						<tr align="center">
							<td colspan="2">';
								$html .="
								<button onClick=\"paraGenerarM('".$datosReferencia[$referencia]."')\" style='background-color:#0586E2; border:none; cursor:pointer;''>
									<font color='white'><b>Para regenerar M</b></font>
								</button>
								";

						$html .= '
							</td>
						</tr>';

					}

					if($datosReferencia[$estatus] == "Para desistir"){

						$html .= '
						<tr style="font-family:Arial; color:white; font-size:20;" height="10%">
							<td colspan="2">Detalle:</td>
						</tr>

						<tr height="10px"></tr>

						<tr id="datHist">
							<td colspan="2"><font size="2">'.$datosReferencia[$datos].'</font></td>
						</tr>

						<tr height="5px"></tr>

						<tr>
							<td colspan="2" id="lineaBlanca"></td>
						</tr>

						<tr height="15px"></tr>';

						$html .= '
						<tr align="center">
							<td colspan="2" width="150px" height="33px">';
								$html .="
								<img onClick=\"muestraArchivos('".str_replace('"',"\'", json_encode($datosReferencia))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" src=\"../Views/img/ICN_PreviewGris.png\">
								</img>";

						$html .= '
							</td>
						</tr>

						<tr height="15px"></tr>

						<tr>
							<td colspan="2" id="lineaBlanca"></td>
						</tr>

						<tr height="15px"></tr>';

						$html .= '
						<tr align="center">
							<td colspan="2">';
								$html .="
								<button onClick=\"paraGenerarM('".$datosReferencia[$referencia]."')\" style='background-color:#0586E2; border:none; cursor:pointer;''>
									<font color='white'><b>Para regenerar M</b></font>
								</button>
								";

						$html .= '
							</td>
						</tr>';

					}


					if($datosReferencia[$estatus] == "Esperando prevalidador"){

						$html .= '
						<tr height="15px"></tr>

						<tr align="center">
							<td colspan="2">';
								$html .="
								<iframe id='archivoValidador' width='100%' height='100%' frameborder='0' src=''></iframe>
								";

						$html .= '
							</td>
						</tr>

						<tr height="15px"></tr>

						<tr align="center">
							<td colspan="2">';
								$html .="
								<button onClick=\"paraGenerarM('".$datosReferencia[$referencia]."')\" style='background-color:#0586E2; border:none; cursor:pointer;''>
									<font color='black'><b>Para regenerar M</b></font>
								</button>
								";

						$html .= '
							</td>
						</tr>';

						$html .= '

						<tr height="15px"></tr>

						<tr align="center">
							<td colspan="2">';
								$html .="
								<button onClick=\"enviaValidar('".$datosReferencia[$referencia]."')\" style='background-color:#0586E2; border:none; cursor:pointer;''>
									<font color='black'><b>Saltar prevalidador</b></font>
								</button>
								";

						$html .= '
							</td>
						</tr>';

					}

					if($datosReferencia[$estatus] == "Esperando validador"){

						$html .= '
						<tr height="15px"></tr>

						<tr align="center">
							<td colspan="2">';
								$html .="
								<iframe id='archivoValidador' width='100%' height='100%' frameborder='0' src=''></iframe>
								";

						$html .= '
							</td>
						</tr>

						<tr height="15px"></tr>

						<tr align="center">
							<td colspan="2">';
								$html .="
								<button onClick=\"paraGenerarM('".$datosReferencia[$referencia]."')\" style='background-color:#0586E2; border:none; cursor:pointer;''>
									<font color='black'><b>Para regenerar M</b></font>
								</button>
								";

						$html .= '
							</td>
						</tr>

						<tr height="15px"></tr>
						';

						$html .= '
						<tr align="center">
							<td colspan="2" width="150px" height="33px">';
								$html .="
								<button onClick=\"muestraCargaArchivoERR('".$datosReferencia[$referencia]."')\" style='background-color:#0586E2; border:none; cursor:pointer;''>
									<b>Carga archivo ERR</b>
								</button>";

						$html .= '
							</td>
						</tr>';

					}

					
					if($datosReferencia[$estatus] == "Para generar cancelacion"){

						$html .= '

						<tr style="font-family:Arial; color:white; font-size:20;">
							<td align="center" colspan="2">Selecciona validador:</td>
						</tr>

						<tr height="5px"></tr>

						<tr id="datHist">
							<td colspan="2" align="center">
								<font size="2">
									<select id="prevalidador">';
									if ($datosReferencia[$datos]["prevalidadores"] != null){
										foreach($datosReferencia[$datos]["prevalidadores"] as $prevalidador){
											$html .= '
										 		<option value="'.$prevalidador["XT_VALIDADOR"].'">'.$prevalidador["XT_VALIDADOR"].'-'.$prevalidador["XT_NOMBRE"].'</option>
										 	';
										}
									}
						$html .= '
									</select>
								</font>
							</td>
						</tr>

						<tr height="5px"></tr>

						<tr>
							<td colspan="2" id="lineaBlanca"></td>
						</tr>

						<tr height="15px"></tr>
						';

						$html .= '
							<tr align="center">
								<td colspan="2" width="150px" height="33px">';
									
									$html .="
									<button onClick=\"enviaCancelar('".$datosReferencia[$referencia]."')\" style='background-color:rgb(0,249,0); border:none; cursor:pointer;''>
										<b>Elimina firma SAT</b>
									</button>
									";
						$html .= '
								</td>
							</tr>
						';


						$html .= '
							<tr height="15px"></tr>				

							<tr align="center">
								<td colspan="2" width="150px" height="33px">';
									
									$html .="
									<button onClick=\"paraGenerarE('".$datosReferencia[$referencia]."')\" style='background-color:#0586E2; border:none; cursor:pointer;''>
										<b>generar E</b>
									</button>
									";
						$html .= '
								</td>
							</tr>
						';


					}
					

					
					if($datosReferencia[$estatus] == "Esperando pago"){

						$html .= '
						<tr height="15px"></tr>

						<tr align="center">
							<td colspan="2">
								<iframe id="archivoValidador" width="100%" height="100%" frameborder="0" src=""></iframe>
							</td>
						</tr>

						<tr height="15px"></tr>

						<tr align="center">
							<td colspan="2">';
							$html .="
							<button onClick=\"reintentoPagar('".$datosReferencia[$referencia]."')\" style='background-color:#0586E2; border:none; cursor:pointer;''>
								<b>reenviar E</b>
							</button>";

						$html .= '
							</td>
						</tr>

						<tr height="15px"></tr>

						<tr align="center">
							<td colspan="2">';
							$html .="
							<button onClick=\"reGenerarE('".$datosReferencia[$referencia]."')\" style='background-color:#0586E2; border:none; cursor:pointer;''>
								<b>regenerar E</b>
							</button>";

						$html .= '
							</td>
						</tr>

						<tr height="15px"></tr>
						
						<tr align="center">
							<td colspan="2" width="150px" height="33px">';

								$html .="
								<button onClick=\"muestraCargaArchivoA('".$datosReferencia[$referencia]."')\" style='background-color:#0586E2; border:none; cursor:pointer;''>
									<b>Carga archivo A</b>
								</button>";
						

						$html .= '
							</td>
						</tr>
						
						<tr height="15px"></tr>
						
						<tr align="center">
							<td colspan="2" width="150px" height="33px">';
							
								$html .="
								<button onClick=\"saltaCompletarDatosPagoSinA('".$datosReferencia[$referencia]."')\" style='background-color:#0586E2; border:none; cursor:pointer;''>
									<b>Sin archivo A</b>
								</button>";

						$html .= '
							</td>
						</tr>
						
						<tr height="15px"></tr>';

						$html .= '
						<tr align="center">
							<td colspan="2">';

								$html .="
								<button style='background-color:rgb(0,249,0)' onClick=\"saltaCargaEvidenciaSOIA('".$datosReferencia[$referencia]."')\" style='background-color:#0586E2; border:none; cursor:pointer;''>
									<b>Carga Evidencia SOIA</b>
								</button>";

						$html .= '
							</td>
						</tr>
						
						';

						

					}


					if($datosReferencia[$estatus] == "Para generar E"){

						$html .= '

						<tr height="15px"></tr>

						<tr align="center">
							<td colspan="2" width="150px" height="33px">';
								$html .="
								<img onClick=\"muestraArchivos('".str_replace('"',"\'", json_encode($datosReferencia))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" src=\"../Views/img/ICN_PreviewGris.png\">
								</img>";
						$html .= '
							</td>
						</tr>

						<tr height="10px"></tr>

						<tr style="font-family:Arial; color:white; font-size:20;">
							<td align="center" colspan="2">Selecciona banco:</td>
						</tr>

						<tr height="10px"></tr>

						<tr id="datHist">
							<td colspan="2" align="center">
								<font size="2">
									<select onchange="confirmaCambioPeca(\''.$datosReferencia[$referencia].'\')" id="banco">';

										if($datosReferencia[$datos]["peca"] != null){
											foreach($datosReferencia[$datos]["peca"] as $peca){
												$html .= '
											 		<option value="'.$peca["CLAVE_BANCO"]."-".$peca["CLAVE_CUENTA"].'-PECA">PECA-'.$peca["CLAVE_BANCO"]."-".$peca["CLAVE_CUENTA"].'</option>
											 	';
										 	}
										}

										foreach($datosReferencia[$datos]["bancos"] as $banco){
											$html .= '
										 		<option value="'.$banco["XT_CLAVE_BANCO"]."-".$banco["XT_CLAVE_CUENTA"]."-".$banco["XT_NOMBRE"].'">'.$banco["XT_NOMBRE"]."-".$banco["XT_CLAVE_BANCO"]."-".$banco["XT_CLAVE_CUENTA"].'</option>
										 	';
										}

						$html .= '
									</select>
								</font>
							</td>
						</tr>

						<tr height="5px"></tr>

						<tr>
							<td colspan="2" id="lineaBlanca"></td>
						</tr>

						<tr height="15px"></tr>
						';

						if (strpos($datosReferencia[$referencia], '_R') !== false) {

							$html .= '
								<tr align="center">
									<td colspan="2" width="150px" height="33px">';
										$html .="
										<button onClick=\"enviaGenerarE_RECTI('".$datosReferencia[$referencia]."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" style='background-color:rgb(0,249,0); border:none; cursor:pointer;''>
											<b>Generar E RECTI</b>
										</button>";

							$html .= '
									</td>
								</tr>

								<tr height="15px"></tr>
							';

							$html .= '
								<tr align="center">
									<td colspan="2" width="150px" height="33px">';
										$html .="
										<button onClick=\"saltoGeneracionDocumentos('".$datosReferencia[$referencia]."')\" style='background-color:#0586E2; border:none; cursor:pointer;''>
											<b>Salto generacion de documentos</b>
										</button>";

							$html .= '
									</td>
								</tr>

								<tr height="15px"></tr>
							';

						}else{

							$html .= '
								<tr align="center">
									<td colspan="2" width="150px" height="33px">';
										$html .="
										<button onClick=\"enviaGenerarE('".$datosReferencia[$referencia]."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" style='background-color:rgb(0,249,0); border:none; cursor:pointer;''>
											<b>Generar E</b>
										</button>";

							$html .= '
									</td>
								</tr>

								<tr height="15px"></tr>
							';

						}


						

						$html .= '

							<tr align="center">
								<td colspan="2">';
									$html .="
									<button onClick=\"paraGenerarM('".$datosReferencia[$referencia]."')\" style='background-color:#0586E2; border:none; cursor:pointer;''>
										<font color='black'><b>Para regenerar M</b></font>
									</button>
									";
						$html .= '
								</td>
							</tr>
						';

						$html .= '
							<tr align="center">
								<td colspan="2" width="150px" height="33px">';
									$html .="
									<button onClick=\"muestraCargaArchivoE('".$datosReferencia[$referencia]."')\" style='background-color:#0586E2; border:none; cursor:pointer;''>
										<b>Carga archivo E</b>
									</button>
									";
						$html .= '
								</td>
							</tr>
						';

						$html .= '
							<tr align="center">
								<td colspan="2" width="150px" height="33px">';
									$html .="
									<button onClick=\"muestraCargaReciboPago('".$datosReferencia[$referencia]."')\" style='background-color:#0586E2; border:none; cursor:pointer;''>
										<b>Carga recibo de pago</b>
									</button>
									";
						$html .= '
								</td>
							</tr>
						';

						$html .= '
							<tr align="center">
								<td colspan="2" width="150px" height="33px">';
									
									$html .="
									<button onClick=\"paraGenerarCancelacion('".$datosReferencia[$referencia]."')\" style='background-color:red; border:none; cursor:pointer;''>
										<b>Para generar cancelacion</b>
									</button>
									";
						$html .= '
								</td>
							</tr>
						';

					}

					if($datosReferencia[$estatus] == "Validacion Contabilidad"){

						$html .= '
						<tr style="font-family:Arial; color:white; font-size:20;" height="10%">
							<td colspan="2">Detalle:</td>
						</tr>

						<tr height="10px"></tr>

						<tr id="datHist" height="25%">
							<td colspan="2"><font size="2">'.$datosReferencia[$datos]["detalle"].'</font></td>
						</tr>

						<tr height="5px"></tr>

						<tr>
							<td colspan="2" id="lineaBlanca"></td>
						</tr>

						<tr height="15px"></tr>';

						$html .= '
						<tr align="center">
							<td colspan="2">';

								$html .="
								<button style='background-color:rgb(0,249,0)' onClick=\"reGenerarE('".$datosReferencia[$referencia]."')\" style='background-color:rgb(0,249,0); border:none; cursor:pointer;'>
									<b>regenerar E</b>
								</button>";

						$html .= '
							</td>
						</tr>';

					}


					if($datosReferencia[$estatus] == "Para pagar"){

						$html .= '

						<tr height="15px"></tr>

						<tr align="center">
							<td colspan="2" width="150px" height="33px">';
								$html .="
								<img onClick=\"muestraArchivos('".str_replace('"',"\'", json_encode($datosReferencia))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" src=\"../Views/img/ICN_PreviewGris.png\">
								</img>";
						$html .= '
							</td>
						</tr>

						<tr height="10px"></tr>

						<tr style="font-family:Arial; color:white; font-size:20;">
							<td align="center" colspan="2">Selecciona validador:</td>
						</tr>

						<tr height="5px"></tr>

						<tr id="datHist">
							<td colspan="2" align="center">
								<font size="2">
									<select id="validador">';
										foreach($datosReferencia[$datos]["validadores"] as $validador){
											$html .= '
										 		<option value="'.$validador["XT_VALIDADOR"].'">'.$validador["XT_VALIDADOR"].'-'.$validador["XT_NOMBRE"].'</option>
										 	';
										}
						$html .= '
									</select>
								</font>
							</td>
						</tr>

						<tr height="5px"></tr>

						<tr>
							<td colspan="2" id="lineaBlanca"></td>
						</tr>

						<tr height="15px"></tr>
						';

						$html .= '
						<tr align="center">
							<td colspan="2" width="150px" height="33px">';
								$html .="
								<button onClick=\"enviaPagar('".$datosReferencia[$referencia]."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" style='background-color:rgb(0,249,0); border:none; cursor:pointer;''>
									<b>Pagar</b>
								</button>";

						$html .= '
							</td>
						</tr>

						<tr height="15px"></tr>';

						$html .= '
						<tr align="center">
							<td colspan="2">';
							$html .="
							<button style='background-color:#0586E2' onClick=\"reGenerarE('".$datosReferencia[$referencia]."')\" style='background-color:#0586E2; border:none; cursor:pointer;''>
								<b>regenerar E</b>
							</button>";

						$html .= '
							</td>
						</tr>';

					}

					if($datosReferencia[$estatus] == "Para liberar"){

						$html .= '

						<tr height="15px"></tr>

						<tr align="center">
							<td colspan="2" width="150px" height="33px">';
								$html .="
								<img onClick=\"muestraArchivos('".str_replace('"',"\'", json_encode($datosReferencia))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" src=\"../Views/img/ICN_PreviewGris.png\">
								</img>";
						$html .= '
							</td>
						</tr>

						<tr height="10px"></tr>

						<tr>
							<td colspan="2" id="lineaBlanca"></td>
						</tr>

						<tr height="15px"></tr>
						';

						$html .= '
						<tr align="center">
							<td colspan="2" width="150px" height="33px">';
								$html .="
								<button onClick=\"enviaGenerarSimplificado('".$datosReferencia[$referencia]."')\" style='background-color:rgb(0,249,0); border:none; cursor:pointer;''>
									<b>Genera Simplificado</b>
								</button>";

						$html .= '
							</td>
						</tr>';

						//Aqui boton para reprocesar pago
						$html .= '
						<tr align="center">
							<td colspan="2" width="150px" height="33px">';
								$html .="
								<button onClick=\"paraReprocesarPago('".$datosReferencia[$referencia]."')\" style='background-color:#0586E2; border:none; cursor:pointer;''>
									<b>Reprocesar pago</b>
								</button>";

						$html .= '
							</td>
						</tr>';
					}

					if($datosReferencia[$estatus] == "Error prevalidar"){

						$html .= '
						<tr style="font-family:Arial; color:white; font-size:20;" height="10%">
							<td colspan="2">Detalle:</td>
						</tr>

						<tr height="10px"></tr>

						<tr id="datHist" height="25%">
							<td colspan="2"><font size="2">'.$datosReferencia[$datos].'</font></td>
						</tr>

						<tr height="5px"></tr>

						<tr>
							<td colspan="2" id="lineaBlanca"></td>
						</tr>

						<tr height="15px"></tr>';

						$html .= '
						<tr align="center">
							<td colspan="2" width="150px" height="33px">';
								$html .="
								<img onClick=\"muestraArchivos('".str_replace('"',"\'", json_encode($datosReferencia))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" src=\"../Views/img/ICN_PreviewGris.png\">
								</img>";
						$html .= '
							</td>
						</tr>

						<tr height="15px"></tr>

						<tr>
							<td colspan="2" id="lineaBlanca"></td>
						</tr>

						<tr height="15px"></tr>';

						$html .= '
						<tr align="center">
							<td colspan="2">';
								$html .="
								<button onClick=\"paraGenerarM('".$datosReferencia[$referencia]."')\" style='background-color:rgb(0,249,0); border:none; cursor:pointer;''>
									<font color='black'><b>Para regenerar M</b></font>
								</button>
								";

						$html .= '
							</td>
						</tr>';

						$html .= '

						<tr height="15px"></tr>

						<tr align="center">
							<td colspan="2">';
								$html .="
								<button onClick=\"enviaValidar('".$datosReferencia[$referencia]."')\" style='background-color:#0586E2; border:none; cursor:pointer;''>
									<font color='black'><b>Saltar prevalidador</b></font>
								</button>
								";

						$html .= '
							</td>
						</tr>';

					}

					if($datosReferencia[$estatus] == "Error validar"){

						$html .= '
						<tr style="font-family:Arial; color:white; font-size:20;" height="10%">
							<td colspan="2">Detalle:</td>
						</tr>

						<tr height="10px"></tr>

						<tr id="datHist" height="25%">
							<td colspan="2"><font size="2">'.$datosReferencia[$datos].'</font></td>
						</tr>

						<tr height="5px"></tr>

						<tr>
							<td colspan="2" id="lineaBlanca"></td>
						</tr>

						<tr height="15px"></tr>';

						$html .= '
						<tr align="center">
							<td colspan="2" width="150px" height="33px">';
								$html .="
								<img onClick=\"muestraArchivos('".str_replace('"',"\'", json_encode($datosReferencia))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" src=\"../Views/img/ICN_PreviewGris.png\">
								</img>";
						$html .= '
							</td>
						</tr>

						<tr height="15px"></tr>

						<tr>
							<td colspan="2" id="lineaBlanca"></td>
						</tr>

						<tr height="15px"></tr>';

						$html .= '
						<tr align="center">
							<td colspan="2">';
								$html .="
								<button onClick=\"paraGenerarM('".$datosReferencia[$referencia]."')\" style='background-color:rgb(0,249,0); border:none; cursor:pointer;''>
									<font color='black'><b>Para regenerar M</b></font>
								</button>
								";

						$html .= '
							</td>
						</tr>';

					}

					if($datosReferencia[$estatus] == "Error cancelacion"){

						$html .= '
						<tr style="font-family:Arial; color:white; font-size:20;" height="10%">
							<td colspan="2">Detalle:</td>
						</tr>

						<tr height="10px"></tr>

						<tr id="datHist" height="25%">
							<td colspan="2"><font size="2">'.$datosReferencia[$datos]["detalle"].'</font></td>
						</tr>

						<tr height="5px"></tr>

						<tr>
							<td colspan="2" id="lineaBlanca"></td>
						</tr>

						<tr height="15px"></tr>';

						


						$html .= '
						<tr align="center">
							<td colspan="2">';

								$html .="
								<button style='background-color:rgb(0,249,0)' onClick=\"reGenerarE('".$datosReferencia[$referencia]."')\" style='background-color:rgb(0,249,0); border:none; cursor:pointer;''>
									<b>para generar E</b>
								</button>";

						$html .= '
							</td>
						</tr>

						';


					}

					if($datosReferencia[$estatus] == "Error pagar"){

						$html .= '
						<tr style="font-family:Arial; color:white; font-size:20;" height="10%">
							<td colspan="2">Detalle:</td>
						</tr>

						<tr height="10px"></tr>

						<tr id="datHist" height="25%">
							<td colspan="2"><font size="2">'.$datosReferencia[$datos]["detalle"].'</font></td>
						</tr>

						<tr height="5px"></tr>

						<tr>
							<td colspan="2" id="lineaBlanca"></td>
						</tr>

						<tr height="15px"></tr>';

						$html .= '
						<tr align="center">
							<td colspan="2" width="150px" height="33px">';
								$html .="
								<img onClick=\"muestraArchivos('".str_replace('"',"\'", json_encode($datosReferencia))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" src=\"../Views/img/ICN_PreviewGris.png\">
								</img>";
						$html .= '
							</td>
						</tr>

						<tr>
							<td colspan="2" id="lineaBlanca"></td>
						</tr>

						<tr height="15px"></tr>';


						$html .= '
						<tr align="center">
							<td colspan="2">';

								$html .="
								<button style='background-color:rgb(0,249,0)' onClick=\"reGenerarE('".$datosReferencia[$referencia]."')\" style='background-color:rgb(0,249,0); border:none; cursor:pointer;''>
									<b>regenerar E</b>
								</button>";

						$html .= '
							</td>
						</tr>

						<tr height="15px"></tr>';

						$html .= '
						<tr align="center">
							<td colspan="2">';

								$html .="
								<button style='background-color:rgb(0,249,0)' onClick=\"saltaCargaEvidenciaSOIA('".$datosReferencia[$referencia]."')\" style='background-color:#0586E2; border:none; cursor:pointer;''>
									<b>Carga Evidencia SOIA</b>
								</button>";

						$html .= '
							</td>
						</tr>

						<tr height="15px"></tr>

						<tr align="center">
							<td colspan="2">';
								$html .="
								<button onClick=\"paraGenerarM('".$datosReferencia[$referencia]."')\" style='background-color:#0586E2; border:none; cursor:pointer;''>
									<font color='black'><b>Para regenerar M</b></font>
								</button>
								";

						$html .= '
							</td>
						</tr>';


					}

					if($datosReferencia[$estatus] == "Pago realizado"){

						$html .= '
						<tr style="font-family:Arial; color:white; font-size:20;" height="10%">
							<td colspan="2">Detalle:</td>
						</tr>

						<tr height="10px"></tr>';

						$html .= '
						<tr align="center">
							<td colspan="2" width="150px" height="33px">';
								$html .="
								<img onClick=\"muestraArchivos('".str_replace('"',"\'", json_encode($datosReferencia))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" src=\"../Views/img/ICN_PreviewGris.png\">
								</img>";
						$html .= '
							</td>
						</tr>

						<tr height="15px"></tr>

						<tr>
							<td colspan="2" id="lineaBlanca"></td>
						</tr>

						<tr height="15px"></tr>
						';

						if (strpos($datosReferencia[$referencia], '_R') !== false) {
							$html .= '
							<tr align="center">
								<td colspan="2" width="150px" height="33px">';
									$html .="
									<button onClick=\"enviaGenerarSimplificado('".$datosReferencia[$referencia]."')\" style='background-color:rgb(0,249,0); border:none; cursor:pointer;''>
										<b>Genera Simplificado RECTI</b>
									</button>";

							$html .= '
								</td>
							</tr>';
						}else{
							$html .= '
							<tr align="center">
								<td colspan="2" width="150px" height="33px">';
									$html .="
									<button onClick=\"enviaGenerarSimplificado('".$datosReferencia[$referencia]."')\" style='background-color:rgb(0,249,0); border:none; cursor:pointer;''>
										<b>Genera Simplificado</b>
									</button>";

							$html .= '
								</td>
							</tr>';
						}

						

					}

					if($datosReferencia[$estatus] == "Desistimiento realizado"){

						$html .= '
						<tr style="font-family:Arial; color:white; font-size:20;" height="10%">
							<td colspan="2">Detalle:</td>
						</tr>

						<tr height="10px"></tr>';

						$html .= '
						<tr align="center">
							<td colspan="2" width="150px" height="33px">';
								$html .="
								<img onClick=\"muestraArchivos('".str_replace('"',"\'", json_encode($datosReferencia))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" src=\"../Views/img/ICN_PreviewGris.png\">
								</img>";
						$html .= '
							</td>
						</tr>

						<tr height="15px"></tr>

						<tr>
							<td colspan="2" id="lineaBlanca"></td>
						</tr>

						<tr height="15px"></tr>
						';

						if (strpos($datosReferencia[$referencia], '_R') !== false) {
							$html .= '
							<tr align="center">
								<td colspan="2" width="150px" height="33px">';
									$html .="
									<button onClick=\"enviaGenerarSimplificadoDesistimiento('".$datosReferencia[$referencia]."')\" style='background-color:rgb(0,249,0); border:none; cursor:pointer;''>
										<b>Genera Simplificado RECTI</b>
									</button>";

							$html .= '
								</td>
							</tr>';
						}else{
							$html .= '
							<tr align="center">
								<td colspan="2" width="150px" height="33px">';
									$html .="
									<button onClick=\"enviaGenerarSimplificadoDesistimiento('".$datosReferencia[$referencia]."')\" style='background-color:rgb(0,249,0); border:none; cursor:pointer;''>
										<b>Genera Simplificado</b>
									</button>";

							$html .= '
								</td>
							</tr>';
						}

						

					}

					if($datosReferencia[$estatus] == "Liberado"){

						$html .= '
						<tr height="10px"></tr>';

						$html .= '
						<tr align="center">
							<td colspan="2" width="150px" height="33px">';
								$html .="
								<img onClick=\"muestraArchivos('".str_replace('"',"\'", json_encode($datosReferencia))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" src=\"../Views/img/ICN_PreviewGris.png\">
								</img>";
						$html .= '
							</td>
						</tr>';

					}

					if($datosReferencia[$estatus] == "Para cerrar consolidado"){
						

						$html .= '
						
						</tr>

						<tr height="10px"></tr>

						<tr>
							<td colspan="2" id="lineaBlanca"></td>
						</tr>';

						$html .= '
						<tr align="center">
							<td colspan="2" width="150px" height="33px">';
								$html .="
								<img onClick=\"muestraArchivos('".str_replace('"',"\'", json_encode($datosReferencia))."', '".str_replace('"',"\'", json_encode($_SESSION["sesionLinks"]))."')\" src=\"../Views/img/ICN_PreviewGris.png\">
								</img>";
						$html .= '
							</td>
						</tr>

						<tr height="15px"></tr>

						<tr align="center">
							<td colspan="2">';
								$html .="
								<button onClick=\"cerrarConsolidado('".$datosReferencia[$referencia]."')\" style='background-color:rgb(0,249,0); border:none; cursor:pointer;''>
									<font color='black'><b>Cerrar consolidado</b></font>
								</button>	
								";

						$html .= '
							</td>
						</tr>';

					}


					if($datosReferencia[$estatus] == "Consolidado cerrado"){
						

						$html .= '
						

						<tr height="5px"></tr>

						<tr>
							<td colspan="2" id="lineaBlanca"></td>
						</tr>

						<tr height="15px"></tr>';

						if($datosReferencia[$datos]["estatusConsolidado"] == 2){
							
							$html .= '
							<tr align="center">
								<td colspan="2">';
									$html .="
									<button onClick=\"paraGenerarM('".$datosReferencia[$referencia]."')\" style='background-color:rgb(0,249,0); border:none; cursor:pointer;''>
										<font color='black'><b>Para regenerar M</b></font>
									</button>
									";

							$html .= '
								</td>
							</tr>';

						}

					}

					if($datosReferencia[$estatus] == "Carga evidencia SOIA"){
						
						
						$html .= "
							<tr height='5px'></tr>

							<tr>
								<td colspan='2' id='lineaBlanca'></td>
							</tr>

							<tr height='15px'></tr>


							
							<tr align='center'>
								<td colspan='2'>
									<div align='center' style='display:grid; justify-items: center; align-items: center; height:90%;'>
										<div style='color:white;'>
											favor de subir evidencia en formato pdf o imagen.
										</div>

										<div ondrop=\"cargaArchivoEvidenciaSOIA(event,'fileSOIA', '".$datosReferencia[$referencia]."');\" ondragover=\"dragover_handler(event);\">
											<div align='center' id='dropZone'>
												<input type='file' id='fileSOIA' name='fileSOIA' multiple>
											</div>
										</div>
									</div>
								</td>
							</tr>

							<tr height='15px'></tr>
						
							<tr align='center'>
								<td colspan='2' width='150px' height='33px'>";

									$html .="
									<button onClick=\"muestraCargaArchivoA('".$datosReferencia[$referencia]."')\" style='background-color:#0586E2; border:none; cursor:pointer;'>
										<b>Carga archivo A con firma</b>
									</button>";
							
						$html .= "
								</td>
							</tr>


							<tr height='15px'></tr>";


							$html .= '
							<tr align="center">
								<td colspan="2">';
	
									$html .="
									<button style='background-color:#0586E2;s' onClick=\"reGenerarE('".$datosReferencia[$referencia]."')\" style='background-color:rgb(0,249,0); border:none; cursor:pointer;''>
										<b>regenerar E</b>
									</button>";
	
							$html .= "
								</td>
							</tr>
						";

					}

					if($datosReferencia[$estatus] == "Completar datos pago"){
						
						
						$html .= "
							<tr height='5px'></tr>

							<tr>
								<td colspan='2' id='lineaBlanca'></td>
							</tr>

							<tr height='15px'></tr>


							<tr style='font-family:Arial; color:white;' align='center'>
								<td colspan='2'>Operacion bancaria</td>
							</tr>
							<tr align='center'>
								<td colspan='2'>
									<input type='text' id='operacionBancaria'></input>
								</td>
							</tr>

							<tr style='font-family:Arial; color:white;' align='center'>
								<td colspan='2'>Numero Transaccion SAT</td>
							</tr>
							<tr align='center'>
								<td colspan='2'>
									<input type='text' id='transaccionSAT'></input>
								</td>
							</tr>

							<tr style='font-family:Arial; color:white;' align='center'>
								<td colspan='2'>Fecha pago</td>
							</tr>
							<tr align='center'>
								<td colspan='2'>
									<input type='date' id='fechaPago'></input>
								</td>
							</tr>

							<tr style='font-family:Arial; color:white;' align='center'>
								<td colspan='2'>Hora pago</td>
							</tr>
							<tr align='center'>
								<td colspan='2'>
									<input type='time' id='horaPago'></input>
								</td>
							</tr>

							<tr style='font-family:Arial; color:white;' align='center'>
								<td colspan='2'>Turno (M/V)</td>
							</tr>
							<tr align='center'>
								<td colspan='2'>
									<input type='text' id='turno'></input>
								</td>
							</tr>

							<tr align='center'>
								<td colspan='2'>
									<button style='background-color:rgb(0,249,0);' onclick=\"registraDatosPago('".$datosReferencia[$referencia]."')\">Registrar</button>
								</td>
							</tr>

						";

					}

					if($datosReferencia[$estatus] == "Completar datos pago sin A"){
						
						
						$html .= "
							<tr height='5px'></tr>

							<tr>
								<td colspan='2' id='lineaBlanca'></td>
							</tr>

							<tr height='15px'></tr>


							<tr style='font-family:Arial; color:white;' align='center'>
								<td colspan='2'>Operacion bancaria</td>
							</tr>
							<tr align='center'>
								<td colspan='2'>
									<input type='text' id='operacionBancaria'></input>
								</td>
							</tr>

							<tr style='font-family:Arial; color:white;' align='center'>
								<td colspan='2'>Numero Transaccion SAT</td>
							</tr>
							<tr align='center'>
								<td colspan='2'>
									<input type='text' id='transaccionSAT'></input>
								</td>
							</tr>

							<tr style='font-family:Arial; color:white;' align='center'>
								<td colspan='2'>Fecha pago</td>
							</tr>
							<tr align='center'>
								<td colspan='2'>
									<input type='date' id='fechaPago'></input>
								</td>
							</tr>

							<tr style='font-family:Arial; color:white;' align='center'>
								<td colspan='2'>Hora pago</td>
							</tr>
							<tr align='center'>
								<td colspan='2'>
									<input type='time' id='horaPago'></input>
								</td>
							</tr>

							<tr style='font-family:Arial; color:white;' align='center'>
								<td colspan='2'>Turno (M/V)</td>
							</tr>
							<tr align='center'>
								<td colspan='2'>
									<input type='text' id='turno'></input>
								</td>
							</tr>

							<tr align='center'>
								<td colspan='2'>
									<button style='background-color:rgb(0,249,0);' onclick=\"registraDatosPagoSinA('".$datosReferencia[$referencia]."')\">Registrar</button>
								</td>
							</tr>

						";

					}


				$html .= '
				</table>';

    	$html .='
			</div>
		</div>';

		return $html;

	}

	function muestraArchivos($datosReferencia, $archivos, $session){

		$referencia = 0;
		$usuario = 1;
		$estatus = 2;

		if($_SESSION["sesionLinks"]->oficina == "CDMX"){

			$oficina = "AEROPUERTO";

		}else if($_SESSION["sesionLinks"]->oficina == "NLRD"){

			$oficina = "LAREDO";

		}else if($_SESSION["sesionLinks"]->oficina == "CUN"){

			$oficina = "CANCUN";

		}else if($_SESSION["sesionLinks"]->oficina == "VER"){

			$oficina = "VERACRUZ";

		}else if($_SESSION["sesionLinks"]->oficina == "TOL"){

			$oficina = "TOLUCA";

		}

		$host = "71.144.19.155";
		$port =  21;
		$user = "Imagenes";
		$pass = "Img2012Server";
		$servidorSocket = "71.144.19.155";

    	$html ='
			<div>
		';

			if($datosReferencia[$estatus] == "Liberado"){

				$html .='
					<table border="0" height="100%" width="95%">
						<tr>
							<td width="33%">Archivo Simplificado</td>
							<td width="33%" align="center">'.$archivos["Archivo Simplificado"]["Nombre"].'</td>
							<td width="33%" align="right"><a href="data:Application/octet-stream,'.rawurlencode($archivos["Archivo Simplificado"]["Contenido"]).'" download="'.$archivos["Archivo Simplificado"]["Nombre"].'"  src="../Views/img/ICN_PreviewXMLAzul.png"><img src="../Views/img/ICN_DescargarFileAzul.png" alt="descarga Archivo Simplificado"></a></td>
						</tr>
						<tr height"50%" align="center">
							<td colspan="3">
								<object data="data:Application/pdf,'.rawurlencode($archivos["Archivo Simplificado"]["Contenido"]).'" type="application/pdf" width="95%" height="95%">
							  	</object>
							</td>

						</tr>
						<tr>
							<td width="33%">Archivo Proformas</td>
							<td width="33%" align="center">'.$archivos["Archivo Proformas"]["Nombre"].'</td>
							<td width="33%" align="right"><a href="data:Application/octet-stream,'.rawurlencode($archivos["Archivo Proformas"]["Contenido"]).'" download="'.$archivos["Archivo Proformas"]["Nombre"].'"  src="../Views/img/ICN_PreviewXMLAzul.png"><img src="../Views/img/ICN_DescargarFileAzul.png" alt="descarga Archivo Proformas"></a></td>
						</tr>
						<tr height"50%" align="center">
							<td colspan="3">
								<object data="data:Application/pdf,'.rawurlencode($archivos["Archivo Proformas"]["Contenido"]).'" type="application/pdf" width="95%" height="95%">
							  	</object>
							</td>
						</tr>
					</table>
				';
			}else if($datosReferencia[$estatus] == "Para liberar"){

				$html .='
					<table border="0" height="100%" width="95%">
						<tr>
							<td width="33%">Archivo Simplificado</td>
							<td width="33%" align="center">'.$archivos["Archivo Simplificado"]["Nombre"].'</td>
							<td width="33%" align="right"><a href="data:Application/octet-stream,'.rawurlencode($archivos["Archivo Simplificado"]["Contenido"]).'" download="'.$archivos["Archivo Simplificado"]["Nombre"].'"  src="../Views/img/ICN_PreviewXMLAzul.png"><img src="../Views/img/ICN_DescargarFileAzul.png" alt="descarga Archivo Simplificado"></a></td>
						</tr>
						<tr height"50%" align="center">
							<td colspan="3">
								<object data="data:Application/pdf,'.rawurlencode($archivos["Archivo Simplificado"]["Contenido"]).'" type="application/pdf" width="95%" height="95%">
							  	</object>
							</td>

						</tr>

						<tr>
							<td width="33%">Archivo Proformas</td>
							<td width="33%" align="center">'.$archivos["Archivo Proformas"]["Nombre"].'</td>
							<td width="33%" align="right"><a href="data:Application/octet-stream,'.rawurlencode($archivos["Archivo Proformas"]["Contenido"]).'" download="'.$archivos["Archivo Proformas"]["Nombre"].'"  src="../Views/img/ICN_PreviewXMLAzul.png"><img src="../Views/img/ICN_DescargarFileAzul.png" alt="descarga Archivo Proformas"></a></td>
						</tr>
						<tr height"50%" align="center">
							<td colspan="3">
								<object data="data:Application/pdf,'.rawurlencode($archivos["Archivo Proformas"]["Contenido"]).'" type="application/pdf" width="95%" height="95%">
							  	</object>
							</td>
						</tr>
					</table>
				';
			}else if($datosReferencia[$estatus] == "Pago realizado"){
				$html .='
					<table border="0" height="100%" width="95%">
						<tr>
							<td width="33%">Archivo M</td>
							<td width="33%" align="center">'.$archivos["Archivo M"]["Nombre"].'</td>
							<td width="33%" align="right"><a href="data:Application/octet-stream,'.rawurlencode($archivos["Archivo M"]["Contenido"]).'" download="'.$archivos["Archivo M"]["Nombre"].'"  src="../Views/img/ICN_PreviewXMLAzul.png"><img src="../Views/img/ICN_DescargarFileAzul.png" alt="descarga Archivo M"></a></td>
						</tr>
						<tr height"20%" align="center">
							<td colspan="3"><textarea style="width:95%; height:95%;">'.$archivos["Archivo M"]["Contenido"].'</textarea></td>
						</tr>
						<tr>
							<td width="33%">Archivo .err</td>
							<td width="33%" align="center">'.$archivos["Archivo .err"]["Nombre"].'</td>
							<td width="33%" align="right"><a href="data:Application/octet-stream,'.rawurlencode($archivos["Archivo .err"]["Contenido"]).'" download="'.$archivos["Archivo .err"]["Nombre"].'"  src="../Views/img/ICN_PreviewXMLAzul.png"><img src="../Views/img/ICN_DescargarFileAzul.png" alt="descarga Archivo .err"></a></td>
						</tr>
						<tr height"20%" align="center">
							<td colspan="3"><textarea style="width:95%; height:95%;">'.$archivos["Archivo .err"]["Contenido"].'</textarea></td>
						</tr>
						<tr>
							<td width="33%">Archivo E</td>
							<td width="33%" align="center">'.$archivos["Archivo E"]["Nombre"].'</td>
							<td width="33%" align="right"><a href="data:Application/octet-stream,'.rawurlencode($archivos["Archivo E"]["Contenido"]).'" download="'.$archivos["Archivo E"]["Nombre"].'"  src="../Views/img/ICN_PreviewXMLAzul.png"><img src="../Views/img/ICN_DescargarFileAzul.png" alt="descarga Archivo E"></a></td>
						</tr>
						<tr height"20%" align="center">
							<td colspan="3"><textarea style="width:95%; height:95%;">'.$archivos["Archivo E"]["Contenido"].'</textarea></td>
						</tr>
						<tr>
							<td width="33%">Archivo A</td>
							<td width="33%" align="center">'.$archivos["Archivo A"]["Nombre"].'</td>
							<td width="33%" align="right"><a href="data:Application/octet-stream,'.rawurlencode($archivos["Archivo A"]["Contenido"]).'" download="'.$archivos["Archivo A"]["Nombre"].'"  src="../Views/img/ICN_PreviewXMLAzul.png"><img src="../Views/img/ICN_DescargarFileAzul.png" alt="descarga Archivo A"></a></td>
						</tr>
						<tr height"20%" align="center">
							<td colspan="3"><textarea style="width:95%; height:95%;">'.$archivos["Archivo A"]["Contenido"].'</textarea></td>
						</tr>
					</table>
				';
			}else if($datosReferencia[$estatus] == "Desistimiento realizado"){
				$html .='
					<table border="0" height="100%" width="95%">
						<tr>
							<td width="33%">Archivo M</td>
							<td width="33%" align="center">'.$archivos["Archivo M"]["Nombre"].'</td>
							<td width="33%" align="right"><a href="data:Application/octet-stream,'.rawurlencode($archivos["Archivo M"]["Contenido"]).'" download="'.$archivos["Archivo M"]["Nombre"].'"  src="../Views/img/ICN_PreviewXMLAzul.png"><img src="../Views/img/ICN_DescargarFileAzul.png" alt="descarga Archivo M"></a></td>
						</tr>
						<tr height"20%" align="center">
							<td colspan="3"><textarea style="width:95%; height:95%;">'.$archivos["Archivo M"]["Contenido"].'</textarea></td>
						</tr>
						<tr>
							<td width="33%">Archivo .err</td>
							<td width="33%" align="center">'.$archivos["Archivo .err"]["Nombre"].'</td>
							<td width="33%" align="right"><a href="data:Application/octet-stream,'.rawurlencode($archivos["Archivo .err"]["Contenido"]).'" download="'.$archivos["Archivo .err"]["Nombre"].'"  src="../Views/img/ICN_PreviewXMLAzul.png"><img src="../Views/img/ICN_DescargarFileAzul.png" alt="descarga Archivo .err"></a></td>
						</tr>
						<tr height"20%" align="center">
							<td colspan="3"><textarea style="width:95%; height:95%;">'.$archivos["Archivo .err"]["Contenido"].'</textarea></td>
						</tr>
					</table>
				';
			}else if($datosReferencia[$estatus] == "Error pagar"){
				$html .='
					<table border="0" height="100%" width="95%">
						<tr>
							<td width="33%">Archivo E</td>
							<td width="33%" align="center">'.$archivos["Archivo E"]["Nombre"].'</td>
							<td width="33%" align="right"><a href="data:Application/octet-stream,'.rawurlencode($archivos["Archivo E"]["Contenido"]).'" download="'.$archivos["Archivo E"]["Nombre"].'"  src="../Views/img/ICN_PreviewXMLAzul.png"><img src="../Views/img/ICN_DescargarFileAzul.png" alt="descarga Archivo E"></a></td>
						</tr>
						<tr height="40%" align="center">
							<td colspan="3">
								<textarea style="width:95%; height:95%;">'.$archivos["Archivo E"]["Contenido"].'</textarea>
							</td>
						</tr>
						<tr>
							<td width="33%">Archivo A</td>
							<td width="33%" align="center">'.$archivos["Archivo A"]["Nombre"].'</td>
							<td width="33%" align="right"><a href="data:Application/octet-stream,'.rawurlencode($archivos["Archivo A"]["Contenido"]).'" download="'.$archivos["Archivo A"]["Nombre"].'"  src="../Views/img/ICN_PreviewXMLAzul.png"><img src="../Views/img/ICN_DescargarFileAzul.png" alt="descarga Archivo A"></a></td>
						</tr>
						<tr height="40%" align="center">
							<td colspan="3">
								<textarea style="width:95%; height:95%;">'.$archivos["Archivo A"]["Contenido"].'</textarea>
							</td>
						</tr>

					</table>
				';
			}else if($datosReferencia[$estatus] == "Para pagar"){
				$html .='
					<table border="0" height="100%" width="95%">
						<tr>
							<td width="33%">Archivo M</td>
							<td width="33%" align="center">'.$archivos["Archivo M"]["Nombre"].'</td>
							<td width="33%" align="right"><a href="data:Application/octet-stream,'.rawurlencode($archivos["Archivo M"]["Contenido"]).'" download="'.$archivos["Archivo M"]["Nombre"].'"  src="../Views/img/ICN_PreviewXMLAzul.png"><img src="../Views/img/ICN_DescargarFileAzul.png" alt="descarga Archivo M"></a></td>
						</tr>
						<tr height"30%" align="center">
							<td colspan="3"><textarea style="width:95%; height:95%;">'.$archivos["Archivo M"]["Contenido"].'</textarea></td>
						</tr>
						<tr>
							<td width="33%">Archivo .err</td>
							<td width="33%" align="center">'.$archivos["Archivo .err"]["Nombre"].'</td>
							<td width="33%" align="right"><a href="data:Application/octet-stream,'.rawurlencode($archivos["Archivo .err"]["Contenido"]).'" download="'.$archivos["Archivo .err"]["Nombre"].'"  src="../Views/img/ICN_PreviewXMLAzul.png"><img src="../Views/img/ICN_DescargarFileAzul.png" alt="descarga Archivo .err"></a></td>
						</tr>
						<tr height"30%" align="center">
							<td colspan="3"><textarea style="width:95%; height:95%;">'.$archivos["Archivo .err"]["Contenido"].'</textarea></td>
						</tr>
						<tr>
							<td width="33%">Archivo E</td>
							<td width="33%" align="center">'.$archivos["Archivo E"]["Nombre"].'</td>
							<td width="33%" align="right"><a href="data:Application/octet-stream,'.rawurlencode($archivos["Archivo E"]["Contenido"]).'" download="'.$archivos["Archivo E"]["Nombre"].'"  src="../Views/img/ICN_PreviewXMLAzul.png"><img src="../Views/img/ICN_DescargarFileAzul.png" alt="descarga Archivo E"></a></td>
						</tr>
						<tr height="30%" align="center">
							<td colspan="3">
								<textarea style="width:95%; height:95%;">'.$archivos["Archivo E"]["Contenido"].'</textarea>
							</td>
						</tr>
					</table>
				';
			}else if($datosReferencia[$estatus] == "Error prevalidar"){
				$html .='
					<table border="0" height="100%" width="95%">
						<tr>
							<td width="33%">Archivo M</td>
							<td width="33%" align="center">'.$archivos["Archivo M"]["Nombre"].'</td>
							<td width="33%" align="right"><a href="data:Application/octet-stream,'.rawurlencode($archivos["Archivo M"]["Contenido"]).'" download="'.$archivos["Archivo M"]["Nombre"].'"  src="../Views/img/ICN_PreviewXMLAzul.png"><img src="../Views/img/ICN_DescargarFileAzul.png" alt="descarga Archivo M"></a></td>
						</tr>
						<tr height"40%" align="center">
							<td colspan="3"><textarea style="width:95%; height:95%;">'.$archivos["Archivo M"]["Contenido"].'</textarea></td>
						</tr>
						<tr>
							<td width="33%">Archivo K</td>
							<td width="33%" align="center">'.$archivos["Archivo K"]["Nombre"].'</td>
							<td width="33%" align="right"><a href="data:Application/octet-stream,'.rawurlencode($archivos["Archivo K"]["Contenido"]).'" download="'.$archivos["Archivo K"]["Nombre"].'"  src="../Views/img/ICN_PreviewXMLAzul.png"><img src="../Views/img/ICN_DescargarFileAzul.png" alt="descarga Archivo K"></a></td>
						</tr>
						<tr height"40%" align="center">
							<td colspan="3"><textarea style="width:95%; height:95%;">'.$archivos["Archivo K"]["Contenido"].'</textarea></td>
						</tr>
					</table>
				';
			}else if($datosReferencia[$estatus] == "Para prevalidar"){
				$html .='
					<table border="0" height="100%" width="95%">
						<tr>
							<td width="33%">Archivo M</td>
							<td width="33%" align="center">'.$archivos["Archivo M"]["Nombre"].'</td>
							<td width="33%" align="right"><a href="data:Application/octet-stream,'.rawurlencode($archivos["Archivo M"]["Contenido"]).'" download="'.$archivos["Archivo M"]["Nombre"].'"  src="../Views/img/ICN_PreviewXMLAzul.png"><img src="../Views/img/ICN_DescargarFileAzul.png" alt="descarga Archivo M"></a></td>
						</tr>
						<tr height="90%" align="center">
							<td colspan="3">
								<textarea style="width:95%; height:95%;">'.$archivos["Archivo M"]["Contenido"].'</textarea>
							</td>
						</tr>
					</table>
				';
			}else if($datosReferencia[$estatus] == "Para desistir"){
				$html .='
					<table border="0" height="100%" width="95%">
						<tr>
							<td width="33%">Archivo M</td>
							<td width="33%" align="center">'.$archivos["Archivo M"]["Nombre"].'</td>
							<td width="33%" align="right"><a href="data:Application/octet-stream,'.rawurlencode($archivos["Archivo M"]["Contenido"]).'" download="'.$archivos["Archivo M"]["Nombre"].'"  src="../Views/img/ICN_PreviewXMLAzul.png"><img src="../Views/img/ICN_DescargarFileAzul.png" alt="descarga Archivo M"></a></td>
						</tr>
						<tr height="90%" align="center">
							<td colspan="3">
								<textarea style="width:95%; height:95%;">'.$archivos["Archivo M"]["Contenido"].'</textarea>
							</td>
						</tr>
					</table>
				';
			}else{
				$html .='
					<table border="0" height="100%" width="95%">
						<tr height"8%">
							<td width="33%">Archivo M</td>
							<td width="33%" align="center">'.$archivos["Archivo M"]["Nombre"].'</td>
							<td width="33%" align="right"><a href="data:Application/octet-stream,'.rawurlencode($archivos["Archivo M"]["Contenido"]).'" download="'.$archivos["Archivo M"]["Nombre"].'"  src="../Views/img/ICN_PreviewXMLAzul.png"><img src="../Views/img/ICN_DescargarFileAzul.png" alt="descarga Archivo M"></a></td>
						</tr>
						<tr height"25%" align="center">
							<td colspan="3"><textarea style="width:95%; height:95%;">'.$archivos["Archivo M"]["Contenido"].'</textarea></td>
						</tr>
						<tr height"8%">
							<td width="33%">Archivo K</td>
							<td width="33%" align="center">'.$archivos["Archivo K"]["Nombre"].'</td>
							<td width="33%" align="right"><a href="data:Application/octet-stream,'.rawurlencode($archivos["Archivo K"]["Contenido"]).'" download="'.$archivos["Archivo K"]["Nombre"].'"  src="../Views/img/ICN_PreviewXMLAzul.png"><img src="../Views/img/ICN_DescargarFileAzul.png" alt="descarga Archivo K"></a></td>
						</tr>
						<tr height"25%" align="center">
							<td colspan="3"><textarea style="width:95%; height:95%;">'.$archivos["Archivo K"]["Contenido"].'</textarea></td>
						</tr>
						<tr height"8%">
							<td width="33%">Archivo .err</td>
							<td width="33%" align="center">'.$archivos["Archivo .err"]["Nombre"].'</td>
							<td width="33%" align="right"><a href="data:Application/octet-stream,'.rawurlencode($archivos["Archivo .err"]["Contenido"]).'" download="'.$archivos["Archivo .err"]["Nombre"].'"  src="../Views/img/ICN_PreviewXMLAzul.png"><img src="../Views/img/ICN_DescargarFileAzul.png" alt="descarga Archivo .err"></a></td>
						</tr>
						<tr height"25%" align="center">
							<td colspan="3"><textarea style="width:95%; height:95%;">'.$archivos["Archivo .err"]["Contenido"].'</textarea></td>
						</tr>
					</table>
				';
			}




		$html .='
			</div>
		';

		echo $html;

	}


function generaDropZone($referencia/*, $factura, $tipo*/){
		
		$html = '
			<html lang="en">
			<head>
			  	<meta charset="utf-8">
			  	<title>The HTML5 Herald</title>
			  	<meta name="description" content="The HTML5 Herald">
			  	<meta name="author" content="SitePoint">

			  	<link rel="stylesheet" href="../Views/css/dropzone.css">
			  	<script type="text/javascript" src="../Views/js/dropzone.js"></script>
			  	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
			  	<script>
			  		function dropZone(){
 
						Dropzone.options.myDropzone = {
						 	dictDefaultMessage: "Arrastra aqui el archivo.",
						 	addRemoveLinks: true,
						    init: function() {
								 
						        thisDropzone = this;
						                
						        $.get("cargadorArchivos.php", function(data) {
						 
						            $.each(data, function(key,value){
										var url = "";  
						                var mockFile = { name: value.name, size: url}; 
										      
						                thisDropzone.options.addedfile.call(thisDropzone, mockFile);
						                thisDropzone.options.thumbnail.call(thisDropzone, mockFile, "docs/");
									    thisDropzone.emit("complete", mockFile);
									    var ext = mockFile.name.split(".")[1];
									    switch(ext){
									      case "xls":
									      thisDropzone.createThumbnailFromUrl(mockFile, "../Views/img/excel.png");
									      break;
									      case "xlsx":
									      thisDropzone.createThumbnailFromUrl(mockFile, "../Views/img/excel.png");
									      break;
									      case "pdf":
									      thisDropzone.createThumbnailFromUrl(mockFile, "../Views/img/pdf.png");
									      break;
									      case "doc":
									      thisDropzone.createThumbnailFromUrl(mockFile, "../Views/img/word.png");
									      case "docx":
									      thisDropzone.createThumbnailFromUrl(mockFile, "../Views/img/word.png");
									      break;
									      case "zip":
									      thisDropzone.createThumbnailFromUrl(mockFile, "../Views/img/zip.jpg");
									      break;
									      case "rar":
									      thisDropzone.createThumbnailFromUrl(mockFile, "../Views/img/zip.jpg");
									      break;
									      case "ppt":
									      thisDropzone.createThumbnailFromUrl(mockFile, "../Views/img/ppt.png");
									      break;
									      case "pptx":
									      thisDropzone.createThumbnailFromUrl(mockFile, "../Views/img/ppt.png");
									      break;
									      case "png":
									      break;
									      case "jpg":
									      break;
									      case "jpeg":
									      break;
									      default:
									      thisDropzone.createThumbnailFromUrl(mockFile, "../Views/img/nose.png");
									      break;
									     } 
						             });
						         });
						     },
						           
						     accept: function(file, done) {
						     var thumbnail = $(".dropzone .dz-preview.dz-file-preview .dz-image:last");
						 
						     switch (file.type) {
						       case "application/pdf":
						         thumbnail.css("background", "url(../Views/img/pdf.png");
						         break;
						       case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
						         thumbnail.css("background", "url(../Views/img/word.png");
						         break;
						       case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet":
						         thumbnail.css("background", "url(../Views/img/excel.png");
						         break;
						        case "application/vnd.ms-excel":
						        thumbnail.css("background", "url(../Views/img/excel.png");
						         break;
						        case "application/zip, application/x-compressed-zip":
						        thumbnail.css("background", "url(../Views/img/zip.jpg");
						         break;
						        case "application/vnd.ms-powerpointtd>":
						        thumbnail.css("background", "url(../Views/img/ppt.png");
						         break;
						        case "application/vnd.openxmlformats-officedocument.presentationml.presentation":
						        thumbnail.css("background", "url(../Views/img/ppt.png");
						         break;
						        case "img/jpeg":
						        break;
						        case "img/png":
						        break;
						        default:
						        thumbnail.css("background", "url(../Views/img/nose.png");
						     }
						 
						     done();
						   },
						           
							
						};
					 
					}

					dropZone();
			  	</script>
			</head>

			<body>
				<div>
					<form action="validacionController.php?evento=cargaArchivoValidador&referencia='.$referencia.'" method="post" class="dropzone" id="my-awesome-dropzone"></form>
				</div>
			</body>
			</html
		';
		
		echo $html;
		
	}
}

?>
