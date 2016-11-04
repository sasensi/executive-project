<?php

namespace Application\Form;

use Application\Form\Element\GiftsFormElement;
use Application\Form\Element\TagPicker;
use Application\Model\Category;
use Application\Model\Gift;
use Application\Model\Tag;
use Zend\Form\Element\File;
use Zend\Form\Element\Select;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\Validator\File\Extension;
use Zend\Validator\File\Size;
use Zend\Validator\LessThan;

class ProjectAddForm extends Form implements InputFilterAwareInterface
{
	/**
	 * ProjectAddForm constructor.
	 *
	 * @param null       $name
	 * @param Category[] $categories all avaiable categories
	 * @param Tag[]      $tags
	 * @param Gift[]     $gifts
	 */
	public function __construct($name = null, $categories = [], $tags = [], $gifts = [])
	{
		parent::__construct('projectAddForm');

		$this->add([
			'name'    => 'title',
			'type'    => 'Text',
			'options' => [
				'label' => 'Titre*'
			]
		]);

		$this->add([
			'name'    => 'subtitle',
			'type'    => 'Text',
			'options' => [
				'label' => 'Sous-titre*'
			]
		]);

		$this->add([
			'name'    => 'description',
			'type'    => 'TextArea',
			'options' => [
				'label' => 'Description*'
			]
		]);

		$this->add([
			'name'    => 'mainpicture',
			'type'    => 'File',
			'options' => [
				'label' => 'Image principale*'
			]
		]);

		$this->add([
			'name'    => 'goal',
			'type'    => 'Number',
			'options' => [
				'label' => 'Objectif*'
			]
		]);

		$this->add([
			'name'    => 'deadline',
			'type'    => 'Date',
			'options' => [
				'label' => 'Date Butoire*'
			]
		]);

		$categoriesHt = [];
		foreach ($categories as $category)
		{
			$categoriesHt[ $category->id ] = $category->name;
		}
		$this->add([
			'name'       => 'category_ids',
			'type'       => Select::class,
			'attributes' => [
				'multiple' => 'multiple'
			],
			'options'    => [
				'label'         => 'Catégories*',
				'value_options' => $categoriesHt,
			],
		]);


		$tagsHt = [];
		foreach ($tags as $tag)
		{
			$tagsHt[ $tag->id ] = $tag->name;
		}
		$tagField = new TagPicker('tag_ids');
		$tagField->setLabel('Tags');
		$tagField->setItems($tagsHt);
		$this->add($tagField);


		$picturesField = new File('picture_ids');
		$picturesField->setLabel('Images secondaires');
		$picturesField->setAttribute('multiple', true);
		$this->add($picturesField);


		$videosField = new File('video_ids');
		$videosField->setLabel('Vidéos');
		$videosField->setAttribute('multiple', true);
		$this->add($videosField);


		// gifts
		$giftsField = new GiftsFormElement('gift_ids');
		$giftsField->setLabel('Contreparties');
		$this->add($giftsField);


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
				new Size('1MB'),
			]
		]);

		$inputFilter->add([
			'name'       => 'picture_ids',
			'required'   => false,
			'validators' => [
				new Extension('jpg,png'),
				new Size('1MB'),
			]
		]);

		$inputFilter->add([
			'name'       => 'video_ids',
			'required'   => false,
			'validators' => [
				new Extension('mp4'),
				new Size('15MB'),
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