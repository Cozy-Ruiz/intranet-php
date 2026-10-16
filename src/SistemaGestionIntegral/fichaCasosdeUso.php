<?php error_reporting(0); ?>
<?php
$nombrephp = 'tableroRoles.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

$casoUso          = $_GET['CasoUso'];

//echo "SELECT xt_titulo FROM SGI_Procesos_Roles_Actividades_FuncionalidadesCasosdeUso WHERE kp_codigo = '$codigo'";
$s = $INTRANET->Execute("SELECT
							SKU.kp_codigoCasodeUso,
							SKU.xt_nombre,
							SKU.xt_descripcion,
							SKU.kf_codigoFuncionalidad,
							(SELECT SKF.xt_nombre FROM SGI_K_Funcionalidades SKF WHERE SKF.kp_codigoFuncionalidad = SKU.kf_codigoFuncionalidad) as nombreFun
						FROM
							SGI_K_Casosdeuso SKU
						WHERE
							SKU.kp_codigoCasodeUso = '$casoUso'");
						while($r = $s->fetchRow()){
							$codigoCasoUso = $r[0];
							$nombreCasoUso = $r[1];
							$desCU         = $r[2];
							$codigoFunc    = $r[3];
							$nombreFunc    = $r[4];
	
						}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <script type="text/javascript" src="./../JS/jquery-1.9.1.js"></script>
        <head>
        
        	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
			<title>Ficha de caso de uso</title>
			<?php
				if($estiloUsuario == 1){
	            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
				}else if($estiloUsuario == 2){
	            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
				}
			?>
            
            
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

            <script type="text/javascript">
                function casosdeUso(){

                    var vDescripcion=document.getElementById("listCasoUso");
                    if(vDescripcion.style.display == 'block') {
                        vDescripcion.style.display = 'none';
                    } else {
                        vDescripcion.style.display = 'block';
                    }
                }
            </script>
             <script>
				function mostrarIframe(capa){
					var mostrar = document.getElementById(capa);
					if(mostrar.style.display == 'block'){
						mostrar.style.display = 'none';
					}else{
						mostrar.style.display = 'block';
					}
				}
			</script>
            
             <script>
			
				function inCambioDes(){
					
					var descripcion=document.getElementById("nuevaDescripcion").value;
					var codigoCU = "<?php echo $codigo;?>";
					
					 $('#contDescripcion').load("agregaDescripcionCambioCU.php", {descripcion:descripcion, codigoCU:codigoCU}, function(data){

    				 });
					 
				}
				
			</script>
            
            <script>
			function activaModificaD(descripcion){
				
				
				var vDescripcion=document.getElementById('descripcionAct');
				var vBtnModif=document.getElementById('btnModificar');
                var vBtnModif2=document.getElementById('modifP2');
                var vBtnModif3=document.getElementById('modifP3');
				
				if(vDescripcion.style.display == 'block') {
					
					document.getElementById ('nuevaDescripcion').value = descripcion;
    				vDescripcion.style.display = 'none';
                    vBtnModif2.style.display = 'block';
                    vBtnModif3.style.display = 'block';
					
    			} else {
					
					vDescripcion.style.display = 'block';
                    vBtnModif2.style.display = 'none';
                    vBtnModif3.style.display = 'none';
				}
			}
			
			</script>
            
        </head>
        <body>
<?php

$breadcrumb="<a href='../Home.php' id='breadcrumbs'>Home / </a><a href='homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a> 
			<a href='Modulos.php' id='breadcrumbs'> Módulos / </a><a href='Procesos.php' id='breadcrumbs'> Inventario de procesos </a>";

echo "<div id='wrapper'>";
	echo "<table border='0' align='center' width='1160px' style='margin-top:-110px;'>";
		echo "<tr height='40px'><td></td></tr>";
		echo "<tr>";
			echo "<td id='breadcrumbs' width='1160px' align='left'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		echo "<tr height='20px'><td></td></tr>";
	echo "</table>";
	
	//codigo de menu navegable
	echo "<table border='0' align='center' name='Encabezado'>";
		echo"<tr>";
			echo"<td align='center' id='titulo1'>";
				echo "<font>$nombreCasoUso</font>";
			echo"</td>";
		echo"</tr>";
		echo"<tr>"; 
			echo"<td align='center' valign='top' height='20px'>";
				echo "<table border='0' align='center'>";
					echo "<tr height='20px'>";
						echo "<td valign='middle'>";
							echo "<img src='../Imagenes/ICN_PointMeTo.png' id='banana1' style='display:none;' onclick='showBanana(0);'>";
							echo "<img src='../Imagenes/ICN_PointMeTo.png' id='banana0' style='display:inline-block;' onclick='showBanana(1);'>";
						echo "</td>";
						echo "<td valign='middle'>";
							echo "<font style='display:inline-block;'>".$breadcrumb."</font>";
						echo "</td>";
					echo "</tr>";
				echo "</table>";
			echo"</td>";
		echo"</tr>";
	echo "</table>";
	
	
		//banana de navegacion intranet
			echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
					include("../navegacion_banana.php");
				echo "</table>";
		
			echo "<table border='0' align='center'>";
				echo"<tr height='100'><td></td></tr>";
			echo "</table>"; 
		echo"</table>";

		echo "<div id='contDescripcion'>";
			//CODIGO DEL REPORTE
        	echo "<table border='0' align='center' name='Cuerpo'>";
                echo "<tr>";
                    echo "<td align='left' width='100%' id='titulo2'>Código del Caso de uso</td>";
                    echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px'></td>";
                echo "</tr>";                
                //Linea
                echo "<tr>";
                    echo "<td id='titleBlueLineBottom' colspan='3' width='100%'></td>";
                echo "</tr>";            
                echo "<tr height='25'></tr>";            
            echo"</table>";

            echo "<table border='0' cellspacing='0'>";
                echo "<tr>";
                    echo "<td style='padding:0px 0px 0px 25px; s'>";
                        echo "<font size='4px'>".$casoUso.": ".$nombreCasoUso."</font>";
                    echo "</td>";
                echo "</tr>";    
                echo "<tr height='25'></tr>";           
            echo"</table>";
            echo "<br>";
             //DESCRIPCION
            echo "<table border='0' align='center' name='Cuerpo'>";
                echo "<tr>";
                    echo "<td align='left' width='100%' id='titulo2'>Funcionalidad relacionada</td>";
                    echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px'></td>";
                echo "</tr>";                
                //Linea
                echo "<tr>";
                    echo "<td id='titleBlueLineBottom' colspan='3' width='100%'></td>";
                echo "</tr>";            
                echo "<tr height='25'></tr>";            
            echo"</table>";
            echo "<table border='0' cellspacing='0'>";
                echo "<tr>";
                    echo "<td style='padding:0px 0px 0px 25px;'>";
					
                        echo "<a href='http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/fichaFuncionalidadCasoUso.php?funcionalidad=$codigoFunc'><font size='4px'>$codigoFunc - $nombreFunc</font></a>";
                    echo "</td>";
                echo "</tr>";    
                echo "<tr height='25'></tr>";           
            echo"</table>";//DESCRIPION

			echo "<table border='0' align='center' name='Cuerpo'>";
		
				echo "<tr>";
					echo "<td align='left' width='100%' id='titulo2'>Descripción</td>";
					echo "<td align='right' width='15px' style='padding:0px 0px 0px 20px'>";
					echo "</td>";
				echo "</tr>";
				
				//Linea
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='3' width='100%'></td>";
				echo "</tr>";
			
				echo "<tr height='25'></tr>";
			
			echo"</table>";
			
			echo "<table border='0' width='100%' cellspacing='0'>";
				if($desCU != ''){
					echo "<tr>";
						echo "<td style='padding:0px 0px 0px 25px;' id='modifP2'>";
							echo "$desCU"; 
						echo "</td>";
					echo "</tr>";
                    echo "<tr>";
                        echo "<td id='modifP3'>";
                            ?>
                            <a  style='float:right;cursor:pointer;' onClick="activaModificaD('<?php echo $desCU; ?>')"><font color='#007CBD'>Modificar</font></a>
                            <?php
                        echo "</td>";
                    echo "</tr>";
					echo "<tr>";	
						echo "<td padding:0px 0px 0px 25px;' id='descripcionAct' style='display:none;'>";
							echo "<textarea id='nuevaDescripcion' type='text'  rows='3'  cols='75' name='nuevaDescripcion'>$desCU</textarea>";
							?>                         
	                         <a style='cursor:pointer' href="javascript:void(0);" id="modifP"  onClick="inCambioDes()"><font color='#007CBD'>Agregar</font></a>
	                        <?php
						echo "</td>";
					echo "</tr>";
				}else{
					echo "<tr>";	
						echo "<td padding:0px 0px 0px 25px;'>";
							echo "<textarea id='nuevaDescripcion' type='text'  rows='3'  cols='75' name='nuevaDescripcion'></textarea>";
							?>                         
	                         <a  style='cursor:pointer' id="modifP"  onClick="inCambioDes()"><font color='#007CBD'>Agregar</font></a>
	                        <?php
						echo "</td>";
					echo "</tr>";					
				}	
				echo "<tr height='25'></tr>";	
		
			echo"</table>";
			
			
			//DOCUMENTACION
		echo "<table border='0' align='center' width='100%' cellspacing='0'>";
			
			echo "<tr>";
				echo "<td align='left' width='685px' id='titulo2'>Documentación</td>";
				echo "<td width='15px'><a href='tipoDoctosPopUp.php?codigo=".$codigo."&usuario=$usuarioId&nombre=fichaCasosdeUso.php' target='popup' onclick=\"window.open(this.href,this.target,'width=300,height=400,scrollbars=yes')\"><img src='../Imagenes/ICN_BotonMas.png' height='15' width='15'> </a></td>";   
			echo "</tr>";
			
			echo "<tr>";
				echo "<td colspan='2' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
				 echo "</td>";
			echo "</tr>"; 
			
			echo "<tr height='10'></tr>";
			
		echo "</table>";
		
		
            
            //Listo todos los tipos de documentación
            //echo "SELECT xt_tipoDocumento FROM SG_Backlog_Documentos WHERE xt_quejaSolicitud = '$solicitudID'";
            $s = $INTRANET->Execute("SELECT DISTINCT xt_tipoDocumento FROM SGI_Documentos_Actividades_Funcionalidades_CasosdeUso WHERE xt_codigo = '".$codigo."'");
            
            $indexTotalDoc = 0;
            $trPos = 0;
            while($row = $s->fetchRow()){   
                $trPos ++;
                $trPosF = "trFile".$trPos;
                
                echo "<table border='0' width='100%'>";
                
                    echo "<tr>";
                        echo "<td>";
                                echo "<input type='hidden' name='tipoDoc' id='tipoDoc' value='$row[0]'>";
                                //echo "<b> $row[0] </b>";
                                echo "<br>";
                            echo "</td>";
                    echo "</tr>";
                
                    echo "<tr>";
                        echo "<td width='30px'></td>";
                        echo "<td align='left' style='font-size:16px;color:#007CBD;'>$row[0]</td>";
                        echo "<td width='15px'></td>";
                        echo "<td width='15px'>";
                        ?>
                            <a href='javascript:void(0);' onclick='mostrarIframe("<?php echo $trPosF; ?>");'><img  src="../../INTRANET_GEA/Imagenes/ICN_NuevoDoc.png" height='15' width='15'/></a>     
                        <?php
                        echo "</td>";
                    echo "</tr>";
                
                    echo "<tr>";
                        echo "<td width='30px'></td>";
                        echo "<td colspan='3'   style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
                        echo "</td>";
                    echo "</tr>";
					
					echo "<tr height='10'></tr>";
       			  echo "</table>";
                      
                    //consulto archivo correspondiente al tipo de documento
					//echo"SELECT  xt_nombreArchivo, xt_usuario, xd_fecha, xt_rutaArchivo FROM SGI_Documentos_Actividades_Funcionalidades_CasosdeUso WHERE xt_tipoDocumento = '$row[0]' AND xt_codigo = '$codigoAct'";
                    $doc = $INTRANET->Execute("SELECT xt_nombreArchivo, xt_usuario, xd_fecha, xt_rutaArchivo FROM SGI_Documentos_Actividades_Funcionalidades_CasosdeUso WHERE xt_tipoDocumento = '$row[0]' AND xt_codigo = '".$codigo."'");
                
                    $numDoc = 0;
                    while ($listA = $doc -> fetchRow()){
                        if(!empty($listA[0])){
							//echo"$listA[0]--$listA[3]---";
                            echo "<table border='0' width='100%'>";
                                echo "<tr>";
                                    echo "<td width='30px'></td>";
                                    echo "<td style='padding:0px 0px 0px 15px;'><font size=2>$listA[0]</font></td>";
                                    echo "<td><a href='http://71.144.19.155/INTRANET_GEA/SistemaGestionIntegral/eliminaDoctosFichaActividad.php?codigo=".$codigo."&proceso=".$proceso."&actividad=".$actividad."&nombrephp=fichaFuncionalidadCasoUso.php&rol=".$rol."&nombreA=".$listA[0]."&ruta=".$listA[3]."'><img src='../../Imagenes/ICN_NoOK.png' height='13' width='13'/></a></td>";
                                    echo "<td><a href='http://71.144.19.155/INTRANET_GEA/SistemaGestionIntegral/extraccionDoctosReporte.php?nombreA=".$listA[0]."&ruta=".$listA[3]."'><img src='../../Imagenes/ICN_Archivo.png' height='15' width='12' /></a></td>";
                                echo "</tr>";
                
                                echo "<tr>";
                                    echo "<td width='30px'></td>";
                        
                                    echo "<td style='color:#636262; padding:0px 0px 0px 30px'><i><font size=2>$listA[1], $listA[2]</font></i></td>";
                                //echo "<td>[Nombre Usuario] 2015-11-22 14:28:00</td>";
                                echo "</tr>";
                                
                                echo "<tr height='10'></tr>";
                            echo "</table>";
                        }//fin del if de verificaion de que exite archivo
                        $numDoc ++;
                    }//fin del while de archivos*/
                echo "</table>";
                //fila del formulario para subir archivo
                echo "<table border='0' style='width: 100%' cellspacing='0'>";
                    echo "<tr id='$trPosF' style='display: none'>";
                        echo "<td width='250px'></td>";
                        echo "<td>";
						
                            echo "<div id='divFile'>";
                                echo "<iframe src='http://71.144.19.155/INTRANET_GEA/SistemaGestionIntegral/uploadArchivosActividadFuncionalidad.php?codigo=".$codigo."&proceso=".$proceso."&actividad=".$actividad."&rol=".$rol."&tipoArchivo=".$row[0]."&usuario=".$usuarioId."&nombrephp=fichaCasosdeUso.php' frameborder='0' width='800px' height='150px'></iframe><br>";
                            echo "</div>";
                        echo"</td>";
                    echo "</tr>";
					echo "<tr height='10'></tr>";
                echo "</table>";
           // echo "</div>";
	
			}
       		//PIE DE PAGINA
           echo "<br><br>";
			echo "<table border='0' align='center' name='Cuerpo' width='100%'>";
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='3' width='100%'></td>";
				echo "</tr>";
				echo "<tr>";
					echo "<td id='nota_al_pie'>";
						echo "<center>Created by: Grupo Escalante Agencias Aduanales.</center>";
					echo "</td>";
				echo "</tr>";
			echo "</table>";
		echo "<br><br>";