<?php

namespace Application\Model;

/**
 * Automatically generated class from db schema
 * Date: 22/12/2016
 */
class Projectcategory extends AbstractRow
{
	/**
	 * @var integer
	 */
	public $project_id;

	/**
	 * @var integer
	 */
	public $category_id;


	public function exchangeArray(array $data)
	{
		$this->project_id  = (isset($data['project_id'])) ? $data['project_id'] : null;
		$this->category_id = (isset($data['category_id'])) ? $data['category_id'] : null;
	}

	public function getArrayCopy()
	{
		return [
			'project_id'  => $this->project_id,
			'category_id' => $this->category_id,

		];
	}
}
