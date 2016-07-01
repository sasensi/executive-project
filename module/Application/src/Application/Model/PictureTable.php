<?php

namespace Application\Model;

/**
 * Automatically generated class from db schema
 * Date: 30/06/2016
 */
class PictureTable extends AbstractTable
{
	public function getAllFromProjectId($projectId)
	{
	    return $this->tableGateway->select(['project_id' => $projectId]);
	}
}
