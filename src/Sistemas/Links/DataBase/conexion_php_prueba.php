<?php
require_once(__DIR__ . "/../Librerias/adodb/adodb.inc.php");

$usuario = "scia";
$password = "scia";
$host = "192.1.168.4";
$puerto = "33300";
$servicio = "VERACRUZ11g"; // Nombre de tu base de datos o servicio

// Sintaxis Easy Connect: [//]host_name[:port][/service_name]
$db = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=$host)(PORT=$puerto))(CONNECT_DATA=(SERVICE_NAME=$servicio)))";

$conexion = oci_connect($usuario, $password, $db);

if (!$conexion) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
} else {
    echo "¡Conexión exitosa a Oracle usando OCI8!";
}

// Cerrar conexión
oci_close($conexion);
?>
