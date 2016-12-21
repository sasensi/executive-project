<?php

namespace Application\Model;

/**
 * Automatically generated class from db schema
 * Date: 30/06/2016
 */
class Projecttag implements RowInterface
{
	/**
	 * @var integer
	 */
	public $project_id;

	/**
	 * @var integer
	 */
	public $tag_id;


	public function exchangeArray($arr)
	{
		$this->project_id = (isset($arr['project_id'])) ? $arr['project_id'] : null;
		$this->tag_id = (isset($arr['tag_id'])) ? $arr['tag_id'] : null;

	}
}
