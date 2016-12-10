<?php

namespace Application\Model;

/**
 * Automatically generated class from db schema
 * Date: 30/06/2016
 */
class Paymentmethod implements RowInterface
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


	public function exchangeArray($arr)
	{
		$this->id   = (isset($arr['id'])) ? $arr['id'] : null;
		$this->name = (isset($arr['name'])) ? $arr['name'] : null;
	}
}
