<?php

namespace Application\Controller;

use Application\Form\UserAddForm;
use Application\Model\AbstractTable;
use Application\Model\User;
use Application\Model\UserTable;
use Application\Model\Usertype;
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
		$form = new UserAddForm();

		/** @var \Zend\Http\PhpEnvironment\Request $request */
		$request = $this->getRequest();

		if ($request->isPost())
		{
			$post = array_merge_recursive(
				$request->getPost()->toArray(),
				$request->getFiles()->toArray()
			);

			$form->setData($post);

			if ($form->isValid())
			{
				$data = $form->getData();

				$nowDate = new \DateTime('now', new \DateTimeZone('Europe/Paris'));

				$user = new User();
				$user->exchangeArray($data);
				$user->subscriptiondate = $nowDate->format(AbstractTable::DATE_FORMAT);
				// todo: send confirmation mail
				$user->confirmed = true;
				$user->desactivated = false;

				$user->id = $this->getTable('user')->insert([
					'password'         => $user->password,
					'name'             => $user->name,
					'firstname'        => $user->firstname,
					'birthdate'        => $user->birthdate,
					'email'            => $user->email,
					'sex'              => $user->sex,
					'adress'           => $user->adress,
					'postcode'         => $user->postcode,
					'city'             => $user->city,
					'country_id'       => $user->country_id,
					'phone'            => $user->phone,
					'photo'            => $user->photo,
					'facebook'         => $user->facebook,
					'subscriptiondate' => $user->subscriptiondate,
					'confirmed'        => $user->confirmed,
					'desactivated'     => $user->desactivated,
					'usertype_id'      => $user->usertype_id,
				]);
			}
		}

		return new ViewModel([
			'form' => $form
		]);
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