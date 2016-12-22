<?php

namespace Application\Model;

/**
 * Automatically generated class from db schema
 * Date: 22/12/2016
 */
class Projectview extends AbstractRow
{
	/**
	 * @var integer
	 */
	public $user_id;

	/**
	 * @var integer
	 */
	public $project_id;

	/**
	 * @var string
	 */
	public $date;


	public function exchangeArray(array $data)
	{
		$this->user_id    = (isset($data['user_id'])) ? $data['user_id'] : null;
		$this->project_id = (isset($data['project_id'])) ? $data['project_id'] : null;
		$this->date       = (isset($data['date'])) ? $data['date'] : null;
	}

	public function getArrayCopy()
	{
		return [
			'user_id'    => $this->user_id,
			'project_id' => $this->project_id,
			'date'       => $this->date,

		];
	}
}
