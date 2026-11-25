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
/*
//Extensiones permitidas
$extensiones = array('jpg', 'png');

//Obtenemos la extensión del archivo subido
$extension = explode('.', $fileName);
$extension = end($extension);
$extension = strtolower($extension);

/*if(!in_array($extension, $extensiones)) {
	header('HTTP/1.1 500 Internal Server Error');
	header('Content-Type: application/json');
	die(json_encode("Formato de imagen no valido", JSON_FORCE_OBJECT));
}*/
if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir.$_FILES['file']['name'])) {
    $status = 1;
    $conn->query("INSERT INTO SGI_Simulacros_Evidencias (xt_codigoSimulacro, xt_nombre, xt_fechaSubida) VALUES('".$simulacro."', '".$fileName."','".date("Y-m-d H:i:s")."')");
}
?>