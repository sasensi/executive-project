<?php

namespace Application\Controller;

use Application\Form\LoginForm;
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
		$userTypes  = $this->getTable('usertype')->select();
		$countries  = $this->getTable('country')->select();
		$categories = $this->getTable('category')->select();

		$form = new UserAddForm($userTypes, $countries, $categories);

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
				$user->confirmed    = true;
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
					'photo'            => null,
					'facebook'         => $user->facebook,
					'subscriptiondate' => $user->subscriptiondate,
					'confirmed'        => $user->confirmed,
					'desactivated'     => $user->desactivated,
					'usertype_id'      => $user->usertype_id,
				]);

				// rename photo
				if (isset($user->photo['tmp_name']))
				{
					preg_match('/\..+?$/', $user->photo['name'], $matches);
					$fileExtension    = $matches[0];
					$filePathFromRoot = "img/user/{$user->id}.{$fileExtension}";

					rename($user->photo['tmp_name'], PUBLIC_DIR.$filePathFromRoot);

					$this->getTable('user')->update(['photo' => $filePathFromRoot], ['id' => $user->id]);
				}
			}
		}

		$this->addJsDependency('js/user/signin.js');

		return new ViewModel([
			'form' => $form
		]);
	}

	public function loginAction()
	{
		$form = new LoginForm();

		/** @var \Zend\Http\PhpEnvironment\Request $request */
		$request = $this->getRequest();

		if ($request->isPost())
		{
			$form->setData($request->getPost()->toArray());

			if ($form->isValid())
			{
				$data = $form->getData();

				$users = $this->getTable('user')->select([
					'email' => $data[ LoginForm::EMAIL ]
				]);

				if ($users->count() === 0)
				{
					$form->get(LoginForm::EMAIL)->setMessages(["Aucun compte n'existe pour cette adresse email."]);
				}
				else
				{
					/** @var User $user */
					$user = $users->current();
					if ($user->password !== $data[ LoginForm::PASSWORD ])
					{
						$form->get(LoginForm::PASSWORD)->setMessages(['Mot de passe incorrect.']);
					}
					else
					{
						UserController::logUserIn($user);
						$this->redirect()->toRoute('home/action', ['controller' => 'user', 'action' => 'index']);
					}
				}
			}
		}

		return new ViewModel([
			'form' => $form
		]);
	}

	public function forgotPasswordAction()
	{
		return new ViewModel();
	}

	public function logoutAction()
	{
		self::logUserOut();

		$this->redirect()->toRoute('home');
	}

	public function updateAction()
	{
		$userTypes  = $this->getTable('usertype')->select();
		$countries  = $this->getTable('country')->select();
		$categories = $this->getTable('category')->select();

		$user = UserController::getLoggedUser();

		$form = new UserAddForm($userTypes, $countries, $categories);
		$form->setData([
			'password'   => $user->password,
			'sex'        => $user->sex,
			'adress'     => $user->adress,
			'postcode'   => $user->postcode,
			'city'       => $user->city,
			'country_id' => $user->country_id,
			'phone'      => $user->phone,
		]);

		$form->get(UserAddForm::SUBMIT)->setAttribute('value', 'Modifier');
		$form->setValidationGroup(['password', 'sex', 'adress', 'postcode', 'city', 'country_id', 'phone']);

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
				// overrite user datas
				$user->exchangeArray($form->getData());

				$user->id = $this->getTable('user')->update([
					'password'   => $user->password,
					'sex'        => $user->sex,
					'adress'     => $user->adress,
					'postcode'   => $user->postcode,
					'city'       => $user->city,
					'country_id' => $user->country_id,
					'phone'      => $user->phone,
				], ['id' => $user->id]);
			}
		}

		$this->addJsDependency('js/user/signin.js');

		return new ViewModel([
			'form' => $form,
			'user' => $user,
		]);
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
		$sessionContainer = new Container(self::SESSION_LOGIN_KEY);
		$sessionContainer->getManager()->getStorage()->clear(self::SESSION_LOGIN_KEY);
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