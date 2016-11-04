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
use Application\Model\Tag;
use Application\Model\TagTable;
use Application\Model\TransactionTable;
use Application\Model\UserTable;
use Application\Model\VideoTable;
use Zend\Db\Adapter\Adapter;
use Zend\View\Helper\HeadLink;
use Zend\View\Helper\HeadScript;
use Zend\View\Model\ViewModel;

class ProjectController extends AbstractActionCustomController
{
	public function indexAction()
	{
		// handle search filters

		/** @var Category[] $categories */
		$categories = $this->getTable('category')->select();

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
				if (!empty($filterdata['tag']))
				{
					try
					{
						$tag = $this->getTable('tag')->selectOneById($filterdata['tag']);
						$searchFilter->setTag($tag);
					}
					catch (\Exception $e)
					{
					}
				}
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

		$this->addJsDependency('js/project/detail.js');
		$this->addCssDependency('css/project/detail.css');

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
		$categories = $this->getTable('category')->select();
		$tags       = $this->getTable('tag')->select();
		// allow looping over tag twice
		$tags->buffer();

		$form = new ProjectAddForm('projectform', $categories, $tags);
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
				$project->creationdate   = date('Y-m-d');
				$project->user_id        = $user->id;
				$project->transactionsum = 0;
				$project->mainpicture    = '';

				// wrap queries in transaction in case of failure
				$this->getServiceLocator()->get(Adapter::class)->getDriver()->getConnection()->beginTransaction();

				// create row
				$project->id = $this->getTable('project')->insert([
					'user_id'        => $project->user_id,
					'title'          => $project->title,
					'subtitle'       => $project->subtitle,
					'description'    => $project->description,
					'mainpicture'    => $project->mainpicture,
					'creationdate'   => $project->creationdate,
					'deadline'       => $project->deadline,
					'goal'           => $project->goal,
					'promotionend'   => $project->promotionend,
					'transactionsum' => $project->transactionsum,
				]);

				// rename image
				$dirFromRoot = '/img/'.$project->id.'/';
				$fileDir     = PUBLIC_DIR.$dirFromRoot;
				$fileUrlDir  = $dirFromRoot;
				$filePath    = $fileDir.$data['mainpicture']['name'];
				$fileUrl     = $fileUrlDir.$data['mainpicture']['name'];

				if (!file_exists($fileDir))
				{
					mkdir($fileDir);
				}
				rename($data['mainpicture']['tmp_name'], $filePath);

				// update image name
				$this->getProjectTable()->update(['mainpicture' => $fileUrl], ['id' => $project->id]);

				// create categories links
				foreach ($data['category_ids'] as $categoryId)
				{
					$this->getTable('projectcategory')->insert([
						'project_id'  => $project->id,
						'category_id' => $categoryId
					]);
				}

				// create tags
				$postedTags = explode(', ', $data['tag_ids']);
				foreach ($postedTags as $postedTag)
				{
					$tagId = null;
					/** @var Tag $existingTag */
					foreach ($tags as $existingTag)
					{
						if (strtoupper($postedTag) === strtoupper($existingTag->name))
						{
							$tagId = $existingTag->id;
							break;
						}
					}

					// if tag doesn't already exist, create it
					if (!isset($tagId))
					{
						$this->getTable('tag')->insert(['name' => $postedTag]);
						$tagId = $this->getTable('tag')->getLastInsertValue();
					}

					// create project/tag link
					$this->getTable('projecttag')->insert(['project_id' => $project->id, 'tag_id' => $tagId]);
				}

				// pictures
				$pictures = $data['picture_ids'];
				foreach ($pictures as $picture)
				{
					// handle file upload error
					if (empty($picture['tmp_name']) || empty($picture['name'])) continue;

					rename($picture['tmp_name'], $fileDir.$picture['name']);

					// create picture
					$this->getTable('picture')->insert([
						'url'        => $fileUrlDir.$picture['name'],
						'project_id' => $project->id
					]);
				}

				// videos
				$videos = $data['video_ids'];
				foreach ($videos as $video)
				{
					// handle file upload error
					if (empty($video['tmp_name']) || empty($video['name'])) continue;

					rename($video['tmp_name'], $fileDir.$video['name']);

					$this->getTable('video')->insert([
						'url'        => $fileUrlDir.$video['name'],
						'project_id' => $project->id
					]);
				}


				$this->getServiceLocator()->get(Adapter::class)->getDriver()->getConnection()->commit();

				return $this->redirect()->toRoute('home/action', ['controller' => 'project', 'action' => 'user']);
			}

			var_dump($form->getData());
		}

		// client dependencies
		$this->addJsDependency('vendor/bootstrap-tokenfield/dist/bootstrap-tokenfield.min.js');
		$this->addJsDependency('vendor/bootstrap-tokenfield/docs-assets/js/typeahead.bundle.min.js');
		$this->addJsDependency('js/form.js');

		$this->addCssDependency('vendor/bootstrap-tokenfield/dist/css/bootstrap-tokenfield.min.css');
		$this->addCssDependency('vendor/bootstrap-tokenfield/dist/css/tokenfield-typeahead.min.css');
		$this->addCssDependency('css/project/add.css');

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

		return $this->getProjectTable()->selectOneById($id);
	}
}
