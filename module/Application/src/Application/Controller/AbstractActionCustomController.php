<?php

namespace Application\Controller;

use Application\Model\AbstractTable;
use Zend\Db\Adapter\Adapter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Helper\HeadLink;
use Zend\View\Helper\HeadScript;
use Zend\View\Renderer\PhpRenderer;

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
			$sm                         = $this->getServiceLocator();
			$this->tables[ $tableName ] = $sm->get('Application\Model\\'.ucfirst($tableName).'Table');
		}
		return $this->tables[ $tableName ];
	}

	protected function addCssDependency($pathFromBase)
	{
		/** @var HeadLink $headLinkHelper */
		$headLinkHelper = $this->getServiceLocator()->get('ViewHelperManager')->get('HeadLink');
		$headLinkHelper->appendStylesheet($this->getRenderer()->basePath($pathFromBase));
	}

	protected function addJsDependency($pathFromBase)
	{
		/** @var HeadScript $scriptHelper */
		$scriptHelper = $this->getServiceLocator()->get('ViewHelperManager')->get('HeadScript');
		$scriptHelper->appendFile($this->getRenderer()->basePath($pathFromBase));
	}

	/**
	 * @return PhpRenderer
	 */
	protected function getRenderer()
	{
		return $this->getServiceLocator()->get('Zend\View\Renderer\RendererInterface');
	}

	protected function beginTransaction()
	{
		$this->getServiceLocator()->get(Adapter::class)->getDriver()->getConnection()->beginTransaction();
	}

	protected function commitTransaction()
	{
		$this->getServiceLocator()->get(Adapter::class)->getDriver()->getConnection()->commit();
	}
}