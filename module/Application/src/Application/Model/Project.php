<?php

namespace Application\Model;

class Project implements RowInterface
{
	public $id;
	public $user_id;
	public $title;
	public $subtitle;
	public $description;
	public $mainpicture;
	public $creationdate;
	public $deadline;
	public $goal;

	public function exchangeArray($data)
	{
		$this->id           = (!empty($data['id'])) ? $data['id'] : null;
		$this->user_id      = (!empty($data['user_id'])) ? $data['user_id'] : null;
		$this->title        = (!empty($data['title'])) ? $data['title'] : null;
		$this->subtitle     = (!empty($data['subtitle'])) ? $data['subtitle'] : null;
		$this->description  = (!empty($data['description'])) ? $data['description'] : null;
		$this->mainpicture  = (!empty($data['mainpicture'])) ? $data['mainpicture'] : null;
		$this->creationdate = (!empty($data['creationdate'])) ? $data['creationdate'] : null;
		$this->deadline     = (!empty($data['deadline'])) ? $data['deadline'] : null;
		$this->goal         = (!empty($data['goal'])) ? $data['goal'] : null;
	}
}