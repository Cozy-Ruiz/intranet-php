<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Prometheus\CollectorRegistry;
use Prometheus\Storage\APCng;

function metrics_registry(): CollectorRegistry
{
    return new CollectorRegistry(new APCng());
}

function record_http_request(CollectorRegistry $registry, int $status = 200): void
{
    $requests = $registry->getOrRegisterCounter(
        'intranet',
        'http_requests_total',
        'Total HTTP requests',
        ['method', 'route', 'status', 'environment']
    );

    $route = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $requests->inc([
        $_SERVER['REQUEST_METHOD'] ?? 'GET',
        $route,
        (string) $status,
        getenv('APP_ENV') ?: 'unknown',
    ]);
}
