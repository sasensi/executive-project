<?php

namespace Application\Model;

/**
 * Automatically generated class from db schema
 * Date: 30/06/2016
 */
class Gift implements RowInterface
{
	/**
	 * @var integer
	 */
	public $id;

	/**
	 * @var string
	 */
	public $title;

	/**
	 * @var integer
	 */
	public $minamount;

	/**
	 * @var string
	 */
	public $description;

	/**
	 * @var integer
	 */
	public $project_id;


	public function exchangeArray($arr)
	{
		$this->id = (isset($arr['id'])) ? $arr['id'] : null;
		$this->title = (isset($arr['title'])) ? $arr['title'] : null;
		$this->minamount = (isset($arr['minamount'])) ? $arr['minamount'] : null;
		$this->description = (isset($arr['description'])) ? $arr['description'] : null;
		$this->project_id = (isset($arr['project_id'])) ? $arr['project_id'] : null;

	}
}
