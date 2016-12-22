<?php
/**
 * Created by: STAGIAIRE
 * the 21/12/2016
 */

namespace Application\Form\Validator;


use libphonenumber\PhoneNumberUtil;
use Zend\Validator\AbstractValidator;
use Zend\Validator\Exception;

class PhoneValidator extends AbstractValidator
{
	/**
	 * Returns true if and only if $value meets the validation requirements
	 *
	 * If $value fails validation, then this method returns false, and
	 * getMessages() will return an array of messages that explain why the
	 * validation failed.
	 *
	 * @param  mixed $value
	 * @return bool
	 * @throws Exception\RuntimeException If validation of $value is impossible
	 */
	public function isValid($value)
	{
		$phoneUtil = PhoneNumberUtil::getInstance();
		try
		{
			$phoneNumber = $phoneUtil->parse($value, 'FR');
			return $phoneUtil->isValidNumber($phoneNumber);
		}
		catch (\libphonenumber\NumberParseException $e)
		{
			return false;
		}
	}
}