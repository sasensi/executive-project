<?php

namespace Application\Model;

/**
 * Automatically generated class from db schema
 * Date: 30/06/2016
 */
class Project implements RowInterface
{
	/**
	 * @var integer
	 */
	public $id;

	/**
	 * @var integer
	 */
	public $user_id;

	/**
	 * @var string
	 */
	public $title;

	/**
	 * @var string
	 */
	public $subtitle;

	/**
	 * @var string
	 */
	public $description;

	/**
	 * @var string
	 */
	public $mainpicture;

	/**
	 * @var string
	 */
	public $creationdate;

	/**
	 * @var string
	 */
	public $deadline;

	/**
	 * @var integer
	 */
	public $goal;

	/**
	 * @var string
	 */
	public $promotionend;


	public function exchangeArray($arr)
	{
		$this->id = (isset($arr['id'])) ? $arr['id'] : null;
		$this->user_id = (isset($arr['user_id'])) ? $arr['user_id'] : null;
		$this->title = (isset($arr['title'])) ? $arr['title'] : null;
		$this->subtitle = (isset($arr['subtitle'])) ? $arr['subtitle'] : null;
		$this->description = (isset($arr['description'])) ? $arr['description'] : null;
		$this->mainpicture = (isset($arr['mainpicture'])) ? $arr['mainpicture'] : null;
		$this->creationdate = (isset($arr['creationdate'])) ? $arr['creationdate'] : null;
		$this->deadline = (isset($arr['deadline'])) ? $arr['deadline'] : null;
		$this->goal = (isset($arr['goal'])) ? $arr['goal'] : null;
		$this->promotionend = (isset($arr['promotionend'])) ? $arr['promotionend'] : null;

	}
}
