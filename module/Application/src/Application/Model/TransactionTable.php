<?php

namespace Application\Model;

/**
 * Automatically generated class from db schema
 * Date: 30/06/2016
 */
class TransactionTable extends AbstractTable
{
	public function getAllFromUserId($userId)
	{
	    return $this->tableGateway->select(['user_id' => $userId]);
	}

	public function getAllFromProjectId($projectId)
	{
	    return $this->tableGateway->select(['project_id' => $projectId]);
	}
}
