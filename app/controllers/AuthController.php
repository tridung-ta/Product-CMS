<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Http\Url;
use App\Models\User;
use App\Security\Boot;
use App\Security\Csrf;
use RuntimeException;

class AuthController extends Controller
{
    public function __construct(private ?User $model = null)
    {
    }

    public function login(): void
    {
        Request::requireMethods(['GET', 'POST']);
        Boot::session();
        $error = '';
        $username = '';

        if (Request::method() === 'POST') {
            Csrf::requirePost();
            $username = trim(Request::postString('username'));
            $password = Request::postString('password');

            if ($username !== '' && mb_check_encoding($username, 'UTF-8')
                && mb_strlen($username, 'UTF-8') <= 255 && $password !== '') {
                $user = ($this->model ??= new User())->findByUsername($username);
                if ($user && password_verify($password, $user['password'])) {
                    if (!session_regenerate_id(true)) {
                        throw new RuntimeException('Cannot regenerate session.');
                    }
                    unset($_SESSION['csrf_token']);
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    Response::redirect(Url::product());
                }
            }
            $error = 'Tên đăng nhập hoặc mật khẩu không đúng.';
        } elseif (isset($_SESSION['user_id'])) {
            Response::redirect(Url::product());
        }

        $this->render('login.tpl', ['error' => $error, 'loginUsername' => $username]);
    }

    public function logout(): void
    {
        Request::requireMethods(['POST']);
        Boot::session();
        Csrf::requirePost();
        Boot::logout();
        Response::redirect(Url::login());
    }
}
