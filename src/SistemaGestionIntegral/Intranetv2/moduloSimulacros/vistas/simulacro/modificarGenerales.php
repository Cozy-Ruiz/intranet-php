<?php 
require_once("../../../../../ConexionDBT.php");
require_once("../../../../../compruebaUsuario.php");
require_once("../../conexionIntranet.php");
require_once("../../consultas/registrosGeneral.php");
require_once("../../consultas/consultaSimulacros.php");
require_once("../../consultas/consultasRiesgos.php");
require_once("../../consultas/consultasParticipantes.php");
$conexion = new ConexionIntranet();

    if($estiloUsuario == 1){
        echo "<link type='text/css' rel='stylesheet' href='../../../../../css/styleHomePage.css'/>";
    }else if($estiloUsuario == 2){
        echo "<link type='text/css' rel='stylesheet' href='../../../../../css/styleHomePage2.css'/>";
    }
    ?><script type="text/javascript" src="../../archivos/js/scriptWindow.js"></script><?php

class modificarGenerales{

function modificarGen($codigo){
    $general = new RegistrosGenerales();
    $simulacro = new Simulacros();
    $general = new RegistrosGenerales();
?>  
    <body onLoad="window.resizeTo(600, 450)">
        <table border="0" align="center">
        <form action="modificarGenerales.php" method="POST">
        <input type="hidden" name="sim" value="<?php echo $codigo ?>" />
        <tr style="height: 30"></td>
            <td id="titulo1" align="center">Modificar Generales</td></tr>
        <tr><td id='titleBlueLineBottom'></td></tr>
        <tr style="height: 30"><td>Titulo:</td></tr>
        <tr><td><input type="text" name="titulo_simulacro" size="60" maxlength="30" value='<?php $general->nombreSimulacro($codigo); ?>'></input></td></tr>
        <tr style="height: 30"><td>Descripcion:</td></tr>
        <tr><td><textarea rows="5" cols="62" maxlength="900" name="descripcion_simulacro"><?php echo $general->descripcionSimulacro($codigo); ?></textarea> 
        </td></tr>
        <tr style="height: 10"><td></td></tr>
        <tr><td id='titleBlueLineBottom'></td></tr> 
        <tr style="height: 20"></tr>
        <tr>
            <td align='center' height="50px">
            <input type='image' src='../../../../../Imagenes/ICN_BotonAceptar.png' width='95px' height='30'></td>
        </tr>
        </form>
        </table>
        </body>
<?php }//fin de funcion modificarTitulo 

function modificarTipo($codigo){
    $general = new RegistrosGenerales();
    $simulacro = new Simulacros();
    $conexion = new ConexionIntranet();
    $t = $simulacro->getTipos();
?>
    <body onLoad="window.resizeTo(500,350)">
        </body>
        <table border="0" align="center">
        <form action="modificarGenerales.php" method="POST">
        <input type="hidden" name="sim" value="<?php echo $codigo ?>" />
        <tr style="height: 30"></td>
            <td id="titulo1" align="center">Modificar Tipo</td></tr>
            <td id="titulo2" align="center"><?php echo $codigo ?></td></tr>
            <tr style="height: 30"></td>
        <tr><td id='titleBlueLineBottom'></td></tr>
        <tr style="height: 30" align="center"><td>Seleccionar nuevo tipo:</td></tr>
        <tr align="center"><td>
            <select name="sTipo">
                <?php while ($tipos = $t->fetchRow()) {
                    $tipo = $tipos[0];
                    ?><option value="<?php echo $tipo ?>" > <?php echo $tipo ?></option><?php
                }//fin de while tipos ?>
                
            </select>
        </td></tr>

        <tr style="height: 10"><td></td></tr>
        <tr><td id='titleBlueLineBottom'></td></tr> 
        <tr style="height: 20"></tr>
        <tr>
            <td align='center' height="50px">
            <input type='image' src='../../../../../Imagenes/ICN_BotonAceptar.png' width='95px' height='30'></td>
        </tr>
        </form>
        </table> <?php
}//fin de funcon modificarTipo

function modificarRiesgo($codigo){
    $conexion = new ConexionIntranet();
    $general = new RegistrosGenerales();
    $simulacro = new Simulacros();
    $riesgos = new Riesgos();
?>
        <body onLoad="window.resizeTo(650,700)">
        <table border="0" align="center">
        <form action="modificarGenerales.php" method="POST">
        <input type="hidden" name="sim" value="<?php echo $codigo ?>" />
        <tr style="height: 30"><td width="5%"></td><td id="titulo1" colspan="2" align="center">Selecciona riesgos</td>
        <td width="5%"></td></tr><tr style="height: 30"></tr>
        <tr><td></td><td id='titulo2' colspan="4">Riesgos disponibles</td></tr>
        <tr><td></td><td id='titleBlueLineBottom' colspan='2'></td></tr><tr style="height: 20"></tr>
        <?php $riesgos->seleccionarRiesgos($codigo); ?>
        <tr><td></td><td id='titleBlueLineBottom' colspan='2'></td></tr><tr style="height: 20"></tr>
        <tr>
            <td align='center' colspan='4' height="50px">
            <input type='image' src='../../../../../Imagenes/ICN_BotonAceptar.png' width='95px' height='30'></td>
        </tr>
        </form>
        </table>
        </body>
         <?php
}//fin de funcon modificarRiesgo

function modificarParticipantes($codigo){
    $general = new RegistrosGenerales();
    $cparticipantes = new participantes();
    $simulacro = new Simulacros();
    $conexion = new ConexionIntranet();
    $ciudad = $general->ciudadSimulacro($codigo);

    ?><body onLoad="window.resizeTo(500,700)">
        <table border="0" align="center">
        <form action="modificarGenerales.php" method="POST">
        <input type="hidden" name="sim" value="<?php echo $codigo ?>" />
        <tr style="height: 30"></td><td id="titulo1" colspan="4" align="center">Selecciona participantes</td></tr><tr style="height: 30"></tr>
        <tr><td width="10%"></td><td id='titleBlueLineBottom' colspan='2'></td></tr><tr style="height: 20"></tr>

        
        <tr style="height: 10;"><td></td><td><td id="fileItem">Agregar participante externo<a target="popup" title="participanteExt" href="agregarPExterno.php?simulacro=<?php echo $codigo ?>"><img onclick=" window.open('', 'popup', 'width = 0', 'height = 0');" src="../../../../../Imagenes/ICN_BotonMas.png" alt="PExterno"  width='15' height='15' /></a></td></td><td></td></tr>

        <tr style="height: 10"><td colspan="4"></td></tr>
        <?php $cparticipantes->seleccionarParticipantes($ciudad, $codigo); ?>
        <tr><td></td><td id='titleBlueLineBottom' colspan='2'></td></tr><tr style="height: 20"></tr>
        <tr>
            <td align='center' colspan='4' height="50px">
            <input type='image' src='../../../../../Imagenes/ICN_BotonAceptar.png' width='95px' height='30'></td>
        </tr>
        </form>
        </table>
        </body><?php

}//fin de funcion modificarParticipantes

function modificarPdr($codigo){
    $general = new RegistrosGenerales();
    $cparticipantes = new participantes();
    $simulacro = new Simulacros();
    $conexion = new ConexionIntranet();
    $ciudad = $general->ciudadSimulacro($codigo);

    ?><body onLoad="window.resizeTo(500,300)">
        <table border="0" align="center">
        <form action="modificarGenerales.php" method="POST">
        <input type="hidden" name="sim" value="<?php echo $codigo ?>" />
        <tr style="height: 30"></td><td id="titulo1" colspan="4" align="center">Selecciona PDR</td></tr>
        <tr><td id='titleBlueLineBottom' colspan='4'></td></tr>
        <tr style="height: 10"><td colspan="4"></td></tr>
        <tr><td colspan="2" align="center"><?php $cparticipantes->seleccionarPdr($ciudad); ?></td></tr>
        <tr style="height: 10"><td colspan="4"></td></tr>
        <tr><td id='titleBlueLineBottom' colspan='4'></td></tr><tr style="height: 20"></tr>
        <tr>
            <td align='center' colspan='4' height="20px">
            <input type='image' src='../../../../../Imagenes/ICN_BotonAceptar.png' width='95px' height='30'></td>
        </tr>
        </form>
        </table>
        </body><?php
}//fin de funcion modificarParticipantes

function modificarAlcance($codigo){
    $general = new RegistrosGenerales();
    $simulacro = new Simulacros();
    $general = new RegistrosGenerales();
?>  
    <body onLoad="window.resizeTo(500, 380)">
        <table border="0" align="center">
        <form action="modificarGenerales.php" method="POST">
        <input type="hidden" name="sim" value="<?php echo $codigo ?>" />
        <tr style="height: 30"></td>
            <td id="titulo1" align="center">Modificar Alcance</td></tr>
        <tr><td id='titleBlueLineBottom'></td></tr>
        <tr style="height: 30"><td>Alcance:</td></tr>
        <tr><td><textarea rows="5" cols="50" maxlength="900" name="alcance_simulacro"><?php echo $general->alcanceSimulacro($codigo); ?></textarea> 
        </td></tr>
        <tr style="height: 10"><td></td></tr>
        <tr><td id='titleBlueLineBottom'></td></tr> 
        <tr style="height: 20"></tr>
        <tr>
            <td align='center' height="50px">
            <input type='image' src='../../../../../Imagenes/ICN_BotonAceptar.png' width='95px' height='30'></td>
        </tr>
        </form>
        </table>
        </body>
<?php }//fin de funcion modificarAlcance

function modificarRecursos($codigo){
    $general = new RegistrosGenerales();
    $simulacro = new Simulacros();
    $general = new RegistrosGenerales();
?>  
    <body onLoad="window.resizeTo(580,380)">
        <table border="0" align="center">
        <form action="modificarGenerales.php" method="POST">
        <input type="hidden" name="sim" value="<?php echo $codigo ?>" />
        <tr style="height: 30"></td>
            <td id="titulo1" align="center">Recursos utilizados</td></tr>
        <tr><td id='titleBlueLineBottom'></td></tr>
        <tr style="height: 15"><td></td></tr>
        <tr><td><textarea rows="5" cols="62" maxlength="900" name="recursos_simulacro"><?php echo $general->recursos_Simulacro($codigo); ?></textarea> 
        </td></tr>
        <tr style="height: 10"><td></td></tr>
        <tr><td id='titleBlueLineBottom'></td></tr> 
        <tr style="height: 20"></tr>
        <tr>
            <td align='center' height="30px">
            <input type='image' src='../../../../../Imagenes/ICN_BotonAceptar.png' width='95px' height='30'></td>
        </tr>
        </form>
        </table>
        </body>
<?php }//fin de funcion modificarRecursos

function modificarResultados($codigo){
    $general = new RegistrosGenerales();
    $simulacro = new Simulacros();
    $general = new RegistrosGenerales();
?>  
    <body onLoad="window.resizeTo(580,400)">
        <table border="0" align="center">
        <form action="modificarGenerales.php" method="POST">
        <input type="hidden" name="sim" value="<?php echo $codigo ?>" />
        <tr style="height: 30"></td>
            <td id="titulo1" align="center">Resultados</td></tr>
        <tr style="height: 30"><td id='titleBlueLineBottom'></td></tr>
        <tr style="height: 15"><td></td></tr>
        <tr><td><textarea rows="5" cols="62" maxlength="900" name="resultados_simulacro"><?php echo $general->resultados_Simulacro($codigo); ?></textarea> 
        </td></tr>
        <tr style="height: 10"><td></td></tr>
        <tr><td id='titleBlueLineBottom'></td></tr> 
        <tr style="height: 20"></tr>
        <tr>
            <td align='center' height="30px">
            <input type='image' src='../../../../../Imagenes/ICN_BotonAceptar.png' width='95px' height='30'></td>
        </tr>
        </form>
        </table>
        </body>
<?php }//fin de funcion modificarAlcance

function evaluarSimulacro($codigo){
?>  
    <body onLoad="window.resizeTo(400,400)">
        <table border="0" align="center">
        <form action="modificarGenerales.php" method="POST">
        <input type="hidden" name="sim" value="<?php echo $codigo ?>" />
        <tr style="height: 30"></td>
            <td id="titulo1" align="center">Evaluar simulacro</td></tr>
        <tr style="height: 30"><td id='titleBlueLineBottom'></td></tr>
        <tr style="height: 15"><td></td></tr>
        <tr><td align="center"><select name="evaluacion">
        	<option value="">Seleccionar..</option>
        	<option value="1">Eficaz</option>
        	<option value="2">No eficaz</option>
        	<option value="3">Parcialmente eficaz</option>
        </select>
        </td></tr>
        <tr style="height: 10"><td></td></tr>
        <tr><td id='titleBlueLineBottom'></td></tr> 
        <tr style="height: 20"></tr>
        <tr>
            <td align='center' height="30px">
            <input type='image' src='../../../../../Imagenes/ICN_BotonAceptar.png' width='95px' height='30'></td>
        </tr>
        </form>
        </table>
        </body>
<?php }//fin de funcion modificarAlcance

function modificarFechas($codigo){
    $general = new RegistrosGenerales();
    $simulacro = new Simulacros();
    $general = new RegistrosGenerales();

?> <link rel="import" href="bower_components/vaadin-date-picker/vaadin-date-picker.html">
    <body onLoad="window.resizeTo(500,400)">
        <table border="0" align="center">
        <form action="modificarGenerales.php" method="POST">
        <input type="hidden" name="sim" value="<?php echo $codigo ?>" />
        <tr style="height: 30"></td>
        <td colspan="2" id="titulo1" align="center">Modificar fechas</td></tr>
        <tr style="height: 30"><td colspan="2" id='titleBlueLineBottom'></td></tr>
        <tr><td id="titulo2">Programada:</td><td align="center"><input type="text" name="fecha_programada" value="<?php $general->fechaPSimulacro($codigo); ?>" required readonly /></td></tr>
        <tr style="height: 20"><td></td><td align="center">Ingresa fecha y hora</td></tr>
        <tr><td id="titulo2">Inicio:</td><td align="center"><input type="date" name="fecha_inicio" /><input type="time" name="hora_inicio"></td></tr>
        <tr><td id="titulo2">Final:</td><td align="center"><input type="date" name="fecha_final" /><input type="time" name="hora_final"></td></tr>
        <tr style="height: 10"><td></td></tr>
        <tr><td colspan="2" id='titleBlueLineBottom'></td></tr> 
        <tr style="height: 20"></tr>
        <tr>
            <td colspan="2" align='center' height="30px">
            <input type='image' src='../../../../../Imagenes/ICN_BotonAceptar.png' width='95px' height='30'></td>
        </tr>
        </form>
        </table>
        </body>
<?php }//fin de funcion modificarAlcance

function modificarEvidencias($codigo){
	 ?><body onLoad="window.resizeTo(615, 450)">

	 	<link href="../dropzone/style.css" rel="stylesheet" type="text/css">
        <link href="../dropzone/dropzone.css" rel="stylesheet" type="text/css">
        <script src="../dropzone/dropzone.js" type="text/javascript"></script>

     <table border="0">
        <tr style="height: 30%"><td width="30%"></td></tr>
          <tr><td id="titulo1" align="center" colspan="4">Agregar evidencias</td></tr>
          <tr><td colspan="4" id='titleBlueLineBottom'></td></tr>
          <tr><td colspan="4" height="200">
            <div class='content'>
            <form action="../dropzone/upload.php" class="dropzone" id="dropzonewidget">
            	<input style="position: absolute;" type="text" value="<?php echo $codigo ?>" name="simulacro" hidden />
            	<input style="position: absolute;" type="text" name="directorio" value="../../archivos/ImagenesEvidencia/" hidden />
            	<div class="dz-message needsclick" style="color: black;">Click para seleccionar <br> o arrastra tus imagenes aquí.<br><label style="font-size: 12px"><br>El tamaño maximo de la imagen es 2MB en formato jpg o png.<br> Dimensiones sugeridas: 800x600px.</label></div>
            </form>  
            </div>
            </td></tr>
            <tr><td colspan="4" id='titleBlueLineBottom'></td></tr>
            <tr style="height: 40px"><td align="center"><input onclick="alert('Los archivos se subieron correctamente!'); self.close(); opener.location.reload();" type="image" src='../../../../../Imagenes/ICN_BotonAceptar.png' width='90' height='30' /></td></tr>
    </body>
            <?php
}

function modificarSeguimiento($codigo){
    $conexion = new ConexionIntranet();

    ?><body onLoad="window.resizeTo(500,400)">
        <table border="0" align="center">
        <form action="modificarGenerales.php" method="POST">
        <input type="hidden" name="sim" value="<?php echo $codigo ?>" />
        <tr style="height: 30"><td id="titulo1" colspan="2" align="center">Agregar seguimiento</td></tr>
        <tr><td id='titleBlueLineBottom' colspan='2'></td></tr>

        <tr><td id="titulo2" align="center">Codigo:</td><td id="titulo2" align="center">Tipo:</td></tr>
        <tr style="height: 10"><td colspan="2"></td></tr>
        <tr><td align="center"><input type="text" name="codigo_seguimiento" maxlength="20" required /></td><td align="center">
        		<select name="tipo_seguimiento" required>
        			<option value="" >Seleccionar tipo..</option>
        			<option value="1" >Solicitud</option>
        			<option value="2" >Acción correctiva</option>
        			<option value="3" >Acción preventiva</option>
        			<option value="4" >Otro simulacro</option>
        		</select>
        </td></tr>
        <tr style="height: 10"><td colspan="4"></td></tr>
        <tr><td id='titleBlueLineBottom' colspan='4'></td></tr><tr style="height: 20"></tr>
        <tr>
            <td align='center' colspan='4' height="20px">
            <input type='image' src='../../../../../Imagenes/ICN_BotonAceptar.png' width='95px' height='30'></td>
        </tr>
        </form>
        </table>
        </body><?php
}

    function eliminarTratamiento($id){ 
        $conexion = new conexionIntranet();
        $conexion->Execute("DELETE FROM SGI_Simulacros_Seguimientos WHERE idTratamiento = '$id'");
        $conexion->Close();
        cerrarEliminar('seguimientoDiv');
    }
}//fin de clase modificarGenerales

if (isset($_POST['sTipo'])) {
            $tipo=$_POST['sTipo'];
            $cod=$_POST['sim'];
            $simulacro->actualizarTipo($tipo, $cod);
            cerrarModificar('tipoDiv');
}//fin de if modificar tipo
elseif (isset($_POST['titulo_simulacro'])) {
            $titulo=$_POST['titulo_simulacro'];
            $desc=$_POST['descripcion_simulacro'];
            $cod=$_POST['sim'];
            $simulacro->actualizarGeneral($titulo, $desc, $cod); 
            cerrarModificar('generalDiv');
}//fin de if modificar
elseif(isset($_POST['codigosR'])) {
    $rSeleccionados=$_POST['codigosR'];
    $cod=$_POST['sim'];
    if (count($rSeleccionados)>0) {
    		$eliminar = 1;
            for ($i=0; $i < count($rSeleccionados); $i++) { 
                $simulacro->guardarRiesgo_Simulacro($rSeleccionados[$i], $cod, $eliminar);
                $eliminar = 0;
            cerrarModificar('riesgosDiv');
            }
}
}//fin de if modificar
elseif(isset($_POST['pSeleccionados'])) {
    $pSeleccionados=$_POST['pSeleccionados'];

    if (count($pSeleccionados)>0) {
    		$eliminar = 1;
            for ($i=0; $i < count($pSeleccionados); $i++) { 
                $cod=$_POST['sim'];
                $simulacro->guardarParticipante_Simulacro($cod, $pSeleccionados[$i], $eliminar);
                $eliminar = 0;
            cerrarModificar('participantesDiv');
            }
}//fin de if modificar
}
elseif(isset($_POST['sPdr'])) {
    $pdrSeleccionado=$_POST['sPdr'];
    $cod=$_POST['sim'];
    $simulacro->guardarPdr($cod, $pdrSeleccionado);
    cerrarModificar('pdrDiv');
}
elseif(isset($_POST['alcance_simulacro'])) {
    $alcance=$_POST['alcance_simulacro'];
    $cod=$_POST['sim'];
    $simulacro->actualizarAlcance($cod, $alcance);
    cerrarModificar('alcanceDiv');
}
elseif(isset($_POST['recursos_simulacro'])) {
    $recursos=$_POST['recursos_simulacro'];
    $cod=$_POST['sim'];
    $simulacro->actualizarRecursos($cod, $recursos);
    cerrarModificar('recursosDiv');
}
elseif(isset($_POST['resultados_simulacro'])) {
    $resultados=$_POST['resultados_simulacro'];
    $cod=$_POST['sim'];
    $simulacro->actualizarResultados($cod, $resultados);
    cerrarModificar('resultadosDiv');
}
elseif(isset($_POST['fecha_programada'])){
    $cod=$_POST['sim'];
	if(isset($_POST['fecha_inicio'])&&isset($_POST['hora_inicio'])) {
	$fecha_inicio=$_POST['fecha_inicio'].' '.$_POST['hora_inicio'].':00';
    $simulacro->actualizarFecha_Inicio($cod, $fecha_inicio);
    echo "Fecha_inicio: ".$fecha_inicio;
	}else{
		?> <script>alert("Ocurrio un error al actualizar fecha de inicio!");</script> <?php
	}

	if (isset($_POST['fecha_final'])) {
    $fecha_final = $_POST['fecha_final'].' '.$_POST['hora_final'].':00';
    $simulacro->actualizarFecha_Final($cod, $fecha_final);
    cerrarModificar('fechasDiv');
	}else{
		?> <script>alert("Ocurrio un error al actualizar fecha final!");</script> <?php
	}
}elseif(isset($_POST['codigo_seguimiento'])) {
    $clave_s=$_POST['codigo_seguimiento'];
    $tipo_s=$_POST['tipo_seguimiento'];
    $cod=$_POST['sim'];
    $simulacro->agregarSeguimiento($cod, $clave_s, $tipo_s);
    
    cerrarModificar('seguimientoDiv');
}elseif(isset($_POST['evaluacion'])) {
    $simulacro->actualizarEvaluacion($_POST['sim'], $_POST['evaluacion']);
    cerrarModificar('evaluacionDiv');
}
$modGenerales = new modificarGenerales(); 

function cerrarModificar($div){ ?> 
<script>
    alert('Modificado correctamente!');
    self.close();
    window.opener.document.location.href = 'verSimulacro.php#<?php echo $div ?>';
    window.opener.location.reload();
</script> <?php } 

function cerrarEliminar($div){ ?> 
<script>
    self.close();
    window.opener.document.location.href = 'verSimulacro.php#<?php echo $div ?>';
    window.opener.location.reload();
</script> <?php } ?>

