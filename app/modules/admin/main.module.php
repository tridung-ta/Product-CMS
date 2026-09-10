<?php

use App\Http\HttpException;
use App\Http\Request;
use App\Http\Router;

switch (Request::queryString('module', 'manage')) {
    case 'manage':
        require __DIR__ . '/manage.module.php';
        break;
    case 'auth':
        Router::auth(Request::queryString('action', 'login'));
        break;
    default:
        throw new HttpException(404, 'Không tìm thấy module quản trị.');
}
