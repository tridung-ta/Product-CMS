<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AuthController;
use App\Controllers\ProductController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {

    /**
     * Đăng nhập
     */
    case '/login':
        $controller = new AuthController();
        $controller->login();
        break;

    /**
     * Đăng xuất
     */
    case '/logout':
        $controller = new AuthController();
        $controller->logout();
        break;

    /**
     * Danh sách sản phẩm
     */
    case '/':
        $controller = new ProductController();
        $controller->index();
        break;

    /**
     * Thêm sản phẩm
     */
    case '/products/create':
        $controller = new ProductController();
        $controller->create();
        break;

    /**
     * Sửa sản phẩm
     */
    case '/products/edit':
        $controller = new ProductController();
        $controller->edit();
        break;

    /**
     * Xóa sản phẩm
     */
    case '/products/delete':
        $controller = new ProductController();
        $controller->delete();
        break;

    /**
     * Không tìm thấy trang
     */
    default:
        http_response_code(404);
        echo '404 - Page not found';
        break;
}