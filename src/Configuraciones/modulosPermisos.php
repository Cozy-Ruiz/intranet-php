<?php error_reporting(0); ?>
<?PHP
require_once("../conexionMasterDB.php");
//require_once('../compruebaUsuario.php');

$usuario = $_POST['usuario'];
$oficina = $_POST['oficina'];

$oficinas = $MASTER_GE->Execute("SELECT xt_rol, xt_modulo, xt_proceso, xt_actividad FROM PERFILES.ACTIVIDADES where xt_usuario = '$usuario' AND xt_oficina = '$oficina'");
			while($r = $oficinas->fetchRow()){
				$rol       = $r[0];
				$modulo    = $r[1];
				$proceso   = $r[2];
				$actividad = $r[3];
	
		echo"<tr>";
                    echo '<td align="center" name="$datos[5]" id="titulo3Azul">'.$actividad.'</td>';
		echo"</tr>";
		
                $index = 0;
                $FuncionalidadesActivas = array();
				
				$u = $MASTER_GE->Execute ("SELECT xt_funcionalidad FROM PERFILES.FUNCIONALIDADES WHERE  xt_usuario= '$usuario' AND xt_oficina = '$oficina' AND xt_rol = '$rol' AND xt_modulo = '$modulo' AND xt_proceso = '$proceso' AND xt_actividad = '$actividad'"); 
						
					while($o = $u->fetchRow()){
						$FuncionalidadesActivas[$index] = $o[0];
						$index++;
					}	
				
                $p = $MASTER_GE->Execute("SELECT xt_funcionalidad FROM PERFILES.CATALOGO_FUNCIONALIDADES  WHERE xt_actividad = '$actividad' ");
                 $cont=0;
				  while($x = $p->fetchRow()){
                    	
						$funcionalidadesGeneral = $x[0];
						
						echo"<tr>";
							
							echo"<td align='left' id='iconosTexto'>". $funcionalidadesGeneral."</td>";
							
							if(in_array($funcionalidadesGeneral, $FuncionalidadesActivas)){
								
								$total[$cont] = $oficina."-".$rol."-".$modulo."-".$proceso."-".$actividad."-".$funcionalidadesGeneral;
								echo"<td aling = 'right'> <input type='checkbox' checked='true' name='valor[]' value='$total[$cont]'> </td>";
								$cont++;
							}else{
								$total[$cont] = $oficina."-".$rol."-".$modulo."-".$proceso."-".$actividad."-".$funcionalidadesGeneral;
								echo"<td aling = 'right'> <input type='checkbox' name='valor[]' value='$total[$cont]'> </td>";
								$cont++;
							}
						
						echo"</tr>";
                
                }
              
				echo"<tr height='30'></tr>";
				
	}
			echo "<tr>";
				echo "<td> <input type='submit' name='Enviar' align='right' src='../Imagenes/ICN_BotonEnviar.png' width='90' height='29'> </td>";	
			echo "</tr>";
			
			echo"<tr height='20'></tr>";
	
	//echo"</form>";

	
			


?>