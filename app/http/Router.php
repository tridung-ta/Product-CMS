<?php

namespace App\Http;

final class Router
{
    private const PRODUCT_ACTIONS = ['list', 'create', 'edit', 'delete'];
    private const AUTH_ACTIONS = ['login', 'logout'];

    public static function product(string $action): void
    {
        if (!in_array($action, self::PRODUCT_ACTIONS, true)) {
            throw new HttpException(404, 'Không tìm thấy chức năng sản phẩm.');
        }
        require __DIR__ . '/../modules/admin/manage/product/' . $action . '.module.php';
    }

    public static function auth(string $action): void
    {
        if (!in_array($action, self::AUTH_ACTIONS, true)) {
            throw new HttpException(404, 'Không tìm thấy chức năng đăng nhập.');
        }
        require __DIR__ . '/../modules/admin/auth/' . $action . '.module.php';
    }

    public static function legacy(string $path): void
    {
        $routes = [
            '/' => ['product', 'list'],
            '/login' => ['auth', 'login'],
            '/logout' => ['auth', 'logout'],
            '/products/create' => ['product', 'create'],
            '/products/edit' => ['product', 'edit'],
            '/products/delete' => ['product', 'delete'],
        ];
        if (!isset($routes[$path])) {
            throw new HttpException(404, 'Không tìm thấy trang.');
        }
        [$type, $action] = $routes[$path];
        if ($type === 'auth') {
            self::auth($action);
        } else {
            self::product($action);
        }
    }
}
