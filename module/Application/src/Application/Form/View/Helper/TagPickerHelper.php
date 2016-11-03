<?php
/**
 * Created by: STAGIAIRE
 * the 03/11/2016
 */

namespace Application\Form\View\Helper;


use Application\Form\Element\TagPicker;
use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormInput;

class TagPickerHelper extends FormInput
{
	public function render(ElementInterface $element)
	{
		/* @var TagPicker $element */

		if (!$element instanceof TagPicker)
		{
			throw new \InvalidArgumentException(sprintf(
				'%s requires that the element is of type '.TagPicker::class,
				__METHOD__
			));
		}

		$element->setAttributes([
			'data-role'  => 'tagPicker',
			'data-limit' => 7,
			'data-items' => implode(',', array_values($element->getItems())),
		]);

		return parent::render($element);
	}


	protected function getType(ElementInterface $element)
	{
		return 'text';
	}

}