<?php error_reporting(0); ?>
<?php

$horaMexico_City 	= new DateTime('now', new DateTimeZone('America/Mexico_City'));
$horaMexico_City	= $horaMexico_City->format('Y-m-d H:i:sP');

$horaMazatlan		= new DateTime('now', new DateTimeZone('America/Mazatlan'));
$horaMazatlan		= $horaMazatlan->format('Y-m-d H:i:sP');

$horaCancun			= new DateTime('now', new DateTimeZone('America/Cancun'));
$horaCancun			= $horaCancun->format('Y-m-d H:i:sP');

$horaTijuana		= new DateTime('now', new DateTimeZone('America/Tijuana'));
$horaTijuana		= $horaTijuana->format('Y-m-d H:i:sP');

echo "$horaMexico_City|Mexico_City<br>";
echo "$horaMazatlan|Mazatlan<br>";
echo "$horaCancun|Cancun<br>";
echo "$horaTijuana|Tijuana<br>";

?>