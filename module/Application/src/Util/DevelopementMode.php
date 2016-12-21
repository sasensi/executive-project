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
		// debug
		// todo: remove this
		return true;
		//return (isset($_SERVER['APPLICATION_ENV']) && $_SERVER['APPLICATION_ENV'] === 'development');
	}
}