<?php

use App\Http\HttpException;
use App\Http\Request;
use App\Http\Router;

if (Request::queryString('entity', 'product') !== 'product') {
    throw new HttpException(404, 'Không tìm thấy chức năng quản lý.');
}

Router::product(Request::queryString('action', 'list'));
