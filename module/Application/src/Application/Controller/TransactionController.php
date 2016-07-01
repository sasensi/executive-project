<?php

namespace Application\Controller;

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
		return new ViewModel();
	}

	public function addAction()
	{
		return new ViewModel();
	}
}