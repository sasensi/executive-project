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
use Application\Form\View\Helper\FormRow;
use Application\Form\View\Helper\GiftsFormHelper;
use Application\Form\View\Helper\TagPickerHelper;
use Zend\Db\ResultSet\ResultSet;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Config\SessionConfig;
use Zend\Session\Container;
use Zend\Session\SessionManager;

class Module
{
	const HELPER_GIFT = 'giftform';
	const HELPER_TAG  = 'tagpicker';

	public function onBootstrap(MvcEvent $e)
	{
		$eventManager        = $e->getApplication()->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);

		$this->initSession([
			'remember_me_seconds' => 180,
			'use_cookies'         => true,
			'cookie_httponly'     => true,
		]);
	}

	public function initSession($config)
	{
		$sessionConfig = new SessionConfig();
		$sessionConfig->setOptions($config);
		$sessionManager = new SessionManager($sessionConfig);
		$sessionManager->start();
		Container::setDefaultManager($sessionManager);
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

			//$config[ 'Application\Model\\'.$capTableName.'Table' ] = function ($sm) use ($capTableName)
			//{
			//	$className    = '\Application\Model\\'.$capTableName.'Table';
			//	$tableGateway = $sm->get($capTableName.'TableGateway');
			//	$table        = new $className($tableGateway);
			//	return $table;
			//};

			$config[ 'Application\Model\\'.$capTableName.'Table' ] = function ($sm) use ($capTableName, $tableName)
			{
				$tableClassName     = '\Application\Model\\'.$capTableName.'Table';
				$dataClassName      = '\Application\Model\\'.$capTableName;
				$dbAdapter          = $sm->get('Zend\Db\Adapter\Adapter');
				$resultSetPrototype = new ResultSet();
				$resultSetPrototype->setArrayObjectPrototype(new $dataClassName());
				return new $tableClassName($tableName, $dbAdapter, null, $resultSetPrototype);
			};
		}

		return $config;
	}

	public function getViewHelperConfig()
	{
		return [
			'invokables' => [
				'formelement'     => FormElement::class,
				'formrow'         => FormRow::class,
				self::HELPER_TAG  => TagPickerHelper::class,
				self::HELPER_GIFT => GiftsFormHelper::class,
			],
		];
	}
}
