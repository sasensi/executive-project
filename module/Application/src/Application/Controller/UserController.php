<?php

namespace Application\Controller;

use Application\Model\User;
use Application\Model\UserTable;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionCustomController
{
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

	/**
	 * @return User
	 */
	public static function getLoggedUser()
	{
		// todo: get real user data
		$user = new User();
		$user->exchangeArray([
			'id'   => 2,
			'name' => 'test name'
		]);
		return $user;
	}

}