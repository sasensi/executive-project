<?php

namespace Application\Model;

use Application\Form\ProjectSearchFilter;
use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
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
	 * @return ResultSetInterface
	 */
	public function getAllFromSearchFilters($searchFilter)
	{
		$select = new Select($this->table);
		$where  = new Where();

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

		// order
		$orders = ['promotionend DESC'];
		$order  = $searchFilter->getSelectedOrder();
		if ($order === ProjectSearchFilter::ORDER_DEADLINE_ASC)
		{
			$orders[] = 'deadline ASC';
		}
		elseif ($order === ProjectSearchFilter::ORDER_DEADLINE_DESC)
		{
			$orders[] = 'deadline DESC';
		}
		elseif ($order === ProjectSearchFilter::ORDER_GOAL_ASC)
		{
			$orders[] = 'goal ASC';
		}
		elseif ($order === ProjectSearchFilter::ORDER_GOAL_DESC)
		{
			$orders[] = 'goal DESC';
		}
		elseif ($order === ProjectSearchFilter::ORDER_CREATIONDATE_ASC)
		{
			$orders[] = 'creationdate ASC';
		}
		elseif ($order === ProjectSearchFilter::ORDER_CREATIONDATE_DESC)
		{
			$orders[] = 'creationdate DESC';
		}
		elseif ($order === ProjectSearchFilter::ORDER_TRANSACTION_ASC)
		{
			$orders[] = 'transactionsum ASC';
		}
		elseif ($order === ProjectSearchFilter::ORDER_TRANSACTION_DESC)
		{
			$orders[] = 'transactionsum DESC';
		}
		$orders[] = 'id DESC';
		$select->order($orders);

		// limit & offset
		$select->offset($searchFilter->getOffset());
		$select->limit(ProjectSearchFilter::PROJECT_PER_REQUEST);

		// group by
		$select->group('project.id');

		$select->where($where);

		// workaround for zend quotting limit and offset bug
		$sqlObject = new Sql($this->adapter);
		$sqlString = $sqlObject->buildSqlString($select, $this->adapter);

		$statement = $this->getAdapter()->getDriver()->createStatement($sqlString);
		$result    = $statement->execute();

		$resultSet = clone $this->resultSetPrototype;
		$resultSet->initialize($result);

		return $resultSet;
	}

	public function getCreationDateCountForChart()
	{
		$stmt = $this->getAdapter()->getDriver()->createStatement();
		$stmt->prepare('
			SELECT creationdate date, count(*) AS count
			FROM project
			GROUP BY creationdate
		');

		return $stmt->execute();
	}
}