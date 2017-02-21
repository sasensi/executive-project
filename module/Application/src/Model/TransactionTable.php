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
		return $this->select(['user_id' => $userId]);
	}

	public function getAllFromProjectId($projectId)
	{
		return $this->select(['project_id' => $projectId]);
	}

	public function getCountByDay()
	{
		return $this->prepareAndExecute('
			SELECT paymentdate AS date, count(*) AS value
			FROM transaction
			GROUP BY date
		');
	}

	public function getTotalAmountByDay()
	{
		return $this->prepareAndExecute('
			SELECT paymentdate as date, sum(amount) AS value
			FROM transaction
			GROUP BY date
		');
	}
}
