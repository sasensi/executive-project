<?php
/**
 * Created by: STAGIAIRE
 * the 04/11/2016
 */

namespace Application\Form;


use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;

class LoginForm extends Form
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

		$password = new Text(self::PASSWORD);
		$password->setLabel('Mot de passe*');
		$this->add($password);

		$submit = new Submit(self::SUBMIT);
		$submit->setAttributes([
			'value' => 'Se connecter',
			'class' => 'btn btn-primary'
		]);
		$this->add($submit);

		$this->setDefaultInputFilters();
	}

	protected function setDefaultInputFilters()
	{
		$inputFilter = new InputFilter();

		$this->setInputFilter($inputFilter);
	}
}