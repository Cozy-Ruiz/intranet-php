<?php error_reporting(0); ?>
<?php
$moduloScript = "Configuracion";
$oficinaScrpt = "";

require_once("../conexionMasterDB.php");
require_once("../compruebaUsuario.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8">
        <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
		<title>Administrador de Perfiles</title>
		<?php
			if($sesionEstilo == 1){
				echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($sesionEstilo == 2){
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
    </head>
    <body>
<?php

$breadcrumb="<a href='https://escalante.com.mx/Sistemas/seleccionaSistema.php' id='breadcrumbs'>Home / </a><a href='https://escalante.com.mx/Sistemas/Configuraciones/configuraciones.php' id='breadcrumbs'> Configuraciones</a> ";

echo "<div id='wrapper' align='center'>";
	echo "<table border='0' align='center' width='1160px' style='margin-top:-110px;'>";
		echo "<tr height='40px'><td></td></tr>";
		echo "<tr>";
			echo "<td id='breadcrumbs' width='1160px' align='left'>Usuario: ".$sesionUsuario."</td>";
		echo "</tr>";
		echo "<tr height='20px'><td></td></tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' name='Encabezado'>";
		echo "<tr>";
			echo "<td align='center' id='titulo1'>";
				echo "<font>Administrador de Perfiles</font>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='10'> </tr>";
		
		echo "<tr>"; 
			echo "<td align='center' valign='top' height='20px'>";
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
			echo "</td>";
		echo "</tr>";
	echo "</table>";
	
	echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
		echo "<tr>";
			echo "<td align='center'>";
			
				?>
                <table border='0' align='center' id='breadcrumbs' style='border:1px solid #007cbd;'>
                    <tr>
                        <td valign='top'>
                            <a href='../ComunicacionInterna/comunicacionInterna.php' id='breadcrumbs'>
                                Comunicación Interna
                            </a><br />
                            
                            <ul style='list-style-type:square;'>
                                <li>
                                    <a href='../ComunicacionInterna/TableroBoletines.php' id='breadcrumbs'>
                                        Boletines
                                    </a>
                                </li>
                                <li>
                                    <a href='../ComunicacionInterna/listaQueHacer.php' id='breadcrumbs'>
                                        Qué hacer
                                    </a>
                                </li>
                                <li>
                                    <a href='../ComunicacionInterna/tableroSolicitudesyQuejas.php' id='breadcrumbs'>
                                        Solicitudes y Quejas
                                    </a>
                                </li>
                                <li>
                                    <a href='../ComunicacionInterna/busquedaPersonal.php' id='breadcrumbs'>
                                        Acceso Autorizado
                                    </a>
                                </li>
                            </ul>
                        
                        </td>
                    </tr>
                    <tr>
                        <td valign='top'>
                            <a href='../SistemaGestionIntegral/homeSGI.php' id='breadcrumbs'>
                                Gestión Integral
                            </a><br />
                            
                            <ul style='list-style-type:square;'>
                                <li>
                                    <a href='../SistemaGestionIntegral/Normas.php' id='breadcrumbs'>
                                        Normas
                                    </a><br />
                                    
                                    <ul style='list-style-type: disc;'>
                                        <li>
                                            <a href='../SistemaGestionIntegral/CapituloNorma.php?norma=ISO' id='breadcrumbs'>
                                                ISO
                                            </a>
                                        </li>
                                        <li>
                                            <a href='../SistemaGestionIntegral/CapituloNorma.php?norma=NMX' id='breadcrumbs'>
                                                NMX
                                            </a>
                                        </li>
                                        <li>
                                            <a href='../SistemaGestionIntegral/CapituloNorma.php?norma=NEEC' id='breadcrumbs'>
                                                NEEC
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href='../SistemaGestionIntegral/manuales.php' id='breadcrumbs'>
                                        Manuales
                                    </a><br />
                                    
                                    <ul style='list-style-type: disc;'>
                                        <li>
                                            <a href='../SistemaGestionIntegral/Documento.php?manual=GE-MC' id='breadcrumbs'>
                                                Manual de Gestión Integral
                                            </a>
                                        </li>
                                        <li>
                                            <a href='../SistemaGestionIntegral/Documento.php?manual=GE-CDR' id='breadcrumbs'>
                                                Manual de Control de Documentos y Registros
                                            </a>
                                        </li>
                                        <li>
                                            <a href='../SistemaGestionIntegral/Documento.php?manual=GE-AI' id='breadcrumbs'>
                                                Manual de Auditorías Internas
                                            </a>
                                        </li>
                                        <li>
                                            <a href='../SistemaGestionIntegral/Documento.php?manual=GE-CC' id='breadcrumbs'>
                                                Manual del Comité de Calidad
                                            </a>
                                        </li>
                                        <li>
                                            <a href='../SistemaGestionIntegral/Documento.php?manual=GE-DG' id='breadcrumbs'>
                                                Manual de Dirección General
                                            </a>
                                        </li>
                                        <li>
                                            <a href='../SistemaGestionIntegral/Documento.php?manual=GE-ADM' id='breadcrumbs'>
                                                Manual de Administración
                                            </a>
                                        </li>
                                        <li>
                                            <a href='../SistemaGestionIntegral/Documento.php?manual=GE-RH' id='breadcrumbs'>
                                                Manual de Recursos Humanos
                                            </a>
                                        </li>
                                        <li>
                                            <a href='../SistemaGestionIntegral/Documento.php?manual=GE-TI' id='breadcrumbs'>
                                                Manual de Tecnologias de la Información
                                            </a>
                                        </li>
                                        <li>
                                            <a href='../SistemaGestionIntegral/Documento.php?manual=GE-OPE' id='breadcrumbs'>
                                                Manual de Operaciones
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href='../SistemaGestionIntegral/Modulos.php' id='breadcrumbs'>
                                        Módulos del SGI
                                    </a><br />
                                    
                                    <ul style='list-style-type: disc;'>
                                        <li>
                                            <a href='../SistemaGestionIntegral/Riesgos.php' id='breadcrumbs'>
                                                Administración de Riesgos
                                            </a>
                                        </li>
                                        <li>
                                            <a href='../SistemaGestionIntegral/ReunionesyAcuerdos.php' id='breadcrumbs'>
                                                Reuniones y Acuerdos
                                            </a>
                                        </li>
                                        <li>
                                            <a href='../SistemaGestionIntegral/tableroPreventivasCorrectivas.php' id='breadcrumbs'>
                                                Acciones Preventivas y Correctivas
                                            </a>
                                        </li>
                                        <li>
                                            <a href='../SistemaGestionIntegral/tableroAuditorias.php' id='breadcrumbs'>
                                                Auditorías
                                            </a>
                                        </li>
                                        <!-- -->
                                        <li>
                                            <a href='../SistemaGestionIntegral/Procesos.php' id='breadcrumbs'>
                                                Inventario de Procesos
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        
                        </td>
                    </tr>
                    <tr>
                        <td valign='top'>
                            <a href='../Aplicaciones/aplicaciones.php' id='breadcrumbs'>
                                Aplicaciones
                            </a><br />
                            
                            <ul style='list-style-type:square;'>
                                <li>
                                    <a href='../Aplicaciones/operaciones.php' id='breadcrumbs'>
                                        Operaciones
                                    </a>
                                </li>
                                <li>
                                    <a href='../AdministracionProyectos/admonPro.php' id='breadcrumbs'>
                                        Administración de Proyectos
                                    </a>
                                </li>
                            </ul>
                            
                        </td>
                    </tr>
                    <tr>
                        <td valign='top'>
                            <a href='../Registros/Registros.php' id='breadcrumbs'>
                                Registros
                            </a><br />
                            
                            <ul style='list-style-type:square;'>
                                <li>
                                    <a href='../Registros/TableroVisitas2.php' id='breadcrumbs'>
                                        Visitas
                                    </a>
                                </li>
                                <li>
                                    <a href='../Registros/tableroRegistros.php' id='breadcrumbs'>
                                        Registros
                                    </a>
                                </li>
                            </ul>
                            
                        </td>
                    </tr>
                    <tr>
                        <td valign='top'>
                            <a href='../Configuraciones/configuraciones.php' id='breadcrumbs'>
                                Configuraciones
                            </a><br />
                            
                            <ul style='list-style-type:square;'>
                                <li>
                                    <a href='../Configuraciones/ModificaPassword.php' id='breadcrumbs'>
                                        Contraseñas
                                    </a>
                                </li>
                            </ul>
                            
                        </td>
                    </tr>
                </table>
                <?php
			echo "</td>";
		echo "</tr>";
	echo "</table>";
		
	echo "<table border='0' align='center'>";
		echo "<tr height='100'><td></td></tr>";
	echo "</table>";

	echo "<table border='0' align='center' name='cuerpo'>";
	
		echo "<tr>";
			echo "<td colspan='4' width='600' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='20'> </tr>";
	
		echo "<tr>";
			echo "<td width='160'> </td>";
			echo "<td width='220' align='left' id='iconosTexto'>";
				echo "Nueva oficina";
			echo "</td>";
			echo "<td width='20' align='left' >";
				echo "<a href='altaOficina.php' target='popup' onclick=\"window.open(this.href,this.target,'width=400,height=500,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a> ";
			echo "</td>";
			echo "<td width='200'> </td>";
		echo "</tr>";
		
		echo "<tr height='10'> </tr>";
		
		echo "<tr>";
			echo "<td width='160'> </td>";
			echo "<td width='220' align='left' id='iconosTexto'>";
				echo "Nuevo rol";
			echo "</td>";
			echo "<td width='20' align='left' >";
				echo "<a href='altaRol.php' target='popup' onclick=\"window.open(this.href,this.target,'width=400,height=500,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a> ";
			echo "</td>";
			echo "<td width='200'> </td>";
		echo "</tr>";
		
		echo "<tr height='10'> </tr>";
		
		echo "<tr>";
			echo "<td width='160'> </td>";
			echo "<td width='220' align='left' id='iconosTexto'>";
				echo "Nuevo modulo";
			echo "</td>";
			echo "<td width='20' align='left' >";
				echo "<a href='altaModulo.php' target='popup' onclick=\"window.open(this.href,this.target,'width=400,height=500,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a> ";
			echo "</td>";
			echo "<td width='200'> </td>";
		echo "</tr>";
		
		echo "<tr height='10'> </tr>";
		
		echo "<tr>";
			echo "<td width='160'> </td>";
			echo "<td width='220' align='left' id='iconosTexto'>";
				echo "Nuevo proceso";
			echo "</td>";
			echo "<td width='20' align='left' >";
				echo "<a href='altaProceso.php' target='popup' onclick=\"window.open(this.href,this.target,'width=400,height=500,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a> ";
			echo "</td>";
			echo "<td width='200'> </td>";
		echo "</tr>";
		
		echo "<tr height='10'> </tr>";
		
		
		echo "<tr>";
			echo "<td width='160'> </td>";
			echo "<td width='220' align='left' id='iconosTexto'>";
				echo "Nueva actividad";
			echo "</td>";
			echo "<td width='20' align='left' >";
				echo "<a href='altaActividad.php' target='popup' onclick=\"window.open(this.href,this.target,'width=400,height=500,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a> ";
			echo "</td>";
			echo "<td width='200'> </td>";
		echo "</tr>";
		
		echo "<tr height='10'> </tr>";
		
		echo "<tr>";
			echo "<td width='160'> </td>";
			echo "<td width='220' align='left' id='iconosTexto'>";
				echo "Nueva funcionalidad";
			echo "</td>";
			echo "<td width='20' align='left' >";
				echo "<a href='altaFuncionalidad.php' target='popup' onclick=\"window.open(this.href,this.target,'width=400,height=600,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a> ";
			echo "</td>";
			echo "<td width='200'> </td>";
		echo "</tr>";
		
		echo "<tr height='10'> </tr>";
		
		echo "<tr>";
			echo "<td width='160'> </td>";
			echo "<td width='220' align='left' id='iconosTexto'>";
				echo "Nueva Categoria Usuario";
			echo "</td>";
			echo "<td width='20' align='left' >";
				echo "<a href='altaNuevaCategoriaUsuario.php' target='popup' onclick=\"window.open(this.href,this.target,'width=500,height=500,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a> ";
			echo "</td>";
			echo "<td width='200'> </td>";
		echo "</tr>";
		
		echo "<tr height='10'> </tr>";


        echo "<tr>";
            echo "<td width='160'> </td>";
            echo "<td width='220' align='left' id='iconosTexto'>";
            echo "Nuevo Usuario V2";
            echo "</td>";
            echo "<td width='20' align='left' >";
                echo "<a href='newUser.php' target='popup' onclick=\"window.open(this.href,this.target,'width=800,height=600,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a> ";
            echo "</td>";
            echo "<td width='200'> </td>";
        echo "</tr>";

echo "<tr height='10'> </tr>";

	
		echo "<tr>";
			echo "<td width='160'> </td>";
			echo "<td width='220' align='left' id='iconosTexto'>";
			echo "Nuevo Usuario ";
			echo "</td>";
			echo "<td width='20' align='left' >";
				echo "<a href='altaNuevoUsuario.php' target='popup' onclick=\"window.open(this.href,this.target,'width=400,height=680,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a> ";
			echo "</td>";
			echo "<td width='200'> </td>";
		echo "</tr>";
		
		echo "<tr height='10'> </tr>";		
	
		echo "<tr>";
			echo "<td width='160'> </td>";
			echo "<td width='220' align='left' id='iconosTexto'>";
				echo "Alta Oficina usuario";
			echo "</td>";
			echo "<td width='20' align='left' >";
				echo "<a href='altaOficinaUsuario.php' target='popup' onclick=\"window.open(this.href,this.target,'width=400,height=500,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a> ";
			echo "</td>";
			echo "<td width='200'> </td>";
		echo "</tr>";
		
		echo "<tr height='10'> </tr>";
		
		echo "<tr>";
			echo "<td width='160'> </td>";
			echo "<td width='220' align='left' id='iconosTexto'>";
				echo "Alta Cliente Usuario";
			echo "</td>";
			echo "<td width='20' align='left' >";
				echo "<a href='agregaUsuarioClientes.php' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=500,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a> ";
			echo "</td>";
			echo "<td width='200'> </td>";
		echo "</tr>";
		
		echo "<tr height='10'> </tr>";
		
		echo "<tr>";
			echo "<td width='160'> </td>";
			echo "<td width='220' align='left' id='iconosTexto'>";
				echo "Alta Rol Usuario";
			echo "</td>";
			echo "<td width='20' align='left' >";
				echo "<a href='altaRolUsuario.php' target='popup' onclick=\"window.open(this.href,this.target,'width=400,height=500,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a> ";
			echo "</td>";
			echo "<td width='200'> </td>";
		echo "</tr>";
		
		echo "<tr height='10'> </tr>";
		
		
		echo "<tr>";
			echo "<td width='160'> </td>";
			echo "<td width='220' align='left' id='iconosTexto'>";
				echo "Alta Modulo Usuario";
			echo "</td>";
			echo "<td width='20' align='left' >";
				echo "<a href='altaModuloUsuario.php' target='popup' onclick=\"window.open(this.href,this.target,'width=400,height=500,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a> ";
			echo "</td>";
			echo "<td width='200'> </td>";
		echo "</tr>";
		
		echo "<tr height='10'> </tr>";
		
		
		echo "<tr>";
			echo "<td width='160'> </td>";
			echo "<td width='220' align='left' id='iconosTexto'>";
				echo "Alta Proceso usuario ";
			echo "</td>";
			echo "<td width='20' align='left' >";
				echo "<a href='altaProcesoUsuario.php' target='popup' onclick=\"window.open(this.href,this.target,'width=400,height=500,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a> ";
			echo "</td>";
			echo "<td width='200'> </td>";
		echo "</tr>";
		
		echo "<tr height='10'> </tr>";
		
		echo "<tr>";
			echo "<td width='160'> </td>";
			echo "<td width='220' align='left' id='iconosTexto'>";
				echo "Alta Actividades Usuario";
			echo "</td>";
			echo "<td width='20' align='left' >";
				echo "<a href='altaActividadesUsuario.php' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=500,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a> ";
			echo "</td>";
			echo "<td width='200'> </td>";
		echo "</tr>";
		
		echo "<tr height='10'> </tr>";
		/*
		echo "<tr>";
			echo "<td width='160'> </td>";
			echo "<td width='220' align='left' id='iconosTexto'>";
				echo "Alta Funcionalidades Usuario";
			echo "</td>";
			echo "<td width='20' align='left' >";
				echo "<a href='altaFuncionalidadesUsuario.php' target='popup' onclick=\"window.open(this.href,this.target,'width=600,height=600,scrollbars=yes')\"><img src='../Imagenes/ICN_Boton_Azul.png'></a> ";
			echo "</td>";
			echo "<td width='200'> </td>";
		echo "</tr>";
		
		echo "<tr height='10'> </tr>";
		*/		
		echo "<tr>";
			echo "<td width='160'> </td>";
			echo "<td width='220' align='left' id='iconosTexto'>";
				echo "Alta Funcionalidad Usuario ";
			echo "</td>";
			echo "<td width='20' align='left' >";
				echo "<a href='modificaPerfilUsuario.php?administra=true'><img src='../Imagenes/ICN_Boton_Azul.png'></a> ";
			echo "</td>";
			echo "<td width='200'> </td>";
		echo "</tr>";

        echo "<tr height='10'> </tr>";

        echo "<tr>";
			echo "<td width='160'> </td>";
			echo "<td width='220' align='left' id='iconosTexto'>";
				echo "Alta Usuario ";
			echo "</td>";
			echo "<td width='20' align='left' >";
				echo "<a href='https://react.escalante.com.mx:2053/Sistemas/Intranet/Perfiles/AltaUsuario'><img src='../Imagenes/ICN_Boton_Azul.png'></a> ";
			echo "</td>";
			echo "<td width='200'> </td>";
		echo "</tr>";

        echo "<tr height='10'> </tr>";

        echo "<tr>";
			echo "<td width='160'> </td>";
			echo "<td width='220' align='left' id='iconosTexto'>";
				echo "Detalle Usuario ";
			echo "</td>";
			echo "<td width='20' align='left' >";
				echo "<a href='https://react.escalante.com.mx:2053/Sistemas/Intranet/Perfiles/DetalleUsuario'><img src='../Imagenes/ICN_Boton_Azul.png'></a> ";
			echo "</td>";
			echo "<td width='200'> </td>";
		echo "</tr>";
		
		echo "<tr height='20'> </tr>";
		
		echo "<tr>";
			echo "<td colspan='4' width='600' style='border-style:solid;border-color:#007cbd;border-top-width:1px;border-bottom:none;border-left:none;border-right:none;'>";
			echo "</td>";
		echo "</tr>";
	
	echo "</table>";


echo "</div>";


?>
</body>
</html>