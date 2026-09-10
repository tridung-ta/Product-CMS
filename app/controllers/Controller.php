<?php

namespace App\Controllers;

use App\Http\Response;
use App\Http\Url;
use App\Security\Boot;
use App\Security\Csrf;
use Config\SmartyConfig;

abstract class Controller
{
    protected function requireAuth(): void
    {
        Boot::session();
        if (!isset($_SESSION['user_id'])) {
            Response::redirect(Url::login());
        }
    }

    protected function render(string $template, array $data = []): void
    {
        Boot::session();
        $smarty = SmartyConfig::getSmarty();
        $smarty->assign($data + [
            'csrfToken' => Csrf::token(),
            'username' => $_SESSION['username'] ?? '',
            'listUrl' => Url::product(),
            'createUrl' => Url::product('create'),
            'editUrl' => Url::product('edit'),
            'deleteUrl' => Url::product('delete'),
            'loginUrl' => Url::login(),
            'logoutUrl' => Url::logout(),
        ]);
        $smarty->display($template);
    }
}
