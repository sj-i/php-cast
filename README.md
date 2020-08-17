# CAST IN THE NAME OF PHP, YE NOT GUILTY
![Minimum PHP version: 7.0.0](https://img.shields.io/badge/php-7.0.0%2B-blue.svg)
[![Packagist](https://img.shields.io/packagist/v/sj-i/php-cast.svg)](https://packagist.org/packages/sj-i/php-cast)
[![Github Actions](https://github.com/sj-i/php-cast/workflows/build/badge.svg)](https://github.com/sj-i/php-cast/actions)
[![Coverage Status](https://coveralls.io/repos/github/sj-i/php-cast/badge.svg?branch=master)](https://coveralls.io/github/sj-i/php-cast?branch=master)
[![Psalm coverage](https://shepherd.dev/github/sj-i/php-cast/coverage.svg?)](https://shepherd.dev/github/sj-i/php-cast)

## ABOUT
- You can cast any values in the weak mode manner, even if you are in the strict mode (strict_types=1).

## INSTALL
```bash
composer require sj-i/php-cast
```

## SUPPORTED VERSIONS
- PHP 7.0+

## USAGE

```php
use PhpCast\Cast;
use PhpCast\NullableCast;

// int(1)
$int_value = Cast::toInt('1');
// string(1) "1"
$string_value = Cast::toString(1);
// float(1)
$float_value = Cast::toFloat(1);
// bool(true)
$bool_value = Cast::toBool(1);

// TypeError
$int_value = Cast::toInt('a');
// TypeError
$int_value = Cast::toInt(null);


// int(1)
$int_value = NullableCast::toInt('1');
// string(1) "1"
$string_value = NullableCast::toString(1);
// float(1)
$float_value = NullableCast::toFloat(1);
// bool(true)
$bool_value = NullableCast::toBool(1);

// TypeError
$null_value = NullableCast::toInt('');
// null
$null_value = NullableCast::toInt(null);
```

## HOW IT WORKS
- Return type declarations in weak mode files do the job.
- `PhpCast\Cast` and `PhpCast\NullableCast` are defined in files declared as `strict_types=0`
    - Though `strict_types=0` is the current default of PHP, it is explicitly declared to assert the intent.
- The type checks for parameters are done in the caller mode, but the type checks for return values are always done in the callee mode.

## "WHY WEAK MODE? I WANT TO USE STRICT MODE IN EVERYWHERE!"
- To use `strict_types=1` without any `strict_types=0` codes, explicit casts have to be used for untyped data from external sources like DB or HTTP requests.
- But in PHP, explicit cast like `(int)$foo` never fails with a few exceptions.
    - `(int)'abc'` silently results to `0` and doesn't emit a warning.
- So some validations are necessary before just using casts.
- If explicit casts are used without proper validations by a lazy programmer, the purpose of the type declarations are totally ruined.
    - This was, if I understand it correctly, one of the reasons that strict type checks weren't totally welcomed with open arms during the discussion introducing the scalar type hinting to PHP.
- Defining proper rules of validations and type conversions is sometimes overkill.
    - Even though defining them are always "correct" things to do, in humans life, there are times you don't need to be so correct.
- Let's cast untyped values in the weak mode manner, use the "official" rules of validations and type conversions in PHP world!
    - No need to invent and learn new rules every day every night everywhere.
    - If the "official" rules doesn't fit your needs, then define ans use your own rules selectively there.
- If you've ever read [the accepted RFC of STH](https://wiki.php.net/rfc/scalar_type_hints_v5), you would notice the use of weak mode like this library has been already mentioned [there](https://wiki.php.net/rfc/scalar_type_hints_v5#this_proposal_is_a_compromise).
    > This proposal is not a compromise. It is an attempt of allowing strict typing to work in PHP. A mechanism to bridge untyped PHP code with strict typed PHP code, a “weak” bridge, would be required (otherwise explicit (type) casts would be needed). This proposal unifies the strict and weak typing into a single system that integrates tightly and behaves consistently.  

## LICENSE
MIT