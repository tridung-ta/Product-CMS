<?php

declare(strict_types=1);

namespace Config;

use RuntimeException;
use Smarty\Smarty;

final class SmartyConfig
{
    public static function getSmarty(): Smarty
    {
        $compileDirectory = __DIR__ . '/../app/views/templates_c';

        if (!is_dir($compileDirectory)
            && !@mkdir($compileDirectory, 0775, true)
            && !is_dir($compileDirectory)
        ) {
            throw new RuntimeException('Unable to create the Smarty compilation directory.');
        }

        $smarty = new Smarty();
        $smarty->setTemplateDir(__DIR__ . '/../app/views/templates');
        $smarty->setCompileDir($compileDirectory);
        $smarty->setCaching(Smarty::CACHING_OFF);
        $smarty->registerPlugin('modifier', 'money', [Money::class, 'format']);

        return $smarty;
    }
}
