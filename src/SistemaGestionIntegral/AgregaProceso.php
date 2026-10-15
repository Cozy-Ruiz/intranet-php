<?php error_reporting(0); ?>
<?php

$nombrephp='AgregaProceso.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");
require_once("../ConexionIntranet2.php");

?>

<!DOCTYPE html>
<html lang='es'>
<meta charset='utf-8'/>
<head>
    <title>Nuevo Proceso</title>
    <?php
        if($estiloUsuario == 1){
            echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
        }else if($estiloUsuario == 2){
            echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
        }
    ?>
    <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
    <script>
        function show(){
            var option = document.getElementById("seleccion").value;
            if(option == "K"){
                document.getElementById("subproceso1").style.display="block";
                document.getElementById("subproceso2").style.display="block";
            } else{
                document.getElementById("subproceso1").style.display="none";
                document.getElementById("subproceso2").style.display="none";
            }
        }
    </script>
    <style>
        .requerido{
            color: #FFFFFF;
            background-color: #007cbd;
        }
    </style>
</head>
<body>
    <?php
       echo "<div id='wrapperPopUp'>";
        echo "<form name='agregaProceso'  id='agregaProceso' method='POST' action='AgregaProceso.php'>";
           echo "<table border='0' align='center' name='Encabezado'>";
                echo"<tr>";
                    echo"<td align='center' id='titulo1'>";
                        echo "<font>Agregar Proceso</font>";
                    echo"</td>";
                echo"</tr>";
                echo"<tr>"; 
                    echo"<td align='center'>";
                        //echo "<font>$breadcrumb</font>";
                    echo"</td>";
                echo"</tr>";
                echo"<tr height='70'> </tr>";
            echo "</table>";
	
			echo "<table border='0' align='center'>";
				echo "<tr>";
					echo "<td id='titleBlueLineTop'></td>";
				echo "</tr>";
				echo"<tr height='15'> </tr>";
			//TITULO ITEM
				echo "<tr align='left' height='20' >";
					echo "<td id='iconosTexto2' align='left'>Título</td>";
				echo "</tr>";
			//INPUT TITULO
				echo"<tr align='left'>";
					echo "<td  align='left' width='450px'>";
						echo "<input type='text' size='71' maxlength='250' name='titulo'>";
					echo"</td>";
				echo "</tr>";

				echo"<tr height='10'> </tr>";
			echo "</table>";
		

            echo "<table border='0' align='center'>";
               /* echo "<tr>";
                    echo "<td id='titleBlueLineTop' colspan='2'></td>";
                echo "</tr>";
	*/
                echo"<tr height='15'> </tr>";	
                echo "<tr align='left' height='20' >";
            //GRUPO ITEM
                    echo "<td id='iconosTexto2' align='left'>Grupo</td>";
            //MANUAL ITEM
                    echo "<td id='iconosTexto2' align='left'>Manual</td>";
                echo "</tr>";
            
                echo "<tr align='left' height='20' >";
            //INPUT GRUPO
                    echo "<td id='iconosTexto2' align='left' width='150px'>";
                        echo "<select name='grupo'>";
                            echo "<option value='' selected=''></option>";
                            echo "<option value='GE'>GE</option>";
                            echo "<option value='OT'>OT</option>";
                        echo "</select>";
                    echo "</td>";
            //INPUT MANUAL
                    echo "<td id='iconosTexto2' align='left' width='300px'>";
                        echo "<select name='area'>";
                            echo "<option value='' selected=''></option>";
                            $b = $INTRANETV2->Execute("SELECT SUBSTRING_INDEX(xt_codigoManual,'-',-1), xt_nombre FROM SGI_Catalogo_Manuales order by xt_codigoManual");
                                while($o = $b->fetchRow()){
                                    $codigoM = $o[0];
                                    $nombre  = $o[1];
                                    
                                    echo "<option value='".$codigoM."'>".$nombre."</option>";
                                }
                        echo "</select>";
                    echo "</td>";
                echo "</tr>";
                echo"<tr height='10'> </tr>";
            echo "</table>";
            
            echo "<table border='0' align='center'>";
                echo "<tr align='left' height='20' >";
            //TIPO ITEM
                    echo "<td id='iconosTexto2' align='left'>Tipo</td>";
            //CIUDAD ITEM
                    echo "<td id='iconosTexto2' align='left'>Ciudad</td>";	
                echo "</tr>";
                
                echo "<tr align='left' height='20' >";
            //INPUT TIPO
                    echo "<td id='iconosTexto2' align='left' width='150px' onchange='show()'>";
                        echo "<input type='text' name='tipo' value='Proceso' readonly='readonly'>";
                    echo "</td>";
            //INPUT CIUDAD
                    echo "<td id='iconosTexto2' align='left' width='300px'>";
                        echo "<select name='ciudad'>";
                            echo "<option value='' selected='selected'></option>";
                                $t = $INTRANETV2->Execute("SELECT xt_sucursal, xt_nombre FROM SGI_Catalogo_Sucursales ORDER BY xt_nombre ");
                                while($p = $t->fetchRow()){
                                    $ciudades = $p[1];
                                    $cdValor  = $p[0];
                                                            
                                    echo"<option value='".$cdValor."'>".$ciudades."</option>";                                                    
                                }
                        echo "</select>";
                    echo "</td>";
                echo "</tr>";
            
                echo"<tr height='20'> </tr>";
            echo "</table>";
            
            echo "<table border='0' align='center'>";
            //Proceso y Subproceso
                echo "<tr align='left' height='30' style='display:none;' id='subproceso1'>";
                    echo "<td id='iconosTexto2' align='left' width='450px'>Subconsecutivo</td>";
                echo "</tr>";
                
                echo "<tr align='left' height='30' style='display:none;' id='subproceso2'>";
                    echo "<td align='left' width='450px'><input type='text' size='71' maxlength='250' name='subConsecutivo'></td>";
                    echo "<input type='hidden' name='itera' value='ok'>";
                echo "</tr>";
                
                echo"<tr height='10'> </tr>";
            echo "</table>";
            
            echo "<table border='0' align='center'>";
                echo "<tr>";
                    echo "<td id='titleBlueLineBottom' width='450px'></td>";
                echo "</tr>";
                
                echo "<tr height='10'> </tr>";
                
                echo"<tr height='40'>";
                    echo"<td valign='bottom' align='right'>";
                        echo "<input name = 'Enviar' type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'>";
                    echo"</td>";
                echo"</tr>";
                
                echo"<tr height='10'> </tr>";
            echo "</table>";
        echo "<form>";
       echo "</div>"; 

			
	if($_POST['grupo'] != '' && $_POST['area'] != '' && $_POST['tipo'] != '' && $_POST['titulo'] != ''){

		$grupo = $_POST['grupo'];
		$area  = $_POST['area'];
		$tipo  = $_POST['tipo'];
		$ciudad = $_POST['ciudad'];
		$titulo = $_POST['titulo'];
		
		//Obtengo el ultimo proceso
		$maximoProceso = $INTRANETV2->getOne("SELECT MAX(RIGHT(xt_codigoCorto,4)) +1  FROM SGI_Procesos");
		
		
		if($ciudad == ''){$ciudad = '';}else{$ciudad = "-".$ciudad;}
			
		if(strlen($maximoProceso) == 1){

			$maximoProceso = "-K000".$maximoProceso;

		} else if(strlen($maximoProceso) == 2){

			$maximoProceso = "-K00".$maximoProceso;

		} else if(strlen($maximoProceso) == 3){

			$maximoProceso = "-K0".$maximoProceso;
		
		} else if(strlen($maximoProceso) >= 4){

			$maximoProceso = "-K".$maximoProceso;
		}
		//Codigo de proceso
		$proceso = $grupo."-".$area.$ciudad.$maximoProceso;
		
		//Elimino el caracter (-) del codigo de proceso
		$nuevoProceso = substr($maximoProceso, 1);
		
		if($INTRANETV2->Execute("INSERT INTO SGI_Procesos (xt_codigoCorto, xt_codigoProceso, xt_nombre, xd_fechaCreacion) VALUES ('$nuevoProceso','$proceso','$titulo',CURRENT_TIMESTAMP())")){
			
			$mensaje = "Registro con exito";
			echo "<script>";
			echo "if(confirm('$mensaje'));";  
			echo "window.location = 'http://escalante.com.mx/Sistemas/INTRANET_GEA/SistemaGestionIntegral/Intranetv2/fichaProceso.php?proceso=$nuevoProceso';";
			echo "</script>";
			
		}else{
			
			$mensaje = "Hubo un error al registrar. Intentar de nuevo";
			echo "<script>";
			echo "if(confirm('$mensaje'));";  
			echo "window.location = 'AgregaProceso.php';";
			echo "</script>";  
	
		}


	}
		
	
    ?>
</body>
</html>
