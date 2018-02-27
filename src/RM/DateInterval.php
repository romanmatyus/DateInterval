<?php

namespace RM;

use DateTime;
use DateTimeImmutable;

/**
 * @author Roman Mátyus <romanmatyus@romiix.org>
 */
class DateInterval extends \DateInterval
{
	/** @var DateTimeImmutable */
	private $refDT;

	public function __construct($interval = 'PT0S')
	{
		if ($interval === NULL)
			$interval = 'PT0S';
		$this->refDT = new DateTimeImmutable('midnight');
		$invert = FALSE;
		if ($interval instanceof \DateInterval) {
			if ($interval->invert)
				$invert = TRUE;
			$interval = self::parse($interval);
		} elseif (is_string($interval)) {
			if (strpos($interval, '-') === 0) {
				$invert = TRUE;
				$interval = substr($interval, 1);
			}
		} elseif (is_int($interval)) {
			if ($interval < 0)
				$invert = TRUE;
			$interval = sprintf("PT%uS", abs($interval));
		} elseif (is_float($interval)) {
			if ($interval < 0)
				$invert = TRUE;
			$interval = sprintf("PT%uS", abs(round($interval)));
		}
		try {
			parent::__construct($interval);
		} catch (\Exception $e) {
			$this->validateRelativeFormat($interval, $e);
			$d1 = $this->getRefDT();
			$d2 = $this->getRefDT()->modify($interval);
			parent::__construct(self::parse($d1->diff($d2)));
		}
		if ($invert) {
			$this->invert = 1;
		}
	}

	public function add($interval) : self
	{
		$d1 = $this->getRefDT();
		$d1->add($this);
		$d1->add(new self($interval));
		$int = ($this->getRefDT())->diff($d1);
		$this->__construct(self::parse($int));
		if ($d1 < $this->getRefDT())
			$this->invert = 1;
		return $this;
	}

	public function sub($interval) : self
	{
		$d1 = $this->getRefDT();
		$d1->add($this);
		$d1->sub(new self($interval));
		$int = ($this->getRefDT())->diff($d1);
		$this->__construct(self::parse($int));
		if ($d1 < $this->getRefDT())
			$this->invert = 1;
		return $this;
	}

	public function toSeconds() : int
	{
		return (($this->y * 365 * 24 * 60 * 60) +
			($this->m * 30 * 24 * 60 * 60) +
			($this->d * 24 * 60 * 60) +
			($this->h * 60 * 60) +
			($this->i * 60) +
			$this->s) * (($this->invert) ? -1 : 1);
	}

	public static function parse(\DateInterval $dateInterval) : string
	{
		$date = array(
			'Y' => $dateInterval->y,
			'M' => $dateInterval->m,
			'D' => $dateInterval->d
		);

		$time = array(
			'H' => $dateInterval->h,
			'M' => $dateInterval->i,
			'S' => $dateInterval->s
		);

		if (isset($time['H']) && $time['H'] < 0) {
			$time['H'] = 24 + $time['H'];
			if ($date['D'] >= 1)
				$date['D']--;
			elseif ($date['M'] >= 1)
				$date['M']--;
			elseif ($date['Y'] >= 1)
				$date['Y']--;
		}

		if ($time['H'] === 24) {
			$date['D']++;
			$time['H'] = 0;
		}

		$specString = 'P';

		foreach (array_filter($date) as $key => $value) {
			$specString .= $value . $key;
		}
		if (count(array_filter($time)) > 0) {
			$specString .= 'T';
			foreach (array_filter($time) as $key => $value) {
				$specString .= $value . $key;
			}
		}

		if (strlen($specString) === 1) {
			$specString .= 'T0S';
		}

		return $specString;
	}

	public function __toString()
	{
		return self::parse($this);
	}

	public function getRefDT()
	{
		return new DateTime($this->refDT->format(DateTime::ISO8601));
	}

	private function validateRelativeFormat($interval, \Exception $e = NULL)
	{
		$parse = date_parse($interval);
		if ($parse['error_count'])
			throw new DateInterval\InvalidArgumentException(($e) ? $e->getMessage() : NULL, ($e) ? $e->getCode() : NULL, ($e) ? $e : NULL);
		if (!isset($parse['relative']))
			throw new DateInterval\InvalidArgumentException(sprintf("First argument '%s' is not in supported relative date format.", $interval), ($e) ? $e->getCode() : NULL, ($e) ? $e : NULL);
	}
}
