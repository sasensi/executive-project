<?php
/**
 * Created by: STAGIAIRE
 * the 24/11/2016
 */

namespace Application\Util;


class MultiArray
{
	/**
	 * @param array|object $array
	 * @param string       $key
	 * @param bool         $unique
	 * @return array
	 */
	public static function getArrayOfValues($array, $key, $unique = true)
	{
		$result = [];

		foreach ($array as $subArray)
		{
			$value = is_object($subArray) ? $subArray->$key : $subArray[ $key ];
			if ($unique && in_array($value, $result))
			{
				continue;
			}

			$result[] = $value;
		}

		return $result;
	}
}