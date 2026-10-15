<?php?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8" />
		<link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
		<title>Auditoría</title>
		<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>
	</head>
	<body>
		<div id='wrapperFichaExterna' align='center' style='display:none'>
			<form method='post' id='formularioExterno' action='AuditoriaActualizarv2.php'>
				<table border='0' align='center'>
					<tr>
						<td align='left' id='breadcrumbs'>Usuario:</td>
					</tr>						
					<tr height='80px'><td></td></tr>
					<!-- ///Titulo  -->
					<tr>
						<td align='center' class='titulo1' width='700px'>
							codigo
						</td>
					</tr>					
					<tr> 
						<td align='center'>
							breadcrumb
						</td>
					</tr>							
					<tr height='50'><td></td></tr>		
				</table>					
				<table border='0' align='center' width='700px'>	
					<tr height='50px'><td colspan='4'></td></tr>
					<tr>
						<td colspan='3' class='titulo2'><b>Plan de auditoría</b></td>
						<td>							

						</td>
					</tr>					
					<tr>
						<td class='titleBlueLineBottom' colspan='4'></td>
					</tr>				
					<tr height='10px'><td colspan='4'></td></tr>			
					<tr>
						<td></td>
						<td></td>
						<td colspan='2' id='textIntro'>						
								<i></i> <a href='../downloadAuditoria.php?'><img src='../../Imagenes/ICN_Archivo.png'></a>
						</td>
					</tr>
					<tr height='10px'><td colspan='4'></td></tr>
					<tr>
						<td width='20px'></td>
						<td width='20px'></td>
						<td width='645px'>
							<textarea  name='programa' style='width: 645px; height:200px;'></textarea><input type='hidden' name='codigo' value=''>
						</td>
						<td width='15px' align='right'>
							<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_Certif.png' width='10' height='10'>
						</td>
					</tr>		
					<tr height='20px'><td colspan='4'></td></tr>		
				</table>
				<!-- //Informe de la auditoria -->
				<table border='0' align='center' width='700px'>
					<tr>
						<td class='titulo2' colspan='3'><b>Informe de la auditoría</b></td>
						<td>			
								<a href='../AgregaElementos/AgregaElementosv2/AgregarArchivoAuditoriaPopUpv2.php' target='popup' onclick="window.open(this.href,this.target,'width=600,height=400,scrollbars=yes')">
									<img src='../../Imagenes/ICN_CargaDocumento.png' height='15' width='15'>
								</a>
						</td>
					</tr>				
					<tr>
						<td class='titleBlueLineBottom' colspan='4'></td>
					</tr>				
					<tr height='20px'><td colspan='4'></td></tr>				
					<tr>
						<td></td>
						<td></td>
						<td colspan='2' id='textIntro'>					
								<i></i> <a href='downloadAuditoria.php' ><img src='../../Imagenes/ICN_Archivo.png'></a>
						</td>
					</tr>
					<tr height='10px'><td colspan='4'></td></tr>				
					<tr>
						<td width='20px'></td>
						<td width='20px'></td>					
						<td width='645px'>
							<textarea name='informe' style='width: 645px; height:200px;'></textarea>
						</td>					
						<td width='15px' align='right'>
							<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_Certif.png' width='10' height='10'>
						</td>
					</tr>
					<tr height='20'><td colspan='4'></td></tr>
				</table>	
				<table border='0' align='center' width='700px'>	
					<tr height='30px'><td colspan='4'></td></tr>			
					<tr>
						<td class='titulo2' colspan='3'><b>Hallazgos</b></td>
					</tr>					
					<tr>
						<td class='titleBlueLineBottom' colspan='4'></td>
					</tr>					
					<tr height='20px'><td colspan='4'></td></tr>					
					<tr>
						<td width='20px'></td>
						<td width='20px'></td>											
							<td>
								¿Existen Hallazgos?
							</td>
							<td>
								<input type='radio' name='existeH' value='si' checked>SI<br>
								<input type='radio' name='existeH' value='no'>NO<br>
							</td>						
							<td width='15px' align='right' >
								<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_Certif.png' width='10' height='10'>
							</td>																
					</tr>					
					<tr height='20px'><td colspan='4'></td></tr>					
				</table>				
				<!-- //FINALIZAR -->
				<table border='0' align='center' width='700px'>
					<tr>
						<td class='titleBlueLineBottom'></td>
					</tr>					
					<tr height='20px'><td></td></tr>					
					<tr>
						<td align='right'>
							<a href='../FichaAuditoriav2.php'>
								<img src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>
							</a>
						</td>	
					</tr>
					<tr height='50'px><td></td></tr>
				</table>
			</form>					
		</div>
		<div id='wrapperFichaInterna' align='center'>
			<form method='post' id='formulario' action='AuditoriaActualizarv2.php' onsubmit='return validarRegistroAgenda()'>
				<div id='elementosOperar'>
					<table border='0' align='center'>
						<tr>
							<td align='left' id='breadcrumbs'>Usuario: </td>
						</tr>					
						<tr height='80px'><td></td></tr>
						<!-- ///Titulo  -->
						<tr>
							<td align='center' id='titulo1' width='700px'>
								codigo
							</td>
						</tr>	
						<tr>
							<td align='center' id='titulo3' width='700px'>
								Plan de Auditoría
							</td>
						</tr>				
						<tr> 
							<td align='center'>
								breadcrumb;
							</td>
						</tr>						
						<tr height='50'><td></td></tr>		
					</table>				
					<table id='seccionObjetivos' border='0' align='center' width='700px'>	
						<tr height='30px'><td colspan='4'></td></tr>		
						<tr>
							<td class='titulo2' colspan='3'><b>Objetivos</b></td>
							<td align='right'>
								<!-- //Agregar competencia -->
								<a href='modificarObjetivosPopUp.php' target='popup' onclick="window.open(this.href,this.target,'width=700,height=400,scrollbars=yes')">
								<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'></a>
						</td>
						</tr>				
						<tr>
							<td class='titleBlueLineBottom' colspan='4'></td>
						</tr>		
						<tr height='30px'> </tr>					
						<tr>
						<td align='left' width='30px'> </td>
						<td><i style="color:#636262;">Sirven para establecer qué es lo que se va a lograr con la auditoría. Se consideran como objetivos de esta auditoría los que están palomeados.</i></td>
						</tr>
						<tr height='10px'><td colspan='4'></td></tr>
						<tr height='30px'><td colspan='4'></td></tr>	
					</table>
					<table id='seccionAlcance' border='0' align='center' width='700px'>	
						<tr height='30px'><td colspan='4'></td></tr>		
						<tr>
							<td class='titulo2' colspan='3'><b>Alcance de la Auditoría</b></td>
							<td align='right'>
								<!-- //Agregar competencia -->
								<a href='#' target='popup' onclick="window.open(this.href,this.target,'width=400,height=700,scrollbars=yes')">
								<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
								</a>
						</td>
						</tr>				
						<tr>
							<td class='titleBlueLineBottom' colspan='4'></td>
						</tr>	
						<tr height='30px'> </tr>						
						<tr>
							<td align='left' width='30px'> </td>
							<td><i style="color:#636262;">Sirve para describir la extensión y los límites de la auditoría, tales como ubicación, unidades de la organización, actividades y procesos que van a ser auditados, así como el período cubierto por la auditoría.</i></td>
							<td>
						</tr>
						<tr height='10px'><td colspan='4'></td></tr>		
						<tr height='30px'><td colspan='4'></td></tr>
					</table>
					<table id='seccionCriterios' border='0' align='center' width='700px'>	
						<tr height='30px'><td colspan='4'></td></tr>		
						<tr>
							<td class='titulo2' colspan='3'><b>Criterios de la Auditoría</b></td>
							<td align='right'>
								<!-- //Agregar competencia -->
								<a href='#' target='popup' onclick="window.open(this.href,this.target,'width=400,height=700,scrollbars=yes')">
								<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
								</a>
						</td>
						</tr>				
						<tr>
							<td class='titleBlueLineBottom' colspan='4'></td>
						</tr>
						<tr height='30px'> </tr>								
						<tr>
							<td align='left' width='30px'> </td>
							<td><i style="color:#636262;">Se utilizan como una referencia frente a la cual se determina la conformidad. Dichos criterios pueden incluir políticas, procedimientos, normas, leyes y reglamentos, requisitos del sistema de gestión, requisitos contractuales o códigos de conducta de los sectores industriales o de negocio aplicables. Se consideran criterios de esta auditoría los que están palomeados.</i></td>
							<td>
						</tr>
						<tr height='10px'><td colspan='4'></td></tr>
						<tr height='30px'><td colspan='4'></td></tr>
					</table>
					<table id='seccionRiesgos' border='0' align='center' width='700px'>	
						<tr height='30px'><td colspan='4'></td></tr>		
						<tr>
							<td class='titulo2' colspan='3'><b>Riesgos de la Auditoría</b></td>
							<td align='right'>
								<!-- //Agregar competencia -->
								<a href='#' target='popup' onclick="window.open(this.href,this.target,'width=400,height=700,scrollbars=yes')">
								<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
								</a>
						</td>
						</tr>				
						<tr>
							<td class='titleBlueLineBottom' colspan='4'></td>
						</tr>
						<tr height='30px'> </tr>	
						<tr height='30px'><td colspan='4'></td></tr>
					</table>
					<table id='seccionRecursos' border='0' align='center' width='700px'>	
						<tr height='30px'><td colspan='4'></td></tr>		
						<tr>
							<td class='titulo2' colspan='3'><b>Recursos requeridos</b></td>
							<td align='right'>
								<!-- //Agregar competencia -->
								<a href='#' target='popup' onclick="window.open(this.href,this.target,'width=400,height=700,scrollbars=yes')">
								<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
								</a>
						</td>
						</tr>				
						<tr>
							<td class='titleBlueLineBottom' colspan='4'></td>
						</tr>	
						<tr height='30px'> </tr>							
						<tr height='30px'><td colspan='4'></td></tr>
					</table>
					<table id='seccionEquipo' border='0' align='center' width='700px'>	
						<tr height='30px'><td colspan='4'></td></tr>		
						<tr>
							<td class='titulo2' colspan='3'><b>Equipo auditor</b></td>
							<td align='right'>
								<!-- //Agregar competencia -->
								<a href='#' target='popup' onclick="window.open(this.href,this.target,'width=400,height=700,scrollbars=yes')">
								<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
								</a>
						</td>
						</tr>				
						<tr>
							<td class='titleBlueLineBottom' colspan='4'></td>
						</tr>			
						<tr height='30px'> </tr>						
						<tr>
							<td align='left' width='30px'> </td>
							<td><i style="color:#636262;">El equipo auditor se define teniendo en cuenta la competencia necesaria para lograr los objetivos de la auditoría. Se considera parte del equipo auditor a las personas palomeadas.</i></td>
							<td>
						</tr>
						<tr height='10px'><td colspan='4'></td></tr>
						<tr height='30px'><td colspan='4'></td></tr>	
					</table>
					<table id='seccionLider' border='0' align='center' width='700px'>	
						<tr height='30px'><td colspan='4'></td></tr>		
						<tr>
							<td class='titulo2' colspan='3'><b>Auditor líder</b></td>
							<td align='right'>
								<!-- //Agregar competencia -->
								<a href='#' target='popup' onclick="window.open(this.href,this.target,'width=400,height=700,scrollbars=yes')">
								<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
								</a>
						</td>
						</tr>				
						<tr>
							<td class='titleBlueLineBottom' colspan='4'></td>
						</tr>	
						<tr height='30px'> </tr>
						<tr height='10px'><td colspan='4'></td></tr>
					</table>
					<table id='seccionAgenda' order='0' align='center' width='800px'>	
						<tr height='30px'><td colspan='4'></td></tr>		
						<tr>
							<td class='titulo2' colspan='3'><b>Agenda de la Auditoría</b></td>
							<td align='right'>
								<!-- //Agregar competencia -->
								<a href='#' target='popup' onclick="window.open(this.href,this.target,'width=400,height=700,scrollbars=yes')">
								<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
								</a>
						</td>
						</tr>				
						<tr>
							<td class='titleBlueLineBottom' colspan='4'></td>
						</tr>				
						<tr height='30px'> </tr>
						<tr width="800px">
							<td align='left' width='30px'> </td>
							<td><i style="color:#636262;">La junta de apertura se realizará a las nueve de la mañana del primer día de la auditoría y la junta de cierre se realizará según instrucciones del auditor líder.</i></td>
						</tr>
						<tr height='20px'> </tr>
					</table>
					<table class="datos" width="800px" cellspacing="0" cellpadding="0" border="1" align="center" width="100%">
						<tr>
							<td>Auditor
							</td>
							<td>Proceso a auditar
							</td>
							<td>Fecha
							</td>
							<td>Hora
							</td>										
						</tr>
						<tr height='30px'><td colspan='4'></td></tr>
					</table>
					<div id='seccionElaborar'>
						<table width='700px'>
							<tr height='30px'><td colspan='4'></td></tr>
							
							<tr>
								<td align='left' id='titulo2'>Elaborarar plan de auditoría</td>
								<td width='25px'>
									<a href='http://71.144.19.155/INTRANET_GEA/Backlog/backlogVTPopUp.php' target='popup' onclick="window.open(this.href,this.target,'width=500,height=550,scrollbars=yes')"><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>
								</td>		
							</tr>
							
							<tr>
								<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
								</td>
							</tr>
							<tr height='30px'><td colspan='4'></td></tr>
						</table>
						<!-- //div donde muestr gif de cargando -->
						<div id='cargaValidaT' style='display:none' align='center'>
			    			<img src='../../../../INTRANET_GEA/Imagenes/img_load.gif' />
			  			</div>
						
						<div id='contValidaT' style='display:block'>
						
							<div id='validacionTecnica'>
								<table align='center' width='20%'>
									<tr height='20px'></tr>
									<tr height="25px" align="center">
										<td id="valTecnicaProcede" style="width: 35%; cursor:pointer" align="center" bgcolor="#42CB27"  onclick="ilumina('valTecnicaProcede', 'ValidacionTecnica')"><font color="white">Procede</font></td>
									</tr>
								
									<tr height="10px"></tr>
								
									<tr height="25px" align="center">
										<td id="valTecnicaNoProcede" style="width: 35%; cursor:pointer" align="center"  bgcolor="red" onClick="ilumina('valTecnicaNoProcede', 'ValidacionTecnica')"><font color="white">No procede</font></td>
									</tr>
									<tr height='10px'><td colspan='4'></td></tr>
								</table>
								
								<div id='valTecnicaComentario'>
									<table  border='0' align='center' width='500px'>		
										<tr>
											<td style='color:#007CBD;'>Comentarios</td>
										</tr>
							
										<tr>
											<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
											</td>
										</tr>
										<tr height='30px'><td colspan='4'></td></tr>										
										<tr align='center'>
											<td><textarea id='valTecnicaComentarioVerif' rows='4' cols='70'>Comentario</textarea></td>
										</tr>
										<tr height='30px'><td colspan='4'></td></tr>							
										<tr>
											<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
											</td>
										</tr>
										
										<tr height='50px'><td colspan='4'></td></tr>
									</table>
								</div>
							</div>
						</div> <!-- //fin del div que engloba al comentario y a la decision		 -->						
					</div>
					<table id='seccionAlcanceInforme' order='0' align='center' width='700px'>
						<td colspan="4" id="titulo2Blanco">Informe de auditoria</td>
						<tr height='30px'><td colspan='4'></td></tr>	
						<tr height='30px'><td colspan='4'></td></tr>							
						<tr>
							<td class='titulo2' colspan='3'><b>Cumplimiento de Objetivos, alcance, auditor líder y equipo de auditores</b></td>
							<td align='right'>
								<!-- //Agregar competencia -->
								<a href='#' target='popup' onclick="window.open(this.href,this.target,'width=400,height=700,scrollbars=yes')">
								<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
								</a>
							</td>
						</tr>				
						<tr>
							<td class='titleBlueLineBottom' colspan='4'></td>
						</tr>				
						<tr height='30px'><td colspan='4'></td></tr>
						<tr height='30px'><td colspan='4'></td></tr>						
					</table>
					<table id='seccionCumplimiento' order='0' align='center' width='700px'>	
						<tr height='30px'><td colspan='4'></td></tr>
						<tr>
							<td class='titulo2' colspan='3'><b>Cumplimiento de la agenda de la auditoría</b></td>
							<td align='right'>
								<!-- //Agregar competencia -->
								<a href='#' target='popup' onclick="window.open(this.href,this.target,'width=400,height=700,scrollbars=yes')">
								<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
								</a>
							</td>
						</tr>
						<tr>
							<td class='titleBlueLineBottom' colspan='4'></td>
						</tr>							
						<tr height='30px'><td colspan='4'></td></tr>	
						<tr height='30px'><td colspan='4'></td></tr>
						<tr height='30px'><td colspan='4'></td></tr>							
						<tr>
							<td class='titulo2' colspan='3'><b>Comentarios de la agenda de la auditoría</b></td>
							<td align='right'>
								<!-- //Agregar competencia -->
								<a href='#' target='popup' onclick="window.open(this.href,this.target,'width=400,height=700,scrollbars=yes')">
								<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
								</a>
							</td>
						</tr>
						<tr>
							<td class='titleBlueLineBottom' colspan='4'></td>
						</tr>				
						<tr height='30px'><td colspan='4'></td></tr>
						<tr height='30px'><td colspan='4'></td></tr>
					</table>					
					<table id='seccionCriteriosInforme' border='0' align='center' width='700px'>
						<tr height='30px'><td colspan='4'></td></tr>		
						<tr>
							<td class='titulo2' colspan='3'><b>Criterios de la Auditoría</b></td>
							<td align='right'>
								<!-- //Agregar competencia -->
								<a href='#' target='popup' onclick="window.open(this.href,this.target,'width=400,height=700,scrollbars=yes')">
								<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
								</a>
						</td>
						</tr>				
						<tr>
							<td class='titleBlueLineBottom' colspan='4'></td>
						</tr>
						<tr height='30px'> </tr>								
						<tr>
							<td align='left' width='30px'> </td>
							<td><i style="color:#636262;">Se utilizan como una referencia frente a la cual se determina la conformidad. Dichos criterios pueden incluir políticas, procedimientos, normas, leyes y reglamentos, requisitos del sistema de gestión, requisitos contractuales o códigos de conducta de los sectores industriales o de negocio aplicables. Se consideran criterios de esta auditoría los que están palomeados.</i></td>
							<td>
						</tr>
						<tr height='10px'><td colspan='4'></td></tr>
						<tr height='30px'><td colspan='4'></td></tr>
					</table>
					<table id='seccionConclusiones' border='0' align='center' width='700px'>
						<tr height='30px'><td colspan='4'></td></tr>		
						<tr>
							<td class='titulo2' colspan='3'><b>Conclusiones de la Auditoría</b></td>
							<td align='right'>
								<!-- //Agregar competencia -->
								<a href='#' target='popup' onclick="window.open(this.href,this.target,'width=400,height=700,scrollbars=yes')">
								<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
								</a>
						</td>
						</tr>				
						<tr>
							<td class='titleBlueLineBottom' colspan='4'></td>
						</tr>
						<tr height='30px'> </tr>								
						<tr>
							<td align='left' width='30px'> </td>
							<td><i style="color:#636262;">Valoración del equipo auditor respecto a la conformidad del sistema de gestión de calidad con los requisitos establecidos en los criterios, así como valoración de que si éste se ha implementado y se mantiene de manera eficaz.</i></td>
							<td>
						</tr>
						<tr height='10px'><td colspan='4'></td></tr>
						<tr height='30px'><td colspan='4'></td></tr>
					</table>
					<div id="seccionRevisarInforme">
						<table class="datos"  width="700px" cellspacing="0" cellpadding="0" border="0" align="center">
							<tr>
								<span>Auditor lider</span>
							</tr>
							<tr height='20px'> </tr>
						</table>
					</div>
					<table id='seccionComentarios' border='0' align='center' width='700px'>
						<tr height='30px'><td colspan='4'></td></tr>		
						<tr>
							<td class='titulo2' colspan='3'><b>Comentarios de la persona auditada</b></td>
							<td align='right'>
								<!-- //Agregar competencia -->
								<a href='#' target='popup' onclick="window.open(this.href,this.target,'width=400,height=700,scrollbars=yes')">
								<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> 
								</a>
						</td>
						</tr>				
						<tr>
							<td class='titleBlueLineBottom' colspan='4'></td>
						</tr>
						<tr height='30px'><td colspan='4'></td></tr>
						<tr height='30px'><td colspan='4'></td></tr>
					</table>
					<table border='0' align='center' width='900px'>	
						<tr height='30px'><td colspan='4'></td></tr>						
						<tr>
							<td align='left' id='titulo2'><b>Hallazgos</b></td>
							
							<td align='right'>
								<a href='AgregaIssue.php' target='popup' onclick="window.open(this.href,this.target,'width=600,height=550,scrollbars=yes')">
									<img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'>
								</a>
							</td>	
						</tr>
						
						<tr>
							<td id='titleBlueLineBottom' colspan='2'></td>
						</tr>
						
						<tr height='30'><td colspan='2'></td></tr>
					</table>
				
					<table border='0' align='center' width='900px'>
						<tr id='iconosTexto2'>
							<td align='center' width='80px'>Código</td>
							<td align='left' width='500px'>Titulo</td>
							<td align='center' width='80px'>Correctiva</td>
							<td align='center' width='80px'>Estatus</td>
							<td align='center' width='80px'>Fecha</td>
							<td align='center' width='20px'></td>
						</tr>
						
						<tr height='10px'><td colspan='4'></td></tr>
							
						<tr>
							<td align='center' id='fileItem'>
								<a href='fichaIssue.php' id='fileItem' style='text-decoration:none;'>clave</a>
							</td>

							<td align='left' id='fileItem'><a href='fichaIssue.php' id='fileItem' style='text-decoration:none;'>titulo</td>
							<td align='center' id='fileItem'><a href='./Intranetv2/fichaCorrectivav2.php' id='fileItem' style='text-decoration:none;'>codigo</td>
							<td align='center' id='fileItem'>estatus</td>
							<td align='center' id='fileItem'>fecha</td>
							
							<td align='right'>
									<a href='downloadAuditoria.php'><img src='../../Imagenes/ICN_Archivo.png'></a>
							</td>
						</tr>

						<tr height='30px'><td colspan='4'></td></tr>
					</table>
					<div id='seccionTerminar'>
						<table width='700px'>
							<tr height='30px'><td colspan='4'></td></tr>
							
							<tr>
								<td align='left' id='titulo2'>Terminar auditoría</td>
								<td width='25px'>
									<a href='http://71.144.19.155/INTRANET_GEA/Backlog/backlogVTPopUp.php' target='popup' onclick="window.open(this.href,this.target,'width=500,height=550,scrollbars=yes')"><img src='../../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a>
								</td>		
							</tr>
							
							<tr>
								<td colspan='3' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
								</td>
							</tr>

							<tr height='30px'><td colspan='4'></td></tr>
						</table>
						<!-- //div donde muestr gif de cargando -->
						<div id='cargaValidaT' style='display:none' align='center'>
			    			<img src='../../../../INTRANET_GEA/Imagenes/img_load.gif' />
			  			</div>
						
						<div id='contValidaT' style='display:block'>
						
							<div id='validacionTecnica'>
								<table align='center' width='20%'>
									<tr height='20px'></tr>
									<tr height="25px" align="center">
										<td id="valTecnicaProcede" style="width: 35%; cursor:pointer" align="center" bgcolor="#42CB27"  onclick="ilumina('valTecnicaProcede', 'ValidacionTecnica')"><font color="white">Terminar</font></td>
									</tr>
									<tr height='30px'><td colspan='4'></td></tr>
								</table>
								
								<div id='valTecnicaComentario'>
									<table  border='0' align='center' width='500px'>
										<tr>
											<td style='color:#007CBD;'>Comentarios</td>
										</tr>
							
										<tr>
											<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
											</td>
										</tr>

										<tr height='30px'><td colspan='4'></td></tr>										
										<tr align='center'>
											<td><textarea id='valTecnicaComentarioVerif' rows='4' cols='70'>Comentario</textarea></td>
										</tr>
										<tr height='30px'><td colspan='4'></td></tr>							
										<tr>
											<td style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>
											</td>
										</tr>
										
										<tr height='30px'><td colspan='4'></td></tr>
									</table>
								</div>
							</div>
						</div> <!-- //fin del div que engloba al comentario y a la decision		 -->						
					</div>					
				</div>				
			</form>
		</div>
		<br><br><br>
		<table border='0' align='center' name='Cuerpo' width='100%'>
			<tr>
				<td id='titleBlueLineBottom' colspan='3' width='100%'></td>
			</tr>
			<tr>
				<td id='nota_al_pie'>
					<center>Created by: Grupo Escalante Agencias Aduanales.</center>
				</td>
			</tr>
		</table>
		<br><br>		
	</body>
</html>