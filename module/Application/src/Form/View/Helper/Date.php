<?php
/**
 * Created by: STAGIAIRE
 * the 25/11/2016
 */

namespace Application\Form\View\Helper;


use Zend\Form\View\Helper\FormText;

class Date extends FormText
{
	public function createAttributesString(array $attributes)
	{
		$class = 'datePicker';

		$attributes['class'] = isset($attributes['class']) ? $attributes['class'].' '.$class : $class;

		return parent::createAttributesString($attributes);
	}
}