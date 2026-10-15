<?php error_reporting(0); ?>
<?php
require_once("../../ConexionDBT.php");

$entregableID    = $_POST['entregable'];
$catalogacion   = $_POST['catalogacion'];

//echo "UPDATE SGI_Quejas_Solicitudesv2 SET xt_catalogacion = '$catalogacion' WHERE xt_quejaSolicitud = '$solicitudID'";
$estatusQuery = $INTRANET->Execute("UPDATE ENTREGABLE SET xt_catalogacion = '$catalogacion' WHERE xt_codigoEntregable = '$entregableID'");
if($estatusQuery){
	//CATALOGACION
		$estatusCatalogacion = $INTRANET->getOne("SELECT xt_catalogacion FROM ENTREGABLES WHERE xt_codigoEntregable = '$entregableID'");
			
			echo "<table border='0' align='center' width='700'>";
			echo "<tr height='35px'></tr>";
				echo"<tr>";
					echo"<td align='left' id='titulo2' width='550'><b>Catalogación</b></td>";
					echo"</td>";
				echo"</tr>";
				
				echo "<tr>";
					echo "<td id='titleBlueLineBottom' colspan='2'></td>";
				echo "</tr>";
				
				echo"<tr height='20'> </tr>";
			echo "</table>";

		if($estatusCatalogacion == ''){	    
	        echo "<table border='0' align='center' width='700'>";
	            echo "<tr>";
				   echo "<td width='30px'></td>";
		           echo "<td id='iconosTexto' colspan='2' align='left'>";
	                
	                echo "<select name='catalogacion' id='catalogacion'>";
	                echo "<option>Selecciona......</option>";
	                $s = $INTRANET->Execute("SELECT	xt_nombreCatalogacion FROM	IntranetGEA.SGI_Backlog_Catalogo_Catalogacion");
	               // echo "SELECT xt_nombreCatalogacion FROM BACKLOG.MANTENIMIENTO_CATALOGACION";
	                while($r = $s->fetchRow()){
	                    echo "<option value='".$r[0]."'>".$r[0]."</option>";
	                }
	                echo "</select>";
	               echo "</td>";
	               echo "<td id='iconosTexto' width='50' align='right'></td>";	
	            echo "</tr>";
	            echo "<tr>";
	            	echo "<td width='550px;' colspan='2'>";
	            	echo "</td>";
	                echo "<td>";
	                ?>
	                    <div id="btnHistorial" align="right"><a style="cursor:pointer" id="modifP" onclick="guardaCatalogacion()"><font color="#007CBD">Guardar</font></a></div>
	                <?php
	                echo "</td>";
	            echo "</tr>";
				echo"<tr height='10'> </tr>";
	    	echo "</table>";
	    }else{
	    	echo "<table border='0' align='center' id='muestraCatalogacion' width='700'>";
	            echo "<tr>";
				   echo "<td width='30px'> </td>";
		           echo "<td id='iconosTexto' colspan='2' align='left'>";
	               		echo $estatusCatalogacion;
	               echo "</td>";
	               echo "<td id='iconosTexto' width='50' align='right'></td>";	
	            echo "</tr>";
	            echo "<tr>";
	            	echo "<td width='550px;' colspan='2'>";
	            	echo "</td>";
	                echo "<td>";
	                ?>
	                    <div id="btnHistorial" align="right"><a style="cursor:pointer" id="modifP" onclick="editarCatalogacion();"><font color="#007CBD">Modificar</font></a></div>
	                <?php
	                echo "</td>";
	            echo "</tr>";
				echo"<tr height='10'> </tr>";
	    	echo "</table>";

	    	echo "<table border='0' id='editaCatalogacion' align='center' style='display:none;' width='700'>";
	            echo "<tr>";
				   echo "<td width='30px'> </td>";
		           echo "<td id='iconosTexto' colspan='2' align='left'>";
	                
	                echo "<select name='catalogacion' id='catalogacion'>";
	                echo "<option>Selecciona......</option>";
	                $s = $INTRANET->Execute("SELECT	xt_nombreCatalogacion FROM	IntranetGEA.SGI_Backlog_Catalogo_Catalogacion");
	               // echo "SELECT xt_nombreCatalogacion FROM BACKLOG.MANTENIMIENTO_CATALOGACION";
	                while($r = $s->fetchRow()){
	                    echo "<option value='".$r[0]."'>".$r[0]."</option>";
	                }
	                echo "</select>";
	               echo "</td>";
	               echo "<td id='iconosTexto' width='50' align='right'></td>";	
	            echo "</tr>";
	            echo "<tr>";
	            	echo "<td width='550px;' colspan='2'>";
	            	echo "</td>";
	                echo "<td>";
	                ?>
	                    <div id="btnHistorial" align="right"><a style="cursor:pointer" id="modifP" onclick="guardaCatalogacion();"><font color="#007CBD">Guardar</font></a></div>
	                <?php
	                echo "</td>";
	            echo "</tr>";
				echo"<tr height='10'> </tr>";
	    	echo "</table>";
	    }
}else{
	echo "Error al poner la catalogación";
}

?>