<?php

namespace Application\Model;

/**
 * Automatically generated class from db schema
 * Date: 30/06/2016
 */
class Transaction implements RowInterface
{
	/**
	 * @var integer
	 */
	protected $id;

	/**
	 * @var integer
	 */
	protected $amount;

	/**
	 * @var string
	 */
	protected $paymentdate;

	/**
	 * @var string
	 */
	protected $repaymentdate;

	/**
	 * @var integer
	 */
	protected $user_id;

	/**
	 * @var integer
	 */
	protected $project_id;

	/**
	 * @var integer
	 */
	protected $paymentmethod_id;


	public function exchangeArray($arr)
	{
		$this->id = (isset($arr['id'])) ? $arr['id'] : null;
		$this->amount = (isset($arr['amount'])) ? $arr['amount'] : null;
		$this->paymentdate = (isset($arr['paymentdate'])) ? $arr['paymentdate'] : null;
		$this->repaymentdate = (isset($arr['repaymentdate'])) ? $arr['repaymentdate'] : null;
		$this->user_id = (isset($arr['user_id'])) ? $arr['user_id'] : null;
		$this->project_id = (isset($arr['project_id'])) ? $arr['project_id'] : null;
		$this->paymentmethod_id = (isset($arr['paymentmethod_id'])) ? $arr['paymentmethod_id'] : null;

	}
}
