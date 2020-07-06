<?php

/**
 * This file is part of the sj-i/php-cast package.
 *
 * (c) sji <sji@sj-i.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=0);

namespace PhpCast;

final class NullableCast
{
    /**
     * @param $value
     * @return int|null
     */
    public static function toInt($value)
    {
        return is_null($value) ? null : Cast::toInt($value);
    }

    /**
     * @param $value
     * @return string|null
     */
    public static function toString($value)
    {
        return is_null($value) ? null : Cast::toString($value);
    }

    /**
     * @param $value
     * @return float|null
     */
    public static function toFloat($value)
    {
        return is_null($value) ? null : Cast::toFloat($value);
    }

    /**
     * @param $value
     * @return bool|null
     */
    public static function toBool($value)
    {
        return is_null($value) ? null : Cast::toBool($value);
    }
}