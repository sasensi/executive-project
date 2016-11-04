<?php
/**
 * Created by: STAGIAIRE
 * the 04/11/2016
 */

namespace Application\Controller;


use Application\Form\Element\GiftsFormElement;
use Application\Form\View\Helper\GiftsFormHelper;
use Application\Model\Gift;
use Application\Module;
use Zend\View\Model\JsonModel;

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
		$giftHelper = $viewHelperManager->get(Module::HELPER_GIFT); // $escapeHtml can be called as function because of its __invoke method

		$content = $giftHelper->renderGift($gift, $params['index'], $element);

		return $this->sendSuccess($content);
	}

	protected function sendError($msg)
	{
		return new JsonModel([
			'success' => false,
			'error'   => $msg
		]);
	}

	protected function sendSuccess($data)
	{
		return new JsonModel([
			'success' => true,
			'data'    => $data
		]);
	}
}