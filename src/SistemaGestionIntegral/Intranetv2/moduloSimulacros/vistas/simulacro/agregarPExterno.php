<?php 
$simulacro = $_REQUEST['simulacro'];
require_once("../../../../../ConexionDBT.php");
require_once("../../../../../compruebaUsuario.php");
require_once("../../conexionIntranet.php");
require_once("../../consultas/consultasParticipantes.php");

 if($estiloUsuario == 1){
                            echo "<link type='text/css' rel='stylesheet' href='../../../../../css/styleHomePage.css'/>";
                        }else if($estiloUsuario == 2){
                            echo "<link type='text/css' rel='stylesheet' href='../../../../../css/styleHomePage2.css'/>";
                        }
 ?>
<body onLoad="window.resizeTo(500, 400)">
	<table border="0">
	<form action="agregarPExterno.php" method="POST">
        <tr><td id="titulo1" align="center" colspan="3">Agrega participante</td></tr>
        <tr><td id='titleBlueLineBottom' colspan="3"></td></tr>
        <tr style="height: 20px"><td></td></tr>
	<tr><td></td><td align="center">Nombre: <input type="text" size="30" name="nombrePE" /></td><td></td></tr>
	<tr><td></td><td align="center">Apellidos: <input type="text" size="30" name="apellidosPE" /></td><td></td><tr>
	<tr><td></td><td align="center"><input type="text" size="30" name="simu" value="<?php echo $simulacro ?>" hidden /></td><td></td></tr>
	<tr><td align="center" colspan="3"><input type="image" src='../../../../../Imagenes/ICN_BotonAceptar.png' width='90px' height='30' /></td></tr>
	<tr><td id='titleBlueLineBottom' colspan="3"></td></tr>
	</form>
	</table> 
</body>

<?php 

if (isset($_POST['nombrePE'])) {
 	$cparticipantes->agregarPExterno($_POST['simu'], $_POST['nombrePE'], $_POST['apellidosPE']);

?>
<form action="modificarGenerales.php" method="POST" name="pe">
<input type="text" size="30" name="simu" value="<?php echo $simulacro ?>" hidden />
<input type="text" size="30" name="participantes" value="participantes" hidden />
    </form>
<script>
    alert('Participante externo agregado correctamente!');
    self.close();
    location.reload();
    window.reload=function(){
    document.forms["pe"].submit();
    }

</script><?php
 }
 ?>