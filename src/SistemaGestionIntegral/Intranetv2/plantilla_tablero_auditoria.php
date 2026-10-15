<?php

require_once("../../ConexionIntranet2.php");

$oficinas = $INTRANETV2->GetArray("SELECT DISTINCT xt_ciudad FROM SGI_Auditorias");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8">
    <title>Tablero de Auditorías</title>
    <link type='text/css' rel='stylesheet' href='../../css/styleHomePage.css'/>
    <link rel="shortcut icon" type="image/x-icon" href="../../Imagenes/ICN_PestanaWebGE.png">
</head>
        
<body>

    <div id='wrapperRiesgos'>
        <table border='0' align='center' width='1160px' style='margin-top:-110px;'>
            <tr>
                <td id='breadcrumbs' width='1160px' align='left'>Usuario: ".$usuarioId."</td>
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
                                <font style='display:inline-block;'>".$breadcrumb."</font>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr height='40'> </tr>
            
            <td align='center'><a href='altaRiesgoPopUpv2.php'><img src='../../../Imagenes/ICN_BotonAgregar.png' width='90' height='29'> </a></td>
        </table>

        <!-- banan de navegacion de intranet -->
        <table border='0' align='center' id='mapaIntranet' style='display:none;'>
            <!-- include("../../navegacion_banana.php"); -->
        </table>

        
        <table border='0' align='center'>
            <tr height='100'><td></td></tr>
        </table>   

        <table border='0' align='center' width='1150' id='ocultar' style='display:block;'>
            <tr>
                <td colspan='7' align='left' id='iconosTexto2' style='cursor:pointer;' onClick='show(1); '>Filtrar</td>
            </tr>
        </table> 

        <table border='0' align='center' width='1150' id='mostrar' style='display:none;'>
            <tr>

                <td colspan='7' align='left' id='iconosTexto2' onClick='show(0);'> Filtrar </td>
            </tr>
            
            <tr height='5'></tr>

            <!-- ///CATEGORIAS DE LOS FILTROS -->
            <tr>
                <td align='left' id='breadcrumbs' width='160' >Ciudad</td>
                <td align='left' id='breadcrumbs' width='180' >Categoria Internos</td>
                <td align='left' id='breadcrumbs' width='190' >Categoria Externos</td>
                <td align='left' id='breadcrumbs' width='160' >Amenaza</td>
                <td align='left' id='breadcrumbs' width='160' >Protección</td>
                <td align='left' id='breadcrumbs' width='300' >Tratamiento</td>
                <td align='left' id='breadcrumbs' width='160' >Vulnerabilidad</td>
            </tr>
                
            <tr height='10'></tr>
            
            <tr>
                <td id='breadcrumbs' valign='top'>
                    <input type='checkbox' name='ciudad[]' value='".$cdValor[$a]."' checked='checked'>".$ciudades[$a]."<br>
                
                </td>

                <!-- ///OPCIONES PARA CATEGORIA INTERNOS -->
                <td id='breadcrumbs' valign='top'>
                    <input type='checkbox' name='categoriaI[]' value='Todas'> Todas <br>
                    <input type='checkbox' name='categoriaI[]' value='".$a."' checked='checked'>".$internas[$a]."<br>
                </td>

                <!-- ///OPCIONES PARA CATEGORIA EXTERNOS -->
                <td id='breadcrumbs' valign='top'>
                    <input type='checkbox' name='categoriaE[]' value='Todas'> Todas <br>   
                    <input type='checkbox' name='categoriaE[]' value='".$a."' checked='checked'>".$externas[$a]."<br>        
                </td>

                <!-- ///OPCIONES PARA CATEGORIA AMENAZA -->
                <td id='breadcrumbs' valign='top'>
                    <input type='checkbox' name='amenaza[]' value='Todas'> Todas <br>
                    <input type='checkbox' name='amenaza[]' value='".$amenazas[$a]."' checked='checked'>".$amenazas[$a]."<br>
                </td>

                <!-- ///OPCIONES PARA CATEGORIA PROTECCION    -->
                <td id='breadcrumbs' valign='top'>
                    <input type='checkbox' name='proteccion[]' value='Todas'> Todas <br>
                        <input type='checkbox' name='proteccion[]' value='".$protecciones[$a]."' checked='checked'>".$protecciones[$a]."<br>
                </td>
        
                <!-- ///OPCIONES PARA CATEGORIA VULNERABILIDAD    -->
                <td id='breadcrumbs' valign='top'>
                    <input type='checkbox' name='vulnerabilidad[]' value='Todas'> Todas <br>
                    <input type='checkbox' name='vulnerabilidad[]' value='".$vulnerabilidades[$a]."' checked='checked'>".$vulnerabilidades[$a]."<br>
                </td>
        
            </tr>
            
            <tr height='20'> </tr>
            
            <tr>
                <td align='center' colspan='7'><input type='image' onclick='SubmitForm(this.form);' src='../../Imagenes/ICN_BotonEnviar.png' width='90' height='25'> </td>
            </tr>
        </table>

        <?php
        for($a = 0; $a<count($oficinas); $a++){
            echo "
            <table border='0' align='center' width='1150'>
                        
                <tr height='10'> </tr>
                
                <tr>
                    <td id='titulo2Blanco' align='left' width='1150'>".$oficinas[$a][0]."</td>
                </tr>

                <tr>
                    <td id='titleBlueLineBottom'> </td>
                </tr>
                            
            </table>

            <table border='0' align='center' width='1100'>
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
                                <td align='left' > </td>
                                <td align='left' >Código</td>
                                <td align='left' >Título</td>
                                <td align='left' >Fecha</td>
                                <td align='left' >Estatus</td>
                            </tr>
                            
                            <tr height='10'> </tr> 
            ";

                            
            
                            for($b=0; $b<5; $b++){
                                echo "
                                <tr id='fileItem'>
                                    <td align='left' > </td>
                                    <td align='left' >1</td>
                                    <td align='left' >2</td>
                                    <td align='left' >3</td>
                                    <td align='left' >4</td>
                                </tr>";  
                            }
                                
            
                            
            echo "                       
                        </table>
                    </td>
                    
                </tr>   

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
                                <td align='left' > </td>
                                <td align='left' >Código</td>
                                <td align='left' >Título</td>
                                <td align='left' >Fecha</td>
                                <td align='left' >Estatus</td>
                            </tr>
                            
                            <tr height='10'> </tr> 
            ";

                            
            
                            for($b=0; $b<5; $b++){
                                echo "
                                <tr id='fileItem'>
                                    <td align='left' > </td>
                                    <td align='left' >1</td>
                                    <td align='left' >2</td>
                                    <td align='left' >3</td>
                                    <td align='left' >4</td>
                                </tr>";  
                            }
                                
            
                            
            echo "                       
                        </table>
                    </td>
                    
                </tr>   

            </table>
        ";
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