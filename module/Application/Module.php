<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Controller\UserController;
use Application\Exception\NotLoggedUserException;
use Application\Exception\WrongUserTypeException;
use Application\Form\View\Helper\FormElement;
use Application\Form\View\Helper\FormRow;
use Application\Form\View\Helper\GiftsFormHelper;
use Application\Form\View\Helper\TagPickerHelper;
use Zend\Db\ResultSet\ResultSet;
use Zend\Http\Response;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
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

		// check user access to current route
		$eventManager->attach(\Zend\Mvc\MvcEvent::EVENT_ROUTE, function (MvcEvent $event)
		{
			$match = $event->getRouteMatch();

			// 404
			if (!$match instanceof RouteMatch)
			{
				return null;
			}

			try
			{
				$this->checkUserHasRouteAccess($match);
			}
			catch (NotLoggedUserException $exception)
			{
				return $this->redirect($event, 'user', 'login');
			}
			catch (WrongUserTypeException $exception)
			{
				return $this->redirect($event, 'project', 'index');
			}

			return null;
		});

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
				'category',
				'cities',
				'configuration_history',
				'configurations',
				'countries',
				'country',
				'favouritecategory',
				'first_names',
				'gift',
				'last_names',
				'paymentmethod',
				'picture',
				'project',
				'projectcategory',
				'projecttag',
				'projectview',
				'regions',
				'sessions',
				'settings',
				'tag',
				'transaction',
				'user',
				'user_accounts',
				'usertype',
				'video',
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

	//
	// INTERNAL
	//

	/**
	 * @param RouteMatch $routeMatch
	 */
	protected function checkUserHasRouteAccess($routeMatch)
	{
		preg_match('/([^\\\\]+)?$/', $routeMatch->getParam('controller'), $matches);
		$controller = strtolower($matches[1]);
		$action     = $routeMatch->getParam('action');

		// set black lists
		$loginBlackList = [
			'user' => [
				'index',
				'update',
				'delete',
				'export',
			],

			'project' => [
				'add',
				'delete',
				'analyse',
				'user',
				'user_detail',
				'user_update',
				'user_delete',
				'user_promote',
			],

			'transaction' => [
				'index',
				'detail',
				'add',
			],
		];

		$creatorBlacklist = [
			'user' => [
				'export',
			],

			'project' => [
				'add',
				'delete',
				'user',
				'user_detail',
				'user_update',
				'user_delete',
				'user_promote',
			],
		];

		$financerBlacklist = [
			'transaction' => [
				'index',
				'detail',
				'add',
			],
		];

		$adminBlacklist = [
			'project' => [
				'analyse',
			],
		];

		// if not in global black list, user is allowed
		if (empty($controller) || empty($action) || !$this->checkIsInBlacklist($loginBlackList, $controller, $action))
		{
			return;
		}

		$user = UserController::getLoggedUser();

		// not creator
		if (
			($this->checkIsInBlacklist($creatorBlacklist, $controller, $action) && !$user->isCreator())
			|| ($this->checkIsInBlacklist($financerBlacklist, $controller, $action) && !$user->isFinancer())
			|| ($this->checkIsInBlacklist($adminBlacklist, $controller, $action) && !$user->isAdmin())
		)
		{
			throw new WrongUserTypeException();
		}
	}

	protected function checkIsInBlacklist($blacklist, $controller, $action)
	{
		return isset($blacklist[ $controller ]) && in_array($action, $blacklist[ $controller ]);
	}

	protected function redirect(MvcEvent $event, $controller, $action)
	{
		// redirect to login page
		$router = $event->getRouter();
		$url    = $router->assemble(['controller' => $controller, 'action' => $action], ['name' => 'home/action']);

		/** @var Response $response */
		$response = $event->getResponse();
		$response->getHeaders()
		         ->addHeaderLine('Location', $url);
		$response->setStatusCode(302);

		return $response;
	}
}
