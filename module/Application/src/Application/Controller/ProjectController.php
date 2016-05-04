<?php

namespace Application\Controller;

use Application\Form\ProjectAddForm;
use Application\Model\Project;
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
		$form = new ProjectAddForm();

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

				//$data['dateCreationTrajet'] = date('Y-m-d');
				//$data['duree'] = 100;
				//$data['idUtilisateur'] = UtilisateurController::checkIsLogged();

				$project = new Project();
				$project->exchangeArray($data);

				$this->getProjectTable()->insert($project);

				return $this->redirect()->toRoute('home', ['controller' => 'project']);
			}
		}
		return new ViewModel([
			'form' => $form
		]);
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
