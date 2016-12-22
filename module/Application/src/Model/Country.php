<?php

namespace Application\Model;

/**
 * Automatically generated class from db schema
 * Date: 22/12/2016
 */
class Country extends AbstractRow
{
	/**
	 * @var integer
	 */
	public $id;

	/**
	 * @var string
	 */
	public $name;


	public function exchangeArray(array $data)
	{
		$this->id   = (isset($data['id'])) ? $data['id'] : null;
		$this->name = (isset($data['name'])) ? $data['name'] : null;
	}

	public function getArrayCopy()
	{
		return [
			'id'   => $this->id,
			'name' => $this->name,

		];
	}
}
