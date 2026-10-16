<?php error_reporting(0); ?>
<?php
/*
 *@author Samantha Abam Donoso
 *@author Octavio García Robles
 *@version 2.0
 *@copyright Copyright (c) 2014, Grupo Escalante Agencias Aduanales S.C.
 */
 /*
$nombrephp = 'altaAcuerdo.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

if($_GET['id'] != ""){
	
	$id = $_GET['id'];
	
} else if($_POST['id'] != ""){
	
	$id = $_POST['id'];
	
}

if($_GET['cd'] != ""){
	
	$ciudad = $_GET['cd'];
	
} else if($_POST['cd'] != ""){
	
	$ciudad = $_POST['cd'];
	
}

if(($_POST['fecha'] == "") || ($_POST['titulo'] == "") || ($_POST['descripcion'] == "")){
	
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Agregar Acuerdo</title>
                 <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
                <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
                <link type="text/css" href="../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
                <script type="text/javascript" src="../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
                <script type="text/javascript" src="../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
                <script type="text/javascript">;
                    $(function(){
                        $(".DatP").datepicker({ dateFormat: 'yy-mm-dd',
                         monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] ,
                         dayNamesMin:  ['Dom','Lun','Mar','Mie','Jue','Vie','Sab']
                        
                         });
                    });
                </script>
                <script type="text/javascript">
                    function reCargarPadre(){
                        opener.location.reload();
                        window.close();
                    }
                </script>
                
            </head>
            <body>
    <?php
	//echo "fecha:".$_POST['fecha'].", agenda:".$_POST['agenda']."<br>";
	echo "<div id='wrapperPopUp'>";
		echo "<form name='altaAcuerdo' method='post' action='altaAcuerdo.php'>";	
		echo "<table border='0' align='center' name='Encabezado'>";
			echo"<tr>";
				echo"<td align='center' id='titulo1'>";
					echo "<font>Acuerdo</font>";
				echo"</td>";
			echo"</tr>";
			
			echo"<tr></tr>";
			
			echo"<tr height='40'> </tr>";
		echo "</table>";
		//CUERPO FICHA ALTA

		echo "<table border='0' align='center' width='450px'>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineTop' width='450px'></td>";
			echo "</tr>";
	
			echo "<tr height='15px'><td></td></tr>";
			
			echo "<tr>";
				echo "<td id='iconosTexto2'>Fecha</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td><input type='text' class='DatP' name='fecha' size='10'></td>";
			echo "</tr>";
	
			echo "<tr height='20px'><td></td></tr>";
			
			echo "<tr>";
				echo "<td id='iconosTexto2'>Título</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td>";
					echo "<input type='text' name='titulo' size='72'>";
					echo "<input type='hidden'  name='id' value='".$id."'>";
					echo "<input type='hidden'  name='cd' value='".$ciudad."'>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='20px'><td></td></tr>";
			
			echo "<tr>";
				echo "<td id='iconosTexto2'>Descripción</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td>";
					echo "<textarea name='descripcion' style='width:447px; height:100px;'></textarea>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='40px'>";
				echo "<td valign='bottom' align='right'>";
					echo "<input type='image' onclick='SubmitForm(this.form);' src='../Imagenes/ICN_BotonEnviar.png' width='90px' height='29px'>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr height='10px'><td></td></tr>";
			
			echo "<tr>";
				echo "<td id='titleBlueLineBottom'></td>";
			echo "</tr>";
		
			echo "<tr height='30px'>";
				echo "<td align='right'></td>";
			echo "</tr>";
				
		echo "</table>";
		echo "</form>";
	echo "</div>";
	
	?>
    	</body>
    </html>
    <?php
	
} else if(($_POST['fecha'] != "") && ($_POST['titulo'] != "") && ($_POST['descripcion'] != "")){
	
	$fechaInsert = date('Y-m-d', strtotime($_POST['fecha']));
	
	$tituloInsert 		= $_POST['titulo'];
	
	$descripcionInsert 	= $_POST['descripcion'];
	
	$anio 				= date('Y', strtotime($_POST['fecha']));
	
	$maximo = 0;
	//echo "fecha:".$fechaInsert.", agenda:".$agendaInsert.", anio:".$anio.", Max:".$maximo."<br>";
	
	$s = $INTRANET->Execute("SELECT MAX(xn_numero) FROM SGI_Acuerdos WHERE YEAR(xd_fecha) = $anio AND xt_ciudad = '$ciudad' ");
	
	while($r = $s->fetchRow()){
		
		$maximo = $r[0];
		
	} unset($r); unset($s);
	
	$maximo++;
	
	$anio = date('y', strtotime($_POST['fecha']));
	
	if(strlen($maximo) == 1){
		$codigo = "A-".$anio."-".$ciudad."-00".$maximo;
		
	} else if(strlen($maximo) == 2){
		$codigo = "A-".$anio."-".$ciudad."-0".$maximo;
		
	} else if(strlen($maximo) == 3){
		$codigo = "A-".$anio."-".$ciudad."-".$maximo;
		
	}
	
	$personalID = $INTRANET->getOne("SELECT kp_personalId FROM SGI_Empleados WHERE kf_usuario = '$usuarioId' ");
	
	if($INTRANET->Execute("INSERT INTO SGI_Acuerdos (xt_claveAcuerdo, xt_titulo, xt_descripcion, xd_fecha, kf_reunionID, xn_numero, kf_personalID, xt_ciudad) 
											 VALUES ('$codigo', '$tituloInsert', '$descripcionInsert', '$fechaInsert', $id, $maximo, $personalID, '$ciudad') ")){
		
		?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <title>Agregar Acuerdo</title>
                     <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
                    <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
                    <link type="text/css" href="../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
                	<script type="text/javascript" src="../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
                	<script type="text/javascript" src="../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
                    <script type="text/javascript">;
                        $(function(){
                            $(".DatP").datepicker({ dateFormat: 'yy-mm-dd',
                             monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] ,
                             dayNamesMin:  ['Dom','Lun','Mar','Mie','Jue','Vie','Sab']
                            
                             });
                        });
                    </script>
                    <script type="text/javascript">
                        function reCargarPadre(){
                            opener.location.reload();
                            window.close();
                        }
                    </script>
                    
                </head>
                <body>
        <?php
		
		echo "<script type='text/javascript'>reCargarPadre()</script>";
		
		?>
            </body>
        </html>
        <?php
		
	} else{
		
		?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <title>Agregar Acuerdo</title>
                     <?php
			if($estiloUsuario == 1){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			}
			?>
                    <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
                    <link type="text/css" href="../Librerias/JQuery/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
                	<script type="text/javascript" src="../Librerias/JQuery/js/jquery-1.6.2.min.js"></script>
                	<script type="text/javascript" src="../Librerias/JQuery/js/jquery-ui-1.8.16.custom.min.js"></script>
                    <script type="text/javascript">;
                        $(function(){
                            $(".DatP").datepicker({ dateFormat: 'yy-mm-dd',
                             monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] ,
                             dayNamesMin:  ['Dom','Lun','Mar','Mie','Jue','Vie','Sab']
                            
                             });
                        });
                    </script>
                    <script type="text/javascript">
                        function reCargarPadre(){
                            opener.location.reload();
                            window.close();
                        }
                    </script>
                    
                </head>
                <body>
        <?php
		
		echo "<div id='wrapperPopUp'>";
			echo "<table border='0' align='center' name='Encabezado'>";
				echo"<tr>";
					echo"<td align='center' id='titulo1'>";
						echo "Acuerdo No Agregado";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='70'><td></td></tr>";
			echo "</table>";
			
			echo "<table border='0' align='center' width='450px'>";
					
				echo "<tr>";
					echo "<td colspan='2' id='titleBlueLineBottom'></td>";
				echo "</tr>";
		
				echo"<tr height='15px'>";
					echo"<td colspan='2'></td>";
				echo"</tr>";
				
				echo "<tr align='left' height='20px' >";
					echo "<td id='iconosTexto2' align='center' colspan='2'>Error</td>";
				echo "</tr>";
				
				echo"<tr align='left'>";
					echo "<td  align='center' colspan='2'>";
						echo "No se pudo agregar el Acuerdo.";
					echo"</td>";
				echo "</tr>";
				
				echo"<tr height='10'><td colspan='2'></td></tr>";
				
				echo"<tr height='40'>";
					echo"<td valign='bottom' align='right' colspan='2'>";
						echo "<input type='submit' value='Finalizar' onclick='reCargarPadre()'>";
					echo"</td>";
				echo"</tr>";
				
				echo"<tr height='10px'><td colspan='2'></td></tr>";
				
				echo "<tr>";
					echo "<td colspan='2' id='titleBlueLineBottom'></td>";
				echo "</tr>";
				
				echo "<tr height='30'>";
					echo "<td align='right' colspan='2'></td>";
				echo "</tr>";
						
			echo "</table>";
			
			echo "</form>";
		echo "</div>";
		
		?>
            </body>
        </html>
        <?php
		
	}
}
