<?php
/**
 * Created by: STAGIAIRE
 * the 03/11/2016
 *
 * override native zend form element to display custom fields
 */

namespace Application\Form\View\Helper;


use Application\Form\Element\Date;
use Application\Form\Element\GiftsFormElement;
use Application\Form\Element\TagPicker;
use Application\Module;
use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormElement as BaseFormElement;

class FormElement extends BaseFormElement
{
	public function render(ElementInterface $element)
	{
		$renderer = $this->getView();
		if (!method_exists($renderer, 'plugin'))
		{
			// Bail early if renderer is not pluggable
			return '';
		}

		if ($element instanceof TagPicker)
		{
			//return '<p>test</p>';
			$helper = $renderer->plugin(Module::HELPER_TAG);
			return $helper($element);
		}
		elseif ($element instanceof GiftsFormElement)
		{
			$helper = $renderer->plugin(Module::HELPER_GIFT);
			return $helper($element);
		}
		elseif ($element instanceof Date)
		{
			$helper = $renderer->plugin(Module::HELPER_DATE);
			return $helper($element);
		}

		return parent::render($element);
	}
}