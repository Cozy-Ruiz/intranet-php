<?php error_reporting(0); ?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
        <title>Webcam Example App</title>
        <script type="text/javascript" src="jquery-1.6.2.min.js"></script>
       <script type="text/javascript" src="ejem_main.js"></script>
    </head>
    <body>
       <div id="divFoto">
       	<input type="button" onclick="tomaFoto()" value="Activar Función">
        <video id="video" width="250" height="250" autoplay="autoplay"></video>
        <button id="photo">Take a Photo!</button>
        <canvas id="canvas" width="200" height="200"></canvas>
       </div>
    </body>
</html>




