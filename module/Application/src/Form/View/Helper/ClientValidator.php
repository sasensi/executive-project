<?php
/**
 * Created by: STAGIAIRE
 * the 21/12/2016
 */

namespace Application\Form\View\Helper;


use Application\Form\Validator\PhoneValidator;
use Application\Util\DateFormatter;
use Zend\Form\Element;
use Zend\Form\ElementInterface;
use Zend\Form\Form;
use Zend\Validator\Date;

class ClientValidator
{
	/**
	 * @var \Zend\Form\Form
	 */
	protected $form;

	public function __construct(Form $form)
	{
		$this->form = $form;
	}

	public function render()
	{
		$formId = $this->form->getAttribute('id');
		if (empty($formId))
		{
			throw new \Exception('Missing form id');
		}

		$inputfilter = $this->form->getInputFilter();

		$rules = [];
		foreach ($this->form->getElements() as $fieldName => $field)
		{
			if ($field instanceof Element)
			{
				// made to handle brackets suffixed multiple fields
				$fieldValidationName = $this->getFieldValidationName($field);

				$fieldRules  = [];
				$fieldFilter = $inputfilter->get($fieldName);
				if ($fieldFilter->isRequired())
				{
					$fieldRules['required'] = true;
				}

				$validators = $fieldFilter->getValidatorChain()->getValidators();
				foreach ($validators as $validatorConfig)
				{
					$validator = $validatorConfig['instance'];
					if ($validator instanceof Date && $validator->getFormat() === DateFormatter::FORMAT_FR)
					{
						$fieldRules['dateFr'] = true;
					}
					elseif ($validator instanceof PhoneValidator)
					{
						$fieldRules['phone'] = true;
					}
				}
				if (!empty($fieldRules))
				{
					$rules[ $fieldValidationName ] = $fieldRules;
				}
			}
		}
		$jsonRules = json_encode($rules);

		$messages = [];
		foreach ($this->form->getMessages() as $fieldName => $fieldMessages)
		{
			$field = $this->form->get($fieldName);
			// made to handle brackets suffixed multiple fields
			$fieldValidationName              = $this->getFieldValidationName($field);
			$message                          = implode(' ', $fieldMessages);
			$messages[ $fieldValidationName ] = $message;
		}
		$jsonMessages = json_encode($messages);


		// render js
		return <<<JS
$(document).ready(function ()
{
    $('#{$formId}').validate({
        rules         : {$jsonRules},
        errorPlacement: function (error, element)
        {
            element.closest('.iapInputWrapper').append(error);
        },
        highlight     : function (element, errorClass, validClass)
        {
            $(element).add($(element).closest('.iapInputWrapper')).addClass(errorClass).removeClass(validClass);
        },
        unhighlight   : function (element, errorClass, validClass)
        {
            $(element).add($(element).closest('.iapInputWrapper')).removeClass(errorClass).addClass(validClass);
        }

    })
    .showErrors({$jsonMessages})
    ;
});
JS;
	}

	/**
	 * @param ElementInterface $field
	 * @return string
	 */
	private function getFieldValidationName($field)
	{
		if ($field->hasAttribute('multiple'))
		{
			return $field->getName().'[]';
		}
		return $field->getName();
	}
}