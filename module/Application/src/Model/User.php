<?php

namespace Application\Model;

/**
 * Automatically generated class from db schema
 * Date: 22/12/2016
 */
class User extends AbstractRow
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
	public $facebookid;

	/**
	 * @var string
	 */
	public $facebooktoken;

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

	/**
	 * @var string
	 */
	public $passwordrecovercode;


	public function exchangeArray(array $data)
	{
		$this->id                  = (isset($data['id'])) ? $data['id'] : null;
		$this->password            = (isset($data['password'])) ? $data['password'] : null;
		$this->name                = (isset($data['name'])) ? $data['name'] : null;
		$this->firstname           = (isset($data['firstname'])) ? $data['firstname'] : null;
		$this->birthdate           = (isset($data['birthdate'])) ? $data['birthdate'] : null;
		$this->email               = (isset($data['email'])) ? $data['email'] : null;
		$this->sex                 = (isset($data['sex'])) ? $data['sex'] : null;
		$this->adress              = (isset($data['adress'])) ? $data['adress'] : null;
		$this->postcode            = (isset($data['postcode'])) ? $data['postcode'] : null;
		$this->city                = (isset($data['city'])) ? $data['city'] : null;
		$this->country_id          = (isset($data['country_id'])) ? $data['country_id'] : null;
		$this->phone               = (isset($data['phone'])) ? $data['phone'] : null;
		$this->photo               = (isset($data['photo'])) ? $data['photo'] : null;
		$this->facebookid          = (isset($data['facebookid'])) ? $data['facebookid'] : null;
		$this->facebooktoken       = (isset($data['facebooktoken'])) ? $data['facebooktoken'] : null;
		$this->subscriptiondate    = (isset($data['subscriptiondate'])) ? $data['subscriptiondate'] : null;
		$this->confirmed           = (isset($data['confirmed'])) ? $data['confirmed'] : null;
		$this->desactivated        = (isset($data['desactivated'])) ? $data['desactivated'] : null;
		$this->usertype_id         = (isset($data['usertype_id'])) ? $data['usertype_id'] : null;
		$this->passwordrecovercode = (isset($data['passwordrecovercode'])) ? $data['passwordrecovercode'] : null;
	}

	public function getArrayCopy()
	{
		return [
			'id'                  => $this->id,
			'password'            => $this->password,
			'name'                => $this->name,
			'firstname'           => $this->firstname,
			'birthdate'           => $this->birthdate,
			'email'               => $this->email,
			'sex'                 => $this->sex,
			'adress'              => $this->adress,
			'postcode'            => $this->postcode,
			'city'                => $this->city,
			'country_id'          => $this->country_id,
			'phone'               => $this->phone,
			'photo'               => $this->photo,
			'facebookid'          => $this->facebookid,
			'facebooktoken'       => $this->facebooktoken,
			'subscriptiondate'    => $this->subscriptiondate,
			'confirmed'           => $this->confirmed,
			'desactivated'        => $this->desactivated,
			'usertype_id'         => $this->usertype_id,
			'passwordrecovercode' => $this->passwordrecovercode,

		];
	}

	public function isFinancer()
	{
		return $this->usertype_id == Usertype::FINANCER;
	}

	public function isCreator()
	{
		return $this->usertype_id == Usertype::CREATOR;
	}

	public function isAdmin()
	{
		return $this->usertype_id == Usertype::ADMIN;
	}
}
