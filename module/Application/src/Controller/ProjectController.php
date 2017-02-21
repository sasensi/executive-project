<?php

namespace Application\Controller;

use Application\Form\ProjectAddForm;
use Application\Form\ProjectSearchFilter;
use Application\Form\ProjectUpdateForm;
use Application\Form\View\Helper\ClientValidator;
use Application\Model\AbstractTable;
use Application\Model\Category;
use Application\Model\CategoryTable;
use Application\Model\GiftTable;
use Application\Model\Paymentmethod;
use Application\Model\PictureTable;
use Application\Model\Project;
use Application\Model\ProjectviewTable;
use Application\Model\Tag;
use Application\Model\TagTable;
use Application\Model\Transaction;
use Application\Model\TransactionTable;
use Application\Model\User;
use Application\Model\UserTable;
use Application\Model\VideoTable;
use Application\Util\DateFormatter;
use Application\Util\ExcelTable;
use Application\Util\Hashtable;
use Application\Util\MultiArray;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Db\Sql\Ddl\Column\Datetime;
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
			$params = $request->getQuery()->toArray();
			/** @var TagTable $tagTable */
			$tagTable = $this->getTable('tag');
			$searchFilter->fillFromParams($params, $tagTable);
		}

		$projects = $this->getProjectTable()->getAllFromSearchFilters($searchFilter);

		$this->addCssDependency('css/project/index.min.css');
		$this->addJsDependency('js/project/index.min.js');

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

		try
		{
			$user       = UserController::getLoggedUser();
			$paymentUrl = $this->url()->fromRoute('home/action', ['controller' => 'transaction', 'action' => 'add']);
		}
			// not logged user
		catch (\Exception $e)
		{
			$user = null;
			// by default, payment points to login page, with real payment URL as target
			$paymentUrl = $this->url()->fromRoute('home/action', ['controller' => 'user', 'action' => 'login_to_pay']);
		}

		$projectUser = $this->getTable('user')->selectFirstById($project->user_id);

		$paymentIsAllowed = !$project->deadLineIsPassed() && (!isset($user) || $user->isFinancer());

		$this->addJsDependency('js/project/detail.min.js');
		$this->addCssDependency('css/project/detail.min.css');

		return new ViewModel([
			'project'          => $project,
			'categories'       => $categories,
			'gifts'            => $gifts,
			'tags'             => $tags,
			'viewsCount'       => $viewsCount,
			'videos'           => $videos,
			'pictures'         => $pictures,
			'financers'        => $financers,
			'user'             => $user,
			'paymentUrl'       => $paymentUrl,
			'paymentIsAllowed' => $paymentIsAllowed,
			'projectUser'      => $projectUser,
		]);
	}

	public function addAction()
	{
		$categories = $this->getTable('category')->select();
		$tags       = $this->getTable('tag')->select();
		// allow looping over tag twice
		$tags->buffer();

		$form = new ProjectAddForm($categories, $tags);
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

				$data[ ProjectAddForm::DEADLINE ] = DateFormatter::frToUs($data[ ProjectAddForm::DEADLINE ]);

				$project = new Project();
				$project->exchangeArray($data);
				$project->creationdate   = date('Y-m-d');
				$project->user_id        = $user->id;
				$project->transactionsum = 0;
				$project->mainpicture    = '';

				// wrap queries in transaction in case of failure
				$this->beginTransaction();

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
				$dirFromRoot = '/img/project/'.$project->id.'/';
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

				// gifts
				$gifts = $data['gift_ids'] ?: [];
				foreach ($gifts as $gift)
				{
					$this->getTable('gift')->insert([
						'title'       => $gift['title'],
						'minamount'   => $gift['minamount'],
						'description' => $gift['description'],
						'project_id'  => $project->id,
					]);
				}

				$this->commitTransaction();

				return $this->redirectToRoute('project', 'user');
			}
		}

		// add client validation
		$clientValidator = new ClientValidator($form);
		$this->addJs($clientValidator->render());

		return new ViewModel([
			'form' => $form
		]);
	}

	public function deleteAction()
	{
		$project = $this->getProjectFromRouteId();

		$this->getProjectTable()->deleteFromId($project->id);

		return new ViewModel([
			'project' => $project
		]);
	}

	public function analyseAction()
	{
		/** @var TransactionTable $transactionTable */

		$projectsResult             = $this->getProjectTable()->getCreationCountByDay();
		$transactionTable           = $this->getTable('transaction');
		$transactionsResult         = $transactionTable->getCountByDay();
		$transactionAmountSumResult = $transactionTable->getTotalAmountByDay();

		// replace value with cumulated sum
		$transactionsAmountData = $this->convertDbDataForClientBarChart($transactionAmountSumResult);
		$sum                    = 0;
		foreach ($transactionsAmountData as &$item)
		{
			$sum += $item[1];
			$item[1] = $sum;
		}

		return new ViewModel([
			'createdProjectsData'    => $this->convertDbDataForClientBarChart($projectsResult),
			'transactionsData'       => $this->convertDbDataForClientBarChart($transactionsResult),
			'transactionsAmountData' => $transactionsAmountData,
		]);
	}

	/**
	 * @param ResultInterface $data
	 */
	protected function convertDbDataForClientBarChart($data)
	{
		$result = [];
		foreach ($data as $item)
		{
			$date     = \DateTime::createFromFormat(DateFormatter::FORMAT_US, $item['date'], new \DateTimeZone('UTC'));
			$result[] = [(int) gmmktime(0, 0, 0, $date->format('m'), $date->format('d'), $date->format('Y')) * 1000, (int) $item['value']];
		}
		return $result;
	}

	public function userAction()
	{
		$user = UserController::getLoggedUser();

		/** @var Project[] $projects */
		$projects = $this->getProjectTable()->getAllFromUserId($user->id)->buffer();

		// check if project is deletable/editable
		$editableProjectsIds = [];
		foreach ($projects as $project)
		{
			$transactions = $this->getTable('transaction')->select(['project_id' => $project->id]);
			// projects with at least one transaction are not editable
			if ($transactions->count() > 0)
			{
				continue;
			}

			// projects for which deadline is passed are not editable
			if ($project->deadLineIsPassed())
			{
				continue;
			}

			$editableProjectsIds[] = $project->id;
		}

		return new ViewModel([
			'projects'            => $projects,
			'editableProjectsIds' => $editableProjectsIds
		]);
	}

	public function userDetailAction()
	{
		$project      = $this->getProjectFromRouteId();
		$transactions = $this->getTable('transaction')->select(['project_id' => $project->id]);
		$transactions->buffer();
		$userIds     = MultiArray::getArrayOfValues($transactions, 'user_id');
		$financers   = $this->getTable('user')->selectFromIds($userIds);
		$financersHt = Hashtable::createFromObject($financers);

		return new ViewModel([
			'project'      => $project,
			'transactions' => $transactions,
			'financersHt'  => $financersHt,
		]);
	}

	public function userUpdateAction()
	{
		// editor autocompletion helper
		/**
		 * @var TagTable                          $tagTable
		 * @var \Zend\Http\PhpEnvironment\Request $request
		 * @var Tag[]                             $projectTags
		 */

		// get datas
		$tagTable         = $this->getTable('tag');
		$tagsExistingInDb = $tagTable->select();
		// allow looping over tag multiple times
		$tagsExistingInDb->buffer();

		$project = $this->getProjectFromRouteId();

		$pictures    = $this->getTable('picture')->select(['project_id' => $project->id]);
		$picturesIds = MultiArray::getArrayOfValues($pictures, 'id');

		$videos    = $this->getTable('video')->select(['project_id' => $project->id]);
		$videosIds = MultiArray::getArrayOfValues($videos, 'id');

		$projectTags = $tagTable->getAllFromProjectId($project->id)->buffer();
		$tagsIds     = MultiArray::getArrayOfValues($projectTags, 'name');


		// init form
		$form = new ProjectUpdateForm('projectform', $tagsExistingInDb);
		$form->setData([
			ProjectUpdateForm::DESCRIPTION => $project->description,
			ProjectUpdateForm::PICTURES    => $picturesIds,
			ProjectUpdateForm::VIDEOS      => $videosIds,
			ProjectUpdateForm::TAGS        => implode(',', $tagsIds),
		]);

		// handle request
		$request = $this->getRequest();
		if ($request->isPost())
		{
			// get posted data
			$post = array_merge_recursive(
				$request->getPost()->toArray(),
				$request->getFiles()->toArray()
			);

			// validate data
			$form->setData($post);
			if ($form->isValid())
			{
				// get filtered data
				$data = $form->getData();

				// wrap queries in transaction in case of failure
				$this->beginTransaction();

				// update description
				$this->getTable('project')->update([
					'description' => $data[ ProjectUpdateForm::DESCRIPTION ],
				]);

				// create tags
				$postedTags = explode(', ', $data[ ProjectUpdateForm::TAGS ]);
				foreach ($postedTags as $postedTag)
				{
					$tagId = null;
					/** @var Tag $existingTag */
					foreach ($tagsExistingInDb as $existingTag)
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

					// create project/tag link if it doesn't exist yet
					$projectTagAlreadyExists = false;
					foreach ($projectTags as $projectTag)
					{
						if (strtoupper($postedTag) === strtoupper($projectTag->name))
						{
							$projectTagAlreadyExists = true;
							break;
						}
					}

					if (!$projectTagAlreadyExists)
					{
						$this->getTable('projecttag')->insert(['project_id' => $project->id, 'tag_id' => $tagId]);
					}
				}

				// delete tags
				foreach ($projectTags as $projectTag)
				{
					$tagWasRemoved = true;
					foreach ($postedTags as $postedTag)
					{
						if (strtoupper($postedTag) === strtoupper($projectTag->name))
						{
							$tagWasRemoved = false;
							break;
						}
					}

					if ($tagWasRemoved)
					{
						// break link
						$this->getTable('projecttag')->delete(['project_id' => $project->id, 'tag_id' => $projectTag->id]);

						// check if tag is still linked with at least one project
						$count = $this->getTable('projecttag')->select(['tag_id' => $projectTag->id])->count();
						if ($count === 0)
						{
							$this->getTable('tag')->deleteFromId($projectTag->id);
						}
					}
				}

				$this->commitTransaction();

				// add client validation
				$clientValidator = new ClientValidator($form);
				$this->addJs($clientValidator->render());

				return $this->redirectToRoute('project', 'user');
			}
		}

		// add client validation
		$clientValidator = new ClientValidator($form);
		$this->addJs($clientValidator->render());

		return new ViewModel([
			'form' => $form
		]);
	}

	public function userDeleteAction()
	{
		$project = $this->getProjectFromRouteId();

		// delet linked rows first
		$this->getTable('projectcategory')->delete(['project_id' => $project->id]);
		$this->getTable('projecttag')->delete(['project_id' => $project->id]);
		$this->getTable('gift')->delete(['project_id' => $project->id]);
		$this->getTable('picture')->delete(['project_id' => $project->id]);
		$this->getTable('video')->delete(['project_id' => $project->id]);
		$this->getTable('projectview')->delete(['project_id' => $project->id]);
		$this->getTable('project')->deleteFromId($project->id);

		return new ViewModel();
	}

	public function userPromoteAction()
	{
		/** @var \Zend\Http\PhpEnvironment\Request $request */
		$request = $this->getRequest();

		if ($request->isPost())
		{
			$paymentMethodId = $request->getPost()->get('paymentMethodId');
			$amount          = Project::PROMOTION_PRICE;

			// debug: promote project before receiving payment confirmation
			$project = $this->getProjectFromRouteId();

			$previousPromotionEnd = null;
			$nowDate              = DateFormatter::getNowDate();
			if (isset($project->promotionend))
			{
				$previousPromotionEnd = \DateTime::createFromFormat(AbstractTable::DATE_FORMAT, $project->promotionend, DateFormatter::getTimeZone());
			}

			if (!isset($previousPromotionEnd) || $previousPromotionEnd < $nowDate)
			{
				$previousPromotionEnd = $nowDate;
			}

			$newPromotionEnd = $previousPromotionEnd->add(new \DateInterval('P'.Project::PROMOTION_DELAY.'D'));

			$this->getTable('project')->update(['promotionend' => $newPromotionEnd->format(AbstractTable::DATE_FORMAT)], ['id' => $project->id]);


			// paypal case
			if ($paymentMethodId === (string) Paymentmethod::PAYPAL)
			{
				// build URL
				$data                  = [];
				$data['cmd']           = '_donations';
				$data['business']      = 'asensi.samuel-seller@gmail.com';
				$data['amount']        = $amount;
				$data['currency_code'] = 'EUR';
				$data['item_name']     = 'Mise en avant du project '.$project->title;
				$data['lc']            = 'fr_FR';
				$data['cbt']           = 'Revenir sur le site';
				$data['rm']            = 2;
				$data['notify_url']    = $this->url()->fromRoute('home/action', ['controller' => 'project', 'action' => 'paypal_callback']);
				$data['return']        = $this->url()->fromRoute('home/action/id', ['controller' => 'project', 'action' => 'payment_success', 'id' => $project->id]);
				$data['cancel_return'] = $this->url()->fromRoute('home/action/id', ['controller' => 'project', 'action' => 'payment_cancel', 'id' => $project->id]);
				$data['projectId']     = $project->id;

				$url = 'https://www.sandbox.paypal.com/cgi-bin/webscr?'.http_build_query($data);
				return $this->redirect()->toUrl($url);
			}

			return $this->redirectToRoute('project', 'payment_success', $project->id);
		}

		return new ViewModel([
			'promotionPrice' => Project::PROMOTION_PRICE,
			'promotionDelay' => Project::PROMOTION_DELAY,
		]);
	}

	public function paypalCallbackAction()
	{
	}

	public function paymentSuccessAction()
	{
		return new ViewModel([
			'project' => $this->getProjectFromRouteId()
		]);
	}

	public function paymentCancelAction()
	{
		return new ViewModel();
	}

	public function exportAction()
	{
		$project      = $this->getProjectFromRouteId();
		$transactions = $this->getTable('transaction')->select(['project_id' => $project->id]);
		$transactions->buffer();
		$userIds   = MultiArray::getArrayOfValues($transactions, 'user_id');
		$financers = $this->getTable('user')->selectFromIds($userIds);
		/** @var User[] $financersHt */
		$financersHt = Hashtable::createFromObject($financers);

		$excelTable = new ExcelTable('Informations sur les financeurs', 'Idées À Porter');

		// header
		$excelTable->addRow([
			'Date',
			'Montant',
			'Nom du financeur',
			'Email du financeur',
		]);

		/** @var Transaction[] $transactions */
		foreach ($transactions as $transaction)
		{
			$financerName = $financerEmail = '?';

			if (isset($financersHt[ $transaction->user_id ]))
			{
				$financer      = $financersHt[ $transaction->user_id ];
				$financerName  = $financer->name.' '.$financer->firstname;
				$financerEmail = $financer->email;
			}

			$excelTable->addRow([
				DateFormatter::usToFr($transaction->paymentdate),
				$transaction->amount,
				$financerName,
				$financerEmail,
			]);
		}

		$excelTable->output();
	}

	public function financersAction()
	{
		/** @var UserTable $userTable */
		$project   = $this->getProjectFromRouteId();
		$userTable = $this->getTable('user');
		$financers = $userTable->getAllForProject($project->id);

		$this->addCssDependency('css/project/financers.min.css');

		return new ViewModel([
			'financers' => $financers,
			'project'   => $project,
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

		return $this->getProjectTable()->selectFirstById($id);
	}
}
