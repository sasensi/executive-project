<?php
/**
 * Created by: STAGIAIRE
 * the 24/11/2016
 */

namespace Application\Util;


class MultiArray
{
	public static function getArrayOfValues($array, $key)
	{
		$result = [];

		foreach ($array as $subArray)
		{
			if (is_object($subArray))
			{
				$result[] = $subArray->$key;
			}
			elseif (is_array($subArray))
			{
				$result[] = $subArray[$key];
			}
		}

		return $result;
	}
}