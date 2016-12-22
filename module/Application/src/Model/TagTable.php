<?php

namespace Application\Model;

use Zend\Db\Sql\Select;

/**
 * Automatically generated class from db schema
 * Date: 30/06/2016
 */
class TagTable extends AbstractTable
{
	public function getAllFromProjectId($projectId)
	{
		return $this->select(function (Select $select) use ($projectId)
		{
			$select->join('projecttag', 'tag.id = projecttag.tag_id');
			$select->where(['projecttag.project_id' => $projectId]);
		});
	}
}
