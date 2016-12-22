<?php

namespace Application\Model;

/**
 * Automatically generated class from db schema
 * Date: 22/12/2016
 */
class Favouritecategory extends AbstractRow
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


	public function exchangeArray(array $data)
	{
		$this->user_id     = (isset($data['user_id'])) ? $data['user_id'] : null;
		$this->category_id = (isset($data['category_id'])) ? $data['category_id'] : null;
		$this->order       = (isset($data['order'])) ? $data['order'] : null;
	}

	public function getArrayCopy()
	{
		return [
			'user_id'     => $this->user_id,
			'category_id' => $this->category_id,
			'order'       => $this->order,

		];
	}
}
