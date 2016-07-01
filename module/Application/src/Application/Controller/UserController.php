<?php

namespace Application\Controller;

use Application\Model\User;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{
	public function indexAction()
	{
		return new ViewModel();
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
		return new ViewModel();
	}

	public function exportAction()
	{
		return new ViewModel();
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