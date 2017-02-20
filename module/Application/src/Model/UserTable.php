<?php

namespace Application\Model;

/**
 * Automatically generated class from db schema
 * Date: 30/06/2016
 */
class UserTable extends AbstractTable
{
	public function getAllForProject($projectId)
	{
		$stmt = $this->getAdapter()->getDriver()->createStatement();
		$stmt->prepare('
			SELECT user.*, transaction.id AS transaction_id
			FROM user
			  INNER JOIN (transaction
			    INNER JOIN project ON transaction.project_id = project.id)
			  ON user.id = transaction.user_id
			WHERE project.id = ?
			GROUP BY user.id
		');
		$result = $stmt->execute([$projectId]);

		$arr = [];
		foreach ($result as $row)
		{
			$user = new User();
			$user->exchangeArray($row);
			$arr[ $row['transaction_id'] ] = $user;
		}
		return $arr;
	}

	public function desactivate($id)
	{
		$this->update([
			'desactivated' => true
		], [
			'id' => $id
		]);
	}

	public function getFinancersSexsforPieChart($sexKey, $countKey)
	{
		$stmt = $this->getAdapter()->getDriver()->createStatement();
		$stmt->prepare('
			SELECT sex AS ?, count(*) AS ?
			FROM user
			WHERE usertype_id = ?
			GROUP BY sex
			ORDER BY sex DESC
		');

		return $stmt->execute([$sexKey, $countKey, Usertype::FINANCER]);
	}
}
