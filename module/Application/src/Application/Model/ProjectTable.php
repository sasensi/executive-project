<?php

namespace Application\Model;

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
	 * @param string[] $keyWords
	 * @param int      $categoryId
	 * @return \Zend\Db\ResultSet\ResultSet
	 */
	public function getAllFromSearchParams($keyWords = [], $categoryId = null)
	{
		$resultSet = $this->tableGateway->select(function (Select $select) use ($keyWords, $categoryId)
		{
			$select->where(function (Where $where) use ($keyWords, $categoryId, $select)
			{
				foreach ($keyWords as $keyWord)
				{
					$where->OR->like('title', "%$keyWord%");
				}

				if (isset($categoryId))
				{
					$select->join('projectcategory', 'projectcategory.project_id = project.id');
					$where->AND->equalTo('projectcategory.category_id', $categoryId);
				}
			});
		});

		return $resultSet;
	}

	public function insert(Project $project)
	{

	}
}