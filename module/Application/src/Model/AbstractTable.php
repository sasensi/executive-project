<?php

namespace Application\Model;

use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

class AbstractTable extends TableGateway
{
	const DATE_FORMAT = 'Y-m-d';

	/**
	 * Select
	 *
	 * @param Where|\Closure|string|array $where
	 * @return object|null
	 */
	public function selectFirst($where = null)
	{
		$resultSet = $this->select($where);
		return $resultSet->current();
	}

	/**
	 * @param int $id
	 * @return object
	 */
	public function selectFirstById($id)
	{
		return $this->selectFirst(['id' => $id]);
	}

	public function selectFromIds(array $ids)
	{
		if (empty($ids))
		{
			return [];
		}

		$where = new Where();
		$where->in('id', $ids);

		return $this->select($where);
	}

	public function deleteFromId($id)
	{
		parent::delete(['id' => $id]);
	}

	public function insert($set)
	{
		parent::insert($set);

		return $this->getLastInsertValue();
	}


}