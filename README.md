# RM\DateInterval

[![Build Status](https://travis-ci.org/romanmatyus/DateInterval.svg?branch=master)](https://travis-ci.org/romanmatyus/DateInterval)
[![Code Quality](https://scrutinizer-ci.com/g/romanmatyus/DateInterval/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/romanmatyus/DateInterval/)
[![Code Coverage](https://scrutinizer-ci.com/g/romanmatyus/DateInterval/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/romanmatyus/DateInterval/)
[![Latest Stable Version](https://poser.pugx.org/rm/dateinterval/v/stable)](https://packagist.org/packages/rm/dateinterval)
[![Latest Unstable Version](https://poser.pugx.org/rm/dateinterval/v/unstable)](https://packagist.org/packages/rm/dateinterval)
[![License](https://poser.pugx.org/rm/dateinterval/license)](https://packagist.org/packages/rm/dateinterval)

Simple library for manipulating with date intervals in PHP.

## Requirements

- PHP 7.0

## Installation

```
$ composer require rm/dateinterval
```

## Features

### Extends creation possibility

```php
namespace RM\DateInterval;

new DateInterval; // 0 seconds
new DateInterval('PT0S'); // 0 seconds
new DateInterval(new \DateInterval('PT0S')); // 0 seconds
new DateInterval('-P1D'); // - 1 day
new DateInterval('+2 minutes'); 
new DateInterval(10); // 10 seconds
new DateInterval(-1000); // 1000 seconds
new DateInterval(5.5); // 6 seconds
```

### Adding/Subtraction

Allowing summarize multiple intervals into one.

```php
$interval = new \RM\DateInterval;
foreach ([
	'PT10S', // 0:10
	'PT13M14S', // 13:24
	'PT3M3S', // 16:27
	'PT4M58S', // 21:25
] as $data) {
	$interval->add($data);
}
echo $interval->format('%i:%s'); // '21:25'
```

### Convert to seconds

> Usable for comparing.

```php
(new \RM\DateInterval('+1 day'))->toSeconds(); // int(86400)
```

### Generate string

Generating standardized `string`, for storing interval to database.

```php
$now = new DateTime;
$next = clone $now;
$next->modify('+1 day') // 1 day
	->modify('+14 hours') // 1 day 14 hours
	->modify('-3 minutes') // 1 day 13 hours 57 mins
	->modify('13 seconds'); // 1 day 13 hours 57 mins 13 seconds
$interval = new \RM\DateInterval($now->diff($next));
echo (string) $interval; // P1DT13H57M13S

$interval = new \RM\DateInterval($string);
echo $interval->format('%dd %hh %im %ss'); // 1d 13h 57m 13s
```

Alternatively it's possible use only static method `RM\DateInterval::parse(DateInterval $interval)`.


