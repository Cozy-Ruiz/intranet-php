<?php
/*
 *@author Octavio F. García Robles
 *@version 1.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
 
$nombrephp = 'reporteEnCeros.php';
require_once("../../ConexionDBT.php");
require_once("../../ConexionImagenes.php");
require_once("../../compruebaUsuario.php");

$currentYear 	= date('Y');
$currentMonth 	= date('m');

if($_POST['year'] != ""){
	
	$year = $_POST['year'];
	
} else{
	
	$year = $currentYear;
	
}

$patente[1] = 3061;
$patente[2] = 3371;
$patente[3] = 3034;
$patente[4] = 3925;

$breadcrumb = "<a href='../../Home.php' id='breadcrumbs'> Home / </a><a href='../aplicaciones.php' id='breadcrumbs'> Módulos / </a>
			   <a href='../operaciones.php' id='breadcrumbs'> Operaciones / </a><a href='homeFracciones.php' id='breadcrumbs'> Fracciones Vulnerables </a>";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--Inicia html-->
<html xmlns="http://www.w3.org/1999/xhtml">
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--Titulo de la pagina-->
        <title>Reporte en Ceros</title>   
        <!--Importacion de archivos externos-->
        <?php
		if($estiloUsuario == 1){
			
			?>
			<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>
			<?php
			
		}else if($estiloUsuario == 2){
			
			?>
			<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>
			<?php
		}
		?>
        <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
        <link rel="stylesheet" href="../../css/jquery-ui.css"/>
        <script src="../../css/jquery-1.9.1.js" charset="utf-8"></script>
        <script src="../../css/jquery-ui.js" charset="utf-8"></script>
        <script>
            $(function() {
            $( document ).tooltip();
            });
        </script>
        <script>
            jQuery(document).ready(function($){
              $("#imgInfo").mouseover(function(){
            
                  var posicionLeft = Math.round($("#imgInfo").offset().left)-850;
                  var posicionTop = Math.round($("#imgInfo").offset().top)+36;
                    
                  //alert("L: "+posicionLeft+"T: "+posicionTop);	
                  $("#infoGeneral").css("left",posicionLeft);	
                  $("#infoGeneral").css("top",posicionTop);
                  $("#infoGeneral").css("visibility","visible");
              
              });
            
                $("#imgInfo").mouseout(function(){
                    $("#infoGeneral").css("visibility","hidden");
                });
            });
        </script>
        <script>
			function showBanana(valor){
				if(valor == 1){
					document.getElementById("banana1").style.display="inline-block";
					document.getElementById("banana0").style.display="none";
					document.getElementById("mapaIntranet").style.display="inline-block";
				} else if (valor == 0){
					document.getElementById("banana1").style.display="none";
					document.getElementById("banana0").style.display="inline-block";
					document.getElementById("mapaIntranet").style.display="none";
				}
			}
		</script>
    </head>
    <!--Inicia body-->
    <body>
		<div id="wrapperSolicitudes" align="center">
            <table border="0" align="center" width="800px">
                <tr>
                    <td align="left" id="breadcrumbs">Usuario: <?php echo $usuarioId; ?></td>
                </tr>
                
                <tr height="80px"><td></td></tr>
                
                <tr>
                    <td align="center" id="titulo1">Reporte en Ceros</td>
                </tr>
                
                <tr height="10px"><td></td></tr>
                
                <tr> 
                    <td align="center" valign="top" height="20px">
                        <table border="0" align="center">
                            <tr height="20px">
                                <td valign="middle">
                                    <img src="../../Imagenes/ICN_PointMeTo.png" id="banana1" style="display:none;" onclick="showBanana(0);">
                                    <img src="../../Imagenes/ICN_PointMeTo.png" id="banana0" style="display:inline-block;" onclick="showBanana(1);">
                                </td>
                                
                                <td valign="middle">
                                    <font style="display:inline-block;"><?php echo $breadcrumb; ?></font>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            
            <table border="0" align="center" id="mapaIntranet" style="display:none;">
                <tr>
                    <td align="center">
                        <table border="0" align="center" id="breadcrumbs" style="border:1px solid #007cbd;">
                            <tr>
                                <td valign="top">
                                    <a href="../../ComunicacionInterna/comunicacionInterna.php" id="breadcrumbs">
                                        Comunicación Interna
                                    </a><br />
                                    
                                    <ul style="list-style-type:square;">
                                        <li>
                                            <a href="../../ComunicacionInterna/TableroBoletines.php" id="breadcrumbs">
                                                Boletines
                                            </a>
                                        </li>
                                        
                                        <li>
                                            <a href="../../ComunicacionInterna/listaQueHacer.php" id="breadcrumbs">
                                                Qué hacer
                                            </a>
                                        </li>
                                        
                                        <li>
                                            <a href="../../ComunicacionInterna/tableroSolicitudesyQuejas.php" id="breadcrumbs">
                                                Solicitudes y Quejas
                                            </a>
                                        </li>
                                        
                                        <li>
                                            <a href="../../ComunicacionInterna/busquedaPersonal.php" id="breadcrumbs">
                                                Acceso Autorizado
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            
                            <tr>
                                <td valign="top">
                                    <a href="../../SistemaGestionIntegral/homeSGI.php" id="breadcrumbs">
                                        Gestión Integral
                                    </a><br />
                                    
                                    <ul style="list-style-type:square;">
                                        <li>
                                            <a href="../../SistemaGestionIntegral/Normas.php" id="breadcrumbs">
                                                Normas
                                            </a><br />
                                            
                                            <ul style="list-style-type: disc;">
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/CapituloNorma.php?norma=ISO" id="breadcrumbs">
                                                        ISO
                                                    </a>
                                                </li>
                                                
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/CapituloNorma.php?norma=NMX" id="breadcrumbs">
                                                        NMX
                                                    </a>
                                                </li>
                                                
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/CapituloNorma.php?norma=NEEC" id="breadcrumbs">
                                                        NEEC
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        
                                        <li>
                                            <a href="../../SistemaGestionIntegral/manuales.php" id="breadcrumbs">
                                                Manuales
                                            </a><br />
                                            
                                            <ul style="list-style-type: disc;">
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/Documento.php?manual=GE-MC" id="breadcrumbs">
                                                        Manual de Gestión Integral
                                                    </a>
                                                </li>
                                                
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/Documento.php?manual=GE-CDR" id="breadcrumbs">
                                                        Manual de Control de Documentos y Registros
                                                    </a>
                                                </li>
                                                
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/Documento.php?manual=GE-AI" id="breadcrumbs">
                                                        Manual de Auditorías Internas
                                                    </a>
                                                </li>
                                                
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/Documento.php?manual=GE-CC" id="breadcrumbs">
                                                        Manual del Comité de Calidad
                                                    </a>
                                                </li>
                                                
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/Documento.php?manual=GE-DG" id="breadcrumbs">
                                                        Manual de Dirección General
                                                    </a>
                                                </li>
                                                
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/Documento.php?manual=GE-ADM" id="breadcrumbs">
                                                        Manual de Administración
                                                    </a>
                                                </li>
                                                
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/Documento.php?manual=GE-RH" id="breadcrumbs">
                                                        Manual de Recursos Humanos
                                                    </a>
                                                </li>
                                                
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/Documento.php?manual=GE-TI" id="breadcrumbs">
                                                        Manual de Tecnologias de la Información
                                                    </a>
                                                </li>
                                                
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/Documento.php?manual=GE-OPE" id="breadcrumbs">
                                                        Manual de Operaciones
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        
                                        <li>
                                            <a href="../../SistemaGestionIntegral/Modulos.php" id="breadcrumbs">
                                                Módulos del SGI
                                            </a><br />
                                            
                                            <ul style="list-style-type: disc;">
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/Riesgos.php" id="breadcrumbs">
                                                        Administración de Riesgos
                                                    </a>
                                                </li>
                                                
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/ReunionesyAcuerdos.php" id="breadcrumbs">
                                                        Reuniones y Acuerdos
                                                    </a>
                                                </li>
                                                
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/tableroPreventivasCorrectivas.php" id="breadcrumbs">
                                                        Acciones Preventivas y Correctivas
                                                    </a>
                                                </li>
                                                
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/tableroAuditorias.php" id="breadcrumbs">
                                                        Auditorías
                                                    </a>
                                                </li>
                                                
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/tableroSeguimientos.php" id="breadcrumbs">
                                                        Seguimientos
                                                    </a>
                                                </li>
                                                
                                                <li>
                                                    <a href="../../SistemaGestionIntegral/Procesos.php" id="breadcrumbs">
                                                        Inventario de Procesos
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                
                                </td>
                            </tr>
                            
                            <tr>
                                <td valign="top">
                                    <a href="../../Aplicaciones/aplicaciones.php" id="breadcrumbs">
                                        Aplicaciones
                                    </a><br />
                                    
                                    <ul style="list-style-type:square;">
                                        <li>
                                            <a href="../../Aplicaciones/operaciones.php" id="breadcrumbs">
                                                Operaciones
                                            </a>
                                        </li>
                                        
                                        <li>
                                            <a href="../../AdministracionProyectos/admonPro.php" id="breadcrumbs">
                                                Administración de Proyectos
                                            </a>
                                        </li>
                                    </ul>
                                    
                                </td>
                            </tr>
                            
                            <tr>
                                <td valign="top">
                                    <a href="../../Registros/Registros.php" id="breadcrumbs">
                                        Registros
                                    </a><br />
                                    
                                    <ul style="list-style-type:square;">
                                        <li>
                                            <a href="../../Registros/TableroVisitas2.php" id="breadcrumbs">
                                                Visitas
                                            </a>
                                        </li>
                                    </ul>
                                    
                                </td>
                            </tr>
                            
                            <tr>
                                <td valign="top">
                                    <a href="../../Configuraciones/configuraciones.php" id="breadcrumbs">
                                        Configuraciones
                                    </a><br />
                                    
                                    <ul style="list-style-type:square;">
                                        <li>
                                            <a href="../../Configuraciones/ModificaPassword.php" id="breadcrumbs">
                                                Contraseñas
                                            </a>
                                        </li>
                                    </ul>
                                    
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            
            <table border="0" align="center">
                <tr height="50px"><td></td></tr>
            </table>
            
            
            <form action="reporteEnCeros.php" method="post">
                <table align="center">
                    <tr id="fileItem">
                        <td align="center">Seleccione año:</td>
                    </tr>
                    
                    <tr>
                        <td align="center">
                            <select name="year">
                                <option value="" selected="selected">Elija una opción...</option>
                                <?php
                                for($o = $currentYear; $o >= 2013; $o--){
                                    
                                    if($year == $o){
                                        
                                        ?>
                                        <option value="<?php echo $o; ?>" selected="selected"><?php echo $o; ?></option>
                                        <?php
                                        
                                    } else{
                                        
                                        ?>
                                        <option value="<?php echo $o; ?>"><?php echo $o; ?></option>
                                        <?php
                                        
                                    }
                                    
                                } unset($o);
                                ?>
                            </select>
                        </td>
                    </tr>
                    
                    <tr height="20px"><td></td></tr>
                    
                    <tr>
                        <td align="center">
                            <input type="image" onclick="SubmitForm(this.form);" src="../../Imagenes/ICN_BotonEnviar.png" width="90px" height="29px">
                        </td>
                    </tr>
                </table>
            </form>
            
            <table border="0" align="center">
            	<tr height="70px"><td colspan='13'></td></tr>
                
            	<tr id="titulo2">
                	<td width="80px" align="center">Patente</td>
                    <td width="60px" align="center">Enero</td>
                    <td width="100px" align="center">Febrero</td>
                    <td width="60px" align="center">Marzo</td>
                    <td width="60px" align="center">Abril</td>
                    <td width="60px" align="center">Mayo</td>
                    <td width="60px" align="center">Junio</td>
                    <td width="60px" align="center">Julio</td>
                    <td width="90px" align="center">Agosto</td>
                    <td width="110px" align="center">Septiembre</td>
                    <td width="110px" align="center">Octubre</td>
                    <td width="110px" align="center">Noviembre</td>
                    <td width="110px" align="center">Diciembre</td>
            	</tr>
                
                <tr height="20px">
                	<td colspan="13" id="titleBlueLineTop"></td>
                </tr>
                
                <?php
				
                for($o = 1; $o <= count($patente); $o++){
					?>
                    <tr id="fileItem" height="40px">
                    	<td align="center" id="titulo12"><b><?php echo $patente[$o]; ?></b></td>
                        
                    	<?php
                        for($a = 1; $a <= 12; $a++){
						
							$numero = 0;
							
							$s = $INTRANET->Execute("SELECT COUNT(*) FROM MASTER_GE.MASTER_PEDIMENTOS MMP WHERE YEAR(MMP.xd_fechaPago) = $year 
													 AND MONTH(MMP.xd_fechaPago) = $a AND MMP.xn_patente = $patente[$o] AND MMP.xn_opVulnerable = 1 ");
							
							while($r = $s->fetchRow()){
								
								$numero = $r[0];
								
							} unset($r);
							
							?>
                            <td align="center">
								<?php
								if($year == $currentYear){
									
									if($a < $currentMonth){
										
										if($numero == 0){
										
											echo $numero;
											?>
											&nbsp;<img src="../../Imagenes/ICN_SemaforoRojoOscuro.png" height="10px" width="10px" />
											<?php
											
										} else if($numero > 0){
											
											echo $numero;
											
										}
										
									} else{
										
										break;
										
									}
									
								} else{
									
									if($numero == 0){
										
										echo $numero;
										?>
										&nbsp;<img src="../../Imagenes/ICN_SemaforoRojoOscuro.png" height="10px" width="10px" />
										<?php
										
									} else if($numero > 0){
										
										echo $numero;
										
									}
									
								}
								?>
                            </td>
                        	<?php
							
						} unset($a);
						?>
                    </tr>
                    <?php
				} unset($o);
				
                ?>
                
                <tr height="20px">
                	<td colspan="13" id="titleBlueLineBottom"></td>
                </tr>
            </table>
            
            <table border="0" align="center">
                <tr height="50px"><td></td></tr>
            </table>
		</div><!--Fin de wrapper-->
	</body><!--Termina body-->
</html><!--Termina html-->
<?
