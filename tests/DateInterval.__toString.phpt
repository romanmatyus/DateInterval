<?php

use RM\DateInterval;
use Tester\Assert;

require __DIR__ . '/bootstrap.php';

$midnight = new DateTime('midnight');
$tomorowMidnight = (clone $midnight)->modify('+1 day');

Assert::same('P1D', (string) (new DateInterval($midnight->diff($tomorowMidnight))));

$now = new DateTime;
$next = clone $now;
$next->modify('+1 day') // 1 day
	->modify('+14 hours') // 1 day 14 hours
	->modify('-3 minutes') // 1 day 13 hours 57 mins
	->modify('13 seconds'); // 1 day 13 hours 57 mins 13 seconds
$interval = new DateInterval($now->diff($next));
$string = (string) $interval;
Assert::same('P1DT13H57M13S', $string);

$interval = new DateInterval($string);
Assert::same('1d 13h 57m 13s', $interval->format('%dd %hh %im %ss'));
