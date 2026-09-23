<?php
require __DIR__ . '/metrics_registry.php';

$registry = metrics_registry();
record_http_request($registry);

$env = getenv('APP_ENV') ?: 'undefined';
echo "Hola Cozy !!, estamos en ambiente " . $env;
?>