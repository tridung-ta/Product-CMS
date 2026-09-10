<?php

require_once __DIR__ . '/../vendor/autoload.php';

App\Security\Boot::run(static function (): void {
    require __DIR__ . '/../app/modules/admin/main.module.php';
});
