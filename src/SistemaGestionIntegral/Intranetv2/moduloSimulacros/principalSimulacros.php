<?php
$nombreModulo="Simulacros";
$nombrephp = "principalSimulacros.php";
//incluyo los archivos necesarios
require_once("../../../Librerias/adodb/adodb.inc.php");
require_once("header.php"); 
require_once("consultas/consultaSimulacros.php");
require_once("consultas/consultasUsuarios.php");
require_once("consultas/consultasCiudades.php");
require_once("../../../Consultas/ConsutasGlobales.php");
//obtengo arreglo de las personas que tienen permisos para hacer modificaciones al simulacro
$usuariosAdmin = $con_usuario->getUsuariosAdmin();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8">
            <title>Simulacros</title>
        </head>
<body>
        
        <table border='0' align='right' width='100%' id='ocultar' style='display:block;'>

            <?php if (in_array($usuarioId, $usuariosAdmin)) { ?>
            <tr>
                <td colspan="2" align="center">
                    <a title='Agregar simulacro' href='vistas/simulacro/altaSimulacro.php'>
                    <img src='../../../Imagenes/ICN_BotonAgregar.png' width='95px' height='30' alt='Agregar simulacro' /></a>
                </td>
            </tr> <?php } ?>

            <tr style="height: 20"><td></td></tr>
            <tr>
                <td></td>
                <td align='center' id='iconosTexto2' onClick='show(1);' width='100%' style="cursor: pointer;">Filtro</td>
            </tr>
        </table>
        <form method='POST' action='principalSimulacros.php'>
        <table border='0' align='center' width='100%' id='mostrar' style='display:none;'>
            <tr>
                <td></td>
                <td align='center' width='150px' id='iconosTexto2' onClick='show(0);'>Ciudad</td>
                <td align='center' width='150px' id='iconosTexto2' onClick='show(0);'>Status</td>
                <td align='center' width='150px' id='iconosTexto2' onClick='show(0);'>Año</td>
                <td align='center' width='150px' id='iconosTexto2' onClick='show(0);'>Categoría</td>
                <td width="35%"></td>
            </tr>

            <tr>
                <td width="35%"></td>
                <td height="20px" id='breadcrumbs' align='center' width='150px'>
                     <?php  opcionesCiudades(); ?>
                </td>

                <td id='breadcrumbs' align='center' width='150px'>
                    
                    <select name='statusFiltro'>
                            <option value=''>Selecciona....</option>
                            <option value='1'>Sin asignar</option>
                            <option value='2'>Asignado</option>
                            <option value='3'>En proceso</option>
                            <option value='4'>Por evaluar</option>
                            <option value='5'>Terminado</option>                           
                    </select>
                </td>

                <td id='breadcrumbs' align='center' width='150px'>
                    
                        <?php opcionesanio(); ?>
                     
                </td>
                <td id='breadcrumbs' align='center' width='150px'>
                    <select name='categoryFiltro'>
                        <option value=''>Selecciona...</option>
                        <?php $simulacro->opcionesCategorias(); ?>
                    </select>
                </td><td width="35%"></td>              
            </tr>
            
            <tr><td></td>
                    <td align='center' colspan='4' height="50px">
                        <input type='image' onclick='SubmitForm(this.form);' src='../../../Imagenes/ICN_BotonEnviar.png' width='80px' height='20'>
                    </td><td width="35%"></td>
            </tr>
        </table>
        </form>
        <?php 

        //valido que se hayan recibido datos y guardo en variabkes para su uso
        if (isset($_REQUEST['ciudad'])){

        //echo $_REQUEST['ciudad'];

        $seleccionCity = $_REQUEST['ciudad'];
        $seleccionStatus = $_REQUEST['statusFiltro'];
        $seleccionYear = $_REQUEST['anio'];
        $seleccionCategory = $_REQUEST['categoryFiltro'];

            //si recibo filtro de ciudad genero parte de la consulta
            if (!empty($seleccionCity)) {
                // $sqlCity = "AND xt_ciudad = '".$seleccionCity."' ";
                if ($seleccionCity != "Todas")
                { $sqlCity = "AND xt_ciudad = '".$seleccionCity."' ";}
                else { $sqlCity = '';}

            }else{ $sqlCity = ''; }

            if (!empty($seleccionStatus)) {
                $sqlStatus = "AND xt_statusSimulacro = ".$seleccionStatus." ";
            }else{ $sqlStatus = ''; }
            if (!empty($seleccionYear)) {
                //$sqlYear = "AND xd_fechaProgramada LIKE '".$seleccionYear."%' ";
                if ($seleccionYear != "Todas")
                { $sqlYear = "AND xd_fechaProgramada LIKE '".$seleccionYear."%' ";}
                else { $sqlYear = '';}
            }else{ $sqlYear = ''; }
            if (!empty($seleccionCategory)) {
                $sqlCategory = "AND xt_tipoSimulacro = '".$seleccionCategory."' ";
            }else{  $sqlCategory = ''; }
        }else {
            
            $seleccionCity = '';
            $seleccionStatus = '';
            $seleccionYear = '';
            $seleccionCategory = '';
            $sqlCity = '';
            $sqlStatus = '';
            $sqlYear = '';
            $sqlCategory = '';
            $filtroSql = '';
        }//fin de condicion si se pasan valores por POST
        //concateno todas las condiciones segun filtros recibidos

        $filtroSql = $sqlCity.$sqlStatus.$sqlYear.$sqlCategory;

        if (!empty($filtroSql)) {
            $sql = $filtroSql;
        }else{
            $filtroSql = "";
            $sql = "";
        }
        //genero tabla de simulacros
        $simulacro->tablaSimulacro($sql, $usuarioId);
        ?>
        </body>
    </html>