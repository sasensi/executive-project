<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProjectController extends AbstractActionController
{
	public function indexAction()
	{
		$request = $this->params()->fromRoute();
		
		// debug
		echo '$request =';
		var_dump($request);
		
		
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

	public function deleteAction()
	{
		return new ViewModel();
	}

	public function analyseAction()
	{
		return new ViewModel();
	}

	public function userAction()
	{
		return new ViewModel();
	}
	
	public function userDetailAction()
	{

	}

	public function userUpdateAction()
	{

	}

	public function userDeleteAction()
	{

	}

	public function userPromoteAction()
	{

	}
}
