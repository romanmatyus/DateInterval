<?php

use RM\DateInterval;
use Tester\Assert;

require __DIR__ . '/bootstrap.php';

$interval = new DateInterval;
Assert::same(0, $interval->toSeconds());

$interval->add('-PT1S');
Assert::same(-1, $interval->toSeconds());

$interval->add(new DateInterval(new \DateInterval('P3D')));
Assert::same(259199, $interval->toSeconds());

$interval->add('PT1S');
Assert::same(259200, $interval->toSeconds());

$interval->sub('3 days');
Assert::same(0, $interval->toSeconds());

$interval->sub(10);
Assert::same(-10, $interval->toSeconds());

$interval->add(-5.5);
Assert::same(-16, $interval->toSeconds());

$intervals = [
	'PT10S',
	'PT13M14S',
	'PT3M3S',
	'PT4M58S',
];

$interval = new DateInterval;
foreach ([
	'PT10S', // 0:10
	'PT13M14S', // 13:24
	'PT3M3S', // 16:27
	'PT4M58S', // 21:25
] as $data) {
	$interval->add($data);
}
Assert::same('21:25', $interval->format('%i:%s'));
