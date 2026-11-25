<?php
    $dbHost = getenv('LINKS_DB_HOST');
    $dbUsername = getenv('LINKS_DB_USER');
    $dbPassword = getenv('LINKS_DB_PASS');
    $dbName = getenv('LINKS_DB_NAME_V2');
    
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