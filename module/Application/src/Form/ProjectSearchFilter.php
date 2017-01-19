<?php
/**
 * Created by PhpStorm.
 * User: STAGIAIRE
 * Date: 08/09/2016
 * Time: 10:14
 */

namespace Application\Form;


use Application\Model\Category;
use Application\Model\Tag;
use Application\Model\TagTable;

class ProjectSearchFilter
{
	const ORDER_DEADLINE_ASC      = 'ORDER_DEADLINE_ASC';
	const ORDER_DEADLINE_DESC     = 'ORDER_DEADLINE_DESC';
	const ORDER_CREATIONDATE_ASC  = 'ORDER_CREATIONDATE_ASC';
	const ORDER_CREATIONDATE_DESC = 'ORDER_CREATIONDATE_DESC';
	const ORDER_GOAL_ASC          = 'ORDER_GOAL_ASC';
	const ORDER_GOAL_DESC         = 'ORDER_GOAL_DESC';
	const ORDER_TRANSACTION_ASC   = 'ORDER_TRANSACTION_ASC';
	const ORDER_TRANSACTION_DESC  = 'ORDER_TRANSACTION_DESC';

	const STATUS_FINISHED = 'STATUS_FINISHED';
	const STATUS_CURRENT  = 'STATUS_CURRENT';

	const PROJECT_PER_REQUEST = 12;

	protected $selectedKeyWords;
	protected $selectedCategory;
	protected $selectedStatus;
	protected $selectedOrder;

	protected $statuses = [
		self::STATUS_CURRENT  => 'en cours',
		self::STATUS_FINISHED => 'terminé',
	];
	protected $orders   = [
		self::ORDER_CREATIONDATE_ASC  => 'date de création ↗',
		self::ORDER_CREATIONDATE_DESC => 'date de création ↘',
		self::ORDER_DEADLINE_ASC      => 'date butoire ↗',
		self::ORDER_DEADLINE_DESC     => 'date butoire ↘',
		self::ORDER_GOAL_ASC          => 'objectif ↗',
		self::ORDER_GOAL_DESC         => 'objectif ↘',
		self::ORDER_TRANSACTION_ASC   => 'somme récoltée ↗',
		self::ORDER_TRANSACTION_DESC  => 'somme récoltée ↘',
	];
	protected $categories;
	/**
	 * @var Tag
	 */
	protected $tag;

	protected $offset;

	/**
	 * ProjectSearchFilter constructor.
	 *
	 * @param Category[] $categories
	 */
	public function __construct($categories)
	{
		$this->categories       = $categories;
		$this->selectedOrder    = self::ORDER_CREATIONDATE_DESC;
		$this->selectedKeyWords = [];
		$this->offset           = 0;
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

	/**
	 * @return \Application\Model\Tag
	 */
	public function getTag()
	{
		return $this->tag;
	}

	/**
	 * @param \Application\Model\Tag $tag
	 */
	public function setTag(Tag $tag)
	{
		$this->tag = $tag;
	}

	/**
	 * @return mixed
	 */
	public function getOffset()
	{
		return $this->offset;
	}

	/**
	 * @param mixed $offset
	 */
	public function setOffset($offset)
	{
		$this->offset = $offset;
	}

	/**
	 * @param array    $params
	 * @param TagTable $tagTable
	 */
	public function fillFromParams($params, $tagTable)
	{
		if (!empty($params['keywords']))
		{
			$keyWords = preg_split('/[^a-zA-Z]+/', $params['keywords'], -1, PREG_SPLIT_NO_EMPTY);
			$this->setSelectedKeyWords($keyWords);
		}
		if (!empty($params['category'])) $this->setSelectedCategory($params['category']);
		if (!empty($params['order'])) $this->setSelectedOrder($params['order']);
		if (!empty($params['status'])) $this->setSelectedStatus($params['status']);
		if (!empty($params['tag']))
		{
			try
			{
				/** @var Tag $tag */
				$tag = $tagTable->selectFirstById($params['tag']);
				$this->setTag($tag);
			}
			catch (\Exception $e)
			{
			}
		}
	}

}