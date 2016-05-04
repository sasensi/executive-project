<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\Validator\File\Extension;
use Zend\Validator\File\FilesSize;
use Zend\Validator\File\Size;
use Zend\Validator\LessThan;
use Zend\Validator\StringLength;

class ProjectAddForm extends Form implements InputFilterAwareInterface
{
	public function __construct($name = null)
	{
		parent::__construct('projectAddForm');

		$this->add([
			'name'    => 'title',
			'type'    => 'Text',
			'options' => [
				'label' => 'Titre'
			]
		]);

		$this->add([
			'name'    => 'subtitle',
			'type'    => 'Text',
			'options' => [
				'label' => 'Sous-titre'
			]
		]);

		$this->add([
			'name'    => 'description',
			'type'    => 'TextArea',
			'options' => [
				'label' => 'Description'
			]
		]);

		$this->add([
			'name'    => 'mainpicture',
			'type'    => 'File',
			'options' => [
				'label' => 'Image principale'
			]
		]);

		$this->add([
			'name'    => 'deadline',
			'type'    => 'Date',
			'options' => [
				'label' => 'Date Butoire'
			]
		]);

		$this->add([
			'name'    => 'goal',
			'type'    => 'Number',
			'options' => [
				'label' => 'Objectif'
			]
		]);


		$this->add([
			'name'       => 'submit',
			'type'       => 'Submit',
			'attributes' => [
				'value' => 'Créer',
				'class' => 'btn btn-primary'
			],
		]);


		$this->setDefaultInputFilters();
	}

	protected function setDefaultInputFilters()
	{
		$inputFilter = new InputFilter();

		$inputFilter->add([
			'name'       => 'title',
			'required'   => true,
			'validators' => [
				InputFilterConfigProvider::getStringLength(null, 80),
			],
		]);

		$inputFilter->add([
			'name'       => 'subtitle',
			'required'   => true,
			'validators' => [
				InputFilterConfigProvider::getStringLength(null, 90),
			]
		]);

		$inputFilter->add([
			'name'       => 'description',
			'required'   => true,
			'validators' => [
				InputFilterConfigProvider::getStringLength(null, 10000),
			]
		]);

		$inputFilter->add([
			'name'       => 'mainpicture',
			'required'   => true,
			'validators' => [
				new Extension('jpg,png'),
			    new Size(1048576),
			]
		]);

		$inputFilter->add([
			'name'       => 'goal',
			'required'   => true,
			'validators' => [
				new LessThan(['max' => 1000000]),
			]
		]);
		
		$this->setInputFilter($inputFilter);
	}


}