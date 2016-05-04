<?php

namespace Application\Controller;

use Application\Model\AbstractTable;
use Zend\Mvc\Controller\AbstractActionController;

class AbstractActionCustomController extends AbstractActionController
{
	protected $tables;

	/**
	 * @param $tableName
	 * @return AbstractTable
	 */
	protected function getTable($tableName)
	{
		if (!isset($this->tables[ $tableName ]))
		{
			$sm = $this->getServiceLocator();
			$this->tables[ $tableName ] = $sm->get('Application\Model\\'.ucfirst($tableName).'Table');
		}
		return $this->tables[ $tableName ];
	}
}