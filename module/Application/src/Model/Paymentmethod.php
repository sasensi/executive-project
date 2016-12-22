<?php

namespace Application\Model;

/**
 * Automatically generated class from db schema
 * Date: 22/12/2016
 */
class Paymentmethod extends AbstractRow
{
	const CREDIT_CARD = 1;
	const PAYPAL      = 2;
	const BITCOIN     = 3;

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
