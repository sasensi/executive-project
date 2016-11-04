<?php
/**
 * Created by: STAGIAIRE
 * the 04/11/2016
 */

namespace Application\Form\Element;


use Zend\Form\Element;
use Zend\InputFilter\InputProviderInterface;

class GiftElement extends Element implements InputProviderInterface
{
	/**
	 * @var string
	 */
	protected $title;
	/**
	 * @var int
	 */
	protected $amount;
	/**
	 * @var string
	 */
	protected $description;

	public function __construct($name = '', array $options = [])
	{
		$this->title       = '';
		$this->amount      = 0;
		$this->description = '';

		parent::__construct($name, $options);
	}

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}

	/**
	 * @return int
	 */
	public function getAmount()
	{
		return $this->amount;
	}

	/**
	 * @param int $amount
	 */
	public function setAmount($amount)
	{
		$this->amount = $amount;
	}

	/**
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @param string $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}


	/**
	 * Should return an array specification compatible with
	 * {@link Zend\InputFilter\Factory::createInput()}.
	 *
	 * @return array
	 */
	public function getInputSpecification()
	{
		return [
			'name'     => $this->getName(),
			'required' => false
		];
	}
}