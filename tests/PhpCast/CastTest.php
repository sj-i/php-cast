<?php

/**
 * This file is part of the sj-i/php-cast package.
 *
 * (c) sji <sji@sj-i.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * declare(strict_types=1) in the line below is important :-)
 */

declare(strict_types=1);

namespace PhpCast;

use Exception;
use PHPUnit\Framework\TestCase;
use Throwable;
use TypeError;

class CastTest extends TestCase
{
    public function testToInt(): void
    {
        $this->assertSame(0, Cast::toInt(0));
        $this->assertSame(1, Cast::toInt(1));
        $this->assertSame(1, Cast::toInt(1.1));
        $this->assertSame(1, Cast::toInt(1.9));
        $this->assertSame(0, Cast::toInt('0'));
        $this->assertSame(1, Cast::toInt('1'));
        $this->assertSame(1, Cast::toInt('1.1'));
        $this->assertSame(1, Cast::toInt('1.9'));
        $this->assertSame(0, Cast::toInt(false));
        $this->assertSame(1, Cast::toInt(true));

        $this->assertTypeError(fn () => Cast::toInt(''));
        $this->assertTypeError(fn () => Cast::toInt('a'));
        $this->assertTypeError(fn () => Cast::toInt('ok'));
        $this->assertTypeError(fn () => Cast::toInt('true'));
        $this->assertTypeError(fn () => Cast::toInt('null'));
        $this->assertTypeError(fn () => Cast::toInt(null));
        $this->assertTypeError(fn () => Cast::toInt([]));
        $this->assertTypeError(fn () => Cast::toInt((object)[]));
        $this->assertTypeError(fn () => Cast::toInt(PHP_INT_MAX + 1));
        $this->assertTypeError(fn () => Cast::toInt(-9223372036854776833));

        try {
            Cast::toInt('123abc');
        } catch (\Throwable $e) {
        }
        $this->assertTrue(isset($e));
        $this->assertInstanceOf(TypeError::class, $e);
        $this->assertInstanceOf(Exception::class, $e->getPrevious());
        $this->assertSame('A non well formed numeric value encountered', $e->getPrevious()->getMessage());
        $result = @Cast::toInt('123abc');
        $this->assertSame(123, $result);
    }

    public function testToFloat(): void
    {
        $this->assertSame(0.0, Cast::toFloat(0));
        $this->assertSame(1.0, Cast::toFloat(1));
        $this->assertSame(1.1, Cast::toFloat(1.1));
        $this->assertSame(1.9, Cast::toFloat(1.9));
        $this->assertSame(0.0, Cast::toFloat('0'));
        $this->assertSame(1.0, Cast::toFloat('1'));
        $this->assertSame(1.1, Cast::toFloat('1.1'));
        $this->assertSame(1.9, Cast::toFloat('1.9'));
        $this->assertSame(0.0, Cast::toFloat(false));
        $this->assertSame(1.0, Cast::toFloat(true));
        $this->assertSame(PHP_INT_MAX + 1, Cast::toFloat(PHP_INT_MAX + 1));
        $this->assertSame(-9223372036854776833, Cast::toFloat(-9223372036854776833));

        $this->assertTypeError(fn () => Cast::toFloat(''));
        $this->assertTypeError(fn () => Cast::toFloat('a'));
        $this->assertTypeError(fn () => Cast::toFloat('ok'));
        $this->assertTypeError(fn () => Cast::toFloat('true'));
        $this->assertTypeError(fn () => Cast::toFloat('null'));
        $this->assertTypeError(fn () => Cast::toFloat(null));
        $this->assertTypeError(fn () => Cast::toFloat([]));
        $this->assertTypeError(fn () => Cast::toFloat((object)[]));
    }

    public function testToString(): void
    {
        $this->assertSame('0', Cast::toString(0));
        $this->assertSame('1', Cast::toString(1));
        $this->assertSame('1.1', Cast::toString(1.1));
        $this->assertSame('0', Cast::toString('0'));
        $this->assertSame('1', Cast::toString('1'));
        $this->assertSame('a', Cast::toString('a'));
        $this->assertSame('1.1', Cast::toString('1.1'));
        $this->assertSame('', Cast::toString(false));
        $this->assertSame('1', Cast::toString(true));
        $this->assertSame(
            'stringable',
            Cast::toString(
                new class () {
                    public function __toString()
                    {
                        return 'stringable';
                    }
                }
            )
        );

        $this->assertTypeError(fn () => Cast::toString(null));
        $this->assertTypeError(fn () => Cast::toString([]));
        $this->assertTypeError(fn () => Cast::toString((object)[]));
    }

    public function testToBool(): void
    {
        $this->assertFalse(Cast::toBool(0));
        $this->assertTrue(Cast::toBool(1));
        $this->assertTrue(Cast::toBool(1.1));
        $this->assertFalse(Cast::toBool('0'));
        $this->assertTrue(Cast::toBool('1'));
        $this->assertTrue(Cast::toBool('a'));
        $this->assertTrue(Cast::toBool('1.1'));
        $this->assertFalse(Cast::toBool(false));
        $this->assertTrue(Cast::toBool(true));
        $this->assertFalse(Cast::toBool(''));
        $this->assertTrue(Cast::toBool('a'));
        $this->assertTrue(Cast::toBool('ok'));
        $this->assertTrue(Cast::toBool('ng'));
        $this->assertTrue(Cast::toBool('false'));
        $this->assertTrue(Cast::toBool('true'));
        $this->assertTrue(Cast::toBool('null'));

        $this->assertTypeError(fn () => Cast::toBool(null));
        $this->assertTypeError(fn () => Cast::toBool([]));
        $this->assertTypeError(fn () => Cast::toBool((object)[]));
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
