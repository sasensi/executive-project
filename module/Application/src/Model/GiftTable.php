<?php

namespace Application\Model;

use Zend\Db\Sql\Select;

/**
 * Automatically generated class from db schema
 * Date: 30/06/2016
 */
class GiftTable extends AbstractTable
{
	public function getAllFromProjectId($projectId)
	{
		return $this->select(function (Select $select) use ($projectId)
		{
			$select->where(['project_id' => $projectId]);
			$select->order('minamount ASC');
		});
	}
}
