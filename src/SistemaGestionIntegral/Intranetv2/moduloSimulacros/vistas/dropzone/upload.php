<?php
    $dbHost = '192.1.172.9:3306';
    $dbUsername = 'GEA';
    $dbPassword = '7b1QqK#m1F3m';
    $dbName = 'INTRANET2';
    
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

$simulacro = $_POST['simulacro'];
$target_dir = $_POST['directorio'];
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$fileName = basename($_FILES["file"]["name"]);

if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir.$_FILES['file']['name'])) {
    $status = 1;
    $conn->query("INSERT INTO SGI_Simulacros_Evidencias (xt_codigoSimulacro, xt_nombre, xt_fechaSubida) VALUES('".$simulacro."', '".$fileName."','".date("Y-m-d H:i:s")."')");
    //$conn->getone("SELECT xt_statusSimulacro FROM SGI_Simulacros WHERE xt_codigoSimulacro = '".$simulacro."' LIMIT 1");
    $conn->query("UPDATE SGI_Simulacros SET xt_statusSimulacro = 4 WHERE xt_codigoSimulacro = '".$simulacro."' AND xt_statusSimulacro = 3");
}
?>