<?php

namespace Application\Model;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;

class AbstractTable extends TableGateway
{
	const DATE_FORMAT = 'Y-m-d';

	/**
	 * @param int $id
	 */
	public function selectOneById($id)
	{
		$resultSet = $this->select(['id' => $id]);
		return $resultSet->current();
	}

	public function delete($id)
	{
		$this->delete(['id' => $id]);
	}

	public function insert($set)
	{
		parent::insert($set);

		return $this->getLastInsertValue();
	}


}