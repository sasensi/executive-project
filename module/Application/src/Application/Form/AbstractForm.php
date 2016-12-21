<?php
/**
 * Created by: STAGIAIRE
 * the 04/11/2016
 */

namespace Application\Form;


use Zend\Form\Form;

abstract class AbstractForm extends Form
{
	public function __construct($name = '', $options = [])
	{
		$this->setAttributes([
			'class'  => 'form-horizontal',
			'action' => $_SERVER['REQUEST_URI'],
			'id'     => 'form_'.uniqid()
		]);

		parent::__construct($name, $options);
	}

}