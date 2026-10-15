<?php
require_once("../../ConexionDBT.php");

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data['image'])) {
    $img = $data['image'];
    $usuario = !empty($data['usuario']) ? preg_replace('/[^a-zA-Z0-9_-]/', '_', $data['usuario']) : 'usuario';
    
    // Limpiar y decodificar imagen base64
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $imgData = base64_decode($img);

    // Crear carpeta si no existe
    $folder = __DIR__ . '/FILES/';
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    // Guardar con el nombre del usuario
    $fileName = $usuario . '_' . date('Ymd_His') . '.png';
    $path = $folder . $fileName;

    // Guardar archivo
    if (file_put_contents($path, $imgData)) {

        $INTRANET->Execute("UPDATE perfiles.usuarios SET xt_foto = 'FILES/".$fileName."', xd_fechaActualizacionFoto = '".date("Y-m-d")."' WHERE xt_usuario = '".$usuario."' ");
        $INTRANET->Execute("UPDATE intranetgea.sgi_empleados SET xn_Foto = 'FILES/".$fileName."' WHERE kf_usuario = '".$usuario."' ");

        echo "✅ Foto guardada correctamente como: $fileName";
    } else {
        echo "❌ Error al guardar la foto.";
    }

} else {
    echo "⚠️ No se recibió la imagen.";
}
?>