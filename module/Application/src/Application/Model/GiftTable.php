<?php

namespace Application\Model;

/**
 * Automatically generated class from db schema
 * Date: 30/06/2016
 */
class GiftTable extends AbstractTable
{
	public function getAllFromProjectId($projectId)
	{
		return $this->select(['project_id' => $projectId]);
	}
}
