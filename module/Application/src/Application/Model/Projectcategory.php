<?php

namespace Application\Model;

/**
 * Automatically generated class from db schema
 * Date: 30/06/2016
 */
class Projectcategory implements RowInterface
{
	/**
	 * @var integer
	 */
	protected $project_id;

	/**
	 * @var integer
	 */
	protected $category_id;


	public function exchangeArray($arr)
	{
		$this->project_id = (isset($arr['project_id'])) ? $arr['project_id'] : null;
		$this->category_id = (isset($arr['category_id'])) ? $arr['category_id'] : null;

	}
}
