<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Form\View\Helper\FormElement;
use Application\Form\View\Helper\TagPickerHelper;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
	public function onBootstrap(MvcEvent $e)
	{
		$eventManager        = $e->getApplication()->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);
	}

	public function getConfig()
	{
		return include __DIR__.'/config/module.config.php';
	}

	public function getAutoloaderConfig()
	{
		return [
			'Zend\Loader\StandardAutoloader' => [
				'namespaces' => [
					__NAMESPACE__ => __DIR__.'/src/'.__NAMESPACE__,
				],
			],
		];
	}

	public function getServiceConfig()
	{
		return [
			'factories' => $this->getFactoriesConfig([
				'user',
				'project',
				'category',
				'gift',
				'tag',
				'projectview',
				'video',
				'picture',
				'transaction',
				'paymentmethod',
				'projectcategory',
				'projecttag',
			]),
		];
	}

	/**
	 * @param array $tableNames
	 * @return array
	 */
	protected function getFactoriesConfig($tableNames)
	{
		$config = [];

		foreach ($tableNames as $tableName)
		{
			$capTableName = ucfirst($tableName);

			$config[ 'Application\Model\\'.$capTableName.'Table' ] = function ($sm) use ($capTableName)
			{
				$className    = '\Application\Model\\'.$capTableName.'Table';
				$tableGateway = $sm->get($capTableName.'TableGateway');
				$table        = new $className($tableGateway);
				return $table;
			};

			$config[ $capTableName.'TableGateway' ] = function ($sm) use ($capTableName, $tableName)
			{
				$className          = '\Application\Model\\'.$capTableName;
				$dbAdapter          = $sm->get('Zend\Db\Adapter\Adapter');
				$resultSetPrototype = new ResultSet();
				$resultSetPrototype->setArrayObjectPrototype(new $className());
				return new TableGateway($tableName, $dbAdapter, null, $resultSetPrototype);
			};
		}

		return $config;
	}

	public function getViewHelperConfig()
	{
		return [
			'invokables' => [
				'formelement' => FormElement::class,
				'tagpicker'   => TagPickerHelper::class
			],
		];
	}
}
