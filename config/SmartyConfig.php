<?php

namespace Config;

use Smarty\Smarty;

class SmartyConfig
{
    public static function getSmarty(): Smarty
    {
        $smarty = new Smarty();

        $smarty->setTemplateDir(
            __DIR__ . '/../app/views/templates/'
        );

        $smarty->setCompileDir(
            __DIR__ . '/../app/views/templates_c/'
        );

        return $smarty;
    }
}