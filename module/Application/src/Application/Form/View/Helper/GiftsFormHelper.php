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

		return <<<HTML

<fieldset data-index="{$i}">
	<span class="giftDeleteButton btn btn-danger">Supprimer</span>
    <div class="">
        <label for="$titleName">Titre</label>
        <input type="text" name="$titleName" id="$titleName" value="{$gift->title}" />
    </div>
    <div class="">
        <label for="{$amountName}">Montant minimum</label>
        <input type="number" name="{$amountName}" id="{$amountName}" value="{$gift->minamount}" />
    </div>
    <div class="">
        <label for="{$descriptionName}">Description</label>
        <input type="text" name="{$descriptionName}" id="{$descriptionName}" value="{$gift->description}" />
    </div>
</fieldset>
		
HTML;
	}
}