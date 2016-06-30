<?php

namespace Application\Model;
use Zend\Db\Sql\Select;

/**
 * Automatically generated class from db schema
 * Date: 30/06/2016
 */
class CategoryTable extends AbstractTable
{
	public function getAllFromProjectId($projectId)
	{
		return $this->tableGateway->select(function (Select $select) use ($projectId)
		{
			$select->join('projectcategory', 'category.id = projectcategory.category_id');
			$select->where(['projectcategory.project_id' => $projectId]);
		});
	}
}
