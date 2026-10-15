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
                WHEN xt_ciudad = 'GRL' THEN
                        'General'
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
            
        </table>";
      echo "<div style='margin-left: 38.5%;'><table border='0' align='center' id='mapaIntranet' style='display:none;'>";
        include('../../navegacion_banana.php');
    echo "</table></div>";

echo " <table border='0' align='center'><tr>
                <td align='center'>";
                
                    if(($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'Eibar_Ponce') || ($usuarioId == 'Alberto_Martinez') || ($usuarioId == 'Daniel_Guadarrama') || ($usuarioId == 'Ricardo_Garcia') || ($usuarioId == 'sdelap') || ($usuarioId == 'Lizbeth_Guadarrama') || ($usuarioId == 'Guillermo_Quezada')){
                        echo "
                        <a href='altaAuditoriaPopUpv2.php' target='popup' onclick=\"window.open(this.href,this.target,'width=700,height=500');\"><img src='../../Imagenes/ICN_BotonAgregar.png' width='90' height='29'></a>";
                        
                    }
                    echo "
                </td>
            </tr></table>";
        echo "
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
                                            WHEN xt_ciudad = 'GRL' THEN
                                                    'General'
                                            END AS valorCiudad
                                    FROM 
                                            SGI_Auditorias
                                ");
                                while($p = $t->fetchRow()){
                                    $ciudadess = $p[1];
                                    $cdValors  = $p[0];

                                    if (isset($_POST['ciudad'])) {
                                        if ($_POST['ciudad'] == $cdValors) {
                                        echo "<option SELECTED value='".$cdValors."'>".$ciudadess."</option>";
                                        }else{
                                        echo "<option value='".$cdValors."'>".$ciudadess."</option>";
                                    }
                                    }else{
                                        echo "<option value='".$cdValors."'>".$ciudadess."</option>";
                                    }
                                        
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
                                    if (isset($_POST['anio'])) {
                                        if ($_POST['anio'] == $anio) {
                                        echo "<option SELECTED value=".$anio.">".$anio."</option>";
                                        }else{
                                        echo "<option value=".$anio.">".$anio."</option>";
                                    }
                                    }else{
                                        echo "<option value=".$anio.">".$anio."</option>";
                                    }
                                }
                            echo "
                            </select>
                        </div>
                    </td>
                    <td>
                        <div style='margin-right:40%;'>
                            <select name='estatus'>
                                <option value=''>Selecciona......".$_POST['estatus']."</option>";
                                if (isset($_POST['estatus'])) {
                                    if ($_POST['estatus'] == 1) {
                                        echo "
                                        <option SELECTED value='1'>PROGRAMADA</option>
                                        <option value='2'>REALIZADA</option>";
                                    }elseif($_POST['estatus'] == 2){
                                        echo "
                                        <option value='1'>PROGRAMADA</option>
                                        <option SELECTED value='2'>REALIZADA</option>";
                                    }
                                }else{
                                    echo "
                                        <option value='1'>PROGRAMADA</option>
                                        <option value='2'>REALIZADA</option>";
                                }
                                echo "
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
    
    if(isset($_POST['ciudad']) || isset($_POST['anio']) || isset($_POST['estatus'])){
        
        $estatusA = $_POST['estatus'];
        if ($estatusA == 2) {
            $filtroS = "AND (xt_status = 2 OR xt_status = 4)";
        }else{
            $filtroS = "AND (xt_status = 1 OR xt_status = 3)";
        }

        if (!empty($_POST['ciudad'])) {
            $ciudadA = $_POST['ciudad'];
            $ciudadF = "AND xt_ciudad = '$ciudadA'";
        }

        if (!empty($_POST['anio'])) {
           $anio   = $_POST['anio'];
           $anioF = "AND YEAR (xd_fecha) = '$anio'";
        }
        //defino como sera el filtro     
           
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
                    WHERE 1=1
                        $ciudadF $anioF $filtroS 
                    ORDER BY
                        xd_fecha DESC
                ";

        //echo $consulta;

        $bandera = 0;
        $indice = 0;
        $registrosAuditorias = $INTRANETV2->Execute($consulta);
        while ($registroAuditoria = $registrosAuditorias->fetchRow()){
            $clave[$indice] = $registroAuditoria[0];
            $grupo[$indice] = $registroAuditoria[1];
            $ciudad[$indice] = $registroAuditoria[2];
            $tipo[$indice] = $registroAuditoria[3];
            $titulo[$indice] = $registroAuditoria[4];
            $fecha[$indice] = date('Y-m-d', strtotime($registroAuditoria[5]));
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

                echo "<!-- auditorias internas -->
                <table border='0' align='center' width='1150'>";                
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
                                    <td align='left' style='width:10px;'>Status</td>
                                    <td align='left' style='width:5px;'> </td>
                                </tr>
                                
                                <tr height='10'> </tr> ";                            
                                for($b=0; $b<count($clave); $b++){
                                    if (($tipo[$b]=='IN')&&($ciudad[$b]==$oficinas[$a][0])){
                                    echo "
                                        <tr id='fileItem'>
                                            <td align='left' > </td>
                                            <td align='left' >";
                                                echo "<a href='auditoria_actualizar.php?clave=".$clave[$b]."' id='fileItem' style='text-decoration:none;'>".$clave[$b]."</a>";
                                            echo "</td>
                                            <td align='left' >".$titulo[$b]."</td>
                                            <td align='left' >".$fecha[$b]."</td>
                                            <td align='left' >";
                                            if($estatus[$b] == 1){
                                                
                                                echo "PROGRAMADA";
                                                
                                            }else if($estatus[$b] == 3){
                                                
                                                echo "NO REALIZADA";
                                                
                                            }else if($estatus[$b] == 4 || $estatus[$b] == 2){
                                                
                                                echo "REALIZADA";
                                                
                                            }                               
                                            echo "</td>
                                            <!-- //defino semaforo para determinar si los allazgos registrados ya estan terminados o existe alguno pendiente
                                            //primero identificamos si se declaron o no hallazgos-->";
                                            $declaroHallazgo = $INTRANETV2->getOne("SELECT xt_hallazgo FROM SGI_Auditorias WHERE xt_claveAuditoria = '$clave[$b]'");
                                            
                                            $existeHallazgo = $INTRANETV2->getOne("SELECT xt_claveHallazgo FROM SGI_Auditorias_Hallazgos WHERE xt_claveAuditoria = '$clave[$b]' ");
                                            echo "<td align='center'>";
                                            
                                            if(empty($declaroHallazgo) && empty($existeHallazgo) && $estatus[$b] == 1){
                                                echo "";
                                            
                                            } else if((($declaroHallazgo == 'No')||empty($declaroHallazgo)) && empty($existeHallazgo) && (($estatus[$b] == 2) || ($estatus[$b] == 4))){
                                                echo "<IMG SRC='../../Imagenes/ICN_Estrella_Amarilla_Auditoria.png' width=17 height=17>";
                                            } else if(($declaroHallazgo == 'Si' || empty($declaroHallazgo)) && !empty($existeHallazgo)){
                                            
                                                //1,.Obtengo los hallazgos
                                                    
                                                $d = $INTRANETV2->Execute("SELECT xt_claveHallazgo FROM SGI_Auditorias_Hallazgos WHERE xt_claveAuditoria = '$clave[$b]'");
                                                $i=0;
                                                    
                                                while($listIssue = $d->fetchRow()){
                                                    //obtengo el codigo de la correctiva 
                                                    $c = $INTRANETV2->Execute("SELECT xt_claveTratamiento FROM SGI_Auditorias_Hallazgos_Tratamientos WHERE xt_claveHallazgo = '$listIssue[0]'");
                                                    echo $xt_claveHallazgo;
                                                    while ($listCodC = $c->fetchRow()){
                                                        $cod = $listCodC[0];
                                                        

                                                        //obtengo la ultima etapa

                                                         $semaforoTerminada[$i] = $INTRANETV2->getOne("SELECT xt_titulo FROM SGI_Acciones_Preventivas_Correctivas_Etapas WHERE xt_codigoAccion = '$cod' ORDER BY xn_etapa DESC LIMIT 1");
                                                         $statusSolicitud[$i] = $INTRANETV2->getOne("SELECT DISTINCT xt_status FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$cod' ORDER BY xn_numero DESC LIMIT 1");
                                                         $accionEvaluada[$i] = $INTRANETV2->getOne("SELECT DISTINCT xn_status FROM SGI_Acciones_Preventivas_Correctivas WHERE xt_claveAccion = '$cod' LIMIT 1");
                                    
                                                            if(($statusSolicitud[$i] == 'TERMINADA' || $semaforoTerminada[$i] == 'EVALUACION' || !empty($accionEvaluada[$i]))){
                                                                $banderaT[$i] = 1;
                                                            }else{
                                                                $banderaT[$i] = 0;
                                                            }

                                                            //echo $banderaT[$i];
                                                        }

                                                         $i++;
                                                        
                                                    }//fin del while       

                                                    $igualT = count(array_unique($banderaT)) === 1;
                                                    //echo $banderaT[0];
                                                    if($igualT==true && $banderaT[0] == 1){
                                                        echo "<IMG SRC='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width=10 height=10>";
                                                    } else {
                                                        echo "<IMG SRC='../../Imagenes/ICN_SemaforoRojoOscuro.png' width=10 height=10>";
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
                }

                if(in_array('EX', $tipo)){
                    echo "<!-- auditorias internas -->
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
                                    <td align='left' style='width:10px;'>Status</td>
                                    <td align='left' style='width:5px;'> </td>                                    
                                </tr>
                                
                                <tr height='10'> </tr> ";                            
                
                                for($b=0; $b<count($clave); $b++){
                                    if (($tipo[$b]=='EX')&&($ciudad[$b]==$oficinas[$a][0])){
                                    echo "
                                        <tr id='fileItem'>
                                            <td align='left' > </td>
                                            <td>";
                                                echo "<a href='auditoria_actualizar.php?clave=".$clave[$b]."' id='fileItem' style='text-decoration:none;'>".$clave[$b]."</a>";
                                            echo "</td>
                                            <td align='left' >".$titulo[$b]."</td>
                                            <td align='left' >".$fecha[$b]."</td>
                                            <td align='left' >";
                                            if($estatus[$b] == 1){
                                                
                                                echo "PROGRAMADA";
                                                
                                            }else if($estatus[$b] == 3){
                                                
                                                echo "NO REALIZADA";
                                                
                                            }else if($estatus[$b] == 4 || $estatus[$b] == 2){
                                                
                                                echo "REALIZADA";
                                                
                                            }                                             
                                            echo "</td>
                                            <!--                                             // defino semaforo para determinar si los allazgos registrados ya estan terminados o existe alguno pendiente
                                            // primero identificamos si se declaron o no hallazgos -->
                                            ";
                                            $declaroHallazgo = $INTRANETV2->getOne("SELECT xt_hallazgo FROM SGI_Auditorias WHERE xt_claveAuditoria = '$clave[$b]'");
                                            
                                            $existeHallazgo = $INTRANETV2->getOne("SELECT xt_claveHallazgo FROM SGI_Auditorias_Hallazgos WHERE xt_claveAuditoria = '$clave[$b]' ");
                                            echo "<td align='center'>";
                                            
                                            if(empty($declaroHallazgo) && empty($existeHallazgo) && $estatus[$b] == 1){
                                                echo "";
                                            
                                            } else if((($declaroHallazgo == 'No')||empty($declaroHallazgo)) && empty($existeHallazgo) && (($estatus[$b] == 2) || ($estatus[$b] == 4))){
                                                echo "<IMG SRC='../../Imagenes/ICN_Estrella_Amarilla_Auditoria.png' width=17 height=17>";
                                            } else if(($declaroHallazgo == 'Si' || empty($declaroHallazgo)) && !empty($existeHallazgo)){
                                            
                                                //1,.Obtengo los hallazgos
                                                    
                                                $d = $INTRANETV2->Execute("SELECT xt_claveHallazgo FROM SGI_Auditorias_Hallazgos WHERE xt_claveAuditoria = '$clave[$b]'");
                                                $i=0;

                                                while($listIssue = $d->fetchRow()){
                                                    //obtengo el codigo de la correctiva 
                                                    $c = $INTRANETV2->Execute("SELECT xt_claveTratamiento FROM SGI_Auditorias_Hallazgos_Tratamientos WHERE xt_claveHallazgo = '$listIssue[0]'");
                                                    echo $xt_claveHallazgo;
                                                    while ($listCodC = $c->fetchRow()){
                                                        $cod = $listCodC[0];
                                                        

                                                        //obtengo la ultima etapa

                                                         $semaforoTerminada[$i] = $INTRANETV2->getOne("SELECT xt_titulo FROM SGI_Acciones_Preventivas_Correctivas_Etapas WHERE xt_codigoAccion = '$cod' ORDER BY xn_etapa DESC LIMIT 1");
                                                         $statusSolicitud[$i] = $INTRANETV2->getOne("SELECT DISTINCT xt_status FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$cod' ORDER BY xn_numero DESC LIMIT 1");
                                                         $accionEvaluada[$i] = $INTRANETV2->getOne("SELECT DISTINCT xn_status FROM SGI_Acciones_Preventivas_Correctivas WHERE xt_claveAccion = '$cod' LIMIT 1");
                                    
                                                            if(($statusSolicitud[$i] == 'TERMINADA' || $semaforoTerminada[$i] == 'EVALUACION' || !empty($accionEvaluada[$i]))){
                                                                $banderaT[$i] = 1;
                                                            }else{
                                                                $banderaT[$i] = 0;
                                                            }

                                                            //echo $banderaT[$i];
                                                        }

                                                         $i++;
                                                        
                                                    }//fin del while  

                                            
                                                    $igualT = count(array_unique($banderaT)) === 1;
                                                    //echo $banderaT[0];
                                                    if($igualT==true && $banderaT[0] == 1){
                                                        echo "<IMG SRC='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width=10 height=10>";
                                                    } else {
                                                        echo "<IMG SRC='../../Imagenes/ICN_SemaforoRojoOscuro.png' width=10 height=10>";
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
                } 

                echo "
                </table>";
            }
        }

    } else{
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
                ORDER BY
                    xd_fecha DESC                    
            ");
        while ($registroAuditoria = $registrosAuditorias->fetchRow()){
            $clave[$indice] = $registroAuditoria[0];
            $grupo[$indice] = $registroAuditoria[1];
            $ciudad[$indice] = $registroAuditoria[2];
            $tipo[$indice] = $registroAuditoria[3];
            $titulo[$indice] = $registroAuditoria[4];
            $fecha[$indice] = date('Y-m-d', strtotime($registroAuditoria[5]));
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
                <table border='0' align='center' width='1150'>"; 
                //es aqui para auditorias internas               
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
                                    <td align='left' style='width:5%;'> </td>
                                    <td align='left' style='width:15%;'>Código</td>
                                    <td align='left' style='width:40%;'>Título</td>
                                    <td align='left' style='width:15%;'>Fecha</td>
                                    <td align='left' style='width:15%;'>Status</td>
                                    <td align='center' style='width:10%;'>Hallazgos</td>                                    
                                </tr>
                                
                                <tr height='10'> </tr> ";                            
                                for($b=0; $b<count($clave); $b++){
                                    $banderaHallazgo = array();
                                    $banderaT = array();
                                    if (($tipo[$b]=='IN')&&($ciudad[$b]==$oficinas[$a][0])){
                                    echo "
                                        <tr id='fileItem'>
                                            <td align='left' > </td>
                                            <td>";

                                                echo "<a href='auditoria_actualizar.php?clave=".$clave[$b]."' id='fileItem' style='text-decoration:none;'>".$clave[$b]."</a>";

                                            echo "</td>
                                            <td align='left' >".$titulo[$b]."</td>
                                            <td align='left' >".$fecha[$b]."</td>
                                            <td align='left' >";
                                            if($estatus[$b] == 1){
                                                
                                                echo "PROGRAMADA";
                                                
                                            }else if($estatus[$b] == 3){
                                                
                                                echo "NO REALIZADA";
                                                
                                            }else if($estatus[$b] == 4 || $estatus[$b] == 2){
                                                echo "REALIZADA";
                                                
                                            }                                     
                                            echo "</td>
                                            <!--                                             // defino semaforo para determinar si los allazgos registrados ya estan terminados o existe alguno pendiente
                                            // primero identificamos si se declaron o no hallazgos -->
                                            ";
                                            $declaroHallazgo = $INTRANETV2->getOne("SELECT xt_hallazgo FROM SGI_Auditorias WHERE xt_claveAuditoria = '$clave[$b]' LIMIT 1");
                                            
                                            $existeHallazgo = $INTRANETV2->getOne("SELECT xt_claveHallazgo FROM SGI_Auditorias_Hallazgos WHERE xt_claveAuditoria = '$clave[$b]' LIMIT 1");
                                            echo "<td align='center'>";
                                            
                                            if(empty($declaroHallazgo) && empty($existeHallazgo) && $estatus[$b] == 1){
                                                echo "";
                                            
                                            } else if((($declaroHallazgo == 'No')||empty($declaroHallazgo)) && empty($existeHallazgo) && (($estatus[$b] == 2) || ($estatus[$b] == 4))){
                                                echo "<IMG SRC='../../Imagenes/ICN_Estrella_Amarilla_Auditoria.png' width=17 height=17>";
                                            }elseif ($estatus[$b] == 1) {
                                                echo "";
                                            } else if(($declaroHallazgo == 'Si' || empty($declaroHallazgo)) && !empty($existeHallazgo)){
                                            
                                                //1,.Obtengo los hallazgos
                                                    
                                                $d = $INTRANETV2->Execute("SELECT xt_claveHallazgo FROM SGI_Auditorias_Hallazgos WHERE xt_claveAuditoria = '$clave[$b]'");
                                                $i=0;

                                                while($listIssue = $d->fetchRow()){
                                                    //obtengo el codigo de la correctiva 
                                                    $c = $INTRANETV2->Execute("SELECT xt_claveTratamiento FROM SGI_Auditorias_Hallazgos_Tratamientos WHERE xt_claveHallazgo = '$listIssue[0]'");
                                                    echo $xt_claveHallazgo;
                                                    while ($listCodC = $c->fetchRow()){
                                                        $cod = $listCodC[0];
                                                        

                                                        //obtengo la ultima etapa

                                                         $semaforoTerminada[$i] = $INTRANETV2->getOne("SELECT xt_titulo FROM SGI_Acciones_Preventivas_Correctivas_Etapas WHERE xt_codigoAccion = '$cod' ORDER BY xn_etapa DESC LIMIT 1");
                                                         $statusSolicitud[$i] = $INTRANETV2->getOne("SELECT DISTINCT xt_status FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$cod' ORDER BY xn_numero DESC LIMIT 1");
                                                         $accionEvaluada[$i] = $INTRANETV2->getOne("SELECT DISTINCT xn_status FROM SGI_Acciones_Preventivas_Correctivas WHERE xt_claveAccion = '$cod' LIMIT 1");
                                    
//echo "Estado: $listIssue[0]";
                                                            if(($statusSolicitud == "TERMINADA" || $semaforoTerminada[$i] == 'EVALUACION' || !empty($accionEvaluada[$i]))){
                                                                $banderaT[$i] = 1;
                                                            }else{
                                                                $banderaT[$i] = 0;
                                                            }
                                                            
                                                            //echo $banderaT[$i];

                                                        }

                                                         $i++;
                                                        
                                                    }//fin del while  
                                            
                                                    $igualT = count(array_unique($banderaT)) === 1;
                                                    //var_dump($igualT);
                                                    if($igualT == true && $banderaT[0]==1){
                                                        echo "<IMG SRC='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width=10 height=10>";
                                                    } else {
                                                        echo "<IMG SRC='../../Imagenes/ICN_SemaforoRojoOscuro.png' width=10 height=10>";
                                                    }
                                                
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

                    <tr>
                        <td>
                            <table border='0' align='center' width='1050'>
                                <tr height='10'> </tr>
                            <!-- ///CABECERA DE LA TABLA -->
                                <tr id='iconosTexto2'>
                                    <td align='left' style='width:5%;'> </td>
                                    <td align='left' style='width:15%;'>Código</td>
                                    <td align='left' style='width:40%;'>Título</td>
                                    <td align='left' style='width:15%;'>Fecha</td>
                                    <td align='left' style='width:15%;'>Status</td>
                                    <td align='center' style='width:10%;'>Hallazgos</td>                                    
                                </tr>
                                
                                <tr height='10'> </tr> ";                            
                                for($b=0; $b<count($clave); $b++){
                                    $banderaHallazgo = array();
                                    $banderaT = array();
                                    if (($tipo[$b]=='EX')&&($ciudad[$b]==$oficinas[$a][0])){
                                    echo "
                                        <tr id='fileItem'>
                                            <td align='left' > </td>
                                            <td>";

                                                echo "<a href='auditoria_actualizar.php?clave=".$clave[$b]."' id='fileItem' style='text-decoration:none;'>".$clave[$b]."</a>";

                                            echo "</td>
                                            <td align='left' >".$titulo[$b]."</td>
                                            <td align='left' >".$fecha[$b]."</td>
                                            <td align='left' >";
                                            if($estatus[$b] == 1){
                                                
                                                echo "PROGRAMADA";
                                                
                                            }else if($estatus[$b] == 3){
                                                
                                                echo "NO REALIZADA";
                                                
                                            }else if($estatus[$b] == 4 || $estatus[$b] == 2){
                                                echo "REALIZADA";
                                                
                                            }                                     
                                            echo "</td>
                                            <!--                                             // defino semaforo para determinar si los allazgos registrados ya estan terminados o existe alguno pendiente
                                            // primero identificamos si se declaron o no hallazgos -->
                                            ";
                                            $declaroHallazgo = $INTRANETV2->getOne("SELECT xt_hallazgo FROM SGI_Auditorias WHERE xt_claveAuditoria = '$clave[$b]' LIMIT 1");
                                            
                                            $existeHallazgo = $INTRANETV2->getOne("SELECT xt_claveHallazgo FROM SGI_Auditorias_Hallazgos WHERE xt_claveAuditoria = '$clave[$b]' LIMIT 1");
                                            echo "<td align='center'>";
                                            
                                            if(empty($declaroHallazgo) && empty($existeHallazgo) && $estatus[$b] == 1){
                                                echo "";
                                            
                                            } else if((($declaroHallazgo == 'No')||empty($declaroHallazgo)) && empty($existeHallazgo) && (($estatus[$b] == 2) || ($estatus[$b] == 4))){
                                                echo "<IMG SRC='../../Imagenes/ICN_Estrella_Amarilla_Auditoria.png' width=17 height=17>";
                                            }elseif ($estatus[$b] == 1) {
                                                echo "";
                                            } else if(($declaroHallazgo == 'Si' || empty($declaroHallazgo)) && !empty($existeHallazgo)){
                                            
                                                //1,.Obtengo los hallazgos
                                                    
                                                $d = $INTRANETV2->Execute("SELECT xt_claveHallazgo FROM SGI_Auditorias_Hallazgos WHERE xt_claveAuditoria = '$clave[$b]'");
                                                $i=0;

                                                while($listIssue = $d->fetchRow()){
                                                    //obtengo el codigo de la correctiva 
                                                    $c = $INTRANETV2->Execute("SELECT xt_claveTratamiento FROM SGI_Auditorias_Hallazgos_Tratamientos WHERE xt_claveHallazgo = '$listIssue[0]'");
                                                    echo $xt_claveHallazgo;
                                                    while ($listCodC = $c->fetchRow()){
                                                        $cod = $listCodC[0];
                                                        

                                                        //obtengo la ultima etapa

                                                         $semaforoTerminada[$i] = $INTRANETV2->getOne("SELECT xt_titulo FROM SGI_Acciones_Preventivas_Correctivas_Etapas WHERE xt_codigoAccion = '$cod' ORDER BY xn_etapa DESC LIMIT 1");
                                                         $statusSolicitud[$i] = $INTRANETV2->getOne("SELECT DISTINCT xt_status FROM SGI_Quejas_Solicitudesv2 WHERE xt_quejaSolicitud = '$cod' ORDER BY xn_numero DESC LIMIT 1");
                                                         $accionEvaluada[$i] = $INTRANETV2->getOne("SELECT DISTINCT xn_status FROM SGI_Acciones_Preventivas_Correctivas WHERE xt_claveAccion = '$cod' LIMIT 1");
                                    
                                                            if(($statusSolicitud[$i] == 'TERMINADA' || $semaforoTerminada[$i] == 'EVALUACION' || !empty($accionEvaluada[$i]))){
                                                                $banderaT[$i] = 1;
                                                            }else{
                                                                $banderaT[$i] = 0;
                                                            }

                                                            //echo $banderaT[$i];
                                                        }

                                                         $i++;
                                                        
                                                    }//fin del while  

                                            
                                                    $igualT = count(array_unique($banderaT)) === 1;
                                                    //echo $banderaT[0];
                                                    if($igualT==true && $banderaT[0] == 1){
                                                        echo "<IMG SRC='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width=10 height=10>";
                                                    } else {
                                                        echo "<IMG SRC='../../Imagenes/ICN_SemaforoRojoOscuro.png' width=10 height=10>";
                                                    }
                                                
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
