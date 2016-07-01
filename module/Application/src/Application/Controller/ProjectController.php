<?php

namespace Application\Controller;

use Application\Form\ProjectAddForm;
use Application\Model\CategoryTable;
use Application\Model\GiftTable;
use Application\Model\PictureTable;
use Application\Model\Project;
use Application\Model\ProjectviewTable;
use Application\Model\TagTable;
use Application\Model\TransactionTable;
use Application\Model\UserTable;
use Application\Model\VideoTable;
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

		/** @var $categoryTable CategoryTable */
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

		/** @var VideoTable $videoTable */
		$videoTable = $this->getTable('video');
		$videos     = $videoTable->getAllFromProjectId($project->id);

		/** @var PictureTable $pictureTable */
		$pictureTable = $this->getTable('picture');
		$pictures     = $pictureTable->getAllFromProjectId($project->id);

		return new ViewModel([
			'project'    => $project,
			'categories' => $categories,
			'gifts'      => $gifts,
			'tags'       => $tags,
			'viewsCount' => $viewsCount,
			'videos'     => $videos,
			'pictures'   => $pictures,
		]);
	}

	public function addAction()
	{
		$form = new ProjectAddForm();
		$user = UserController::getLoggedUser();

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

				$project = new Project();
				$project->exchangeArray($data);
				$project->creationdate = date('Y-m-d');
				$project->user_id      = $user->id;

				$this->getProjectTable()->insert($project);

				return $this->redirect()->toRoute('home', ['controller' => 'project', 'action' => 'user']);
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
		return new ViewModel();
	}

	public function userUpdateAction()
	{
		return new ViewModel();
	}

	public function userDeleteAction()
	{
		return new ViewModel();
	}

	public function userPromoteAction()
	{
		return new ViewModel();
	}

	public function exportAction()
	{
		$project = $this->getProjectFromRouteId();

		/** @var TransactionTable $transactionTable */
		$transactionTable = $this->getTable('transaction');
		$transactions     = $transactionTable->getAllFromProjectId($project->id);

		/** @var UserTable $userTable */
		$userTable = $this->getTable('user');
		$users     = $userTable->getAllForProject($project->id);

		return new ViewModel([
			'project'      => $project,
			'transactions' => $transactions,
			'users'        => $users,
		]);
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
