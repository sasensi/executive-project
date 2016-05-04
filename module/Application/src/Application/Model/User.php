<?php

namespace Application\Model;

class User implements RowInterface
{
	public $id;
	public $password;
	public $name;
	public $firstname;
	public $birthdate;
	public $email;
	public $sex;
	public $adress;
	public $postcode;
	public $city;
	public $country_id;
	public $phone;
	public $photo;
	public $facebook;
	public $subscriptiondate;
	public $confirmed;
	public $desactivated;
	public $usertype_id;

	public function exchangeArray($data)
	{
		$this->id               = (!empty($data['id'])) ? $data['id'] : null;
		$this->password         = (!empty($data['password'])) ? $data['password'] : null;
		$this->name             = (!empty($data['name'])) ? $data['name'] : null;
		$this->firstname        = (!empty($data['firstname'])) ? $data['firstname'] : null;
		$this->birthdate        = (!empty($data['birthdate'])) ? $data['birthdate'] : null;
		$this->email            = (!empty($data['email'])) ? $data['email'] : null;
		$this->sex              = (!empty($data['sex'])) ? $data['sex'] : null;
		$this->adress           = (!empty($data['adress'])) ? $data['adress'] : null;
		$this->postcode         = (!empty($data['postcode'])) ? $data['postcode'] : null;
		$this->city             = (!empty($data['city'])) ? $data['city'] : null;
		$this->country_id       = (!empty($data['country_id'])) ? $data['country_id'] : null;
		$this->phone            = (!empty($data['phone'])) ? $data['phone'] : null;
		$this->photo            = (!empty($data['photo'])) ? $data['photo'] : null;
		$this->facebook         = (!empty($data['facebook'])) ? $data['facebook'] : null;
		$this->subscriptiondate = (!empty($data['subscriptiondate'])) ? $data['subscriptiondate'] : null;
		$this->confirmed        = (!empty($data['confirmed'])) ? $data['confirmed'] : null;
		$this->desactivated     = (!empty($data['desactivated'])) ? $data['desactivated'] : null;
		$this->usertype_id      = (!empty($data['usertype_id'])) ? $data['usertype_id'] : null;
	}
}