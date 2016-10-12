<?php

namespace Application\Controller;

use Application\Model\AbstractTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Helper\HeadLink;
use Zend\View\Helper\HeadScript;

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

	protected function getRenderer()
	{
		return $this->getServiceLocator()->get('Zend\View\Renderer\RendererInterface');
	}
}