<?php

require_once __DIR__ . '/../vendor/autoload.php';

App\Security\Boot::run(static function (): void {
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    App\Http\Router::legacy(is_string($path) ? $path : '');
});
