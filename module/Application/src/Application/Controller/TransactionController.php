<?php

namespace Application\Controller;

use Application\Model\AbstractTable;
use Application\Model\Transaction;
use Application\Model\TransactionTable;
use Zend\View\Model\ViewModel;

class TransactionController extends AbstractActionCustomController
{
	public function indexAction()
	{
		$user = UserController::getLoggedUser();

		/** @var TransactionTable $transactionTable */
		$transactionTable = $this->getTable('transaction');
		$transactions     = $transactionTable->getAllFromUserId($user->id);

		return new ViewModel([
			'transactions' => $transactions
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

	public function paymentAction()
	{
		/** @var \Zend\Http\PhpEnvironment\Request $request */
		$request = $this->getRequest();

		if ($request->isPost())
		{
			$post          = $request->getPost();
			$amount        = $post->get('amount');
			$project       = $this->getTable('project')->selectFirstById($post->get('projectId'));
			$paymentMethod = $this->getTable('paymentmethod')->selectFirstById($post->get('paymentMethodId'));

			if ($amount <= 1)
			{
				throw new \Exception('Invalid transaction amount: '.$amount);
			}

			return new ViewModel([
				'amount'        => $amount,
				'project'       => $project,
				'paymentMethod' => $paymentMethod,
			]);
		}

		// redirect invalid request
		$this->redirect()->toRoute('home');
		return null;
	}

	public function addAction()
	{
		/** @var \Zend\Http\PhpEnvironment\Request $request */
		$request = $this->getRequest();

		if ($request->isPost())
		{
			$post            = $request->getPost();
			$amount          = $post->get('amount');
			$projectId       = $post->get('projectId');
			$paymentMethodId = $post->get('paymentMethodId');
			$nowDate         = new \DateTime('now', new \DateTimeZone('Europe/Paris'));

			if ($amount <= 1)
			{
				throw new \Exception('Invalid transaction amount: '.$amount);
			}

			$this->getTable('transaction')->insert([
				'amount'           => $amount,
				'paymentdate'      => $nowDate->format(AbstractTable::DATE_FORMAT),
				'user_id'          => UserController::getLoggedUser()->id,
				'project_id'       => $projectId,
				'paymentmethod_id' => $paymentMethodId,
			]);

			$this->redirect()->toRoute('home', ['controller' => 'transaction']);
			return;
		}

		// redirect invalid request
		$this->redirect()->toRoute('home');
		return;
	}
}