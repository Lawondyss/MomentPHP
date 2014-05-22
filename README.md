# MomentPHP

MomentPHP is date library for parsing, validating, manipulating, and formatting dates.
It's inspired by the JavaScript library [Moment.js].


## License

Is freely distributable under the terms of the [GPL-3] license.


## Install

MomentPHP is available on [Packagist], where you can get it via [Composer].

File **composer.json**:
```json
{
    "require": {
        "lawondyss/moment-php": "dev-master"
    }
}
```

Run in command-line:
```sh
php composer.phar install
```


## Parse

### Now

Get the current date and time:
```php
$moment = new MomentPHP\MomentPHP();
```

### String

Create from a string with date time. The string are acceptable same as for function `strtotime` (http://www.php.net/manual/en/function.strtotime.php).
```php
$string = '1980-12-07';
$string = '7 December 1980';
$string = '+1 week 2 days 4 hours 2 seconds';
$string = 'next Thursday';

$moment = new MomentPHP\MomentPHP($string);
```

### Integer

Create from a integer with timestamp. The integer is a number seconds from the Unix Epoch.
```php
$integer = 345061302;
$integer = time();

$moment = new MomentPHP\MomentPHP($integer);
```

### DateTime

Create from a instance of the class DateTime (http://www.php.net/manual/en/class.datetime.php):
```php
$moment = new MomentPHP\MomentPHP(new DateTime());
```

### String + Format

If the string is unrecognized or confusing, you can add its format. The format are same as for method `DateTime::createFromFormat` (http://www.php.net/manual/en/datetime.createfromformat.php).
```php
$string = '1980-07-12';
$format = 'Y-d-m';

$moment = new MomentPHP\MomenthPHP($string, $format);
```

The format may be a field with more formats. Then use the first acceptable format.
```php
$string = '1980-12-07';
$format = array('U', 'Y-m-d');

$moment = new MomentPHP\MomentPHP($string, $format);
```

### Set Timezone

The Timezone is set via the third parameter to the constructor. Timezone may be string from a table with [supported Timezones], or instance of the class DateTimeZone (http://www.php.net/manual/en/class.datetimezone.php).
```php
$timezone = 'Europe/Prague';
$timezone = new DateTimeZone('Europe/Prague');

$moment = new MomentPHP\MomentPHP(null, null, $timezone);
```

## Display
For examples we have:
```php
$moment = new MomentPHP\MomentPHP('1980-12-07 19:21:42');
```

### Format()
Return formating date time. Parameter is same as for function `date` (http://www.php.net/manual/en/function.date.php).
```php
var_dump( $moment->format('d/m/Y') ); // string(10) "07/12/1980"
```

### Timestamp()
Return number seconds from the Unix Epoch.
```php
var_dump( $moment->timestamp() ); // string(9) "345061302"
```
### Partials from date time
```php
var_dump( $moment->seconds() ); // string(2) "42"
// it`s same as
var_dump( $moment->second() );

var_dump( $moment->minutes() ); // string(2) "21"
// it's same as
var_dump( $moment->minute() );

var_dump( $moment->hours() ); // string(2) "19"
// it's same as
var_dump( $moment->hour() );

var_dump( $moment->days() ); // string(2) "07"
// it's same as
var_dump( $moment->day() );

var_dump( $moment->months() ); // string(2) "12"
// it's same as
var_dump( $moment->month() );

var_dump( $moment->years ); // string(4) "1980"
// ti's same as
var_dump( $moment->year() );

var_dump( $moment->weeks() ); //string(2) "49"
// it's same as
var_dump( $moment->week() );

// 1 (for Monday) through 7 (for Sunday)
var_dump( $moment->dayOfWeek() ); // string(1) "7"

// starting from 1
var_dump( $moment->dayOfYear() ); // string(3) "342"

var_dump( $moment->nameOfDayShort() ); // string(3) "Sun"

var_dump( $moment->nameOfDayLong() ); // string(6) "Sunday"

var_dump( $moment->dayWithSuffix() ); // string(3) "7th"
```



[Moment.js]:http://momentjs.com/
[GPL-3]:https://tldrlegal.com/license/gnu-general-public-license-v3-(gpl-3)
[Packagist]:https://packagist.org/packages/lawondyss/moment-php
[Composer]:http://getcomposer.org/
[supported Timezones]:http://www.php.net/manual/en/timezones.php