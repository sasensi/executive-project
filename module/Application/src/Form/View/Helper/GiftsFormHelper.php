<?php
/**
 * Created by: STAGIAIRE
 * the 04/11/2016
 */

namespace Application\Form\View\Helper;


use Application\Form\Element\GiftsFormElement;
use Application\Model\Gift;
use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormInput;

class GiftsFormHelper extends FormInput
{
	public function render(ElementInterface $element)
	{
		/* @var GiftsFormElement $element */

		if (!$element instanceof GiftsFormElement)
		{
			throw new \InvalidArgumentException(sprintf(
				'%s requires that the element is of type '.GiftsFormElement::class,
				__METHOD__
			));
		}

		$giftsContent = '';
		foreach ($element->getGifts() as $i => $gift)
		{
			$giftsContent .= $this->renderGift($gift, $i, $element);
		}

		return <<<HTML
<div class="giftsWrapper" data-name="{$element->getName()}">
	{$giftsContent}
	<span class="giftsAddButton btn btn-default">Ajouter</span>
</div>
HTML;
	}

	/**
	 * @param Gift             $gift
	 * @param int              $i
	 * @param GiftsFormElement $element
	 * @return string
	 */
	public function renderGift($gift, $i, $element)
	{
		$titleName       = "{$element->getName()}[{$i}][title]";
		$amountName      = "{$element->getName()}[{$i}][minamount]";
		$descriptionName = "{$element->getName()}[{$i}][description]";

		$displayIndex = $i+1;

		return <<<HTML
<fieldset data-index="{$i}">
    <legend>Contrepartie n°{$displayIndex}</legend>
    <div class="form-group row">
        <label class="col-sm-2 control-label" for="$titleName">Titre</label>
        <div class="col-sm-10">
            <input class="form-control" type="text" name="$titleName" id="$titleName" value="{$gift->title}"/>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 control-label" for="{$amountName}">Montant minimum</label>
        <div class="col-sm-10">
            <input class="form-control" type="number" name="{$amountName}" id="{$amountName}" value="{$gift->minamount}"/>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 control-label" for="{$descriptionName}">Description</label>
        <div class="col-sm-10">
            <textarea class="form-control" type="text" name="{$descriptionName}" id="{$descriptionName}" value="{$gift->description}"></textarea>
        </div>
    </div>
    <span class="giftDeleteButton btn btn-danger">Supprimer</span>
</fieldset>
		
HTML;
	}
}