<?php error_reporting(0); ?>
﻿<?php


$nombrephp = 'tableroSolicitudesyQuejas.php';
require_once("../../../ConexionDBT.php");
require_once("../../../ConexionIntranet2.php");
require_once("../../../compruebaUsuario.php");

 error_reporting(E_PARSE);
$breadcrumb = "<a href='../../../Home.php' id='breadcrumbs'> Home / </a><a href='../../comunicacionInterna.php' id='breadcrumbs'> Comunicación Interna </a>";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <title>Tablero de Solicitudes</title>
        
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
        
        <link rel="shortcut icon" type="image/x-icon" href="../../../Imagenes/ICN_PestanaWebGE.png">
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
        <script>
        	function muestraPersonalizada(){
					var form1 = document.getElementById("ocultaPersonalizada");
					var form2 = document.getElementById("ocultaCodigo");
					if(form1.style.display ==  'none'){
						form2.style.display = 'none';
						form1.style.display = 'block';			
						}else{
							form1.style.display =  'none';
						}
			}
			
			function muestraCodigo(){
				var form1 = document.getElementById("ocultaPersonalizada");
				var form2 = document.getElementById("ocultaCodigo");
				if(form2.style.display == 'none'){
					form1.style.display = 'none';
					form2.style.display = 'block';
				}else{
					form2.style.display = 'none';
				}
				
			}
 
			function cerrarManual(codigo)
			{
				//var elemento= document.getElementById();

				$("#step1_"+codigo).attr({
					"src" : "https://escalante.com.mx/Sistemas/INTRANET_GEA/Imagenes/img_load.gif"
				});

				 $.ajax({

                type: "POST",

                url: "cierreGlobalScripts.php",

                data: {codigo: codigo, Consulta:1}, //veremos que accion realizara

                //timeout:1000,

                success: function (dataResponse) {

                    console.log(dataResponse);

                   	$("#step1_"+codigo).attr({
					"src" : "https://escalante.com.mx/Sistemas/INTRANET_GEA/Imagenes/ICN_BotonVerde.png"
				});


                },

                complete: function () {

                    //	elemento.attr("src", "images/card-front.jpg"); 

                }

            });

			}
        </script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    </head>
        
    <body>
        <div id="wrapperSolicitudes" align="center">
			<table border="0" align="center" width="800px" >
                <tr>
                    <td align="left" id="breadcrumbs">Usuario: <?php echo $usuarioId; ?></td>
                </tr>
                
                <tr height="80px"><td></td></tr>
                
                <tr>
                    <td align="center"  ><h3>Se cerraran las siguientes Solicitudes </h3></td>
                </tr>
                
                </table>  
			
			<table border="0" align="center" >

			<?php

				echo "<tr style='height: 21px' id='fileItem'> <th> Codigo </th><th></th>  <th> Titulo  </th>  <th> Tipo </th>  <th>Ciudad </th>  <th>Fecha </th>  <th> </th></tr>   ";
			$l= $INTRANETV2->Execute('SELECT xt_quejaSolicitud, xt_titulo,xt_tipoSolicitud,xt_ciudad,xd_fecha
											FROM
												SGI_Quejas_Solicitudesv2 
											WHERE
												xt_status = "REVISION" 
												AND ( xt_pdr = "Gerente_Sistemas" OR xt_pdr = "Gilberto_Fernandez" OR xt_pdr = "Rodrigo_Romo" ) 
												AND xd_fecha < DATE_SUB( CURDATE(), INTERVAL 30 DAY ) 
											ORDER BY 	xd_fecha');
			while($i= $l->fetchRow()){

					echo "<tr style='height: 21px' id='fileItem'> <td> <a  target='_blank' href='fichaSolicitudv2.php?codigo=".$i[0]."'>  ".$i[0]." </a> </td> <td width='30px'>   </td>  <td> ".$i[1]."  </td>  <td> ".$i[2]." </td>  <td>".$i[3]." </td>  <td>".$i[4]." </td> <td>
					<img id='step1_".$i[0]."'  src='https://escalante.com.mx/Sistemas/INTRANET_GEA/Imagenes/ICN_Boton_Azul.png' style='cursor: pointer; height: 15px;  idth='15px''' onclick=cerrarManual('".$i[0]."') > </td>   </tr>  ";
				 
			}
            
            
  echo" </table>   </body>";
echo"</html>";
?>
  