<?php

namespace App\Controllers;

use App\Models\User;

class AuthController
{
    public function login(): void
    {
        session_start();

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            $userModel = new User();
            $user = $userModel->findByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                header('Location: /');
                exit;
            }

            $error = 'Tên đăng nhập hoặc mật khẩu không đúng.';
        }

        $smarty = \Config\SmartyConfig::getSmarty();

        $smarty->assign('error', $error);
        $smarty->display('login.tpl');
    }

    public function logout(): void
    {
        session_start();
        session_destroy();

        header('Location: /login');
        exit;
    }
}