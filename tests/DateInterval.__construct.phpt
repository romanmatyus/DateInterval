<?php

use RM\DateInterval;
use Tester\Assert;

require __DIR__ . '/bootstrap.php';

$interval = new DateInterval;
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
