<?php
/**
 * Created by: STAGIAIRE
 * the 24/11/2016
 */

namespace Application\Util;


class DateFormatter
{
	const FORMAT_US = 'Y-m-d';
	const FORMAT_FR = 'd/m/Y';

	protected static $timezone;

	public static function usToFr($dateUs)
	{
		return self::getDateTime($dateUs, self::FORMAT_US)->format(self::FORMAT_FR);
	}

	public static function frToUs($dateFr)
	{
		return self::getDateTime($dateFr, self::FORMAT_FR)->format(self::FORMAT_US);
	}

	protected static function getDateTime($date, $format)
	{
		$date = \DateTime::createFromFormat($format, $date, self::getTimeZone());
		if ($date === false)
		{
			throw new \Exception("Cannot create parse date '{$date}' from format '{$format}'");
		}

		return $date;
	}

	/**
	 * @return mixed
	 */
	public static function getTimeZone()
	{
		if (!isset(self::$timezone))
		{
			self::$timezone = new \DateTimeZone('Europe/Paris');
		}
		return self::$timezone;
	}
}