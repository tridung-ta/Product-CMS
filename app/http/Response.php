<?php

namespace App\Http;

final class Response
{
    public static function redirect(string $url): never
    {
        header('Location: ' . $url, true, Request::method() === 'POST' ? 303 : 302);
        exit;
    }
}
