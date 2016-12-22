<?php
/**
 * Created by: STAGIAIRE
 * the 04/11/2016
 */

namespace Application\Form;


use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\InputFilter\InputFilter;

class LoginForm extends AbstractForm
{
	const EMAIL    = 'email';
	const PASSWORD = 'password';
	const SUBMIT   = 'submit';

	public function __construct()
	{
		parent::__construct('userAddForm');

		$email = new Text(self::EMAIL);
		$email->setLabel('Email*');
		$this->add($email);

		$password = new Password(self::PASSWORD);
		$password->setLabel('Mot de passe*');
		$this->add($password);

		$submit = new Submit(self::SUBMIT);
		$submit->setAttributes([
			'value' => 'Se connecter',
			'class' => 'btn btn-primary'
		]);
		$this->add($submit);


		$this->setInputFilter((new InputFilter())
			->add($this->createInputFilter(self::EMAIL))
			->add($this->createInputFilter(self::PASSWORD))
		);
	}
}