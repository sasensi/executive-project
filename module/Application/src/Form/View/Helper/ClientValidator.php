<?php
/**
 * Created by: STAGIAIRE
 * the 21/12/2016
 */

namespace Application\Form\View\Helper;


use Zend\Form\Element;
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
		$inputfilter = $this->form->getInputFilter();

		$rules = [];
		foreach ($this->form->getElements() as $fieldName => $field)
		{
			if ($field instanceof Element)
			{
				// made to handle brackets suffixed multiple fields
				$fieldValidationName = $fieldName;
				if ($field->hasAttribute('multiple'))
				{
					$fieldValidationName .= '[]';
				}

				$fieldRules  = [];
				$fieldFilter = $inputfilter->get($fieldName);
				if ($fieldFilter->isRequired())
				{
					$fieldRules['required'] = true;
				}

				$validators = $fieldFilter->getValidatorChain();
				foreach ($validators as $validator)
				{
					/*if ($validator instanceof Date)
					{
						$rules
					}*/
				}
				if (!empty($fieldRules))
				{
					$rules[ $fieldValidationName ] = $fieldRules;
				}
			}
		}

		$jsonRules = json_encode($rules);

		$formId = $this->form->getAttribute('id');
		if (empty($formId))
		{
			throw new \Exception('Missing form id');
		}

		// render js
		return <<<JS
$(document).ready(function ()
{
    // force validation on browser autocomplete
    $('body').on('input change', 'input, textarea, select', function ()
    {
        $(this).valid();
    });


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

    });
});
JS;
	}
}