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
		$resultSet = $this->select(['user_id' => $userId]);
		return $resultSet;
	}

	/**
	 * @param ProjectSearchFilter $searchFilter
	 * @return \Zend\Db\ResultSet\ResultSet
	 */
	public function getAllFromSearchFilters($searchFilter)
	{
		$resultSet = $this->select(function (Select $select) use ($searchFilter)
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
					//$select->join('projectcategory', 'projectcategory.project_id = project.id', Select::SQL_STAR, Select::JOIN_LEFT);
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

				// tag
				$tag = $searchFilter->getTag();
				if (isset($tag))
				{
					$select->join('projecttag', 'projecttag.project_id = project.id');
					$where->AND->equalTo('projecttag.tag_id', $tag->id);
				}
			});

			// order
			$orders = ['promotionend DESC'];
			$order  = $searchFilter->getSelectedOrder();
			if ($order === ProjectSearchFilter::ORDER_DATE_ASC)
			{
				$orders[] = 'deadline ASC';
			}
			elseif ($order === ProjectSearchFilter::ORDER_DATE_DESC)
			{
				$orders[] = 'deadline DESC';
			}
			$select->order($orders);

			$select->group('project.id');
		});

		return $resultSet;
	}
}