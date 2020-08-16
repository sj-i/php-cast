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
    public function testToInt()
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

        $this->assertTypeError(function () {
            return Cast::toInt('');
        });
        $this->assertTypeError(function () {
            return Cast::toInt('a');
        });
        $this->assertTypeError(function () {
            return Cast::toInt('ok');
        });
        $this->assertTypeError(function () {
            return Cast::toInt('true');
        });
        $this->assertTypeError(function () {
            return Cast::toInt('null');
        });
        $this->assertTypeError(function () {
            return Cast::toInt(null);
        });
        $this->assertTypeError(function () {
            return Cast::toInt([]);
        });
        $this->assertTypeError(function () {
            return Cast::toInt((object)[]);
        });
        $this->assertTypeError(function () {
            return Cast::toInt(PHP_INT_MAX + 1);
        });
        $this->assertTypeError(function () {
            return Cast::toInt(-9223372036854776833);
        });

        try {
            Cast::toInt('123abc');
        } catch (\Throwable $e) {
        }
        if (version_compare(PHP_VERSION, '7.1.0') >= 0) {
            $this->assertTrue(isset($e));
            if (version_compare(PHP_VERSION, '7.4.0') >= 0) {
                $this->assertInstanceOf(TypeError::class, $e);
                $this->assertInstanceOf(Exception::class, $e->getPrevious());
                $this->assertSame('A non well formed numeric value encountered', $e->getPrevious()->getMessage());
            } else {
                $this->assertInstanceOf(Exception::class, $e);
                $this->assertSame('A non well formed numeric value encountered', $e->getMessage());
            }
            $this->assertInstanceOf(TypeError::class, $e);
            $this->assertInstanceOf(Exception::class, $e->getPrevious());
            $this->assertSame('A non well formed numeric value encountered', $e->getPrevious()->getMessage());
        }
        $result = @Cast::toInt('123abc');
        $this->assertSame(123, $result);
    }

    public function testToFloat()
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

        $this->assertTypeError(function () {
            return Cast::toFloat('');
        });
        $this->assertTypeError(function () {
            return Cast::toFloat('a');
        });
        $this->assertTypeError(function () {
            return Cast::toFloat('ok');
        });
        $this->assertTypeError(function () {
            return Cast::toFloat('true');
        });
        $this->assertTypeError(function () {
            return Cast::toFloat('null');
        });
        $this->assertTypeError(function () {
            return Cast::toFloat(null);
        });
        $this->assertTypeError(function () {
            return Cast::toFloat([]);
        });
        $this->assertTypeError(function () {
            return Cast::toFloat((object)[]);
        });
    }

    public function testToString()
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

        $this->assertTypeError(function () {
            return Cast::toString(null);
        });
        $this->assertTypeError(function () {
            return Cast::toString([]);
        });
        $this->assertTypeError(function () {
            return Cast::toString((object)[]);
        });
    }

    public function testToBool()
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

        $this->assertTypeError(function () {
            return Cast::toBool(null);
        });
        $this->assertTypeError(function () {
            return Cast::toBool([]);
        });
        $this->assertTypeError(function () {
            return Cast::toBool((object)[]);
        });
    }

    private function assertTypeError(callable $func)
    {
        try {
            $func();
        } catch (Throwable $e) {
        }
        $this->assertTrue(isset($e));
        $this->assertInstanceOf(TypeError::class, $e);
    }
}
