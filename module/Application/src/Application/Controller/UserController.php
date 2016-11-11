<?php

namespace Application\Controller;

use Application\Exception\NotLoggedUserException;
use Application\Form\ChangePasswordForm;
use Application\Form\ForgotPasswordForm;
use Application\Form\LoginForm;
use Application\Form\UserForm;
use Application\Model\AbstractTable;
use Application\Model\Project;
use Application\Model\Transaction;
use Application\Model\User;
use Application\Model\UserTable;
use Application\Model\Usertype;
use Zend\Crypt\BlockCipher;
use Zend\Crypt\Symmetric\Mcrypt;
use Zend\Mail\Message;
use Zend\Mail\Transport\Sendmail;
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

		$form = new UserForm($userTypes, $countries, $categories);

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

				$this->beginTransaction();

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
				if (!empty($user->photo['tmp_name']))
				{
					preg_match('/\..+?$/', $user->photo['name'], $matches);
					$fileExtension    = $matches[0];
					$filePathFromRoot = "img/user/{$user->id}.{$fileExtension}";

					rename($user->photo['tmp_name'], PUBLIC_DIR.$filePathFromRoot);

					$user->photo = $filePathFromRoot;

					$this->getTable('user')->update(['photo' => $user->photo], ['id' => $user->id]);
				}

				$this->commitTransaction();

				// log user in
				self::logUserIn($user);
				$this->redirect()->toRoute('home/action', ['controller' => 'user']);
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
		$form = new ForgotPasswordForm();

		/** @var \Zend\Http\PhpEnvironment\Request $request */
		$request = $this->getRequest();

		if ($request->isPost())
		{
			$post = $request->getPost()->toArray();

			$form->setData($post);

			if ($form->isValid())
			{
				$postedEmail = $post[ ForgotPasswordForm::EMAIL ];

				// check user exists for this email
				$user = $this->getTable('user')->selectFirst(['email' => $postedEmail]);
				if ($user === false)
				{
					$form->get(ForgotPasswordForm::EMAIL)->setMessages(["Aucun utilisateur n'existe pour cette adresse email."]);
				}
				else
				{
					$code        = $user->id.'_'.time();
					$cryptedCode = $this->getCrypter()->encrypt($code);
					// store code in db
					$this->getTable('user')->update(['passwordrecovercode' => $cryptedCode], ['id' => $user->id]);
					// build unique usage URL
					$changePasswordUrl = $this->url()->fromRoute('home/action', ['controller' => 'user', 'action' => 'change_password']);
					$changePasswordUrl .= '?'.http_build_query(['code' => $cryptedCode]);

					$emailBody = <<<HTML
<p>Bonjour,</p>
<p>Vous avez fait une demande de récupération de mot de passe.</p>
<p>Cliquez <a href="{$changePasswordUrl}">ici</a> pour changer votre mot de passe.</p>
HTML;

					//
					// DEBUG
					//
					$viewModel = new ViewModel([
						'emailBody' => $emailBody
					]);
					$viewModel->setTemplate('application/user/forgot_password_email_debug.phtml');
					return $viewModel;


					$message = new Message();
					$message->addTo($postedEmail)
					        ->addFrom('contact@iap.com')
					        ->setSubject('Récupération de votre mot de passe')
					        ->setBody($emailBody);

					$transport = new Sendmail();
					$transport->send($message);
				}
			}
		}

		return new ViewModel([
			'form' => $form
		]);
	}

	public function changePasswordAction()
	{
		/** @var \Zend\Http\PhpEnvironment\Request $request */
		$request = $this->getRequest();

		$cryptedCode = $request->getQuery()->get('code');
		$code        = $this->getCrypter()->decrypt($cryptedCode);
		$id          = explode('_', $code)[0];
		/** @var User $user */
		$user = $this->getTable('user')->selectFirstById($id);

		if ($user->passwordrecovercode !== $cryptedCode)
		{
			throw new \Exception('Invalid password recovery code');
		}

		$form = new ChangePasswordForm();

		if ($request->isPost())
		{
			$post = $request->getPost()->toArray();

			$form->setData($post);

			if ($form->isValid())
			{
				// change user password
				$user->password = $post[ ChangePasswordForm::PASSWORD ];
				// make password recover code null to prevent using URL multiple times
				$this->getTable('user')->update(['password' => $user->password, 'passwordrecovercode' => null], ['id' => $user->id]);

				// log user in
				self::logUserIn($user);
				$this->redirect()->toRoute('home/action', ['controller' => 'user']);
			}
		}

		return new ViewModel([
			'form' => $form
		]);
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

		// get current user
		$user = UserController::getLoggedUser();

		$form = new UserForm($userTypes, $countries, $categories);
		$form->setData([
			'sex'        => $user->sex,
			'adress'     => $user->adress,
			'postcode'   => $user->postcode,
			'city'       => $user->city,
			'country_id' => $user->country_id,
			'phone'      => $user->phone,
		]);

		// change submit button label
		$form->get(UserForm::SUBMIT)->setAttribute('value', 'Modifier');

		// only validate displayed fields
		$form->setValidationGroup(['sex', 'adress', 'postcode', 'city', 'country_id', 'phone']);

		/** @var \Zend\Http\PhpEnvironment\Request $request */
		$request = $this->getRequest();

		if ($request->isPost())
		{
			$post = $request->getPost()->toArray();

			$form->setData($post);

			if ($form->isValid())
			{
				// overrite user datas
				$user->exchangeArray($form->getData());

				$user->id = $this->getTable('user')->update([
					'sex'        => $user->sex,
					'adress'     => $user->adress,
					'postcode'   => $user->postcode,
					'city'       => $user->city,
					'country_id' => $user->country_id,
					'phone'      => $user->phone,
				], ['id' => $user->id]);
			}
		}

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
		/** @var UserTable $table */
		$table = $this->getTable('user');

		$deletable    = false;
		$desactivable = false;
		if ($user->isFinancer())
		{
			$transactions = $this->getTable('transaction')->select(['user_id' => $user->id]);
			if ($transactions->count() === 0)
			{
				$deletable = true;
			}
			else
			{
				$desactivable = true;
				$timeZone     = new \DateTimeZone('Europe/Paris');
				$nowDate      = new \DateTime('now', $timeZone);
				/** @var Transaction $transaction */
				foreach ($transactions as $transaction)
				{
					/** @var Project $project */
					$project             = $this->getTable('project')->selectFirstById($transaction->project_id);
					$projectDeadlineDate = \DateTime::createFromFormat(AbstractTable::DATE_FORMAT, $project->deadline, $timeZone);
					if ($projectDeadlineDate > $nowDate)
					{
						$desactivable = false;
						break;
					}
				}
			}
		}
		elseif ($user->isCreator())
		{
			$projects = $this->getTable('project')->select(['user_id' => $user->id]);
			if ($projects->count() === 0)
			{
				$deletable = true;
			}
			else
			{
				$desactivable = true;
				$timeZone     = new \DateTimeZone('Europe/Paris');
				$nowDate      = new \DateTime('now', $timeZone);
				/** @var Project $project */
				foreach ($projects as $project)
				{
					$projectDeadlineDate = \DateTime::createFromFormat(AbstractTable::DATE_FORMAT, $project->deadline, $timeZone);
					if ($projectDeadlineDate > $nowDate)
					{
						$desactivable = false;
						break;
					}
				}
			}
		}

		// user is deletable
		$success = false;
		if ($deletable || $desactivable)
		{
			if ($deletable)
			{
				$table->delete($user->id);
			}
			elseif ($desactivable)
			{
				$table->desactivate($user->id);
			}
			$success = true;
			self::logUserOut();
		}

		return new ViewModel([
			'user'    => $user,
			'success' => $success
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
			throw new NotLoggedUserException('User is not logged.');
		}

		return $sessionContainer->user;
	}


	//
	// INTERNAL
	//

	protected function getCrypter()
	{
		$blockCipher = new BlockCipher(new Mcrypt(['algo' => 'aes']));
		$blockCipher->setKey('encryption key');
		return $blockCipher;
	}

}