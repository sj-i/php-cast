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

class NullableCastTest extends TestCase
{
    public function testToInt()
    {
        $this->assertSame(null, NullableCast::toInt(null));
        $this->assertSame(0, NullableCast::toInt(0));
        $this->assertSame(1, NullableCast::toInt(1));
        $this->assertSame(1, NullableCast::toInt(1.1));
        $this->assertSame(1, NullableCast::toInt(1.9));
        $this->assertSame(0, NullableCast::toInt('0'));
        $this->assertSame(1, NullableCast::toInt('1'));
        $this->assertSame(1, NullableCast::toInt('1.1'));
        $this->assertSame(1, NullableCast::toInt('1.9'));
        $this->assertSame(0, NullableCast::toInt(false));
        $this->assertSame(1, NullableCast::toInt(true));

        $this->assertTypeError(fn () => NullableCast::toInt(''));
        $this->assertTypeError(fn () => NullableCast::toInt('a'));
        $this->assertTypeError(fn () => NullableCast::toInt('ok'));
        $this->assertTypeError(fn () => NullableCast::toInt('true'));
        $this->assertTypeError(fn () => NullableCast::toInt('null'));
        $this->assertTypeError(fn () => NullableCast::toInt([]));
        $this->assertTypeError(fn () => NullableCast::toInt((object)[]));
        $this->assertTypeError(fn () => NullableCast::toInt(PHP_INT_MAX + 1));
        $this->assertTypeError(fn () => NullableCast::toInt(-9223372036854776833));
    }

    public function testToFloat()
    {
        $this->assertSame(null, NullableCast::toFloat(null));
        $this->assertSame(0.0, NullableCast::toFloat(0));
        $this->assertSame(1.0, NullableCast::toFloat(1));
        $this->assertSame(1.1, NullableCast::toFloat(1.1));
        $this->assertSame(1.9, NullableCast::toFloat(1.9));
        $this->assertSame(0.0, NullableCast::toFloat('0'));
        $this->assertSame(1.0, NullableCast::toFloat('1'));
        $this->assertSame(1.1, NullableCast::toFloat('1.1'));
        $this->assertSame(1.9, NullableCast::toFloat('1.9'));
        $this->assertSame(0.0, NullableCast::toFloat(false));
        $this->assertSame(1.0, NullableCast::toFloat(true));
        $this->assertSame(PHP_INT_MAX + 1, NullableCast::toFloat(PHP_INT_MAX + 1));
        $this->assertSame(-9223372036854776833, NullableCast::toFloat(-9223372036854776833));

        $this->assertTypeError(fn () => NullableCast::toFloat(''));
        $this->assertTypeError(fn () => NullableCast::toFloat('a'));
        $this->assertTypeError(fn () => NullableCast::toFloat('ok'));
        $this->assertTypeError(fn () => NullableCast::toFloat('true'));
        $this->assertTypeError(fn () => NullableCast::toFloat('null'));
        $this->assertTypeError(fn () => NullableCast::toFloat([]));
        $this->assertTypeError(fn () => NullableCast::toFloat((object)[]));
    }

    public function testToString()
    {
        $this->assertSame(null, NullableCast::toString(null));
        $this->assertSame('0', NullableCast::toString(0));
        $this->assertSame('1', NullableCast::toString(1));
        $this->assertSame('1.1', NullableCast::toString(1.1));
        $this->assertSame('0', NullableCast::toString('0'));
        $this->assertSame('1', NullableCast::toString('1'));
        $this->assertSame('a', NullableCast::toString('a'));
        $this->assertSame('1.1', NullableCast::toString('1.1'));
        $this->assertSame('', NullableCast::toString(false));
        $this->assertSame('1', NullableCast::toString(true));
        $this->assertSame(
            'stringable',
            NullableCast::toString(new class () {public function __toString() {return 'stringable';}})
        );

        $this->assertTypeError(fn () => NullableCast::toString([]));
        $this->assertTypeError(fn () => NullableCast::toString((object)[]));
    }

    public function testToBool()
    {
        $this->assertSame(null, NullableCast::toBool(null));
        $this->assertSame(false, NullableCast::toBool(0));
        $this->assertSame(true, NullableCast::toBool(1));
        $this->assertSame(true, NullableCast::toBool(1.1));
        $this->assertSame(false, NullableCast::toBool('0'));
        $this->assertSame(true, NullableCast::toBool('1'));
        $this->assertSame(true, NullableCast::toBool('a'));
        $this->assertSame(true, NullableCast::toBool('1.1'));
        $this->assertSame(false, NullableCast::toBool(false));
        $this->assertSame(true, NullableCast::toBool(true));
        $this->assertSame(false, NullableCast::toBool(''));
        $this->assertSame(true, NullableCast::toBool('a'));
        $this->assertSame(true, NullableCast::toBool('ok'));
        $this->assertSame(true, NullableCast::toBool('ng'));
        $this->assertSame(true, NullableCast::toBool('false'));
        $this->assertSame(true, NullableCast::toBool('true'));
        $this->assertSame(true, NullableCast::toBool('null'));

        $this->assertTypeError(fn () => NullableCast::toBool([]));
        $this->assertTypeError(fn () => NullableCast::toBool((object)[]));
    }

    private function assertTypeError(callable $func): void
    {
        try {
            $func();
        } catch (Throwable $e) {
        }
        $this->assertTrue(isset($e));
        $this->assertInstanceOf(TypeError::class, $e);
    }
}
