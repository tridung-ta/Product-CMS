<?php

declare(strict_types=1);

namespace Config;

use InvalidArgumentException;

final class Money
{
    /** Format an exact decimal amount as whole VND, rounding halves away from zero. */
    public static function format(string|int $value): string
    {
        if (!preg_match('/\A(-?)([0-9]+)(?:\.([0-9]+))?\z/', (string) $value, $parts)) {
            throw new InvalidArgumentException('Money must be a plain decimal string or integer.');
        }

        $whole = ltrim($parts[2], '0');
        $whole = $whole === '' ? '0' : $whole;

        if (isset($parts[3]) && $parts[3][0] >= '5') {
            $position = strlen($whole) - 1;

            while ($position >= 0 && $whole[$position] === '9') {
                $whole[$position] = '0';
                --$position;
            }

            if ($position < 0) {
                $whole = '1' . $whole;
            } else {
                $whole[$position] = chr(ord($whole[$position]) + 1);
            }
        }

        $formatted = strrev(implode('.', str_split(strrev($whole), 3)));

        return $parts[1] === '-' && $whole !== '0' ? '-' . $formatted : $formatted;
    }
}
