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
use Application\Form\View\Helper\Date;
use Application\Form\View\Helper\FormElement;
use Application\Form\View\Helper\FormRow;
use Application\Form\View\Helper\GiftsFormHelper;
use Application\Form\View\Helper\TagPickerHelper;
use Application\Util\BasePathOrUrl;
use Zend\Db\ResultSet\ResultSet;
use Zend\Http\Response;
use Zend\Mvc\I18n\Translator;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\ServiceManager\ServiceManager;
use Zend\Session\Config\SessionConfig;
use Zend\Session\Container;
use Zend\Session\SessionManager;
use Zend\Validator\AbstractValidator;

class Module
{
	const HELPER_GIFT             = 'giftform';
	const HELPER_TAG              = 'tagpicker';
	const HELPER_DATE             = 'datepicker';
	const HELPER_BASE_PATH_OR_URL = 'basePathOrUrl';

	public function onBootstrap(MvcEvent $e)
	{
		$eventManager        = $e->getApplication()->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);

		// check user access to current route
		$eventManager->attach(MvcEvent::EVENT_ROUTE, function (MvcEvent $event)
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

		// init session
		$this->initSession([
			'remember_me_seconds' => 180,
			'use_cookies'         => true,
			'cookie_httponly'     => true,
		]);

		// set form validation translator
		$translator = new \Zend\I18n\Translator\Translator();
		$translator->setLocale('FR');
		$validationTranslator = new Translator($translator);
		AbstractValidator::setDefaultTranslator($validationTranslator);
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
					__NAMESPACE__ => __DIR__.'/src',
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

			$config[ 'Application\Model\\'.$capTableName.'Table' ] = function ($sm) use ($capTableName, $tableName)
			{
				/** @var ServiceManager $sm */
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
				// overriden zend hepers
				'formelement'                 => FormElement::class,
				'formrow'                     => FormRow::class,
				// custom application helpers
				self::HELPER_TAG              => TagPickerHelper::class,
				self::HELPER_GIFT             => GiftsFormHelper::class,
				self::HELPER_DATE             => Date::class,
				self::HELPER_BASE_PATH_OR_URL => BasePathOrUrl::class,
			],
		];
	}

	//
	// INTERNAL
	//

	/**
	 * @param RouteMatch $routeMatch
	 * @throws \Application\Exception\WrongUserTypeException
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
				'export',
			],

			'transaction' => [
				'index',
				'detail',
				'add',
			],
		];

		$creatorBlacklist = [
			'project' => [
				'add',
				'delete',
				'user',
				'user_detail',
				'user_update',
				'user_delete',
				'user_promote',
				'export',
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
			'transaction' => [
				'analyse',
			],
		];

		// if not in global black list, user is allowed
		if (empty($controller) || empty($action) || !$this->checkIsInBlacklist($loginBlackList, $controller, $action))
		{
			return;
		}

		$user = UserController::getLoggedUser();

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
