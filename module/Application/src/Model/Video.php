<?php

namespace Application\Model;

/**
 * Automatically generated class from db schema
 * Date: 22/12/2016
 */
class Video extends AbstractRow
{
	/**
	 * @var integer
	 */
	public $id;

	/**
	 * @var string
	 */
	public $url;

	/**
	 * @var integer
	 */
	public $project_id;


	public function exchangeArray(array $data)
	{
		$this->id         = (isset($data['id'])) ? $data['id'] : null;
		$this->url        = (isset($data['url'])) ? $data['url'] : null;
		$this->project_id = (isset($data['project_id'])) ? $data['project_id'] : null;
	}

	public function getArrayCopy()
	{
		return [
			'id'         => $this->id,
			'url'        => $this->url,
			'project_id' => $this->project_id,

		];
	}
}
