<?php

use RM\DateInterval;
use Tester\Assert;

require __DIR__ . '/bootstrap.php';

$interval = new DateInterval;
Assert::type(\DateInterval::class, $interval);
Assert::type(DateInterval::class, $interval);

$interval = new DateInterval(NULL);
Assert::type(\DateInterval::class, $interval);
Assert::type(DateInterval::class, $interval);

$interval = new DateInterval('PT0S');
Assert::type(\DateInterval::class, $interval);
Assert::type(DateInterval::class, $interval);

$interval = new DateInterval(new \DateInterval('PT0S'));
Assert::type(\DateInterval::class, $interval);
Assert::type(DateInterval::class, $interval);

$interval = new DateInterval('-PT0S');
Assert::type(\DateInterval::class, $interval);
Assert::type(DateInterval::class, $interval);
Assert::same(1, $interval->invert);

Assert::exception(function() {
	new DateInterval('Lorem ipsum');
}, RM\DateInterval\InvalidArgumentException::class);

Assert::exception(function() {
	new DateInterval('01-01-2000');
}, RM\DateInterval\InvalidArgumentException::class, "First argument '%A%' is not in supported relative date format.");

$interval = new DateInterval('+2 minutes');
Assert::type(\DateInterval::class, $interval);
Assert::type(DateInterval::class, $interval);

$interval = new DateInterval(10);
Assert::type(\DateInterval::class, $interval);
Assert::type(DateInterval::class, $interval);

$interval = new DateInterval(5.5);
Assert::type(\DateInterval::class, $interval);
Assert::type(DateInterval::class, $interval);

// Inspired by https://stackoverflow.com/questions/40975057/php-datetime-diff-creates-dateinterval-with-negative-hours
$d1 = new DateTime('2016-07-05T00:00:00');
$d2 = new DateTime('2016-12-30T23:59:59');
$intervalOriginal = $d1->diff($d2);
$intervalForStore = new DateInterval($intervalOriginal);
$stringForStore = (string) $intervalForStore;
Assert::same('P5M25DT23H59M59S', (string) new DateInterval($intervalOriginal));

$d1 = new DateTime('2016-10-29T03:00:00');
$d2 = new DateTime('2016-10-30T02:00:00');
Assert::same('P1D', (string) new DateInterval($d1->diff($d2)));
