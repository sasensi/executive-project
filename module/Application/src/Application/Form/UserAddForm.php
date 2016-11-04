<?php
/**
 * Created by: STAGIAIRE
 * the 04/11/2016
 */

namespace Application\Form;


use Application\Model\Category;
use Application\Model\Country;
use Application\Model\Usertype;
use Zend\Form\Element\Select;
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

	/**
	 * UserAddForm constructor.
	 *
	 * @param Usertype[] $userTypes
	 * @param Country[]  $countries
	 * @param Category[] $categories
	 */
	public function __construct($userTypes, $countries, $categories)
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

		$countriesHt = [];
		foreach ($countries as $country)
		{
			$countriesHt[ $country->id ] = $country->name;
		}
		$country_id = new Select(self::COUNTRY_ID);
		$country_id->setLabel('Pays*');
		$country_id->setValueOptions($countriesHt);
		$this->add($country_id);

		$phone = new Text(self::PHONE);
		$phone->setLabel('Téléphone');
		$this->add($phone);

		$photo = new Text(self::PHOTO);
		$photo->setLabel('Photo');
		$this->add($photo);

		$categoriesHt = [];
		foreach ($categories as $category)
		{
			$categoriesHt[ $category->id ] = $category->name;
		}
		$favouritecategory_id = new Select(self::FAVOURITECATEGORY_ID);
		$favouritecategory_id->setLabel('Catégorie favorite');
		$favouritecategory_id->setValueOptions($categoriesHt);
		$this->add($favouritecategory_id);

		$userTypesHt = [];
		foreach ($userTypes as $userType)
		{
			$userTypesHt[ $userType->id ] = $userType->name;
		}
		$usertype_id = new Select(self::USERTYPE_ID);
		$usertype_id->setValueOptions($userTypesHt);
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