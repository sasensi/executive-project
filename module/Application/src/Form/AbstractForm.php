<?php
/**
 * Created by: STAGIAIRE
 * the 04/11/2016
 */

namespace Application\Form;


use Zend\Form\Form;
use Zend\InputFilter\Input;
use Zend\Validator\AbstractValidator;

abstract class AbstractForm extends Form
{
	public function __construct($name = '', $options = [])
	{
		$this->setAttributes([
			'class'  => 'form-horizontal',
			'action' => $_SERVER['REQUEST_URI'],
			'id'     => 'form_'.uniqid()
		]);

		parent::__construct($name, $options);
	}

	/**
	 * @param string              $fieldName
	 * @param bool                $required
	 * @param AbstractValidator[] $validators
	 */
	protected function createInputFilter($fieldName, $required = true, array $validators = [])
	{
		$input = new Input($fieldName);
		$input->setRequired($required);
		$validatorChain = $input->getValidatorChain();
		foreach ($validators as $validator)
		{
			$validatorChain->attach($validator);
		}
		return $input;
	}

}