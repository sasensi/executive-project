<?php

namespace Application\Model;

/**
 * Automatically generated class from db schema
 * Date: 22/12/2016
 */
class Transaction extends AbstractRow
{
	/**
	 * @var integer
	 */
	public $id;

	/**
	 * @var integer
	 */
	public $amount;

	/**
	 * @var string
	 */
	public $paymentdate;

	/**
	 * @var string
	 */
	public $repaymentdate;

	/**
	 * @var integer
	 */
	public $user_id;

	/**
	 * @var integer
	 */
	public $project_id;

	/**
	 * @var integer
	 */
	public $paymentmethod_id;


	public function exchangeArray(array $data)
	{
		$this->id               = (isset($data['id'])) ? $data['id'] : null;
		$this->amount           = (isset($data['amount'])) ? $data['amount'] : null;
		$this->paymentdate      = (isset($data['paymentdate'])) ? $data['paymentdate'] : null;
		$this->repaymentdate    = (isset($data['repaymentdate'])) ? $data['repaymentdate'] : null;
		$this->user_id          = (isset($data['user_id'])) ? $data['user_id'] : null;
		$this->project_id       = (isset($data['project_id'])) ? $data['project_id'] : null;
		$this->paymentmethod_id = (isset($data['paymentmethod_id'])) ? $data['paymentmethod_id'] : null;
	}

	public function getArrayCopy()
	{
		return [
			'id'               => $this->id,
			'amount'           => $this->amount,
			'paymentdate'      => $this->paymentdate,
			'repaymentdate'    => $this->repaymentdate,
			'user_id'          => $this->user_id,
			'project_id'       => $this->project_id,
			'paymentmethod_id' => $this->paymentmethod_id,

		];
	}
}
