<?php
/**
 * Created by: STAGIAIRE
 * the 04/11/2016
 */

namespace Application\Form;


use Application\Form\Element\Date;
use Application\Model\Category;
use Application\Model\Country;
use Application\Model\Usertype;
use Application\Util\DateFormatter;
use Zend\Form\Element\Email;
use Zend\Form\Element\File;
use Zend\Form\Element\Number;
use Zend\Form\Element\Password;
use Zend\Form\Element\Select;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;

class UserForm extends AbstractForm
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

		$email = new Email(self::EMAIL);
		$email->setLabel('Email*');
		$this->add($email);

		$password = new Password(self::PASSWORD);
		$password->setLabel('Mot de passe*');
		$this->add($password);

		$name = new Text(self::NAME);
		$name->setLabel('Nom*');
		$this->add($name);

		$firstName = new Text(self::FIRSTNAME);
		$firstName->setLabel('Prénom*');
		$this->add($firstName);

		$birthdate = new Date(self::BIRTHDATE);
		$birthdate->setLabel('Date de naissance*');
		$this->add($birthdate);

		$sex = new Select(self::SEX);
		$sex->setLabel('Sexe*');
		$sex->setValueOptions([
			'M' => 'Homme',
			'F' => 'Femme',
		]);
		$this->add($sex);

		$adress = new Text(self::ADRESS);
		$adress->setLabel('Adresse*');
		$this->add($adress);

		$postcode = new Number(self::POSTCODE);
		$postcode->setLabel('Code postal*');
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
		$phone->setAttribute('class', 'phoneInput');
		$this->add($phone);

		$photo = new File(self::PHOTO);
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

		$inputFilter
			->add((new Input(self::EMAIL))->setRequired(true))
			->add((new Input(self::PASSWORD))->setRequired(true))
			->add((new Input(self::NAME))->setRequired(true))
			->add((new Input(self::FIRSTNAME))->setRequired(true))
			->add((new Input(self::SEX))->setRequired(true))
			->add((new Input(self::ADRESS))->setRequired(true))
			->add((new Input(self::POSTCODE))->setRequired(true))
			->add((new Input(self::CITY))->setRequired(true))
			->add((new Input(self::COUNTRY_ID))->setRequired(true))
			;

		$dateFilter = new \Zend\Validator\Date();
		$dateFilter->setFormat(DateFormatter::FORMAT_FR);

		$input = new Input(self::BIRTHDATE);
		$input->setRequired(true);
		$input->getValidatorChain()->attach($dateFilter);
		$inputFilter->add($input);

		$input = new Input(self::FAVOURITECATEGORY_ID);
		$input->setRequired(false);
		$inputFilter->add($input);

		$this->setInputFilter($inputFilter);
	}
}