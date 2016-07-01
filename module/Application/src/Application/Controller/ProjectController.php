<?php

namespace Application\Controller;

use Application\Form\ProjectAddForm;
use Application\Model\CategoryTable;
use Application\Model\GiftTable;
use Application\Model\Project;
use Application\Model\ProjectviewTable;
use Application\Model\TagTable;
use Zend\View\Model\ViewModel;

class ProjectController extends AbstractActionCustomController
{
	public function indexAction()
	{
		// todo: get from context
		//$test = $this->params()->fromQuery();
		// search params
		$keyWords   = ['dolor', 'cursus'];
		$categoryId = 1;


		$projects = $this->getProjectTable()->getAllFromSearchParams($keyWords, $categoryId);

		return new ViewModel([
			'projects' => $projects
		]);
	}

	public function detailAction()
	{
		$project = $this->getProjectFromRouteId();

		/**
		 * @var $categoryTable CategoryTable
		 */
		$categoryTable = $this->getTable('category');
		$categories    = $categoryTable->getAllFromProjectId($project->id);

		/** @var GiftTable $giftTable */
		$giftTable = $this->getTable('gift');
		$gifts     = $giftTable->getAllFromProjectId($project->id);

		/** @var TagTable $tagTable */
		$tagTable = $this->getTable('tag');
		$tags     = $tagTable->getAllFromProjectId($project->id);

		/** @var ProjectviewTable $projectViewTable */
		$projectViewTable = $this->getTable('projectview');
		$viewsCount       = $projectViewTable->getCountFromProjectId($project->id);

		return new ViewModel([
			'project'    => $project,
			'categories' => $categories,
			'gifts'      => $gifts,
			'tags'       => $tags,
		    'viewsCount' => $viewsCount,
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
		$project = $this->getProjectFromRouteId();

		$this->getProjectTable()->delete($project->id);

		return new ViewModel([
			'project' => $project
		]);
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

	/**
	 * @return Project
	 */
	protected function getProjectFromRouteId()
	{
		$id = $this->params()->fromRoute('id');

		return $this->getProjectTable()->getOneById($id);
	}
}
