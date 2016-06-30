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
	protected $id;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var integer
	 */
	protected $minamount;

	/**
	 * @var string
	 */
	protected $description;

	/**
	 * @var integer
	 */
	protected $project_id;


	public function exchangeArray($arr)
	{
		$this->id = (isset($arr['id'])) ? $arr['id'] : null;
		$this->title = (isset($arr['title'])) ? $arr['title'] : null;
		$this->minamount = (isset($arr['minamount'])) ? $arr['minamount'] : null;
		$this->description = (isset($arr['description'])) ? $arr['description'] : null;
		$this->project_id = (isset($arr['project_id'])) ? $arr['project_id'] : null;

	}
}
