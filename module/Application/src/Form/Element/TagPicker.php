<?php
/**
 * Created by: STAGIAIRE
 * the 03/11/2016
 */

namespace Application\Form\Element;


use Zend\Form\Element;
use Zend\InputFilter\InputProviderInterface;

class TagPicker extends Element implements InputProviderInterface
{
	/**
	 * @var array
	 */
	protected $items;

	public function __construct($name = null, array $options = [])
	{
		$this->items = [];

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
	 * @return array
	 */
	public function getItems()
	{
		return $this->items;
	}

	/**
	 * @param array $items
	 */
	public function setItems($items)
	{
		$this->items = $items;
		return $this;
	}
}