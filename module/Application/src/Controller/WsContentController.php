<?php
/**
 * Created by: STAGIAIRE
 * the 04/11/2016
 */

namespace Application\Controller;


use Application\Form\Element\GiftsFormElement;
use Application\Form\ProjectSearchFilter;
use Application\Form\View\Helper\GiftsFormHelper;
use Application\Model\Category;
use Application\Model\Gift;
use Application\Model\ProjectTable;
use Application\Model\TagTable;
use Application\Module;
use Zend\Http\Request;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class WsContentController extends AbstractActionCustomController
{
	/**
	 * GET params:
	 * - index, int, required
	 * - name, string, required
	 */
	public function giftAction()
	{
		$params = $this->getRequest()->getQuery()->toArray();

		if (!isset($params['name']))
		{
			return $this->sendError('Missing name parameter.');
		}
		elseif (!isset($params['index']))
		{
			return $this->sendError('Missing index parameter.');
		}

		$element = new GiftsFormElement($params['name']);

		$gift              = new Gift();
		$viewHelperManager = $this->getServiceLocator()->get('ViewHelperManager');
		/** @var GiftsFormHelper $giftHelper */
		$giftHelper = $viewHelperManager->get(Module::HELPER_GIFT);

		$content = $giftHelper->renderGift($gift, $params['index'], $element);

		return $this->sendSuccess($content);
	}

	public function projectAction()
	{
		try
		{
			$this->requireParametters(['offset', 'url']);

			/** @var Request $request */
			$request = $this->getRequest();
			$get     = $request->getQuery();

			$query = parse_url($get->get('url'), PHP_URL_QUERY);
			parse_str($query, $searchParams);

			/** @var TagTable $tagTable */
			$tagTable = $this->getTable('tag');
			/** @var Category[] $categories */
			$categories = $this->getTable('category')->select();

			$searchFilter = new ProjectSearchFilter($categories);
			$searchFilter->fillFromParams($searchParams, $tagTable);
			$searchFilter->setOffset($get->get('offset'));

			/** @var ProjectTable $projectTable */
			$projectTable = $this->getTable('project');
			$projects     = $projectTable->getAllFromSearchFilters($searchFilter);

			$partial = (new ViewModel())
				->setTerminal(true)
				->setTemplate('partial/project/projects')
				->setVariables([
					'projects' => $projects
				]);

			$htmlOutput = $this->getServiceLocator()
			                   ->get('viewrenderer')
			                   ->render($partial);

			$additionalData = [];
			// check if these were the last projects for this query
			if (count($projects) < ProjectSearchFilter::PROJECT_PER_REQUEST)
			{
				$additionalData['end'] = true;
			}

			return $this->sendSuccess($htmlOutput, $additionalData);
		}
		catch (\Exception $e)
		{
			return $this->sendError($e->getMessage());
		}
	}

	protected function requireParametters($requiredParams)
	{
		/** @var Request $request */
		$request = $this->getRequest();
		$params  = $request->getQuery()->toArray();

		foreach ($requiredParams as $requiredParam)
		{
			if (!array_key_exists($requiredParam, $params))
			{
				throw new \Exception("Missing \"{$requiredParam}\" parameter.");
			}
		}
	}

	protected function sendError($msg)
	{
		return new JsonModel([
			'success' => false,
			'error'   => $msg
		]);
	}

	protected function sendSuccess($data, array $additionalData = [])
	{
		$response = $additionalData + [
				'success' => true,
				'data'    => $data
			];

		return new JsonModel($response);
	}
}