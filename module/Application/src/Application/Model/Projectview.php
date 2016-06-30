<?php

namespace Application\Model;

/**
 * Automatically generated class from db schema
 * Date: 30/06/2016
 */
class Projectview implements RowInterface
{
	/**
	 * @var integer
	 */
	public $user_id;

	/**
	 * @var integer
	 */
	public $project_id;

	/**
	 * @var string
	 */
	public $date;


	public function exchangeArray($arr)
	{
		$this->user_id = (isset($arr['user_id'])) ? $arr['user_id'] : null;
		$this->project_id = (isset($arr['project_id'])) ? $arr['project_id'] : null;
		$this->date = (isset($arr['date'])) ? $arr['date'] : null;

	}
}
