<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class TransactionController extends AbstractActionController
{
	public function indexAction()
	{
		return new ViewModel();
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