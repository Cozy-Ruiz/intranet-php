<?php error_reporting(0); ?>
<?php
$nombrephp='ayudaSolicitud.php';
require_once("../../../ConexionDBT.php");
require_once("../../../ConexionIntranet2.php");
require_once("../../../compruebaUsuario.php");


$codigoSolicitud = array();
$index = 0;
$s = $INTRANETV2->Execute("SELECT
    xt_quejaSolicitud,
    xt_tipoSolicitud,
    xt_titulo
FROM
    SGI_Quejas_Solicitudesv2 
WHERE
    xt_status = 'REVISION'
AND kf_usuarioId = 'Karla_Cruz'
AND xt_tipoSolicitud not in('PY','DS')
ORDER BY xd_fecha DESC
            ");
while($r = $s->fetchRow()){

    $codigoSolicitud[$index] = $r[0];
    $tipoSolicitud[$index]   = $r[1];
    $titulo[$index]          = $r[2];

    $index++;

}


$breadcrumb="<a href='../../../Home.php' id='breadcrumbs'>Home / </a><a href='../../comunicacionInterna.php' id='breadcrumbs'>Comunicación Interna / </a>
            <a href='tableroSolicitudesyQuejasv2.php' id='breadcrumbs'> Solicitudes</a>";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8">
        <title>Ayuda Solicitud</title>
        <?php
        if($estiloUsuario == 1){
            ?>
            <link type='text/css' rel='stylesheet' href='../../../css/styleHomePage.css'/>
            <?php
        }else if($estiloUsuario == 2){
            ?>
            <link type='text/css' rel='stylesheet' href='../../../css/styleHomePage2.css'/>
            <?php
        }
        ?>
        
        <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">        
        <script type="text/javascript">
            function reCargarPadre(){
                opener.location.reload();
                window.close();
            }
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
    <body>
<?php


echo"<div id='wrapperFicha' align='center'>";
    
    echo "<table border='0' align='center' name='Encabezado' width='700px'>";
    
        echo "<tr height='12px'>";
            echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId." </td>";
        echo "</tr>";
        
        echo"<tr height='20px'> </tr>";
        echo"<tr>";
            echo"<td align='center' id='titulo1'>";
                echo "<font>Solicitud</font>";
            echo"</td>";
        echo"</tr>";
        echo"<tr>"; 
            echo"<td align='center' valign='top' height='20px'>";
                echo "<table border='0' align='center'>";
                    echo "<tr height='20px'>";
                        echo "<td valign='middle'>";
                            echo "<img src='../../../Imagenes/ICN_PointMeTo.png' id='banana1' style='display:none;' onclick='showBanana(0);'>";
                            echo "<img src='../../../Imagenes/ICN_PointMeTo.png' id='banana0' style='display:inline-block;' onclick='showBanana(1);'>";
                        echo "</td>";
                        
                        echo "<td valign='middle'>";
                            echo "<font style='display:inline-block;'>".$breadcrumb."</font>";
                        echo "</td>";
                    echo "</tr>";
                echo "</table>";
            echo"</td>";
        echo"</tr>";
        //echo"<tr height='70'> </tr>";
    echo "</table>";
    
    echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
        include("../../../navegacion_banana.php");
    echo "</table>";
            
        
    echo "<table border='0' align='center'>";
        echo"<tr height='100'><td></td></tr>";
    echo "</table>"; 

        
    if(count($codigoSolicitud) > 0){

        echo "<table border='0' align='left' width='800'>";
            echo "<tr>";
                echo "<td id='titleBlueLineBottom' colspan='2'></td>";
            echo "</tr>";
            echo"<tr height='30'> </tr>";
            echo"<tr>";
                echo"<td id='titulo12'>";
                    echo '<i>Conforme a lo establecido en el procedimiento en atención de solicitudes "CRP-AD-GRL-P-0144", no puedes levantar una solicitud nueva mientras no cierres las pendientes ('.count($codigoSolicitud).').</i>';
                echo"</td>";
            echo"</tr>";
            echo"<tr height='30'> </tr>";
        echo "</table>";


        echo "<table border='0' align='left' width='800px'>";
            echo"<tr>";
                    echo"<td id='titulo12' width='200px'>";
                        echo '<b>Código</b>';
                    echo"</td>";
                    echo"<td id='titulo12' width='600px'>";
                        echo '<b>Descripción</b>';
                    echo"</td>";
            echo"</tr>";
            echo"<tr height='15'> </tr>";
            for($a=0; $a<count($codigoSolicitud); $a++){    
                echo"<tr>";
                    echo"<td id='titulo12' width='200px'>";
                        if($tipoSolicitud[$a] == 'MT'){
                            echo"<a href='fichaMantenimiento_Sistema.php?codigo=$codigoSolicitud[$a]' style='text-decoration:none;'>".$codigoSolicitud[$a]."</a>";
                        }else if($tipoSolicitud[$a] == 'AV'){
                            echo"<a href='fichaSolicitudv2.php?coodigo=$codigoSolicitud[$a]' style='text-decoration:none;'>".$codigoSolicitud[$a]."</a>";
                        }else if($tipoSolicitud[$a] == 'EA'){
                            echo"<a href='fichaEnvioArchivos.php?codigo=$codigoSolicitud[$a]' style='text-decoration:none;'>".$codigoSolicitud[$a]."</a>";
                        }else if($tipoSolicitud[$a] == 'AB'){
                            echo"<a href='fichaAltaBajaUsuario.php?codigo=$codigoSolicitud[$a]' style='text-decoration:none;'>".$codigoSolicitud[$a]."</a>";
                        }else if($tipoSolicitud[$a] == 'ST'){
                            echo "<a href='fichaSoporteTecnico.php?codigo=$codigoSolicitud[$a]' style='text-decoration:none;'>".$codigoSolicitud[$a]."</a>";
                        }
                    echo"</td>";
                    echo"<td id='titulo12' width='600px'>";
                        echo $titulo[$a];
                    echo"</td>";
                echo"</tr>";
                echo"<tr height='5'> </tr>";
            }
            echo"<tr height='30'> </tr>";
        echo "</table>";

         echo "<table border='0' align='left' width='800px'>";
            echo "<tr>";
                echo "<td id='titleBlueLineBottom' colspan='2'></td>";
            echo "</tr>";
            echo"<tr height='30'> </tr>";
        echo "</table>";
    
    

    }else{

    //CUERPO SOLICITUD
        echo "<table border='0' align='left' width='700'>";
            echo"<tr>";
                echo"<td id='titulo2' style='font-size:22px;'>";
                    echo "<b>¿Qué tipo de solicitud necesitas?</b>";
                echo"</td>";
            echo"</tr>";

        echo "</table>";
        
        echo "<table border='0' align='left' width='700'>";
            echo "<tr>";
                echo "<td id='titleBlueLineBottom' colspan='2'></td>";
            echo "</tr>";
            
            echo"<tr height='30'> </tr>";
        echo "</table>";

        //ADMINISTRATIVA

        echo "<table border='0' align='left' width='700'>";
            echo "<tr>";
                echo "<td style='font-size:20px;width:550px;' >Administrativa</td>";
                echo "<td><a href='altaSolicitudQuejaPopUpv2.php'><img src='../../../Imagenes/ICN_BotonAgregar.png' style='width:95%;' ></a></td>";
            echo "</tr>";
            echo"<tr height='20'></tr>";
        echo "</table>";
        
        echo "<table border='0' align='left' width='700'>";
            echo "<tr>";
                echo  "<td width='50'></td>";
                echo "<td width='650' style='text-align:justify; font-size:16px;'>";
                        echo "Son las relacionadas con peticiones propias de los procesos administrativos y
                                de recursos humanos de la organización. Por ejemplo, asuntos relacionados
                                con los inmuebles o instalaciones; petición de recursos.";
                echo "</td>";
            echo "</tr>";
            echo "<tr height='15'></tr>";
            echo "<tr>";
                echo  "<td width='50'></td>";
                echo "<td width='650' style='text-align:justify; font-size:16px;'>";
                        echo "Son las solicitudes que normalmente atienden las Gerencias de
                                Administración, Calidad y Jurídica.";
                echo "</td>";
            echo "</tr>";
            echo "<tr height='30'></tr>";
        echo "</table>";

        //SOPORTE TECNICO

        echo "<table border='0' align='left' width='700'>";
            echo "<tr>";
                echo "<td style='font-size:20px;width:550px;' >Soporte técnico</td>";
                echo "<td><a href='http://71.144.19.155/INTRANET_GEA/Backlog/solicitudesv2/fichaCapturaSoporteTecnico.php?usuario=".base64_encode($usuarioId)."'><img src='../../../Imagenes/ICN_BotonAgregar.png' style='width:95%;' ></a></td>";
            echo "</tr>";
            echo"<tr height='20'></tr>";
        echo "</table>";
        
        echo "<table border='0' align='left' width='700'>";
            echo "<tr>";
                echo  "<td width='50'></td>";
                echo "<td width='650' style='text-align:justify; font-size:16px;'>";
                        echo "Son las relacionadas con la infraestructura informática y de comunicación. Por
                                ejemplo, asuntos relacionados con las computadoras (instalación de software,
                                antivirus, respaldos); telecomunicaciones (lentitud de Internet, problemas con
                                la telefonía); elaboración de inventarios; impresoras.";
                echo "</td>";
            echo "</tr>";
            echo "<tr height='15'></tr>";
            echo "<tr>";
                echo  "<td width='50'></td>";
                echo "<td width='650' style='text-align:justify; font-size:16px;'>";
                        echo "Son las solicitudes que normalmente atiende el personal de Intercomm";
                echo "</td>";            
            echo "</tr>";
            echo "<tr height='30'></tr>";
        echo "</table>";

        //MANTENIMIENTO DE SISTEMAS

        echo "<table border='0' align='left' width='700'>";
            echo "<tr>";
                echo "<td style='font-size:20px;width:550px;' >Mantenimiento de Sistemas</td>";
                echo "<td><a href='http://71.144.19.155/INTRANET_GEA/Backlog/solicitudesv2/fichaCapturaMantenimientoSistemas.php?usuario=".base64_encode($usuarioId)."'><img src='../../../Imagenes/ICN_BotonAgregar.png' style='width:95%;' ></a></td>";
            echo "</tr>";
            echo"<tr height='20'></tr>";
        echo "</table>";
        
        echo "<table border='0' align='left' width='700'>";
            echo "<tr>";
                echo  "<td width='50'></td>";
                echo "<td width='650' style='text-align:justify; font-size:16px;'>";
                        echo "Son las relacionadas con fallas en las funcionalidades de un sistema. Por
                                ejemplo, una agrupación que no ocurre, la generación de un COVE que no
                                funciona, un reporte que no se genera adecuadamente.";
                echo "</td>";
            echo "</tr>";
            echo "<tr height='15'></tr>";
            echo "<tr>";
                echo  "<td width='50'></td>";
                echo "<td width='650' style='text-align:justify; font-size:16px;'>";
                        echo "Son las solicitudes que normalmente atienden Abel, Cuauhtémoc y Alberto Ramírez";
                echo "</td>";
            echo "</tr>";
            echo "<tr height='30'></tr>";
        echo "</table>";

        //DESARROLLO DE NUEVAS FUNCIONALIDADES

        echo "<table border='0' align='left' width='700'>";
            echo "<tr>";
                echo "<td style='font-size:20px;width:550px;' >Desarrollo de nuevas funcionalidades</td>";
                echo "<td><a href='http://71.144.19.155/INTRANET_GEA/Backlog/solicitudesv2/fichaCapturaDesarrolloFuncionalidad.php?usuario=".base64_encode($usuarioId)."'><img src='../../../Imagenes/ICN_BotonAgregar.png' style='width:95%;' ></a></td>";
            echo "</tr>";
            echo"<tr height='20'></tr>";
        echo "</table>";
        
        echo "<table border='0' align='left' width='700'>";
            echo "<tr>";
                echo  "<td width='50'></td>";
                echo "<td width='650' style='text-align:justify; font-size:16px;'>";
                        echo "Son las peticiones para incorporar capacidades previamente inexistentes en
                                los sistemas institucionales, como por ejemplo, la creación de un nuevo
                                reporte; un nuevo cálculo de impuestos o variables; una visualización de datos
                                nueva; un complemento a un flujo de archivos; interacción con sistemas desde
                                un nuevo medio de comunicación (telefonía móvil).";
                echo "</td>";
            echo "</tr>";
            echo "<tr height='15'></tr>";
            echo "<tr>";
                echo  "<td width='50'></td>";
                echo "<td width='650' style='text-align:justify; font-size:16px;'>";
                        echo "Son las solicitudes que normalmente atiende el equipo de Desarrollo.";
                echo "</td>";
            echo "</tr>";
            echo "<tr height='30'></tr>";
        echo "</table>";

        //DISTRIBUCION DE ARCHIVOS

        echo "<table border='0' align='left' width='700'>";
            echo "<tr>";
                echo "<td style='font-size:20px;width:550px;' >Distribución de archivos</td>";
                echo "<td><a href='fichaCapturaEnvioArchivos.php'><img src='../../../Imagenes/ICN_BotonAgregar.png' style='width:95%;' ></a></td>";
            echo "</tr>";
            echo"<tr height='20'></tr>";
        echo "</table>";
        
        echo "<table border='0' align='left' width='700'>";
            echo "<tr>";
                echo  "<td width='50'></td>";
                echo "<td width='650' style='text-align:justify; font-size:16px;'>";
                        echo "Son las peticiones para incluir a uno o más individuos al esquema institucional
                                de distribución de archivos.";
                echo "</td>";
            echo "</tr>";
            echo "<tr height='15'></tr>";
            echo "<tr>";
                echo  "<td width='50'></td>";
                echo "<td width='650' style='text-align:justify; font-size:16px;'>";
                        echo "Son las solicitudes que normalmente atienden Richard y Alberto.";
                echo "</td>";
            echo "</tr>";
            echo "<tr height='30'></tr>";
        echo "</table>";

        //ALTAS Y BAJAS DE USUARIOS
            echo "<table border='0' align='left' width='700'>";
            echo "<tr>";
                echo "<td style='font-size:20px;width:550px;' >Alta y baja de accesos y permisos</td>";
                echo "<td><a href='AltaUsuario/altaBaja_Usuario.php?usuario=".base64_encode($usuarioId)."'><img src='../../../Imagenes/ICN_BotonAgregar.png' style='width:95%;' ></a></td>";
            echo "</tr>";
            echo"<tr height='20'></tr>";
        echo "</table>";
        
        
        echo "<table border='0' align='left' width='700'>";
            echo "<tr>";
                echo  "<td width='50'></td>";
                echo "<td width='650' style='text-align:justify; font-size:16px;'>";
                        echo "Son las peticiones para otorgar o eliminar el acceso de una persona a
                                cualquiera de los sistemas institucionales, así como la modificación de lo que
                                un usuario puede hacer en ellos.";
                echo "</td>";
            echo "</tr>";
            echo "<tr height='15'></tr>";
            echo "<tr>";
                echo  "<td width='50'></td>";
                echo "<td width='650' style='text-align:justify; font-size:16px;'>";
                        echo "Son las solicitudes que normalmente atienden Lizbeth y Alberto.";
                echo "</td>";
            echo "</tr>";
            echo "<tr height='30'></tr>";
        echo "</table>";

        //NUEVO PROYECTO
        
        if($usuarioId == 'Rodrigo_Romo'){
            echo "<table border='0' align='left' width='700'>";
                echo "<tr>";
                    echo "<td style='font-size:20px;width:550px;' >Funcionalidades de Proyecto</td>";
                    echo "<td><a href='fichaCapturaProyecto.php'><img src='../../../Imagenes/ICN_BotonAgregar.png' style='width:95%;' ></a></td>";
                echo "</tr>";
                echo"<tr height='20'></tr>";
            echo "</table>";
        }   
        echo "<br>";
        echo "<br>";
    
        echo "<table border='0' align='left' width='700'>";
            echo "<tr>";
                echo "<td id='titleBlueLineBottom' colspan='2'></td>";
            echo "</tr>";
            
            echo"<tr height='70'> </tr>";
        echo "</table>";

     }

    echo "<br>";
    echo "<br>";
echo "</div>";
?>
</body>
</html>