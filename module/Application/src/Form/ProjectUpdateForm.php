<?php

namespace Application\Form;

use Application\Form\Element\TagPicker;
use Application\Model\Tag;
use Zend\Form\Element\File;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\Validator\File\Extension;
use Zend\Validator\File\Size;

class ProjectUpdateForm extends AbstractForm
{
	const DESCRIPTION = 'description';
	const TAGS        = 'tag_ids';
	const PICTURES    = 'picture_ids';
	const VIDEOS      = 'video_ids';
	const SUBMIT      = 'submit';

	/**
	 * ProjectAddForm constructor.
	 *
	 * @param null  $name
	 * @param Tag[] $tags
	 */
	public function __construct($name = null, $tags = [])
	{
		parent::__construct('projectAddForm');

		$this->add([
			'name'    => self::DESCRIPTION,
			'type'    => 'TextArea',
			'options' => [
				'label' => 'Description*'
			]
		]);

		$tagsHt = [];
		foreach ($tags as $tag)
		{
			$tagsHt[ $tag->id ] = $tag->name;
		}
		$tagField = new TagPicker(self::TAGS);
		$tagField->setLabel('Tags');
		$tagField->setItems($tagsHt);
		$this->add($tagField);


		$picturesField = new File(self::PICTURES);
		$picturesField->setLabel('Images secondaires');
		$picturesField->setAttribute('multiple', true);
		$this->add($picturesField);


		$videosField = new File(self::VIDEOS);
		$videosField->setLabel('Vidéos');
		$videosField->setAttribute('multiple', true);
		$this->add($videosField);


		$this->add([
			'name'       => self::SUBMIT,
			'type'       => 'Submit',
			'attributes' => [
				'value' => 'Modifier',
				'class' => 'btn btn-primary'
			],
		]);


		$this->setDefaultInputFilters();
	}

	protected function setDefaultInputFilters()
	{
		$inputFilter = new InputFilter();

		$inputFilter->add([
			'name'       => 'description',
			'required'   => true,
			'validators' => [
				InputFilterConfigProvider::getStringLength(null, 10000),
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

		$this->setInputFilter($inputFilter);
	}


}