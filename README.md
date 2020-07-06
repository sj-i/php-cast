# CAST IN THE NAME OF PHP, YE NOT GUILTY
## ABOUT
- you can cast any values in the weak mode manner, even if you are in the strict mode (strict_types=1)

## INSTALL
```
composer require sj-i/php-cast
```

## SUPPORTED VERSIONS
- PHP 7.0+

## USAGE

```
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
$null_value = NullableCast:toInt('');
// null
$null_value = NullableCast:toInt(null);
```

## LICENSE
MIT