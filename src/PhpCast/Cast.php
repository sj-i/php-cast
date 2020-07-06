<?php

/**
 * This file is part of the sj-i/php-cast package.
 *
 * (c) sji <sji@sj-i.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=0); // very important :-)

namespace PhpCast;

final class Cast
{
    public static function toInt($value): int
    {
        return $value;
    }

    public static function toString($value): string
    {
        return $value;
    }

    public static function toFloat($value): float
    {
        return $value;
    }

    public static function toBool($value): bool
    {
        return $value;
    }
}
