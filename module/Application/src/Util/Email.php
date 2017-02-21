<?php
/**
 * Created by PhpStorm.
 * User: sam
 * Date: 21/02/2017
 * Time: 15:26
 */

namespace Application\Util;


use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Part;

class Email
{
	/**
	 * @param string $to target email adress
	 * @param string $subject
	 * @param string $htmlBody
	 * @throws \Exception
	 */
	public static function send($to, $subject, $htmlBody)
	{
		$html       = new Part($htmlBody);
		$html->type = "text/html";

		$body = new \Zend\Mime\Message();
		$body->setParts([$html]);

		$message = new Message();
		$message->setEncoding("UTF-8")
		        ->addTo($to)
		        ->addFrom('contact@iap.com')
		        ->setSubject($subject)
		        ->setBody($body);

		$transport = new Smtp();
		$options   = new SmtpOptions([
			'host'              => 'smtp.mailtrap.io',
			'connection_class'  => 'crammd5',
			'connection_config' => [
				'username' => '849b71e185fb13',
				'password' => '1d2caa3226388e',
			],
			'port'              => 2525,
		]);

		$transport->setOptions($options);
		$transport->send($message);
	}
}