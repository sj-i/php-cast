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
final class NullableCast
{
    /**
     * @param mixed $value
     * @return int|null
     * @psalm-pure
     * @throws \TypeError
     */
    public static function toInt($value)
    {
        return is_null($value) ? null : Cast::toInt($value);
    }

    /**
     * @param mixed $value
     * @return string|null
     * @psalm-pure
     * @throws \TypeError
     */
    public static function toString($value)
    {
        return is_null($value) ? null : Cast::toString($value);
    }

    /**
     * @param mixed $value
     * @return float|null
     * @psalm-pure
     * @throws \TypeError
     */
    public static function toFloat($value)
    {
        return is_null($value) ? null : Cast::toFloat($value);
    }

    /**
     * @param mixed $value
     * @return bool|null
     * @psalm-pure
     * @throws \TypeError
     */
    public static function toBool($value)
    {
        return is_null($value) ? null : Cast::toBool($value);
    }
}
