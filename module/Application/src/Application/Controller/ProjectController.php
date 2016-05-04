<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;

class ProjectController extends AbstractActionCustomController
{
	public function indexAction()
	{
		return new ViewModel();
	}

	public function detailAction()
	{
		$id      = $this->params()->fromRoute('id');
		$project = $this->getTable('user')->getOneById($id);

		return new ViewModel([
			'project' => $project
		]);
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
