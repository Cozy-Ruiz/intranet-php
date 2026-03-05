<?php
require __DIR__ . '/../vendor/autoload.php';

use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;
use Prometheus\Storage\InMemory;

$registry = new CollectorRegistry(new InMemory());

$counter = $registry->getOrRegisterCounter(
    'intranet',
    'http_requests_total',
    'Total HTTP Requests',
    ['method']
);

$counter->inc([$_SERVER['REQUEST_METHOD']]);

header('Content-Type: ' . RenderTextFormat::MIME_TYPE);
$renderer = new RenderTextFormat();
echo $renderer->render($registry->getMetricFamilySamples());
?>