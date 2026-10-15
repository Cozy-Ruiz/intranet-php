<?php error_reporting(0); ?>
<?php
$nombrephp = 'ActualizaReunion.php';
require_once("../ConexionDBT.php");
require_once("../compruebaUsuario.php");

$id = $_GET["id"];
$campo = $_GET["fi"];
$item = $_POST["$campo"];

$INTRANET->Execute("UPDATE SGI_Registros SET xt_contenido = '$item' WHERE kf_itemID = 1 ");

header("Location: AgregarReunion.php?id=1");
?>