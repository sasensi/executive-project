<?php

namespace Application\Controller;

use Application\Exception\NotLoggedUserException;
use Application\Form\ChangePasswordForm;
use Application\Form\ForgotPasswordForm;
use Application\Form\LoginForm;
use Application\Form\UserForm;
use Application\Form\View\Helper\ClientValidator;
use Application\Model\AbstractTable;
use Application\Model\Project;
use Application\Model\Transaction;
use Application\Model\User;
use Application\Model\UserTable;
use Application\Util\DateFormatter;
use Application\Util\DisplayableException;
use Application\Util\Email;
use Application\Util\MultiArray;
use Facebook\Facebook;
use Facebook\GraphNodes\GraphUser;
use Zend\Crypt\BlockCipher;
use Zend\Crypt\Symmetric\Mcrypt;
use Zend\Mail\Message;
use Zend\Mail\Transport\Sendmail;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Part;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionCustomController
{
	const SESSION_LOGIN_KEY          = 'login';
	const SESSION_LOGIN_FACEBOOK_KEY = 'facebookLogin';
	const SESSION_FORWARD_PAYMENT    = 'forwardPayment';

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

		// if user logged through facebook, fill rom with facebook datas
		$facebookLoginSessionContainer = new Container(self::SESSION_LOGIN_FACEBOOK_KEY);
		$fbUser                        = null;
		if (isset($facebookLoginSessionContainer->graphUser))
		{
			/** @var GraphUser $fbUser */
			$fbUser          = $facebookLoginSessionContainer->graphUser;
			$fbUserBirthDate = $fbUser->getBirthday();
			if (isset($fbUserBirthDate))
			{
				$fbUserBirthDate = $fbUserBirthDate->format(AbstractTable::DATE_FORMAT);
			}
			$fbUserGender = $fbUser->getGender();
			if (isset($fbUserGender))
			{
				$fbUserGender = $fbUserGender === 'male' ? 'M' : 'F';
			}
			$form->get(UserForm::EMAIL)->setValue($fbUser->getEmail());
			$form->get(UserForm::FIRSTNAME)->setValue($fbUser->getFirstName());
			$form->get(UserForm::BIRTHDATE)->setValue($fbUserBirthDate);
			$form->get(UserForm::SEX)->setValue($fbUserGender);
			$form->get(UserForm::NAME)->setValue($fbUser->getLastName());
		}

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

				// check email unicity
				// todo: do this check with a validator
				$existingUserWithSameEmail = $this->getTable('user')->selectFirst(['email' => $data[ UserForm::EMAIL ]]);
				if (isset($existingUserWithSameEmail))
				{
				}

				// format birthdate
				$data[ UserForm::BIRTHDATE ] = DateFormatter::frToUs($data[ UserForm::BIRTHDATE ]);

				$nowDate = new \DateTime('now', new \DateTimeZone('Europe/Paris'));

				$user = new User();
				$user->exchangeArray($data);
				$user->subscriptiondate = $nowDate->format(AbstractTable::DATE_FORMAT);
				$user->confirmed        = true;
				$user->desactivated     = false;

				if (isset($fbUser))
				{
					$user->facebookid = $fbUser->getId();
					if (isset($facebookLoginSessionContainer->token))
					{
						$user->facebooktoken = $facebookLoginSessionContainer->token;
					}
				}

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
					'facebookid'       => $user->facebookid,
					'facebooktoken'    => $user->facebooktoken,
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

				// clear facebook login session
				$facebookLoginSessionContainer->exchangeArray([]);

				// log user in
				self::logUserIn($user);
				return $this->redirectToRoute('user');
			}
		}

		$this->addJsDependency('js/user/signin.min.js');

		// add client validation
		$clientValidator = new ClientValidator($form);
		$this->addJs($clientValidator->render());

		return new ViewModel([
			'form' => $form
		]);
	}

	public function loginAction()
	{
		$form = new LoginForm();

		$facebookLoginUrl = $this->getFacebookLoginUrl();

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

						// check if user was prompted to login after payment request
						$session = new Container(self::SESSION_FORWARD_PAYMENT);
						if (isset($session->payment) && $user->isFinancer())
						{
							// clear session
							$params = $session->payment;
							$session->exchangeArray([]);
							return $this->redirectToRoute('transaction', 'add', null, $params);
						}
						else
						{
							return $this->redirectToRoute('user');
						}
					}
				}
			}
		}

		$this->addCssDependency('css/user/login.min.css');

		// add client validation
		$clientValidator = new ClientValidator($form);
		$this->addJs($clientValidator->render());

		return new ViewModel([
			'form'             => $form,
			'facebookLoginUrl' => $facebookLoginUrl,
		]);
	}

	public function loginToPayAction()
	{
		/** @var \Zend\Http\PhpEnvironment\Request $request */
		$request = $this->getRequest();

		// store payment informations
		$session          = new Container(self::SESSION_FORWARD_PAYMENT);
		$session->payment = $request->getQuery()->toArray();

		// display login
		return $this->redirectToRoute('user', 'login');
	}

	public function facebookLoginCallbackAction()
	{
		$fb = $this->getFacebook();

		$helper = $fb->getRedirectLoginHelper();
		try
		{
			$accessToken = $helper->getAccessToken();

			if (!isset($accessToken))
			{
				throw new \Exception('Cannot get access token');
			}

			// OAuth 2.0 client handler
			$oAuth2Client = $fb->getOAuth2Client();

			// Exchanges a short-lived access token for a long-lived one
			$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($accessToken->getValue());

			// get user infos
			$fb->setDefaultAccessToken($longLivedAccessToken->getValue());

			$response   = $fb->get('/me?fields=id,birthday,email,first_name,gender,last_name');
			$userNode   = $response->getGraphUser();
			$email      = $userNode->getEmail();
			$facebookId = $userNode->getId();

			// case of a user that already connected with his facebook account
			/** @var User $user */
			$user = $this->getTable('user')->selectFirst(['facebookid' => $facebookId]);
			if (isset($user))
			{
				// log in and redirect
				self::logUserIn($user);
				return $this->redirectToRoute('user');
			}
			else
			{
				// case of a user existing in database with the same email adress
				$user = $this->getTable('user')->selectFirst(['email' => $email]);
				if (isset($user))
				{
					// store user facebookid infos
					$user->facebookid    = $facebookId;
					$user->facebooktoken = $longLivedAccessToken->getValue();
					$this->getTable('user')->update([
						'facebookid'    => $user->facebookid,
						'facebooktoken' => $user->facebooktoken,

					], ['id' => $user->id]);

					// log in
					self::logUserIn($user);

					// redirect
					return $this->redirectToRoute('user');
				}
				else
				{
					// case of a new user
					// redirect to signin page forwarding user datas
					$sessionContainer            = new Container(self::SESSION_LOGIN_FACEBOOK_KEY);
					$sessionContainer->graphUser = $userNode;
					$sessionContainer->token     = $longLivedAccessToken->getValue();

					return $this->redirectToRoute('user', 'signin');
				}
			}
		}
		catch (\Exception $e)
		{
			// When Graph returns an error
			echo 'there was an error: '.$e->getMessage();
			exit;
		}
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
				/** @var User $user */
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
					$changePasswordUrl = $this->url()->fromRoute('home/action', ['controller' => 'user', 'action' => 'change_password'], ['force_canonical' => true]);
					$changePasswordUrl .= '?'.http_build_query(['code' => $cryptedCode]);

					$emailBody = <<<HTML
<p>Bonjour {$user->firstname},</p>
<p>Vous avez fait une demande de récupération de mot de passe.</p>
<p>Cliquez <a href="{$changePasswordUrl}">ici</a> pour changer votre mot de passe.</p>
HTML;

					Email::send($user->email, 'Récupération de votre mot de passe', $emailBody);
				}
			}
		}

		$clientValidator = new ClientValidator($form);
		$this->addJs($clientValidator->render());

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
				return $this->redirectToRoute('user');
			}
		}

		$clientValidator = new ClientValidator($form);
		$this->addJs($clientValidator->render());

		return new ViewModel([
			'form' => $form
		]);
	}

	public function logoutAction()
	{
		self::logUserOut();

		return $this->redirectToRoute();
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

		// add client validation
		$clientValidator = new ClientValidator($form);
		$this->addJs($clientValidator->render());

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
				$table->deleteFromId($user->id);
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

	public function profileAction()
	{
		/** @var User $user */
		$id   = $this->params()->fromRoute('id');
		$user = $this->getTable('user')->selectFirstById($id);
		if (!isset($user))
		{
			throw new DisplayableException("Cet utilisateur n'existe pas.");
		}

		$usertype = $this->getTable('usertype')->selectFirstById($user->usertype_id);

		if ($user->isAdmin())
		{
			throw new DisplayableException("Vous n'avez pas le droit de consulter le profil de cet utilisateur.");
		}

		$projects = [];
		if ($user->isCreator())
		{
			$projects = $this->getTable('project')->select(['user_id' => $user->id]);
		}
		elseif ($user->isFinancer())
		{
			/** @var Transaction[] $transactions */
			$transactions    = $this->getTable('transaction')->select(['user_id' => $user->id]);
			$transactionsIds = MultiArray::getArrayOfValues($transactions, 'project_id');
			$projects        = $this->getTable('project')->selectFromIds($transactionsIds);
		}

		$this->addCssDependency('css/user/profile.min.css');

		return new ViewModel([
			'user'     => $user,
			'usertype' => $usertype,
			'projects' => $projects,
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
		$sessionContainer->exchangeArray([]);
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

	protected function getFacebook()
	{
		return new Facebook([
			'app_id'                => '1759318977664202',
			'app_secret'            => '7400f08d28732ba37094d74af0561013',
			'default_graph_version' => 'v2.8',
		]);
	}

	protected function getFacebookLoginUrl()
	{
		$fb          = $this->getFacebook();
		$helper      = $fb->getRedirectLoginHelper();
		$permissions = ['email'];
		$targetRoute = $this->url()->fromRoute('home/action', ['controller' => 'user', 'action' => 'facebook_login_callback'], ['force_canonical' => true]);
		return $helper->getLoginUrl($targetRoute, $permissions);
	}

}