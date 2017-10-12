<?php

use RM\DateInterval;
use Tester\Assert;

require __DIR__ . '/bootstrap.php';

$interval = new DateInterval('PT0S');
Assert::same(0, $interval->toSeconds());

$interval = new DateInterval('-PT1S');
Assert::same(-1, $interval->toSeconds());

$midnight = new DateTime('midnight');
$tomorowMidnight = (clone $midnight)->modify('+1 day');
Assert::same(24 * 60 * 60, (new DateInterval($midnight->diff($tomorowMidnight)))->toSeconds());

Assert::same(24 * 60 * 60, (new DateInterval('+1 day'))->toSeconds());

Assert::same(2 * 60 * -1, (new DateInterval('-2 minutes'))->toSeconds());

Assert::same(1000, (new DateInterval(1000))->toSeconds());

Assert::same(6, (new DateInterval(5.5))->toSeconds());

Assert::same(-1, (new DateInterval(-1))->toSeconds());

$d1 = new DateTime('midnight');
$d2 = clone $d1;
$d2->modify('+1 second');
Assert::same(1, (new DateInterval($d1->diff($d2)))->toSeconds());

$d1 = new DateTime('midnight');
$d2 = clone $d1;
$d2->modify('-1 second');
Assert::same(-1, (new DateInterval($d1->diff($d2)))->toSeconds());
