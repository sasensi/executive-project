<?php
/**
 * Created by PhpStorm.
 * User: STAGIAIRE
 * Date: 08/09/2016
 * Time: 10:14
 */

namespace Application\Form;


use Application\Model\Category;

class ProjectSearchFilter
{
	const ORDER_DATE_ASC  = 'ORDER_DATE_ASC';
	const ORDER_DATE_DESC = 'ORDER_DATE_DESC';

	const STATUS_FINISHED = 'STATUS_FINISHED';
	const STATUS_CURRENT  = 'STATUS_CURRENT';

	protected $selectedKeyWords;
	protected $selectedCategory;
	protected $selectedStatus;
	protected $selectedOrder;

	protected $statuses = [
		self::STATUS_CURRENT  => 'en cours',
		self::STATUS_FINISHED => 'terminé',
	];
	protected $orders   = [
		self::ORDER_DATE_ASC  => 'date ordre croissant',
		self::ORDER_DATE_DESC => 'date ordre décroissant',
	];
	protected $categories;

	/**
	 * ProjectSearchFilter constructor.
	 *
	 * @param Category[] $categories
	 */
	public function __construct($categories)
	{
		$this->categories    = $categories;
		$this->selectedOrder = self::ORDER_DATE_DESC;
	}

	/**
	 * @return mixed
	 */
	public function getSelectedKeyWords()
	{
		return $this->selectedKeyWords;
	}

	/**
	 * @param mixed $selectedKeyWords
	 */
	public function setSelectedKeyWords($selectedKeyWords)
	{
		$this->selectedKeyWords = $selectedKeyWords;
	}

	/**
	 * @return mixed
	 */
	public function getSelectedCategory()
	{
		return $this->selectedCategory;
	}

	/**
	 * @param mixed $selectedCategory
	 */
	public function setSelectedCategory($selectedCategory)
	{
		$this->selectedCategory = $selectedCategory;
	}

	/**
	 * @return mixed
	 */
	public function getSelectedStatus()
	{
		return $this->selectedStatus;
	}

	/**
	 * @param mixed $selectedStatus
	 */
	public function setSelectedStatus($selectedStatus)
	{
		$this->selectedStatus = $selectedStatus;
	}

	/**
	 * @return mixed
	 */
	public function getSelectedOrder()
	{
		return $this->selectedOrder;
	}

	/**
	 * @param mixed $selectedOrder
	 */
	public function setSelectedOrder($selectedOrder)
	{
		$this->selectedOrder = $selectedOrder;
	}

	/**
	 * @return array
	 */
	public function getStatuses()
	{
		return $this->statuses;
	}

	/**
	 * @return array
	 */
	public function getOrders()
	{
		return $this->orders;
	}

	/**
	 * @return \Application\Model\Category[]
	 */
	public function getCategories()
	{
		return $this->categories;
	}

}