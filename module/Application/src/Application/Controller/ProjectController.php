<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;

class ProjectController extends AbstractActionCustomController
{
	public function indexAction()
	{
		// todo: get from context
		//$test = $this->params()->fromQuery();
		// search params
		$keyWords = ['dolor', 'cursus'];
		$categoryId = 1;


		$projects = $this->getProjectTable()->getAllFromSearchParams($keyWords, $categoryId);

		return new ViewModel([
			'projects' => $projects
		]);
	}

	public function detailAction()
	{
		$id      = $this->params()->fromRoute('id');
		$project = $this->getTable('project')->getOneById($id);

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
		// todo get real user id from session
		$userId = 11;
		
		$projects = $this->getProjectTable()->getAllFromUserId($userId);

		return new ViewModel([
			'projects' => $projects
		]);
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


	/**
	 * @return \Application\Model\ProjectTable
	 */
	protected function getProjectTable()
	{
	    return $this->getTable('project');
	}
}
