<?php

namespace Application\Model;

/**
 * Automatically generated class from db schema
 * Date: 30/06/2016
 */
class Favouritecategory implements RowInterface
{
	/**
	 * @var integer
	 */
	public $user_id;

	/**
	 * @var integer
	 */
	public $category_id;

	/**
	 * @var integer
	 */
	public $order;


	public function exchangeArray($arr)
	{
		$this->user_id = (isset($arr['user_id'])) ? $arr['user_id'] : null;
		$this->category_id = (isset($arr['category_id'])) ? $arr['category_id'] : null;
		$this->order = (isset($arr['order'])) ? $arr['order'] : null;

	}
}
