<?php
require __DIR__ . '/metrics_registry.php';

use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;

$registry = metrics_registry();

record_http_request($registry);

$memory = $registry->getOrRegisterGauge(
    'intranet',
    'php_memory_usage_bytes',
    'Current PHP memory usage in bytes'
);
$memory->set(memory_get_usage(true));

$peakMemory = $registry->getOrRegisterGauge(
    'intranet',
    'php_memory_peak_usage_bytes',
    'Peak PHP memory usage in bytes'
);
$peakMemory->set(memory_get_peak_usage(true));

$renderer = new RenderTextFormat();

header('Content-Type: ' . RenderTextFormat::MIME_TYPE);
echo $renderer->render($registry->getMetricFamilySamples());
?>