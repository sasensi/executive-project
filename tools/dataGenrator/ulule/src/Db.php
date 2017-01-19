<?php
/**
 * Created by: STAGIAIRE
 * the 18/01/2017
 */

namespace Ulule;


class Db extends \PDO
{
	public function __construct()
	{
		parent::__construct('mysql:dbname=crowdfunding;host=127.0.0.1', 'root', '');
		$this->setAttribute(self::ATTR_ERRMODE, self::ERRMODE_EXCEPTION);
		$this->exec('SET NAMES utf8');
	}
}