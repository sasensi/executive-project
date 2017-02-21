<?php
/**
 * Created by PhpStorm.
 * User: sam
 * Date: 11/11/2016
 * Time: 10:46
 */

namespace Application\Form;


use Zend\Form\Element\Email;
use Zend\Form\Element\Submit;
use Zend\InputFilter\InputFilter;
use Zend\Validator\EmailAddress;

class ForgotPasswordForm extends AbstractForm
{
	const SUBMIT = 'submit';
	const EMAIL  = 'email';

	public function __construct()
	{
		parent::__construct('forgotPasswordForm');

		$email = new Email(self::EMAIL);
		$email->setLabel('Email*');
		$this->add($email);

		$submit = new Submit(self::SUBMIT);
		$submit->setAttributes([
			'value' => 'Envoyer',
			'class' => 'btn btn-primary'
		]);
		$this->add($submit);


		//
		// VALIDATION
		//

		$this->setInputFilter((new InputFilter())
			->add($this->createInputFilter(self::EMAIL, true, [new EmailAddress()]))
		);
	}

}