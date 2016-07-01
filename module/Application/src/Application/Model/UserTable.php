<?php

namespace Application\Model;

use Zend\Db\Sql\Select;

/**
 * Automatically generated class from db schema
 * Date: 30/06/2016
 */
class UserTable extends AbstractTable
{
	public function getAllForProject($projectId)
	{

		$stmt = $this->tableGateway->getAdapter()->getDriver()->createStatement();
		$stmt->prepare('
			SELECT user.*, transaction.id as transaction_id
			FROM user
			  INNER JOIN (transaction
			    INNER JOIN project ON transaction.project_id = project.id)
			  ON user.id = transaction.user_id
			WHERE project.id = ?
		');
		$result = $stmt->execute([$projectId]);

		$arr = [];
		foreach ($result as $row)
		{
			$user = new User();
			$user->exchangeArray($row);
			$arr[$row['transaction_id']] = $user;
		}
		return $arr;
	}
}
