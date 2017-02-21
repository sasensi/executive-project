<?php
/**
 * Created by PhpStorm.
 * User: sam
 * Date: 11/11/2016
 * Time: 11:19
 */

namespace Application\Form;


use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Identical;
use Zend\Validator\StringLength;

class ChangePasswordForm extends AbstractForm
{
	const PASSWORD         = 'password';
	const PASSWORD_CONFIRM = 'passwordConfirm';
	const SUBMIT           = 'submit';

	public function __construct()
	{
		parent::__construct('changePasswordForm');

		$password = new Password(self::PASSWORD);
		$password->setLabel('Mot de passe*');
		$this->add($password);

		$passwordConfirm = new Password(self::PASSWORD_CONFIRM);
		$passwordConfirm->setLabel('Confirmation du mot de passe*');
		$this->add($passwordConfirm);

		$submit = new Submit(self::SUBMIT);
		$submit->setAttributes([
			'value' => 'Valider',
			'class' => 'btn btn-primary'
		]);
		$this->add($submit);


		//
		// VALIDATION
		//

		$this->setInputFilter((new InputFilter())
			->add($this->createInputFilter(self::PASSWORD, true, [(new StringLength())->setMin(6)]))
			->add($this->createInputFilter(self::PASSWORD_CONFIRM, true, [(new Identical())->setToken(self::PASSWORD)]))
		);
	}

}