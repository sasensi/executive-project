<?php
/**
 * Created by: STAGIAIRE
 * the 04/11/2016
 */

namespace Application\Form\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormRow as BaseFormRow;

class FormRow extends BaseFormRow
{
	public function render(ElementInterface $element, $labelPosition = null)
	{
		if (!$element->hasAttribute('id'))
		{
			$element->setAttribute('id', 'element_'.uniqid());
		}

		if (empty($element->getLabel()))
		{
			$element->setLabel(ucfirst($element->getName()));
		}

		if (empty($element->getAttribute('class')))
		{
			$element->setAttribute('class', 'form-control');
		}
		else
		{
			$element->setAttribute('class', $element->getAttribute('class').' form-control');
		}

		$elementContent = $this->getElementHelper()->render($element);

		return <<<HTML
<div class="form-group row">
    <label for="{$element->getAttribute('id')}" class="col-sm-2 control-label">{$element->getLabel()}</label>
    <div class="col-sm-10">
        {$elementContent}
	</div>
</div>
HTML;
		//return parent::render($element, $labelPosition);
	}

}
