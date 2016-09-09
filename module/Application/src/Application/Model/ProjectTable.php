<?php

namespace Application\Model;

use Application\Form\ProjectSearchFilter;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

/**
 * Automatically generated class from db schema
 * Date: 30/06/2016
 */
class ProjectTable extends AbstractTable
{
	/**
	 * @param int $userId
	 * @return \Zend\Db\ResultSet\ResultSet
	 */
	public function getAllFromUserId($userId)
	{
		$resultSet = $this->tableGateway->select(['user_id' => $userId]);
		return $resultSet;
	}

	/**
	 * @param ProjectSearchFilter $searchFilter
	 * @return \Zend\Db\ResultSet\ResultSet
	 */
	public function getAllFromSearchFilters($searchFilter)
	{
		$resultSet = $this->tableGateway->select(function (Select $select) use ($searchFilter)
		{
			$select->where(function (Where $where) use ($searchFilter, $select)
			{
				$keyWords = $searchFilter->getSelectedKeyWords();
				if (!empty($keyWords))
				{
					foreach ($keyWords as $keyWord)
					{
						$keyWord = strtoupper($keyWord);
						$where->OR->expression('UPPER(title) LIKE ?', '%'.$keyWord.'%');
					}
				}

				$categoryId = $searchFilter->getSelectedCategory();
				if (isset($categoryId))
				{
					$select->join('projectcategory', 'projectcategory.project_id = project.id');
					$where->AND->equalTo('projectcategory.category_id', $categoryId);
				}

				// status
				$status = $searchFilter->getSelectedStatus();
				if ($status === ProjectSearchFilter::STATUS_CURRENT)
				{
					$where->AND->literal('deadline > now()');
				}
				elseif ($status === ProjectSearchFilter::STATUS_FINISHED)
				{
					$where->AND->literal('deadline < now()');
				}
			});

			// order
			$order = $searchFilter->getSelectedOrder();
			if ($order === ProjectSearchFilter::ORDER_DATE_ASC)
			{
				$select->order('deadline ASC');
			}
			elseif ($order === ProjectSearchFilter::ORDER_DATE_DESC)
			{
				$select->order('deadline DESC');
			}

			$select->group('project.id');
		});

		return $resultSet;
	}

	public function insert(Project $project)
	{
	}
}