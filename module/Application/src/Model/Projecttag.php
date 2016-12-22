<?php

namespace Application\Model;

/**
 * Automatically generated class from db schema
 * Date: 22/12/2016
 */
class Projecttag extends AbstractRow
{
	/**
	 * @var integer
	 */
	public $project_id;

	/**
	 * @var integer
	 */
	public $tag_id;


	public function exchangeArray(array $data)
	{
		$this->project_id = (isset($data['project_id'])) ? $data['project_id'] : null;
		$this->tag_id     = (isset($data['tag_id'])) ? $data['tag_id'] : null;
	}

	public function getArrayCopy()
	{
		return [
			'project_id' => $this->project_id,
			'tag_id'     => $this->tag_id,

		];
	}
}
