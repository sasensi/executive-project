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
	protected $id;

	/**
	 * @var string
	 */
	protected $password;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $firstname;

	/**
	 * @var string
	 */
	protected $birthdate;

	/**
	 * @var string
	 */
	protected $email;

	/**
	 * @var string
	 */
	protected $sex;

	/**
	 * @var string
	 */
	protected $adress;

	/**
	 * @var integer
	 */
	protected $postcode;

	/**
	 * @var string
	 */
	protected $city;

	/**
	 * @var integer
	 */
	protected $country_id;

	/**
	 * @var string
	 */
	protected $phone;

	/**
	 * @var string
	 */
	protected $photo;

	/**
	 * @var string
	 */
	protected $facebook;

	/**
	 * @var string
	 */
	protected $subscriptiondate;

	/**
	 * @var string
	 */
	protected $confirmed;

	/**
	 * @var string
	 */
	protected $desactivated;

	/**
	 * @var integer
	 */
	protected $usertype_id;


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
