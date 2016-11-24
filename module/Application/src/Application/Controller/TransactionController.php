<?php

namespace Application\Controller;

use Application\Model\AbstractTable;
use Application\Model\Paymentmethod;
use Application\Model\Transaction;
use Application\Model\TransactionTable;
use Application\Util\Hashtable;
use Zend\Db\Sql\Where;
use Zend\View\Model\ViewModel;

class TransactionController extends AbstractActionCustomController
{
	public function indexAction()
	{
		$user = UserController::getLoggedUser();

		/** @var TransactionTable $transactionTable */
		$transactionTable = $this->getTable('transaction');

		$transactions = $transactionTable->getAllFromUserId($user->id);
		$transactions->buffer();

		$projectsIds = [];
		/** @var Transaction[] $transactions */
		foreach ($transactions as $transaction)
		{
			if (!in_array($transaction->project_id, $projectsIds))
			{
				$projectsIds[] = $transaction->project_id;
			}
		}

		$where = new Where();
		$where->in('id', $projectsIds);
		$projects   = $this->getTable('project')->select($where);
		$projectsHt = Hashtable::createFromObject($projects);

		$paymentMethods   = $this->getTable('paymentmethod')->select();
		$paymentMethodsHt = Hashtable::createFromObject($paymentMethods);

		return new ViewModel([
			'transactions'     => $transactions,
			'projectsHt'       => $projectsHt,
			'paymentMethodsHt' => $paymentMethodsHt,
		]);
	}

	public function detailAction()
	{
		$id = $this->params()->fromRoute('id');

		/** @var Transaction $transaction */
		$transaction = $this->getTable('transaction')->selectFirstById($id);

		$project = $this->getTable('project')->selectFirstById($transaction->project_id);

		$paymentMethod = $this->getTable('paymentmethod')->selectFirstById($transaction->paymentmethod_id);

		return new ViewModel([
			'transaction'   => $transaction,
			'project'       => $project,
			'paymentMethod' => $paymentMethod,
		]);
	}

	public function addAction()
	{
		/** @var \Zend\Http\PhpEnvironment\Request $request */
		$request = $this->getRequest();
		if (!$request->isPost())
		{
			$this->redirect()->toRoute('home');
			return;
		}

		$post            = $request->getPost();
		$amount          = $post->get('amount');
		$projectId       = $post->get('projectId');
		$paymentMethodId = $post->get('paymentMethodId');
		$nowDate         = new \DateTime('now', new \DateTimeZone('Europe/Paris'));

		if ($amount < 1)
		{
			throw new \Exception('Invalid transaction amount: '.$amount);
		}

		// debug: create transaction before receiving payment confirmation
		$this->getTable('transaction')->insert([
			'amount'           => $amount,
			'paymentdate'      => $nowDate->format(AbstractTable::DATE_FORMAT),
			'user_id'          => UserController::getLoggedUser()->id,
			'project_id'       => $projectId,
			'paymentmethod_id' => $paymentMethodId,
		]);

		// paypal case
		if ($paymentMethodId === (string) Paymentmethod::PAYPAL)
		{
			$project = $this->getTable('project')->selectFirstById($projectId);

			// build URL
			$params                    = [];
			$params['cmd']             = '_donations';
			$params['business']        = 'asensi.samuel-seller@gmail.com';
			$params['amount']          = $amount;
			$params['currency_code']   = 'EUR';
			$params['item_name']       = 'Financement du project '.$project->title;
			$params['lc']              = 'fr_FR';
			$params['cbt']             = 'Revenir sur le site';
			$params['rm']              = 2;
			$params['notify_url']      = $this->url()->fromRoute('home/action', ['controller' => 'transaction', 'action' => 'paypal_callback']);
			$params['return']          = $this->url()->fromRoute('home/action', ['controller' => 'transaction', 'action' => 'payment_success']);
			$params['cancel_return']   = $this->url()->fromRoute('home/action', ['controller' => 'transaction', 'action' => 'payment_cancel']);
			$params['projectId']       = $project->id;
			$params['paymentMethodId'] = $paymentMethodId;

			$url = 'https://www.sandbox.paypal.com/cgi-bin/webscr?'.http_build_query($params);
			$this->redirect()->toUrl($url);
			return;
		}

		$this->redirect()->toRoute('home', ['controller' => 'transaction']);
		return;
	}

	public function paypalCallbackAction()
	{
		// todo: handle IPN handshake then create transaction
	}

	public function paymentSuccessAction()
	{
		return new ViewModel();
	}

	public function paymentCancelAction()
	{
		return new ViewModel();
	}
}