<?php
/**
 * Created by: STAGIAIRE
 * the 25/11/2016
 */

namespace Application\Form\View\Helper;


class Date extends \Zend\Form\View\Helper\FormText
{
	public function createAttributesString(array $attributes)
	{
		$class = 'datePicker';

		$attributes['class'] = isset($attributes['class']) ? $attributes['class'].' '.$class : $class;

		return parent::createAttributesString($attributes);
	}
}