<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class AbstractTable
{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	/**
	 * @return \Zend\Db\TableGateway\TableGateway
	 */
	public function getTableGateway()
	{
		return $this->tableGateway;
	}

	public function getAll()
	{
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}

	/**
	 * @param int $id
	 */
	public function getOneById($id)
	{
		$resultSet = $this->tableGateway->select(['id' => $id]);
		return $resultSet->current();
	}

	public function delete($id)
	{
	    $this->tableGateway->delete(['id' => $id]);
	}
}