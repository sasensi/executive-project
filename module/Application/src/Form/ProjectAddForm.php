<?php

namespace Application\Form;

use Application\Form\Element\Date;
use Application\Form\Element\GiftsFormElement;
use Application\Form\Element\TagPicker;
use Application\Model\Category;
use Application\Model\Gift;
use Application\Model\Tag;
use Application\Util\DateFormatter;
use Zend\Form\Element\File;
use Zend\Form\Element\Number;
use Zend\Form\Element\Select;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\InputFilter\InputFilter;
use Zend\Validator\File\Extension;
use Zend\Validator\File\Size;
use Zend\Validator\LessThan;
use Zend\Validator\StringLength;

class ProjectAddForm extends AbstractForm
{
	const TITLE        = 'title';
	const SUBTITLE     = 'subtitle';
	const DESCRIPTION  = 'description';
	const MAINPICTURE  = 'mainpicture';
	const GOAL         = 'goal';
	const DEADLINE     = 'deadline';
	const CATEGORY_IDS = 'category_ids';
	const TAG_IDS      = 'tag_ids';
	const PICTURE_IDS  = 'picture_ids';
	const VIDEO_IDS    = 'video_ids';
	const GIFT_IDS     = 'gift_ids';
	const SUBMIT       = 'submit';

	/**
	 * ProjectAddForm constructor.
	 *
	 * @param Category[] $categories all avaiable categories
	 * @param Tag[]      $tags
	 * @param Gift[]     $gifts
	 * @internal param null $name
	 */
	public function __construct($categories = [], $tags = [], $gifts = [])
	{
		parent::__construct('projectAddForm');

		// prepare data
		$categoriesHt = [];
		foreach ($categories as $category)
		{
			$categoriesHt[ $category->id ] = $category->name;
		}
		$tagsHt = [];
		foreach ($tags as $tag)
		{
			$tagsHt[ $tag->id ] = $tag->name;
		}

		$this
			->add((new Text(self::TITLE))
				->setLabel('Titre*')
			)
			->add((new Text(self::SUBTITLE))
				->setLabel('Sous-titre*')
			)
			->add((new Textarea(self::DESCRIPTION))
				->setLabel('Description*')
			)
			->add((new File(self::MAINPICTURE))
				->setLabel('Image principale*')
			)
			->add((new Number(self::GOAL))
				->setLabel('Objectif*')
			)
			->add((new Date(self::DEADLINE))
				->setLabel('Date Butoire*')
			)
			->add((new Select(self::CATEGORY_IDS))
				->setValueOptions($categoriesHt)
				->setDisableInArrayValidator(true)
				->setAttribute('multiple', 'mutliple')
				->setLabel('Catégories*')
			)
			->add((new TagPicker(self::TAG_IDS))
				->setItems($tagsHt)
				->setLabel('Tags')
			)
			->add((new File(self::PICTURE_IDS))
				->setAttribute('multiple', 'mutliple')
				->setLabel('Vidéos')
			)
			->add((new File(self::VIDEO_IDS))
				->setAttribute('multiple', 'mutliple')
				->setLabel('Images secondaires')
			)
			->add((new GiftsFormElement(self::GIFT_IDS))
				->setGifts($gifts)
				->setLabel('Contreparties')
			)
			->add((new Submit(self::SUBMIT))
				->setAttribute('class', 'btn btn-primary')
				->setAttribute('value', 'Créer')
			);

		$this->setDefaultInputFilters();
	}

	protected function setDefaultInputFilters()
	{
		$pictureExtensionValidator = new Extension('jpg,png');
		$pictureSizeValidator      = new Size('1MB');

		$this->setInputFilter((new InputFilter())
			->add($this->createInputFilter(self::TITLE, true, [(new StringLength())->setMax(80)]))
			->add($this->createInputFilter(self::SUBTITLE, true, [(new StringLength())->setMax(90)]))
			->add($this->createInputFilter(self::DESCRIPTION, true, [(new StringLength())->setMax(10000)]))
			->add($this->createInputFilter(self::MAINPICTURE, true, [$pictureExtensionValidator, $pictureSizeValidator]))
			->add($this->createInputFilter(self::GOAL, true, [new LessThan(['max' => 1000000])]))
			->add($this->createInputFilter(self::DEADLINE, true, [(new \Zend\Validator\Date())->setFormat(DateFormatter::FORMAT_FR)]))
			->add($this->createInputFilter(self::CATEGORY_IDS))
			->add($this->createInputFilter(self::PICTURE_IDS, false, [$pictureExtensionValidator, $pictureSizeValidator]))
			->add($this->createInputFilter(self::VIDEO_IDS, false, [new Extension('mp4'), new Size('1MB')]))
		);
	}
}