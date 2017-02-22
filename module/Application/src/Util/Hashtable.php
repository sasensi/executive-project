<?php
/**
 * Created by PhpStorm.
 * User: sam
 * Date: 06/11/2016
 * Time: 18:09
 */

namespace Application\Util;


class Hashtable
{
	/**
	 * @param object[] $objectsArray
	 * @param string   $idKey
	 * @return array
	 */
	public static function createFromObject($objectsArray, $idKey='id')
	{
		$result = [];

		foreach ($objectsArray as $object)
		{
			$result[$object->$idKey] = $object;
		}

		return $result;
	}
}