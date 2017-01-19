<?php
/**
 * Created by: STAGIAIRE
 * the 18/01/2017
 */

namespace Ulule;


class DbFactory
{
	/**
	 * @var Db
	 */
	protected static $db;

	public static function getDb()
	{
		if (!isset(self::$db))
		{
			self::$db = new Db();
		}
		return self::$db;
	}
}