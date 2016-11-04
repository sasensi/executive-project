<?php

namespace Application\Controller;

use Application\Model\User;
use Application\Model\UserTable;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionCustomController
{
	const SESSION_LOGIN_KEY = 'login';

	public function indexAction()
	{
		$user = self::getLoggedUser();

		return new ViewModel([
			'user' => $user
		]);
	}

	public function signinAction()
	{
		return new ViewModel();
	}

	public function loginAction()
	{
		return new ViewModel();
	}

	public function forgotPasswordAction()
	{
		return new ViewModel();
	}

	public function logoutAction()
	{
		return new ViewModel();
	}

	public function updateAction()
	{
		return new ViewModel();
	}

	public function updateAvatarAction()
	{
		return new ViewModel();
	}

	public function updateDetailsAction()
	{
		return new ViewModel();
	}

	public function updatePreferencesAction()
	{
		return new ViewModel();
	}

	public function deleteAction()
	{
		$user = self::getLoggedUser();

		/** @var UserTable $userTable */
		$userTable = $this->getTable('user');
		$userTable->desactivate($user->id);

		return new ViewModel([
			'user' => $user
		]);
	}


	//
	// STATIC LOGIN
	//

	public static function logUserIn(User $user)
	{
		$sessionContainer       = new Container(self::SESSION_LOGIN_KEY);
		$sessionContainer->user = $user;
	}

	public static function logUserOut()
	{
	}

	/**
	 * @return User
	 * @throws \Exception
	 */
	public static function getLoggedUser()
	{
		$sessionContainer = new Container(self::SESSION_LOGIN_KEY);
		if (!isset($sessionContainer->user))
		{
			throw new \Exception('User is not logged.');
		}

		return $sessionContainer->user;
	}

}