<?php
$simu=$_POST['simulacro'];
$ciudad=$_POST['ciudad'];

require_once("../../../../../ConexionDBT.php");
require_once("../../../../../compruebaUsuario.php");
require_once("../../conexionIntranet.php");
require_once("modificarGenerales.php");

$conexion = new ConexionIntranet();

    if($estiloUsuario == 1){
        echo "<link type='text/css' rel='stylesheet' href='../../../../../css/styleHomePage.css'/>";
    }else if($estiloUsuario == 2){
        echo "<link type='text/css' rel='stylesheet' href='../../../../../css/styleHomePage2.css'/>";
    }
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Modificar</title>
</head>
    <?php
    if (isset($_POST['aviso'])) {
    require_once("../aviso/subirAviso.php");
    }elseif (isset($_POST['desarrollo'])) {
    require_once("../desarrollo/subirDesarrollo.php");
    }elseif (isset($_POST['asistencia'])) {
        require_once("../desarrollo/subirAsistencia.php");
    }elseif (isset($_POST['riesgos'])) {
        $modGenerales->modificarRiesgo($simu);
    }elseif (isset($_POST['participantes'])) {
        $modGenerales->modificarParticipantes($simu);
    }elseif (isset($_POST['evidencia'])) {
       $modGenerales->modificarEvidencias($simu);
    }elseif (isset($_POST['modificarGenerales'])) {
        $modGenerales->modificarGen($simu);
    }elseif (isset($_POST['modificarTipo'])) {
        $modGenerales->modificarTipo($simu);
    }elseif (isset($_POST['modificarPdr'])) {
        $modGenerales->modificarPdr($simu);
    }elseif (isset($_POST['modificarAlcance'])) {
        $modGenerales->modificarAlcance($simu);
    }elseif (isset($_POST['modificarRecursos'])) {
        $modGenerales->modificarRecursos($simu);
    }elseif (isset($_POST['modificarResultados'])) {
        $modGenerales->modificarResultados($simu);
    }elseif(isset($_POST['modificarFechas'])) {
        $modGenerales->modificarFechas($simu);
    }elseif(isset($_POST['evaluar'])) {
        $modGenerales->evaluarSimulacro($simu);
    }elseif(isset($_POST['agregarSeguimiento'])) {
        $modGenerales->modificarSeguimiento($simu);
    }elseif(isset($_POST['seguimiento'])) {
            ?><script>window.onload=function(){
                document.forms["seguimiento_simulacro"].submit();
                }</script>
                <form name="seguimiento_simulacro" action="verSimulacro.php" method="POST">
                <input type="text" name="simulacro" value="<?php echo $_POST['clave'] ?>">
                </form><?php
    }
    elseif(isset($_POST['eliminarTratamiento'])) {
            $modGenerales->eliminarTratamiento($_POST['idTratamiento']);
    }
    ?>
    </center>

    <table>
        <tr><td id='titleBlueLineBottom' colspan='7'></td></tr>
    </table>
</body>
</html>
