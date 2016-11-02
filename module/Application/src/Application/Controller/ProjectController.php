<?php

namespace Application\Controller;

use Application\Form\ProjectAddForm;
use Application\Form\ProjectSearchFilter;
use Application\Model\Category;
use Application\Model\CategoryTable;
use Application\Model\GiftTable;
use Application\Model\PictureTable;
use Application\Model\Project;
use Application\Model\ProjectTable;
use Application\Model\ProjectviewTable;
use Application\Model\TagTable;
use Application\Model\TransactionTable;
use Application\Model\UserTable;
use Application\Model\VideoTable;
use Zend\View\Helper\HeadLink;
use Zend\View\Helper\HeadScript;
use Zend\View\Model\ViewModel;

class ProjectController extends AbstractActionCustomController
{
	public function indexAction()
	{
		// handle search filters

		/** @var Category[] $categories */
		$categories = $this->getTable('category')->getAll();

		$searchFilter = new ProjectSearchFilter($categories);

		/** @var \Zend\Http\PhpEnvironment\Request $request */
		$request = $this->getRequest();
		if ($request->isGet())
		{
			$filterdata = $request->getQuery()->toArray();
			if (!empty($filterdata))
			{
				if (!empty($filterdata['keywords']))
				{
					$keyWords = preg_split('/[^a-zA-Z]+/', $filterdata['keywords'], -1, PREG_SPLIT_NO_EMPTY);
					$searchFilter->setSelectedKeyWords($keyWords);
				}
				if (!empty($filterdata['category'])) $searchFilter->setSelectedCategory($filterdata['category']);
				if (!empty($filterdata['order'])) $searchFilter->setSelectedOrder($filterdata['order']);
				if (!empty($filterdata['status'])) $searchFilter->setSelectedStatus($filterdata['status']);
			}
		}

		$projects = $this->getProjectTable()->getAllFromSearchFilters($searchFilter);

		$this->addCssDependency('css/project/index.css');
		$this->addJsDependency('js/project/index.js');

		return new ViewModel([
			'projects'     => $projects,
			'searchFilter' => $searchFilter
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

		/** @var UserTable $userTable */
		$userTable = $this->getTable('user');
		$financers = $userTable->getAllForProject($project->id);

		$this->addCssDependency('css/project/detail.css');
		$this->addJsDependency('js/project/detail.js');

		return new ViewModel([
			'project'    => $project,
			'categories' => $categories,
			'gifts'      => $gifts,
			'tags'       => $tags,
			'viewsCount' => $viewsCount,
			'videos'     => $videos,
			'pictures'   => $pictures,
			'financers'  => $financers,
		]);
	}

	public function addAction()
	{
		$categories = $this->getTable('category')->getAll();
		$form       = new ProjectAddForm('projectform', $categories);

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

				var_dump($data);


				$project = new Project();
				$project->exchangeArray($data);
				$project->creationdate   = date('Y-m-d');
				$project->user_id        = $user->id;
				$project->transactionsum = 0;
				$project->mainpicture    = '';

				// create row
				$newProjectId = $this->getProjectTable()->insert($project);

				// rename image
				$dirFromRoot = '/img/'.$newProjectId.'/';
				$fileDir     = PUBLIC_DIR.$dirFromRoot;
				$filePath    = $fileDir.$data['mainpicture']['name'];
				$fileUrl     = $this->getRenderer()->basePath().$dirFromRoot.$data['mainpicture']['name'];

				if (!file_exists($fileDir))
				{
					mkdir($fileDir);
				}
				rename($data['mainpicture']['tmp_name'], $filePath);

				// update image name
				$this->getProjectTable()->getTableGateway()->update(['mainpicture' => $fileUrl], ['id' => $newProjectId]);

				// create categories links
				foreach ($data['category_ids'] as $categoryId)
				{
					$this->getTable('projectcategory')->getTableGateway()->insert([
						'project_id'  => $newProjectId,
						'category_id' => $categoryId
					]);
				}

				return $this->redirect()->toRoute('home/action', ['controller' => 'project', 'action' => 'user']);
			}

			var_dump($form->getData());
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
