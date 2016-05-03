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
}
