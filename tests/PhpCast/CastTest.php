<?php

/**
 * This file is part of the sj-i/php-cast package.
 *
 * (c) sji <sji@sj-i.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1); // important :-)

namespace PhpCast;

use PHPUnit\Framework\TestCase;
use Throwable;
use TypeError;

class CastTest extends TestCase
{
    public function testToInt()
    {
        $this->assertSame(1, Cast::toInt('1'));
        $this->assertSame(1, Cast::toInt('1.1'));
        try {
            Cast::toInt('a');
        } catch (Throwable $e) {
        }
        $this->assertTrue(isset($e));
        $this->assertInstanceOf(TypeError::class, $e);
    }
}
