<?php

use RM\DateInterval;
use Tester\Assert;

require __DIR__ . '/bootstrap.php';

$midnight = new DateTime('midnight');
$tomorowMidnight = (clone $midnight)->modify('+1 day');

Assert::same('P1D', (string) (new DateInterval($midnight->diff($tomorowMidnight))));
