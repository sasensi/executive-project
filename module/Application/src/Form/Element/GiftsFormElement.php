<?php
/**
 * Created by: STAGIAIRE
 * the 04/11/2016
 */

namespace Application\Form\Element;


use Application\Model\Gift;
use Zend\Form\Element;
use Zend\InputFilter\InputProviderInterface;

class GiftsFormElement extends Element implements InputProviderInterface
{
	/**
	 * @var Gift[]
	 */
	protected $gifts;

	public function __construct($name = '', array $options = [])
	{
		$this->gifts = [];

		parent::__construct($name, $options);
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

	/**
	 * @return \Application\Model\Gift[]
	 */
	public function getGifts()
	{
		return $this->gifts;
	}

	/**
	 * @param \Application\Model\Gift[] $gifts
	 */
	public function setGifts($gifts)
	{
		$this->gifts = $gifts;
		return $this;
	}
}