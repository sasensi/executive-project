<?php
/**
 * Created by: STAGIAIRE
 * the 09/12/2016
 */

namespace Application\Util;


class DevelopementMode
{
	public static function isActive()
	{
		return true;
		return strpos($_SERVER['HTTP_HOST'], 'localhost') === 0;
	}
}