<?php

namespace Application\Model;

/**
 * Automatically generated class from db schema
 * Date: 22/12/2016
 */
class Gift extends AbstractRow
{
	/**
	 * @var integer
	 */
	public $id;

	/**
	 * @var string
	 */
	public $title;

	/**
	 * @var integer
	 */
	public $minamount;

	/**
	 * @var string
	 */
	public $description;

	/**
	 * @var integer
	 */
	public $project_id;


	public function exchangeArray(array $data)
	{
		$this->id          = (isset($data['id'])) ? $data['id'] : null;
		$this->title       = (isset($data['title'])) ? $data['title'] : null;
		$this->minamount   = (isset($data['minamount'])) ? $data['minamount'] : null;
		$this->description = (isset($data['description'])) ? $data['description'] : null;
		$this->project_id  = (isset($data['project_id'])) ? $data['project_id'] : null;
	}

	public function getArrayCopy()
	{
		return [
			'id'          => $this->id,
			'title'       => $this->title,
			'minamount'   => $this->minamount,
			'description' => $this->description,
			'project_id'  => $this->project_id,

		];
	}
}
