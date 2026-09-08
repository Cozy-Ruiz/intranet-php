<?php
require __DIR__ . '/../vendor/autoload.php';

use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;
use Prometheus\Storage\APCng;

$registry = new CollectorRegistry(new APCng());

$requests = $registry->getOrRegisterCounter(
    'intranet',
    'http_requests_total',
    'Total HTTP requests',
    ['method', 'route', 'status', 'environment']
);

$requests->inc([
    $_SERVER['REQUEST_METHOD'] ?? 'GET',
    '/metrics.php',
    '200',
    getenv('APP_ENV') ?: 'unknown',
]);

$renderer = new RenderTextFormat();

header('Content-Type: ' . RenderTextFormat::MIME_TYPE);
echo $renderer->render($registry->getMetricFamilySamples());
?>