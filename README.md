# CAST IN THE NAME OF PHP, YE NOT GUILTY
## ABOUT
- you can cast any values in the weak mode manner, even if you are in the strict mode (strict_types=1)

## INSTALL
```
composer require sj-i/php-cast
```

## USAGE

```
use PhpCast\Cast;

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
```

## LICENSE
MIT