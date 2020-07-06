<?php

/**
 * This file is part of the sj-i/php-cast package.
 *
 * (c) sji <sji@sj-i.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * declare(strict_types=0) in the line below is very important :-)
 */

declare(strict_types=0);

namespace PhpCast;

/**
 * @psalm-immutable
 */
final class Cast
{
    /**
     * @param mixed $value
     * @return int
     * @psalm-pure
     * @throws \TypeError
     */
    public static function toInt($value): int
    {
        /** @var int */
        return $value;
    }

    /**
     * @param mixed $value
     * @psalm-pure
     * @return string
     */
    public static function toString($value): string
    {
        /** @var string */
        return $value;
    }

    /**
     * @param mixed $value
     * @return float
     * @psalm-pure
     * @throws \TypeError
     */
    public static function toFloat($value): float
    {
        /** @var float */
        return $value;
    }

    /**
     * @param mixed $value
     * @return bool
     * @psalm-pure
     * @throws \TypeError
     */
    public static function toBool($value): bool
    {
        /** @var bool */
        return $value;
    }
}
