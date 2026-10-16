<?php
$nombrephp = 'tableroReuniones.php';
require_once("../../ConexionDBT.php");
require_once("../../compruebaUsuario.php");
require_once("../../ConexionIntranet2.php");
error_reporting(E_PARSE);
$contador = 0;
$t = $INTRANET->Execute("
    SELECT
    CASE O.xt_codigoCiudad
    WHEN 'ALL' THEN
        'GRL'
    WHEN 'DF' THEN
        'CMX'
    ELSE
        O.xt_codigoCiudad
    END,
     (
        SELECT
            CASE CO.xt_descripcion
        WHEN 'Mexico DF' THEN
            'Ciudad de México'
        ELSE
            CO.xt_descripcion
        END
        FROM
            IntranetGEA.IntranetGEA_CATALOGO_OFICINA CO
        WHERE
            CO.xt_oficina = O.xt_codigoCiudad
    )
    FROM
        IntranetGEA.IntranetGEA_Usuarios_Oficina O
    WHERE
        O.kf_usuarioId = '".$usuarioId."'
    AND 
        CASE O.xt_codigoCiudad
        WHEN 'DF' THEN
            'CMX'
        ELSE
            O.xt_codigoCiudad
        END IN (
            SELECT
                E.xt_ciudad
            FROM
                INTRANET2.SGI_Simulacros E
        )
");
while($p = $t->fetchRow()){
    $ciudades[$contador] = $p[1];
    $cdValor[$contador]  = $p[0];
    $contador++;    
}unset($p);unset($t);unset($contador);

$index = 0;


$indice                 = 1;
$ciudadesDisponibles    = NULL;

$s = $INTRANET->Execute("SELECT
        CASE xt_codigoCiudad
        WHEN 'ALL' THEN
            'GRL'
        WHEN 'DF' THEN
            'CMX'
        ELSE
            xt_codigoCiudad
        END
        FROM
            IntranetGEA_Usuarios_Oficina
        WHERE
            kf_usuarioId = '$usuarioId'
        ORDER BY
            xt_codigoCiudad
    ");

while($r = $s->fetchRow()){
    
     $ciudadesDisponibles[$indice] = $r[0];
    
    $indice++;
    
} unset($r); unset($s); unset($indice);

$categoriaUsr   = $INTRANET->getOne("SELECT kf_categoria FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");

$ciudadDefault  = $INTRANET->getOne("SELECT CASE xt_ciudad WHEN 'ALL' THEN 'GRL' WHEN 'DF' THEN 'CMX' ELSE xt_ciudad END FROM IntranetGEA_USUARIOS WHERE kp_usuario = '$usuarioId' ");

if($_POST['ciudad'] != ""){
    $ciudadShow = $_POST['ciudad']; 
} else if($_GET['ciudad'] != ""){
    $ciudadShow = $_GET['ciudad'];
} else{
    $ciudadShow = $ciudadDefault;
}

for($o=0; $o <count($cdValor); $o++){
    
    if($cdValor[$o] == $ciudadShow){
        $imprimeCiudad = $ciudades[$o];
    }
    
} unset($o);


             

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8">
            <title>Tablero de Simulacros</title>
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
            </script>
            
            <script>
                function show(valor){
                    if(valor == 1){
                        document.getElementById("mostrar").style.display="block";
                        document.getElementById("ocultar").style.display="none";
                    } else if (valor == 0){
                        document.getElementById("mostrar").style.display="none";
                        document.getElementById("ocultar").style.display="block";
                    }
                }
            </script>
        </head>
        <body>
<?php

$breadcrumb="<a href='../../Home.php' id='breadcrumbs'> Home / </a><a href='../homeSGI.php' id='breadcrumbs'> Sistema de Gestión Integral / </a> 
             <a href='../Modulos.php' id='breadcrumbs'> Modulos </a>";

echo "<div id='wrapperSolicitudes' align='center'>";
    echo "<form method='post' action='tableroSimulacros.php'>";    
    echo "<table border='0' align='center' name='Encabezado' style='width:1300px'>";
        echo "<tr>";
            echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId."</td>";
        echo "</tr>";
        
        echo "<tr height='80px'><td></td></tr>";
        
        echo "<tr>";
            echo "<td align='center' id='titulo1'>Simulacros</td>";
        echo "</tr>";
        echo"<tr>"; 
                echo"<td align='center' valign='top' height='20px'>";
                    echo "<table border='0' align='center'>";
                        echo "<tr height='20px'>";
                            echo "<td valign='middle'>";
                                echo "<img src='../../Imagenes/ICN_PointMeTo.png' id='banana1' style='display:none;' onclick='showBanana(0);'>";
                                echo "<img src='../../Imagenes/ICN_PointMeTo.png' id='banana0' style='display:inline-block;' onclick='showBanana(1);'>";
                            echo "</td>";
                            
                            echo "<td valign='middle'>";
                                echo "<font style='display:inline-block;'>".$breadcrumb."</font>";
                            echo "</td>";
                        echo "</tr>";
                    echo "</table>";
                echo"</td>";
            echo"</tr>";
        
        echo "<tr>";
            echo "<td align='center'>";
                if(($usuarioId == 'Rodrigo_Romo') || ($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'cozy')|| ($usuarioId == 'Ricardo_Garcia') || ($usuarioId == 'sdelap') || ($usuarioId == 'Daniel_Guadarrama') || ($usuarioId == 'Cecilia_Flores') || ($usuarioId == 'Gerardo_Martinez') || ($usuarioId == 'Antonio_Astorga') ||($usuarioId == 'Denisse_Valladares') || ($usuarioId == 'Christian_Martinez')|| ($usuarioId == "Miguel_Patiño")  || ($usuarioId == "Alberto_Martinez") || ($usuarioId == "Gerardo_Nunez") || ($usuarioId == "Jorge_Doring") || ($usuarioId== "Carmina_Cruz") || ($usuarioId== "Akari_Hernandez")|| ($usuarioId== "Adlemy_Tah")|| ($usuarioId== "Guillermo_Quezada")){
                    echo "<a href='altaSimulacro.php'><img src='../../Imagenes/ICN_BotonAgregar.png' width='90' height='29'></a>";
                }
            echo "</td>";
        echo "</tr>";
        
        echo "<tr height='30px'><td></td></tr>";
    echo "</table>";
    
            //banana de navegacion intranet
            echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
                include("../../navegacion_banana.php");
            echo "</table>";
                
            echo "</td>";
        echo "</tr>";
        
    echo "<table border='0' align='center'>";
        echo"<tr height='100'><td></td></tr>";
    echo "</table>"; 
    
        echo "<table border='0' align='center' width='700px' id='ocultar' style='display:block;'>";
            echo"<tr>";
                echo"<td align='left' id='iconosTexto2' onClick='show(1);' width='700px'>Filtro</td>";
            echo"</tr>";
            
            echo"<tr height='30px'><td></td></tr>";
        echo"</table>";

        ///TABLA QUE MUESTRA LAS OPCIONES DE LOS FILTROS, SE DESACTIVA CON EL ONCLICK
        echo "<table border='0' align='center' width='450px' id='mostrar' style='display:none;'>";
            echo "<tr>";
                echo "<td align='center' width='150px' id='iconosTexto2' onClick='show(0);'>Ciudad</td>";
                echo "<td align='center' width='150px' id='iconosTexto2' onClick='show(0);'>Status</td>";
                echo "<td align='center' width='150px' id='iconosTexto2' onClick='show(0);'>Año</td>";
                echo "<td align='center' width='150px' id='iconosTexto2' onClick='show(0);'>Categoría</td>";
            echo "</tr>";

            echo "<tr>";
                echo "<td id='breadcrumbs' valign='left' width='150px'>";
            ///DESPLIEGA LAS CIUDADES QUE EL USUARIO TIENE DISPONIBLES
                    echo "<select name='ciudad'>";
                        echo "<option value=''>Selecciona....</option>";
                        echo "<option value='TODAS'>Todas....</option>";
                        for($a = 0; $a <count($cdValor); $a++){
                            
                            if(in_array($cdValor[$a], $ciudadesDisponibles)){
                                
                                if($cdValor[$a] != $ciudadShow){
                                    if ($cdValor[$a] == 'GRL'){
                                        echo "<option value='GRL'>General</option>";
                                    } else {
                                        echo "<option value='".$cdValor[$a]."'>".$ciudades[$a]."</option>";
                                    }
                                    
                                } else{
                                    if ($cdValor[$a] == 'GRL'){
                                        echo "<option value='GRL' selected='selected'>General</option>";
                                    } else {
                                        echo "<option value='".$cdValor[$a]."'>".$ciudades[$a]."</option>";
                                    }
                                    
                                }
                            }
                        }
                    
                    echo "</select>";
                echo "</td>";
                echo "<td id='breadcrumbs' valign='left' width='150px'>";
                    ///DESPLIEGA EL LISTADO DE AÑOS
                    echo "<select name='statusFiltro'>";
                            echo "<option value=''>Selecciona....</option>";
                            echo "<option value='1'>Sin asignar</option>";
                            echo "<option value='2'>Asignado</option>";
                            echo "<option value='3'>En proceso</option>";
                            echo "<option value='4'>Por evaluar</option>";
                            echo "<option value='5'>Terminado</option>";                            
                    echo "</select>";
                echo "</td>";
                echo "<td id='breadcrumbs' valign='left' width='150px'>";
                    ///DESPLIEGA EL ESTATUS
                    echo "<select name='yearFiltro'>";
                        echo "<option value=''>Selecciona...</option>";
                        $yy = $INTRANETV2->Execute("SELECT DISTINCT YEAR(xd_fechaProgramada) FROM SGI_Simulacros  ORDER BY xd_fechaProgramada DESC");
                        while($ff = $yy->fetchRow()){
                            $añoSimulacro = $ff[0];
                            if(!empty($añoSimulacro)){
                                echo "<option value='".$añoSimulacro."'>".$añoSimulacro."</option>";
                            }
                        }unset($ff);unset($yy);
                    echo "</select>";
                echo "</td>";
                echo "<td id='breadcrumbs' valign='left' width='150px'>";
                    ///DESPLIEGA EL CATEGORIA
                    echo "<select name='categoriaFiltro'>";
                        echo "<option value=''>Selecciona...</option>";
                        $yy = $INTRANETV2->Execute("SELECT DISTINCT xt_tipoSimulacro FROM SGI_Simulacros");
                        while($ff = $yy->fetchRow()){
                            $tipoSimulacro = $ff[0];
                            echo "<option value='".$tipoSimulacro."'>".$tipoSimulacro."</option>";
                        }unset($ff);unset($yy);
                    echo "</select>";
                echo "</td>";                
            echo"</tr>";
            echo"<tr height='15px'><td colspan='2'></td></tr>";
            echo "<tr>";
                    echo "<td align='center' colspan=3>";
                        echo "<input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='80' height='20'>";
                    echo "</td>";
            echo"</tr>";
        
            echo"<tr height='30px'><td colspan='2'></td></tr>";
        echo"</table>";// FIN DEL FILTRO POR CIUDAD
       
        $indice = 0;
        $conjuntoRegistrosCategorias = $INTRANETV2->Execute("SELECT xt_tipo, xt_nombre FROM SGI_Catalogo_Simulacros ORDER BY xt_nombre");
        while($registrosCategorias = $conjuntoRegistrosCategorias->fetchRow()){
            $categoriaSimulacro[$indice]        = $registrosCategorias[0];
            $nombreCategoriaSimulacros[$indice] = $registrosCategorias[1];
            $indice++;
        }unset($registrosCategorias);unset($conjuntoRegistrosCategorias);unset($indice);

        for ($indiceCategorias = 0; $indiceCategorias < count($categoriaSimulacro); $indiceCategorias++){
            $indice            = 0;
            $codigoSimulacro   = NULL;
            $statusSimulacro   = NULL;
            $fechaSimulacro    = NULL;
            
            $tipoSimulacro = $_POST['categoriaFiltro'];
            $estatus       = $_POST['statusFiltro'];
            $anio          = $_POST['yearFiltro'];
            $ciudadFiltro  = $_POST['ciudad'];
            if($ciudadFiltro != ''){$ciudadQuery = "xt_ciudad = '$ciudadFiltro':";}else{$ciudadQuery = "xt_ciudad IN ('CUN','LAR','NLR','QRO','TOL','VER','GRL','LR','CDMX','CMX'):";}
            if($estatus != ''){$estatusQuery = "xt_statusSimulacro = '$estatus':";}else{$estatusQuery = "";}
            if($anio != ''){$anioQuery = "YEAR(xd_fechaProgramada) = $anio:";}else{$anioQuery = '';}
            if($tipoSimulacro != ''){$tipoQuery = "xt_tipoSimulacro = '$tipoSimulacro':";}else{$tipoQuery = '';}
            
            if (!empty($ciudadFiltro)){
                if ($ciudadFiltro == 'TODAS'){
                    $ciudadQuery = "xt_ciudad IN ('CUN','LAR','NLR','QRO','TOL','VER','GRL','LR','CMX'):";
                    $concatenarFiltro = $ciudadQuery.$anioQuery.$estatusQuery.$tipoQuery;
                }else{
                    $concatenarFiltro = $ciudadQuery.$anioQuery.$estatusQuery.$tipoQuery;
                }
            } else {
                $ciudadQuery = "xt_ciudad IN ('CUN','LAR','NLR','QRO','TOL','VER','GRL','LR','CMX'):";
                $concatenarFiltro = $ciudadQuery.$anioQuery.$estatusQuery.$tipoQuery;
            }

            $filtroRemplaza = str_replace(":"," AND ",$concatenarFiltro);
            $filtroRemplazaAnd = substr($filtroRemplaza,0,-4);
            if(($estatus != '' || $anio != '' || $ciudadFiltro != '' || $tipoSimulacro != '')&&($filtroRemplazaAnd != '')){
                $query = "
                    SELECT 
                        xt_codigoSimulacro,
                        CASE xt_statusSimulacro 
                        WHEN 1 THEN 
                            'Sin asignar' 
                        WHEN 2 THEN 
                            'Asignado' 
                        WHEN 3 THEN 
                            'En proceso' 
                        WHEN 4 THEN 
                            'Por evaluar'
                        WHEN 5 THEN 
                            'Terminado'                                                          
                        END, 
                        xd_fechaProgramada,
                        xt_evaluacionSimulacro,
                        xt_pdrSimulacro,
                        xt_nombreSimulacro,
                        xt_ciudad                                          
                    FROM 
                        SGI_Simulacros 
                    WHERE 
                        xt_tipoSimulacro = '$categoriaSimulacro[$indiceCategorias]' 
                    AND 
                        ".$filtroRemplazaAnd." 
                    ORDER BY 
                        xd_fechaProgramada DESC
                ";
            }else{
                $query = "
                    SELECT
                        xt_codigoSimulacro,
                        CASE xt_statusSimulacro
                        WHEN 1 THEN 
                            'Sin asignar' 
                        WHEN 2 THEN 
                            'Asignado' 
                        WHEN 3 THEN 
                            'En proceso' 
                        WHEN 4 THEN 
                            'Por evaluar'
                        WHEN 5 THEN 
                            'Terminado'      
                        END,
                        xd_fechaProgramada,
                        xt_evaluacionSimulacro,
                        CONCAT(
                        (
                                SELECT
                                    SE.xt_Nombre
                                FROM
                                    IntranetGEA.SGI_Empleados SE
                                WHERE
                                    SE.kf_usuario = xt_pdrSimulacro
                        ),SPACE(1),
                        (
                                SELECT
                                    SE.xt_ApellidoPaterno
                                FROM
                                    IntranetGEA.SGI_Empleados SE
                                WHERE
                                    SE.kf_usuario = xt_pdrSimulacro
                        )) as nombreCompleto,
                        xt_nombreSimulacro,
                        xt_ciudad
                    FROM
                        SGI_Simulacros
                    WHERE
                        xt_tipoSimulacro = '$categoriaSimulacro[$indiceCategorias]'                     
                    ORDER BY
                      xt_codigoSimulacro,  xd_fechaProgramada DESC
                ";
            }

            $s = $INTRANETV2->Execute($query);
                    
            while($r = $s->fetchRow()){
                
                $codigoSimulacro[$indice]     = $r[0];
                $statusSimulacro[$indice]     = $r[1];
                $fechaSimulacro[$indice]      = date('Y-m-d', strtotime($r[2]));
                $evaluacionSimulacro[$indice] = $r[3];
                $pdrSimulacro[$indice]        = $r[4];
                $tituloSimulacro[$indice]     = $r[5];
                $ciudadSimulacro[$indice]     = $r[6];
                
                $indice++;
                
            } unset($r); unset($s); unset($indice);            

            if(count($codigoSimulacro)>=1){

                echo "<table border='0' align='center' style='width:1300px'>";
                
                    echo "<tr><td colspan='4' id='titulo2Blanco' >".$nombreCategoriaSimulacros[$indiceCategorias]."</td></tr>";
                    echo "<tr height='10px'><td colspan='9'></td></tr>";
                    
                echo "</table>";

                
                    $ss = $INTRANETV2->Execute("SELECT DISTINCT
                                xt_ciudad
                            FROM
                                SGI_Simulacros");
                        while($rr = $ss->fetchRow()){
                            $ciudadadDisponibles = $rr[0];

                            if($ciudadadDisponibles == 'CMX'){
                                $nombreCiudad = "Ciudad de México";
                            }
                            if($ciudadadDisponibles == 'CUN'){
                                $nombreCiudad = "Cancún";
                            }
                            if($ciudadadDisponibles == 'VER'){
                                $nombreCiudad = "Veracruz";
                            }
                            if($ciudadadDisponibles == 'TOL'){
                                $nombreCiudad = "Toluca";
                            }
                            if($ciudadadDisponibles == 'NLR'){
                                $nombreCiudad = "Nuevo Laredo";
                            }

                        echo "<table border='0' align='center' style='width:1200px'>";

                        echo "<tr><td colspan='4' id='titulo2' >".$nombreCiudad."</td></tr>";
                    
                        echo "<tr height='10px'><td colspan='4'></td></tr>";    
                        
                        echo "<tr id='titulo2'>";
                            echo "<td align='center' style='width:50px'></td>";
                            echo "<td align='center' style='width:170px'>Código</td>";
                            echo "<td align='center' style='width:150px'>Fecha</td>";
                            echo "<td align='left'   style='width:600px'>Título</td>";
                            echo "<td align='left' style='width:300px'>PDR</td>";
                            echo "<td align='center' style='width:100px'>Status</td>";
                            echo "<td align='center' style='width:200px'>Evaluación</td>";
                        echo "</tr>";
                    
                        echo "<tr>";
                            echo "<td></td>";
                            echo "<td colspan='9' id='titleBlueLineTop'></td>";
                        echo "</tr>";
                        
                        echo "<tr height='10px'><td colspan='9'></td></tr>";
                    
                    echo "</table>";

                    echo"<table align='center' border='0' style='width:1200px'>";
                        for($indiceSimulacros = 0; $indiceSimulacros < count($codigoSimulacro); $indiceSimulacros++){

                            if($ciudadadDisponibles == $ciudadSimulacro[$indiceSimulacros]){
                                echo "<tr id='fileItem'>";
                                    echo "<td style='width:50px'></td>";              
                                    echo "<td style='width:170px' align='center'>";
                                        if($statusSimulacro[$indiceSimulacros] == 'Asignado' || $statusSimulacro[$indiceSimulacros] == 'En proceso'){ 
                                            echo "<a href='simulacroElementoActualizar.php?simulacro=".$codigoSimulacro[$indiceSimulacros]."' id='fileItem' style='text-decoration: none;'>".$codigoSimulacro[$indiceSimulacros]."</a>";
                                        }else if($statusSimulacro[$indiceSimulacros] == 'Sin asignar'){
                                            echo "<a href='simulacroElementoActualizar.php?simulacro=".$codigoSimulacro[$indiceSimulacros]."' id='fileItem' style='text-decoration: none;'>".$codigoSimulacro[$indiceSimulacros]."</a>";
                                        }else{
                                            echo "<a href='simulacroElementoActualizar.php?simulacro=".$codigoSimulacro[$indiceSimulacros]."' id='fileItem' style='text-decoration: none;'>".$codigoSimulacro[$indiceSimulacros]."</a>";
                                        }
                                    echo "</td>";
                                    echo "<td style='width:150px' align='center'>".$fechaSimulacro[$indiceSimulacros]."</td>";
                                    echo "<td style='width:600px' align='left'>".$tituloSimulacro[$indiceSimulacros]."</td>";
                                    echo "<td style='width:300px' align='left'>".$pdrSimulacro[$indiceSimulacros]."</td>";                        
                                    echo "<td style='width:100px' align='center'>".$statusSimulacro[$indiceSimulacros]."</td>";

                                    if($evaluacionSimulacro[$indiceSimulacros] == 1){
                                        $boton[$indiceSimulacros] = "<img src='../../Imagenes/ICN_SemaforoVerdeOscuro.png' width='10' height='10'>";
                                    }
                                    if($evaluacionSimulacro[$indiceSimulacros] == 2){
                                        $boton[$indiceSimulacros] = "<img src='../../Imagenes/ICN_SemaforoRojoClaro.png' width='10' height='10'>";
                                    }
                                    if($evaluacionSimulacro[$indiceSimulacros] == 3){
                                        $boton[$indiceSimulacros] = "<img src='ICN_SemaforoAmarillo.png' width='10' height='10'>";
                                    }

                                    echo "<td style='width:200px' align='center'>".$boton[$indiceSimulacros]."</td>";
                                echo "</tr>";
                                echo"<tr height='5px'><td colspan='9'></td></tr>";
                            }
                        }
                    echo "</table>";
                    
                    echo "<table border='0' align='center' style='width:1300px'>";
                        echo "<tr>";
                            echo "<td style='width:35px'></td>";
                            echo "<td colspan='9' id='titleBlueLineTop'></td>";
                        echo "</tr>";
                        
                        echo "<tr height='40px'><td colspan='9'></td></tr>";
                    echo "</table>";    
                } 
            }           
        }    
    
        echo "</form>";
    echo "</div>";
    echo "<br><br>";
?>

        </body>
    </html>