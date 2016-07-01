<?php

namespace Application\Controller;

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
		$transaction = $this->getTable('transaction')->getOneById($id);

		$project = $this->getTable('project')->getOneById($transaction->project_id);

		$paymentMethod = $this->getTable('paymentmethod')->getOneById($transaction->paymentmethod_id);

		return new ViewModel([
			'transaction'   => $transaction,
			'project'       => $project,
			'paymentMethod' => $paymentMethod,
		]);
	}

	public function addAction()
	{
		return new ViewModel();
	}
}