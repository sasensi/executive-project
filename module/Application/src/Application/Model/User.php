<?php

namespace Application\Model;

/**
 * Automatically generated class from db schema
 * Date: 30/06/2016
 */
class User implements RowInterface
{
	/**
	 * @var integer
	 */
	public $id;

	/**
	 * @var string
	 */
	public $password;

	/**
	 * @var string
	 */
	public $name;

	/**
	 * @var string
	 */
	public $firstname;

	/**
	 * @var string
	 */
	public $birthdate;

	/**
	 * @var string
	 */
	public $email;

	/**
	 * @var string
	 */
	public $sex;

	/**
	 * @var string
	 */
	public $adress;

	/**
	 * @var integer
	 */
	public $postcode;

	/**
	 * @var string
	 */
	public $city;

	/**
	 * @var integer
	 */
	public $country_id;

	/**
	 * @var string
	 */
	public $phone;

	/**
	 * @var string
	 */
	public $photo;

	/**
	 * @var string
	 */
	public $facebook;

	/**
	 * @var string
	 */
	public $subscriptiondate;

	/**
	 * @var string
	 */
	public $confirmed;

	/**
	 * @var string
	 */
	public $desactivated;

	/**
	 * @var integer
	 */
	public $usertype_id;


	public function exchangeArray($arr)
	{
		$this->id = (isset($arr['id'])) ? $arr['id'] : null;
		$this->password = (isset($arr['password'])) ? $arr['password'] : null;
		$this->name = (isset($arr['name'])) ? $arr['name'] : null;
		$this->firstname = (isset($arr['firstname'])) ? $arr['firstname'] : null;
		$this->birthdate = (isset($arr['birthdate'])) ? $arr['birthdate'] : null;
		$this->email = (isset($arr['email'])) ? $arr['email'] : null;
		$this->sex = (isset($arr['sex'])) ? $arr['sex'] : null;
		$this->adress = (isset($arr['adress'])) ? $arr['adress'] : null;
		$this->postcode = (isset($arr['postcode'])) ? $arr['postcode'] : null;
		$this->city = (isset($arr['city'])) ? $arr['city'] : null;
		$this->country_id = (isset($arr['country_id'])) ? $arr['country_id'] : null;
		$this->phone = (isset($arr['phone'])) ? $arr['phone'] : null;
		$this->photo = (isset($arr['photo'])) ? $arr['photo'] : null;
		$this->facebook = (isset($arr['facebook'])) ? $arr['facebook'] : null;
		$this->subscriptiondate = (isset($arr['subscriptiondate'])) ? $arr['subscriptiondate'] : null;
		$this->confirmed = (isset($arr['confirmed'])) ? $arr['confirmed'] : null;
		$this->desactivated = (isset($arr['desactivated'])) ? $arr['desactivated'] : null;
		$this->usertype_id = (isset($arr['usertype_id'])) ? $arr['usertype_id'] : null;

	}
}
