<?php
/**
 * Created by: STAGIAIRE
 * the 04/11/2016
 */

namespace Application\Form;


use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\InputFilter\InputFilter;

class UserAddForm extends AbstractForm
{
	const EMAIL                = 'email';
	const PASSWORD             = 'password';
	const NAME                 = 'name';
	const FIRSTNAME            = 'firstname';
	const BIRTHDATE            = 'birthdate';
	const SEX                  = 'sex';
	const ADRESS               = 'adress';
	const POSTCODE             = 'postcode';
	const CITY                 = 'city';
	const COUNTRY_ID           = 'country_id';
	const PHONE                = 'phone';
	const PHOTO                = 'photo';
	const FAVOURITECATEGORY_ID = 'favouritecategory_id';
	const USERTYPE_ID          = 'usertype_id';
	const SUBMIT               = 'submit';

	public function __construct()
	{
		parent::__construct('userAddForm');

		$email = new Text(self::EMAIL);
		$email->setLabel('Email*');
		$this->add($email);

		$password = new Text(self::PASSWORD);
		$password->setLabel('Mot de passe*');
		$this->add($password);

		$name = new Text(self::NAME);
		$name->setLabel('Nom*');
		$this->add($name);

		$firstName = new Text(self::FIRSTNAME);
		$firstName->setLabel('Prénom*');
		$this->add($firstName);

		$birthdate = new Text(self::BIRTHDATE);
		$birthdate->setLabel('Date de naissance*');
		$this->add($birthdate);

		$sex = new Text(self::SEX);
		$sex->setLabel('Sexe*');
		$this->add($sex);

		$adress = new Text(self::ADRESS);
		$adress->setLabel('Adresse*');
		$this->add($adress);

		$postcode = new Text(self::POSTCODE);
		$postcode->setLabel('code postal*');
		$this->add($postcode);

		$city = new Text(self::CITY);
		$city->setLabel('Ville*');
		$this->add($city);

		$country_id = new Text(self::COUNTRY_ID);
		$country_id->setLabel('Pays*');
		$this->add($country_id);

		$phone = new Text(self::PHONE);
		$phone->setLabel('Téléphone');
		$this->add($phone);

		$photo = new Text(self::PHOTO);
		$photo->setLabel('Photo');
		$this->add($photo);

		$country_id = new Text(self::FAVOURITECATEGORY_ID);
		$country_id->setLabel('Catégorie favorite');
		$this->add($country_id);

		$usertype_id = new Text(self::USERTYPE_ID);
		$usertype_id->setLabel('Type de compte');
		$this->add($usertype_id);


		$submit = new Submit(self::SUBMIT);
		$submit->setAttributes([
			'value' => 'Créer',
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