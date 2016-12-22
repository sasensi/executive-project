<?php

namespace Application\Model;

use DateTime;
use DateTimeZone;

/**
 * Automatically generated class from db schema
 * Date: 22/12/2016
 */
class Project extends AbstractRow
{
	const PROMOTION_PRICE = 15;
	const PROMOTION_DELAY = 7;

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

	/**
	 * @var integer
	 */
	public $transactionsum;


	public function exchangeArray(array $data)
	{
		$this->id             = (isset($data['id'])) ? $data['id'] : null;
		$this->user_id        = (isset($data['user_id'])) ? $data['user_id'] : null;
		$this->title          = (isset($data['title'])) ? $data['title'] : null;
		$this->subtitle       = (isset($data['subtitle'])) ? $data['subtitle'] : null;
		$this->description    = (isset($data['description'])) ? $data['description'] : null;
		$this->mainpicture    = (isset($data['mainpicture'])) ? $data['mainpicture'] : null;
		$this->creationdate   = (isset($data['creationdate'])) ? $data['creationdate'] : null;
		$this->deadline       = (isset($data['deadline'])) ? $data['deadline'] : null;
		$this->goal           = (isset($data['goal'])) ? $data['goal'] : null;
		$this->promotionend   = (isset($data['promotionend'])) ? $data['promotionend'] : null;
		$this->transactionsum = (isset($data['transactionsum'])) ? $data['transactionsum'] : null;
	}

	public function getArrayCopy()
	{
		return [
			'id'             => $this->id,
			'user_id'        => $this->user_id,
			'title'          => $this->title,
			'subtitle'       => $this->subtitle,
			'description'    => $this->description,
			'mainpicture'    => $this->mainpicture,
			'creationdate'   => $this->creationdate,
			'deadline'       => $this->deadline,
			'goal'           => $this->goal,
			'promotionend'   => $this->promotionend,
			'transactionsum' => $this->transactionsum,

		];
	}

	public function getRemainingDaysCount()
	{
		$timeZone    = new DateTimeZone('Europe/Paris');
		$endDate     = DateTime::createFromFormat('Y-m-d', $this->deadline, $timeZone);
		$currentDate = new DateTime('now', $timeZone);

		$remainingTime = $currentDate->diff($endDate);

		return $remainingTime->invert ? 0 : $remainingTime->days;
	}

	public function getFormattedDeadLine()
	{
		$date = DateTime::createFromFormat(AbstractTable::DATE_FORMAT, $this->deadline);
		if ($date)
		{
			$formattedDate = $date->format('d / m / Y');
			// prevent date line breaking
			return str_replace(' ', '&nbsp;', $formattedDate);
		}
		return null;
	}

	public function getGoalReachingPercentage()
	{
		return round(((int) $this->transactionsum / (int) $this->goal) * 100);
	}
}
