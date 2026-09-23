<?php

$nombrephp = 'tableroAuditorias.php';
require_once("../../ConexionDBT.php");
require_once("../../ConexionIntranet2.php");
require_once("../../compruebaUsuario.php");

error_reporting(E_PARSE);

$oficinas = $INTRANETV2->GetArray("
        SELECT DISTINCT 
                CASE xt_ciudad
                WHEN 'DF' THEN
                    'CMX'
                ELSE    xt_ciudad
                END AS ciudad,
                CASE
                WHEN xt_ciudad IN ('CMX','DF') THEN
                        'Ciudad de México'
                WHEN xt_ciudad = 'TOL' THEN
                        'Toluca'
                WHEN xt_ciudad = 'VER' THEN
                        'Veracruz'
                WHEN xt_ciudad = 'NLR' THEN
                        'Nuevo Laredo'
                WHEN xt_ciudad = 'CUN' THEN
                        'Cancún'
                END AS valorCiudad
        FROM 
                SGI_Auditorias
    ");

$breadcrumb = "<a href='../../Home.php' id='breadcrumbs'> Home / </a><a href='../homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a>
               <a href='../Modulos.php' id='breadcrumbs'> Módulos </a>";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8">
    <title>Tablero de Auditorías</title>
    <?php
    if($estiloUsuario == 1){
        echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>";
    }else if($estiloUsuario == 2){
        echo "<link type='text/css' rel='stylesheet' href='../../css/styleHomePage2.css'/>";
    }
    ?>
    <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
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
        
        function muestraFiltro(){
            var form1 = document.getElementById("filtroTablero");
            if(form1.style.display ==  'none'){
                form1.style.display = 'block';          
                }else{
                    form1.style.display =  'none';
                }
        }
    </script>    
</head>
        
<body>
<?php
    echo "    
        <div id='wrapperRiesgos'>
        <table border='0' align='center' width='1160px' style='margin-top:-110px;'>
            <tr>
                <td id='breadcrumbs' width='1160px' align='left'>Usuario: $usuarioId</td>
            </tr>
            <tr height='80px'><td></td></tr>
        </table>

        <table border='0' align='center' name='Encabezado'>
            <tr>
                <td align='center' id='titulo1'>
                    <font>Auditorías</font>
                </td>
            </tr>
            
            <tr> 
                <td align='center' valign='top' height='20px'>
                    <table border='0' align='center'>
                        <tr height='20px'>
                            <td valign='middle'>
                                <img src='../../Imagenes/ICN_PointMeTo.png' id='banana1' style='display:none;' onclick='showBanana(0);'>
                                <img src='../../Imagenes/ICN_PointMeTo.png' id='banana0' style='display:inline-block;' onclick='showBanana(1);'>
                            </td>
                            
                            <td valign='middle'>
                                <font style='display:inline-block;'>$breadcrumb</font>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr height='40'> </tr>
            <tr>
                <td align='center'>";
                
                    if(($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'cozy') || ($usuarioId == 'Alberto_Martinez') || ($usuarioId == 'Daniel_Guadarrama') || ($usuarioId == 'Ricardo_Garcia') || ($usuarioId == 'sdelap') || ($usuarioId == 'Lizbeth_Guadarrama')){
                        echo "
                        <a href='altaAuditoriaPopUpv2.php' target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=500');\"><img src='../../Imagenes/ICN_BotonAgregar.png' width='90' height='29'></a>";
                        
                    }
                    echo "
                </td>
            </tr>
        </table>

        <!-- banan de navegacion de intranet -->
        <table border='0' align='center' id='mapaIntranet' style='display:none;'>";
        include('../../navegacion_banana.php');
        echo "
        </table>

        
        <table border='0' align='center'>
            <tr height='10'><td></td></tr>
        </table>

        <table border='0' align='center'   width='700px'>
            <tr>
                <td colspan='3' align='left' id='iconosTexto2'><a href='javascript:void(0);' onclick='muestraFiltro();' style='color:rgb(0,124,189);'>Filtro</a> </td>
            </tr >
            <tr height='10'>
            </tr>
        </table>
    
        <form method='POST' action='tablero_auditoria.php' id='filtroTablero' style='display:none;'>
            <table border='0' width='700px;' align='center'>
                <tr>
                    <td>
                        <p style='margin-left:50%;'>OFICINA</p>
                    </td>
                    <td width='25px'></td>
                    <td>
                        <p style='margin-right:50%;'>AÑO</p>
                    </td>
                    <td>
                        <p style='margin-right:50%;'>ESTATUS</p>
                    </td>
                </tr>
                <tr>
                    <td colspan='8' id='titleBlueLineTop'></td>
                </tr>
                <tr style='height:5px'>
                <tr>
                    <td>
                        <div style='margin-left:50%;'>
                
                            <select name='ciudad'>
                
                                <option value=''>Selecciona.....</option>";
                                $t = $INTRANETV2->Execute("
                                    SELECT DISTINCT 
                                            CASE xt_ciudad
                                            WHEN 'DF' THEN
                                                'CMX'
                                            ELSE    xt_ciudad
                                            END AS ciudad,
                                            CASE
                                            WHEN xt_ciudad IN ('CMX','DF') THEN
                                                    'Ciudad de México'
                                            WHEN xt_ciudad = 'TOL' THEN
                                                    'Toluca'
                                            WHEN xt_ciudad = 'VER' THEN
                                                    'Veracruz'
                                            WHEN xt_ciudad = 'NLR' THEN
                                                    'Nuevo Laredo'
                                            WHEN xt_ciudad = 'CUN' THEN
                                                    'Cancún'
                                            END AS valorCiudad
                                    FROM 
                                            SGI_Auditorias
                                ");
                                while($p = $t->fetchRow()){
                                    $ciudadess = $p[1];
                                    $cdValors  = $p[0];

                                    echo "    <option value='".$cdValors."'>".$ciudadess."</option>";
                                        
                                }
                            echo "
                            </select>
                        </div>
                    </td>
                    <td width='25px'></td>
                    <td>
                        <div style='margin-right:10%;'>
                            <select name='anio'>
                                <option value=''>Selecciona......</option>";
                                for($a=0;$a<=3;$a++){
                                    $anio = date("Y") - $a;
                                    echo "<option value=".$anio.">".$anio."</option>";
                                }
                            echo "
                            </select>
                        </div>
                    </td>
                    <td>
                        <div style='margin-right:40%;'>
                            <select name='estatus'>
                                <option value=''>Selecciona......</option>
                                <option value='1'>PROGRAMADA</option>
                                <option value='2'>REALIZADA</option>
                                <option value='3'>TERMINADA</option>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr style='height:10px'>
                </tr>
                <tr>
                    <td colspan='4'>
                        <center><input type='image' name='Enviar' onclick='SubmitForm(this.form);' align='center' src='../../Imagenes/ICN_BotonEnviar.png' width='60' height='20'></center
                    </td>
                </tr>
            </table>
        </form>";        

    echo "<table border='0' align='center'>";
        echo"<tr height='70'><td></td></tr>";
    echo "</table>"; 
    
    //banderas globales
    $banderaT = 0;
    $banderaHallazgo = 0;
    
    if( !empty($_POST['ciudad']) || !empty($_POST['anio']) || !empty($_POST['estatus'])){
        
        $ciudadA = $_POST['ciudad'];
        $anio   = $_POST['anio'];
        $estatusA = $_POST['estatus'];

        //defino como sera el filtro
        
        //1.- ciudad, año, estatus
        if(!empty($_POST['ciudad']) && !empty($_POST['anio']) && !empty($_POST['estatus'])){       
           
            $consulta = "
                    SELECT
                        xt_claveAuditoria,
                        xt_grupo,
                        CASE xt_ciudad
                        WHEN 'DF' THEN
                            'CMX'
                        ELSE xt_ciudad
                        END AS ciudad,
                        xt_tipo,
                        xt_titulo,
                        xd_fecha,
                        xt_status,
                        xt_hallazgo
                    FROM
                        SGI_Auditorias
                    WHERE
                        xt_ciudad = '$ciudadA'
                    AND YEAR (xd_fecha) = '$anio'
                    AND xt_status = $estatusA
                    ORDER BY
                        xd_fecha DESC
                ";

            
        }
        
        if(empty($_POST['ciudad']) && !empty($_POST['anio']) && (!empty($_POST['estatus']) || empty($_POST['estatus']))){
            if(!empty($_POST['estatus'])){

                $consulta = "
                        SELECT
                            xt_claveAuditoria,
                            xt_grupo,
                            CASE xt_ciudad
                            WHEN 'DF' THEN
                                'CMX'
                            ELSE xt_ciudad
                            END AS ciudad,
                            xt_tipo,
                            xt_titulo,
                            xd_fecha,
                            xt_status,
                            xt_hallazgo
                        FROM
                            SGI_Auditorias
                        WHERE
                        YEAR (xd_fecha) = '$anio'
                        AND xt_status = $estatusA
                        ORDER BY
                            xd_fecha DESC";
            }else{

                $consulta = "
                        SELECT
                            xt_claveAuditoria,
                            xt_grupo,
                            CASE xt_ciudad
                            WHEN 'DF' THEN
                                'CMX'
                            ELSE xt_ciudad
                            END AS ciudad,
                            xt_tipo,
                            xt_titulo,
                            xd_fecha,
                            xt_status,
                            xt_hallazgo
                        FROM
                            SGI_Auditorias
                        WHERE
                        YEAR (xd_fecha) = '$anio'
                        ORDER BY
                            xd_fecha DESC";

            }
            
        }
    
        if(!empty($_POST['ciudad']) && !empty($_POST['anio']) &&  empty($_POST['estatus'])){
            $consulta = "
                    SELECT
                        xt_claveAuditoria,
                        xt_grupo,
                        CASE xt_ciudad
                        WHEN 'DF' THEN
                            'CMX'
                        ELSE xt_ciudad
                        END AS ciudad,
                        xt_tipo,
                        xt_titulo,
                        xd_fecha,
                        xt_status,
                        xt_hallazgo
                    FROM
                        SGI_Auditorias
                    WHERE
                    YEAR (xd_fecha) = '$anio'
                    AND xt_ciudad = '$ciudadA'
                    ORDER BY
                        xd_fecha DESC
                ";
        }

        if(!empty($_POST['ciudad'])  && empty($_POST['anio']) && (!empty($_POST['estatus']) || empty($_POST['estatus']))){
            if(!empty($_POST['estatus'])){
                $consulta = "
                        SELECT
                            xt_claveAuditoria,
                            xt_grupo,
                            CASE xt_ciudad
                            WHEN 'DF' THEN
                                'CMX'
                            ELSE xt_ciudad
                            END AS ciudad,
                            xt_tipo,
                            xt_titulo,
                            xd_fecha,
                            xt_status,
                            xt_hallazgo
                        FROM
                            SGI_Auditorias
                        WHERE
                        xt_ciudad = '$ciudadA'
                        AND xt_status = $estatusA
                        ORDER BY
                            xd_fecha DESC
                    ";
            }else{
                $consulta = "
                        SELECT
                            xt_claveAuditoria,
                            xt_grupo,
                            CASE xt_ciudad
                            WHEN 'DF' THEN
                                'CMX'
                            ELSE xt_ciudad
                            END AS ciudad,
                            xt_tipo,
                            xt_titulo,
                            xd_fecha,
                            xt_status,
                            xt_hallazgo
                        FROM
                            SGI_Auditorias
                        WHERE
                        xt_ciudad = '$ciudadA'
                        ORDER BY
                            xd_fecha DESC
                    ";
            }
        }
        
        if(empty($_POST['ciudad']) && empty($_POST['anio']) && !empty($_POST['estatus'])){
            $consulta = "
                    SELECT
                        xt_claveAuditoria,
                        xt_grupo,
                        CASE xt_ciudad
                        WHEN 'DF' THEN
                            'CMX'
                        ELSE xt_ciudad
                        END AS ciudad,
                        xt_tipo,
                        xt_titulo,
                        xd_fecha,
                        xt_status,
                        xt_hallazgo
                    FROM
                        SGI_Auditorias
                    WHERE
                    xt_status = $estatusA
                    ORDER BY
                        xd_fecha DESC
                ";
        }
        $bandera = 0;
        $indice = 0;
        $registrosAuditorias = $INTRANETV2->Execute($consulta);
        while ($registroAuditoria = $registrosAuditorias->fetchRow()){
            $clave[$indice] = $registroAuditoria[0];
            $grupo[$indice] = $registroAuditoria[1];
            $ciudad[$indice] = $registroAuditoria[2];
            $tipo[$indice] = $registroAuditoria[3];
            $titulo[$indice] = $registroAuditoria[4];
            $fecha[$indice] = $registroAuditoria[5];
            $estatus[$indice] = $registroAuditoria[6];
            $hallazgo[$indice] = $registroAuditoria[7];
            $indice++;
        }unset($registroAuditoria); unset($registrosAuditorias); unset($indice);
        for($a = 0; $a<count($oficinas); $a++){
            if(in_array($oficinas[$a][0], $ciudad)){
                echo"
                <table border='0' align='center' width='1150'>
                            
                    <tr height='10'> </tr>
                    
                    <tr>
                        <td id='titulo2Blanco' align='left' width='1150'>".$oficinas[$a][1]."</td>
                    </tr>

                    <tr>
                        <td id='titleBlueLineBottom'> </td>
                    </tr>
                                
                </table>";
                echo "
                <table border='0' align='center' width='1100'>";                
                if(in_array('IN', $tipo)){
                    echo "
                    <tr>
                        <td id='titulo2' align='left'>Internos</td>
                    </tr>
                    
                    <tr height='10'><td> </td></tr>
                    
                    <tr>
                        <td colspan='8' id='titleBlueLineTop'> </td>
                    </tr>

                    <tr>
                        <td>
                            <table border='0' align='center' width='1050'>
                                <tr height='10'> </tr>
                            <!-- ///CABECERA DE LA TABLA -->
                                <tr id='iconosTexto2'>
                                    <td align='left' style='width:20px;'> </td>
                                    <td align='left' style='width:80px;'>Código</td>
                                    <td align='left' style='width:200px;'>Título</td>
                                    <td align='left' style='width:80px;'>Fecha</td>
                                    <td align='left' style='width:10px;'>Tipo</td>
                                    <td align='left' style='width:5px;'> </td>
                                </tr>
                                
                                <tr height='10'> </tr> ";                            
                                for($b=0; $b<count($clave); $b++){
                                    if (($tipo[$b]=='IN')&&($ciudad[$b]==$oficinas[$a][0])){
                                    echo "
                                        <tr id='fileItem'>
                                            <td align='left' > </td>
                                            <td align='left' >";
                                            if($estatus[$b] == 1){
                                                
                                                echo "<a href='auditoria_actualizar.php?clave=".$clave[$b]."' id='fileItem' style='text-decoration:none;'>".$clave[$b]."</a>";
                                                
                                            }else if($estatus[$b] == 2){
                                                
                                                echo "<a href='ficha_auditoria.php?clave=".$clave[$b]."' id='fileItem' style='text-decoration:none;'>".$clave[$b]."</a>";
                                                
                                            }
                                            echo "</td>
                                            <td align='left' >".$titulo[$b]."</td>
                                            <td align='left' >".$fecha[$b]."</td>
                                            <td align='left' >Interna</td>
                                            <!-- //defino semaforo para determinar si los allazgos registrados ya estan terminados o existe alguno pendiente
                                            //primero identificamos si se declaron o no hallazgos-->";
                                            $declaroHallazgo = $INTRANETV2->getOne("SELECT xt_hallazgo FROM SGI_Auditorias WHERE xt_claveAuditoria = '$clave[$b]'");
                                            
                                            $existeHallazgo = $INTRANETV2->getOne("SELECT xt_claveHallazgo FROM SGI_Auditorias_Hallazgos WHERE xt_claveAuditoria = '$clave[$b]' ");
                                            echo "<td align='center'>";
                                            
                                            if(empty($declaroHallazgo) && empty($existeHallazgo) && $estatus[$b] == 1){
                                                echo "";
                                            
                                            } else if(($declaroHallazgo == 'No' || empty($declaroHallazgo)) && empty($existeHallazgo) && $estatus[$b] == 2){
                                                echo "<IMG SRC='../../Imagenes/ICN_Estrella_Amarilla_Auditoria.png' width=17 height=17>";
                                            } else if(($declaroHallazgo == 'Si' || empty($declaroHallazgo)) && !empty($existeHallazgo)){
                                            
                                                //1,.Obtengo los hallazgos
                                                    
                                                $d = $INTRANETV2->Execute("SELECT xt_claveHallazgo FROM SGI_Auditorias_Hallazgos WHERE xt_claveAuditoria = '$clave[$b]'");
                                                    
                                                while($listIssue = $d->fetchRow()){
                                                    //obtengo el codigo de la correctiva
                                                    $c = $INTRANETV2->Execute("SELECT xt_claveTratamiento FROM SGI_Auditorias_Hallazgos_Tratamientos WHERE xt_claveHallazgo = '$listIssue[0]'");
                                                    
                                                    while ($listCodC = $c->fetchRow()){
                                                        
                                                        
                                                        $banderaHallazgo = 1;

                                                        //obtengo la ultima etapa

                                                         $semaforoTerminada = $INTRANETV2->getOne("SELECT xt_titulo FROM SGI_Acciones_Preventivas_Correctivas_Etapas WHERE xt_codigoAccion = '$listCodC[0]' ORDER BY xn_etapa DESC");

                                                            if($semaforoTerminada != 'EVALUACION'){

                                                                $banderaT = 1;

                                                            }
                                                    
                                                        }
                                                        
                                                    }//fin del while        

                                                    if($banderaT == 1 && $banderaHallazgo == 1){
                                                        echo "<IMG SRC='../../Imagenes/ICN_SemaforoRojoOscuro.png' width=10 height=10>";            
                                                    }else if($banderaT != 1 && $banderaHallazgo != 1){
                                                        echo "<IMG SRC='../../Imagenes/ICN_SemaforoRojoOscuro.png' width=10 height=10>";            
                                                    }else if($banderaT != 1 && $banderaHallazgo == 1){
                                                        echo "<IMG SRC='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width=10 height=10>";
                                                    } else {
                                                        echo "";
                                                    }
                                                unset($banderaT);
                                                unset($banderaHallazgo);
                                                
                                            }//fin del if donde verificamos que si existen hallazgos
                                            echo "</td>
                                        </tr>"; 
                                    }
                                }
                            echo "                       
                           </table>
                        </td>
                        
                    </tr>
                    <tr height='20'> </tr>";
                } else {

                }
                if(in_array('EX', $tipo)){
                    echo "
                    <tr>
                        <td id='titulo2' align='left'>Externos</td>
                    </tr>
                    
                    <tr height='10'><td> </td></tr>

                    <tr>
                        <td colspan='8' id='titleBlueLineTop'> </td>
                    </tr>

                    <tr height='10'><td> </td></tr>
                    
                    <tr>
                        <td>
                            <table border='0' align='center' width='1050'>
                                <tr height='10'> </tr>
                            <!-- ///CABECERA DE LA TABLA -->
                                <tr id='iconosTexto2'>
                                    <td align='left' style='width:20px;'> </td>
                                    <td align='left' style='width:80px;'>Código</td>
                                    <td align='left' style='width:200px;'>Título</td>
                                    <td align='left' style='width:80px;'>Fecha</td>
                                    <td align='left' style='width:10px;'>Tipo</td>
                                    <td align='left' style='width:5px;'> </td>                                    
                                </tr>
                                
                                <tr height='10'> </tr> ";                            
                
                                for($b=0; $b<count($clave); $b++){
                                    if (($tipo[$b]=='EX')&&($ciudad[$b]==$oficinas[$a][0])){
                                    echo "
                                        <tr id='fileItem'>
                                            <td align='left' > </td>
                                            <td>";
                                            if($estatus[$b] == 1){
                                                
                                                echo "<a href='auditoria_actualizar.php?clave=".$clave[$b]."' id='fileItem' style='text-decoration:none;'>".$clave[$b]."</a>";
                                                
                                            }else if($estatus[$b] == 2){
                                                
                                                echo "<a href='ficha_auditoria.php?clave=".$clave[$b]."' id='fileItem' style='text-decoration:none;'>".$clave[$b]."</a>";
                                                
                                            }
                                            echo "</td>
                                            <td align='left' >".$titulo[$b]."</td>
                                            <td align='left' >".$fecha[$b]."</td>
                                            <td align='left' >Externa</td>
                                            <!--                                             // defino semaforo para determinar si los allazgos registrados ya estan terminados o existe alguno pendiente
                                            // primero identificamos si se declaron o no hallazgos -->
                                            ";
                                            $declaroHallazgo = $INTRANETV2->getOne("SELECT xt_hallazgo FROM SGI_Auditorias WHERE xt_claveAuditoria = '$clave[$b]'");
                                            
                                            $existeHallazgo = $INTRANETV2->getOne("SELECT xt_claveHallazgo FROM SGI_Auditorias_Hallazgos WHERE xt_claveAuditoria = '$clave[$b]' ");
                                            echo "<td align='center'>";
                                            
                                            if(empty($declaroHallazgo) && empty($existeHallazgo) && $estatus[$b] == 1){
                                                echo "";
                                            
                                            } else if(($declaroHallazgo == 'No' || empty($declaroHallazgo)) && empty($existeHallazgo) && $estatus[$b] == 2){
                                                echo "<IMG SRC='../../Imagenes/ICN_Estrella_Amarilla_Auditoria.png' width=17 height=17>";
                                            } else if(($declaroHallazgo == 'Si' || empty($declaroHallazgo)) && !empty($existeHallazgo)){
                                            
                                                //1,.Obtengo los hallazgos
                                                    
                                                $d = $INTRANETV2->Execute("SELECT xt_claveHallazgo FROM SGI_Auditorias_Hallazgos WHERE xt_claveAuditoria = '$clave[$b]'");
                                                    
                                                while($listIssue = $d->fetchRow()){
                                                    //obtengo el codigo de la correctiva
                                                    $c = $INTRANETV2->Execute("SELECT xt_claveTratamiento FROM SGI_Auditorias_Hallazgos_Tratamientos WHERE xt_claveHallazgo = '$listIssue[0]'");
                                                    
                                                    while ($listCodC = $c->fetchRow()){
                                                        
                                                        
                                                        $banderaHallazgo = 1;

                                                        //obtengo la ultima etapa

                                                         $semaforoTerminada = $INTRANETV2->getOne("SELECT xt_titulo FROM SGI_Acciones_Preventivas_Correctivas_Etapas WHERE xt_codigoAccion = '$listCodC[0]' ORDER BY xn_etapa DESC");

                                                            if($semaforoTerminada != 'EVALUACION'){

                                                                $banderaT = 1;

                                                            }
                                                    
                                                        }
                                                        
                                                    }//fin del while        

                                                    if($banderaT == 1 && $banderaHallazgo == 1){
                                                        echo "<IMG SRC='../../Imagenes/ICN_SemaforoRojoOscuro.png' width=10 height=10>";            
                                                    }else if($banderaT != 1 && $banderaHallazgo != 1){
                                                        echo "<IMG SRC='../../Imagenes/ICN_SemaforoRojoOscuro.png' width=10 height=10>";            
                                                    }else if($banderaT != 1 && $banderaHallazgo == 1){
                                                        echo "<IMG SRC='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width=10 height=10>";
                                                    } else {
                                                        echo "";
                                                    }
                                                unset($banderaT);
                                                unset($banderaHallazgo);
                                                
                                            }//fin del if donde verificamos que si existen hallazgos
                                            echo "</td>
                                        </tr>"; 
                                    }
                                }                        
                            echo "                       
                            </table>
                        </td>
                        
                    </tr>
                    <tr height='20'> </tr>";
                } else {

                }                
                echo "
                </table>";
            }else{

            }
        }
    } else if(empty($_POST['ciudad']) && empty($_POST['anio']) && empty($_POST['estatus'])){
        $indice = 0;
        $registrosAuditorias = $INTRANETV2->Execute("
                SELECT
                    xt_claveAuditoria,
                    xt_grupo,
                    CASE xt_ciudad
                    WHEN 'DF' THEN
                        'CMX'
                    ELSE xt_ciudad
                    END AS ciudad,
                    xt_tipo,
                    xt_titulo,
                    xd_fecha,
                    xt_status,
                    xt_hallazgo
                FROM
                    SGI_Auditorias
            ");
        while ($registroAuditoria = $registrosAuditorias->fetchRow()){
            $clave[$indice] = $registroAuditoria[0];
            $grupo[$indice] = $registroAuditoria[1];
            $ciudad[$indice] = $registroAuditoria[2];
            $tipo[$indice] = $registroAuditoria[3];
            $titulo[$indice] = $registroAuditoria[4];
            $fecha[$indice] = $registroAuditoria[5];
            $estatus[$indice] = $registroAuditoria[6];
            $hallazgo[$indice] = $registroAuditoria[7];
            $indice++;
        }unset($registroAuditoria); unset($registrosAuditorias); unset($indice);
        for($a = 0; $a<count($oficinas); $a++){
            if(in_array($oficinas[$a][0], $ciudad)){
                echo"
                <table border='0' align='center' width='1150'>
                            
                    <tr height='10'> </tr>
                    
                    <tr>
                        <td id='titulo2Blanco' align='left' width='1150'>".$oficinas[$a][1]."</td>
                    </tr>

                    <tr>
                        <td id='titleBlueLineBottom'> </td>
                    </tr>
                                
                </table>";
                echo "
                <table border='0' align='center' width='1100'>";                
                if(in_array('IN', $tipo)){
                    echo "
                    <tr>
                        <td id='titulo2' align='left'>Internos</td>
                    </tr>
                    
                    <tr height='10'><td> </td></tr>
                    
                    <tr>
                        <td colspan='8' id='titleBlueLineTop'> </td>
                    </tr>

                    <tr>
                        <td>
                            <table border='0' align='center' width='1050'>
                                <tr height='10'> </tr>
                            <!-- ///CABECERA DE LA TABLA -->
                                <tr id='iconosTexto2'>
                                    <td align='left' style='width:20px;'> </td>
                                    <td align='left' style='width:80px;'>Código</td>
                                    <td align='left' style='width:200px;'>Título</td>
                                    <td align='left' style='width:80px;'>Fecha</td>
                                    <td align='left' style='width:10px;'>Tipo</td>
                                    <td align='left' style='width:5px;'> </td>                                    
                                </tr>
                                
                                <tr height='10'> </tr> ";                            
                                for($b=0; $b<count($clave); $b++){
                                    if (($tipo[$b]=='IN')&&($ciudad[$b]==$oficinas[$a][0])){
                                    echo "
                                        <tr id='fileItem'>
                                            <td align='left' > </td>
                                            <td>";
                                            if($estatus[$b] == 1){
                                                
                                                echo "<a href='auditoria_actualizar.php?clave=".$clave[$b]."' id='fileItem' style='text-decoration:none;'>".$clave[$b]."</a>";
                                                
                                            }else if($estatus[$b] == 2){
                                                
                                                echo "<a href='ficha_auditoria.php?clave=".$clave[$b]."' id='fileItem' style='text-decoration:none;'>".$clave[$b]."</a>";
                                                
                                            }
                                            echo "</td>
                                            <td align='left' >".$titulo[$b]."</td>
                                            <td align='left' >".$fecha[$b]."</td>
                                            <td align='left' >Interna</td>
                                            <!--                                             // defino semaforo para determinar si los allazgos registrados ya estan terminados o existe alguno pendiente
                                            // primero identificamos si se declaron o no hallazgos -->
                                            ";
                                            $declaroHallazgo = $INTRANETV2->getOne("SELECT xt_hallazgo FROM SGI_Auditorias WHERE xt_claveAuditoria = '$clave[$b]'");
                                            
                                            $existeHallazgo = $INTRANETV2->getOne("SELECT xt_claveHallazgo FROM SGI_Auditorias_Hallazgos WHERE xt_claveAuditoria = '$clave[$b]' ");
                                            echo "<td align='center'>";
                                            
                                            if(empty($declaroHallazgo) && empty($existeHallazgo) && $estatus[$b] == 1){
                                                echo "";
                                            
                                            } else if(($declaroHallazgo == 'No' || empty($declaroHallazgo)) && empty($existeHallazgo) && $estatus[$b] == 2){
                                                echo "<IMG SRC='../../Imagenes/ICN_Estrella_Amarilla_Auditoria.png' width=17 height=17>";
                                            } else if(($declaroHallazgo == 'Si' || empty($declaroHallazgo)) && !empty($existeHallazgo)){
                                            
                                                //1,.Obtengo los hallazgos
                                                    
                                                $d = $INTRANETV2->Execute("SELECT xt_claveHallazgo FROM SGI_Auditorias_Hallazgos WHERE xt_claveAuditoria = '$clave[$b]'");
                                                    
                                                while($listIssue = $d->fetchRow()){
                                                    //obtengo el codigo de la correctiva
                                                    $c = $INTRANETV2->Execute("SELECT xt_claveTratamiento FROM SGI_Auditorias_Hallazgos_Tratamientos WHERE xt_claveHallazgo = '$listIssue[0]'");
                                                    
                                                    while ($listCodC = $c->fetchRow()){
                                                        
                                                        
                                                        $banderaHallazgo = 1;

                                                        //obtengo la ultima etapa

                                                         $semaforoTerminada = $INTRANETV2->getOne("SELECT xt_titulo FROM SGI_Acciones_Preventivas_Correctivas_Etapas WHERE xt_codigoAccion = '$listCodC[0]' ORDER BY xn_etapa DESC");

                                                            if($semaforoTerminada != 'EVALUACION'){

                                                                $banderaT = 1;

                                                            }
                                                    
                                                        }
                                                        
                                                    }//fin del while        

                                                    if($banderaT == 1 && $banderaHallazgo == 1){
                                                        echo "<IMG SRC='../../Imagenes/ICN_SemaforoRojoOscuro.png' width=10 height=10>";            
                                                    }else if($banderaT != 1 && $banderaHallazgo != 1){
                                                        echo "<IMG SRC='../../Imagenes/ICN_SemaforoRojoOscuro.png' width=10 height=10>";            
                                                    }else if($banderaT != 1 && $banderaHallazgo == 1){
                                                        echo "<IMG SRC='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width=10 height=10>";
                                                    } else {
                                                        echo "";
                                                    }
                                                unset($banderaT);
                                                unset($banderaHallazgo);
                                                
                                            }//fin del if donde verificamos que si existen hallazgos
                                            echo "</td>
                                        </tr>"; 
                                    }
                                }
                            echo "                       
                           </table>
                        </td>
                    </tr>
                    <tr height='20'> </tr>";
                } else {

                }
                if(in_array('EX', $tipo)){
                    echo "
                    <tr>
                        <td id='titulo2' align='left'>Externos</td>
                    </tr>
                    
                    <tr height='10'><td> </td></tr>

                    <tr>
                        <td colspan='8' id='titleBlueLineTop'> </td>
                    </tr>

                    <tr height='10'><td> </td></tr>
                    
                    <tr>
                        <td>
                            <table border='0' align='center' width='1050'>
                                <tr height='10'> </tr>
                            <!-- ///CABECERA DE LA TABLA -->
                                <tr id='iconosTexto2'>
                                    <td align='left' style='width:20px;'> </td>
                                    <td align='left' style='width:80px;'>Código</td>
                                    <td align='left' style='width:200px;'>Título</td>
                                    <td align='left' style='width:80px;'>Fecha</td>
                                    <td align='left' style='width:10px;'>Tipo</td>
                                    <td align='left' style='width:5px;'> </td>                                    
                                </tr>
                                
                                <tr height='10'> </tr> ";                            
                
                                for($b=0; $b<count($clave); $b++){
                                    if (($tipo[$b]=='EX')&&($ciudad[$b]==$oficinas[$a][0])){
                                    echo "
                                        <tr id='fileItem'>
                                            <td align='left' > </td>
                                            <td>";
                                            if($estatus[$b] == 1){
                                                
                                                echo "<a href='auditoria_actualizar.php?clave=".$clave[$b]."' id='fileItem' style='text-decoration:none;'>".$clave[$b]."</a>";
                                                
                                            }else if($estatus[$b] == 2){
                                                
                                                echo "<a href='ficha_auditoria.php?clave=".$clave[$b]."' id='fileItem' style='text-decoration:none;'>".$clave[$b]."</a>";
                                                
                                            }
                                            echo "</td>
                                            <td align='left' >".$titulo[$b]."</td>
                                            <td align='left' >".$fecha[$b]."</td>
                                            <td align='left' >Externa</td>
                                            <!--                                             // defino semaforo para determinar si los allazgos registrados ya estan terminados o existe alguno pendiente
                                            // primero identificamos si se declaron o no hallazgos -->
                                            ";
                                            $declaroHallazgo = $INTRANETV2->getOne("SELECT xt_hallazgo FROM SGI_Auditorias WHERE xt_claveAuditoria = '$clave[$b]'");
                                            
                                            $existeHallazgo = $INTRANETV2->getOne("SELECT xt_claveHallazgo FROM SGI_Auditorias_Hallazgos WHERE xt_claveAuditoria = '$clave[$b]' ");
                                            echo "<td align='center'>";
                                            
                                            if(empty($declaroHallazgo) && empty($existeHallazgo) && $estatus[$b] == 1){
                                                echo "";
                                            
                                            } else if(($declaroHallazgo == 'No' || empty($declaroHallazgo)) && empty($existeHallazgo) && $estatus[$b] == 2){
                                                echo "<IMG SRC='../../Imagenes/ICN_Estrella_Amarilla_Auditoria.png' width=17 height=17>";
                                            } else if(($declaroHallazgo == 'Si' || empty($declaroHallazgo)) && !empty($existeHallazgo)){
                                            
                                                //1,.Obtengo los hallazgos
                                                    
                                                $d = $INTRANETV2->Execute("SELECT xt_claveHallazgo FROM SGI_Auditorias_Hallazgos WHERE xt_claveAuditoria = '$clave[$b]'");
                                                    
                                                while($listIssue = $d->fetchRow()){
                                                    //obtengo el codigo de la correctiva
                                                    $c = $INTRANETV2->Execute("SELECT xt_claveTratamiento FROM SGI_Auditorias_Hallazgos_Tratamientos WHERE xt_claveHallazgo = '$listIssue[0]'");
                                                    
                                                    while ($listCodC = $c->fetchRow()){
                                                        
                                                        
                                                        $banderaHallazgo = 1;

                                                        //obtengo la ultima etapa

                                                         $semaforoTerminada = $INTRANETV2->getOne("SELECT xt_titulo FROM SGI_Acciones_Preventivas_Correctivas_Etapas WHERE xt_codigoAccion = '$listCodC[0]' ORDER BY xn_etapa DESC");

                                                            if($semaforoTerminada != 'EVALUACION'){

                                                                $banderaT = 1;

                                                            }
                                                    
                                                        }
                                                        
                                                    }//fin del while        

                                                    if($banderaT == 1 && $banderaHallazgo == 1){
                                                        echo "<IMG SRC='../../Imagenes/ICN_SemaforoRojoOscuro.png' width=10 height=10>";            
                                                    }else if($banderaT != 1 && $banderaHallazgo != 1){
                                                        echo "<IMG SRC='../../Imagenes/ICN_SemaforoRojoOscuro.png' width=10 height=10>";            
                                                    }else if($banderaT != 1 && $banderaHallazgo == 1){
                                                        echo "<IMG SRC='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width=10 height=10>";
                                                    } else {
                                                        echo "";
                                                    }
                                                unset($banderaT);
                                                unset($banderaHallazgo);
                                                
                                            }//fin del if donde verificamos que si existen hallazgos
                                            echo "</td>
                                        </tr>"; 
                                    }
                                }                        
                            echo "                       
                            </table>
                        </td>
                        
                    </tr>
                    <tr height='20'> </tr>";
                } else {

                }                
                echo "
                </table>";
            }else{

            }
        }              
    }    
    ?>

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