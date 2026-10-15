<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    require_once("multiuploadAviso.php");
    $files = $_FILES['userfile']['name'];
    $upload = new Multiupload();
    $isUpload = $upload->upFiles($files, $simulacro);
}else{
    throw new Exception("Error Processing Request", 1);
}

?>