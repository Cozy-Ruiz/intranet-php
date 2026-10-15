<?php error_reporting(0); ?>
<?php
/*
 *@author Samantha Abam 
 *@version 1.0
 *@copyright Copyright (c) 2013, Grupo Escalante Agencias Aduanales S.C.
 */
$nombrephp='homeSGI.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8">
            <title>Busqueda de documentos</title>
             <?php
		//	if($estiloUsuario == 1){
            //	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage.css'/>";
			//}else if($estiloUsuario == 2){
            	echo "<link type='text/css' rel='stylesheet' href='../css/styleHomePage2.css'/>";
			//}*/
			?>
            <link rel="shortcut icon" type="image/x-icon" href="../Imagenes/ICN_PestanaWebGE.png">
            <link href="../../Links/Views/css/bootstrap-5.0.2/css/bootstrap.min.css" rel="stylesheet">
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
                function busquedaDocumento(){

                    try{

                        if (event.keyCode == 13 || event.which == 13){

                            var descripcion = document.getElementById('filtroDocumento').value.toLowerCase();

                            var table_inicio = document.getElementById("tablaDetalle");
                            
                            var rowCount = table_inicio.rows.length;

                            for(var i=0; i<rowCount; i++) {

                                var row = table_inicio.rows[i];
                                table_inicio.deleteRow(i);

                                rowCount--;

                                i--;
                                    

                            }

                            var xhttp = new XMLHttpRequest();                            
                            xhttp.onreadystatechange = function() {
                                if (xhttp.readyState == 4 && xhttp.status == 200) {
                                                                        
                                    if (isJson(xhttp.responseText) == true){

                                        obj = JSON.parse(xhttp.responseText);
                                        console.log(obj);
                                        
                                        objManuales = obj.RegistrosManuales[0];
                                                
                                        if(objManuales.MANUALES.length > 0){
                                                                
                                            var datos = objManuales.MANUALES;   
                                          
                                            datos.forEach(function (datosManual) {                            

                                                var table = document.getElementById("tablaDetalle"),
                                                tbody = table.getElementsByTagName("tbody")[0];
                                                tbody.setAttribute("id","bodyContenido");

                                                var row = document.createElement("tr");
                                                var cel_uno    = document.createElement("td");                            
                                                var cel_dos    = document.createElement("td");
                                                cel_uno.setAttribute("class","align-text-top");
                                                cel_uno.setAttribute("style","cursor:pointer");
                                                cel_uno.setAttribute("class","align-text-top");
                                                cel_dos.setAttribute("id","manualVinculo");

                                                //cel_uno.innerHTML    = datosManual.CodigoCompleto;
                                                cel_uno.innerHTML = '<a href="Intranetv2/fichaDocumentov4.php?id='+datosManual.Codigo+'" id="manualVinculo">'+datosManual.CodigoCompleto+'</a>';
                                                cel_dos.innerHTML    = decodeURIComponent(escape(datosManual.nombre));

                                                row.appendChild(cel_uno);
                                                row.appendChild(cel_dos);
                                                tbody.appendChild(row);

                                            }); 
                        
                                        }else{
                                            alert("No se encuentra la descripción en los registros");
                                        }
                                    }
                                    
                                }
                            };

                            xhttp.open("POST", "consultaManuales.php", true);
                            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                            xhttp.send("evento=evento&descripcion="+encodeURIComponent(descripcion));

                        }
                    }catch(error){
                        //document.getElementById("procesando_producto").innerHTML = "";
                        alert("Error al consultar producto: "+error);
                    }

                }

                function isJson(item) {
                    item = typeof item !== "string"
                        ? JSON.stringify(item)
                        : item;

                    try {
                        item = JSON.parse(item);
                    } catch (e) {
                        return false;
                    }

                    if (typeof item === "object" && item !== null) {
                        return true;
                    }

                    return false;
                }


			</script>
            
            
        </head>
        
        <body>
<?php
$breadcrumb="<a href='https://escalante.com.mx/Sistemas/INTRANET_GEA/Home.php' id='breadcrumbs'>Home</a>";

echo "<div id='wrapperFicha' align='center'>";
	echo "<table border='0' align='center' name='Encabezado' width='800px'>";
		echo "<tr>";
			echo "<td align='left' id='breadcrumbs'>Usuario: ".$usuarioId."</td>";
		echo "</tr>";
		
		echo "<tr height='80px'><td></td></tr>";
		
		echo "<tr>";
			echo "<td align='center' id='titulo1'>";
				echo "<font>Búsqueda de documentos</font>";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr height='10'><td></td></tr>";
		
		echo"<tr>"; 
			echo"<td align='center' valign='top' height='20px'>";
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
			echo"</td>";
		echo"</tr>";

	echo "</table>"; 
		
	//banana de navegacion
	  echo "<table border='0' align='center' id='mapaIntranet' style='display:none;'>";
		include("../navegacion_banana.php");
	echo "</table>";

	echo "<table border='0' align='center' name='Cuerpo' style='width: 80%;'>";
        echo "<tr id='iconosTexto'>";
            echo "<td align='center'>";
                echo "Descripción documento";
            echo "</td>";
        echo "</tr>";
         echo "<tr height='10px'></tr>";
		echo "<tr >";
			echo '<td align="center">
               <div class="form-row">   
                    <div class="form-group col-md-12">
                        <input type="text" class="form-control form-control-sm" style="font-size: 0.73rem;" placeholder="ingrese descripción" id="filtroDocumento" onkeyup="busquedaDocumento()">
                    </div>
                </div>
            </td>';
		echo "</tr>";
	echo "</table>
    <br>";
    echo '
    <table class="table table-striped" style="text-align: left; font-size: 12px;" id="tablaDetalle">
        <thead>
            <tr>
                <th scope="col" id="titulo2">Código</th>
                <th scope="col" id="titulo2">Descripción</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>';
echo"</div>";
?>
</body>
</html>