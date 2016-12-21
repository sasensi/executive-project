<?php

namespace Application\Model;

/**
 * Automatically generated class from db schema
 * Date: 30/06/2016
 */
class ProjectviewTable extends AbstractTable
{
	public function getCountFromProjectId($projectId)
	{
		$result = $this->select(['project_id' => $projectId]);
		return $result->count();
	}
}
