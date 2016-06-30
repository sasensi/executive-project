<?php

namespace Application\Model;

/**
 * Automatically generated class from db schema
 * Date: 30/06/2016
 */
class Video implements RowInterface
{
	/**
	 * @var integer
	 */
	public $id;

	/**
	 * @var string
	 */
	public $url;

	/**
	 * @var integer
	 */
	public $project_id;


	public function exchangeArray($arr)
	{
		$this->id = (isset($arr['id'])) ? $arr['id'] : null;
		$this->url = (isset($arr['url'])) ? $arr['url'] : null;
		$this->project_id = (isset($arr['project_id'])) ? $arr['project_id'] : null;

	}
}
