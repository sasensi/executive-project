<?php
/**
 * Created by: STAGIAIRE
 * the 18/01/2017
 */

namespace Ulule;


use Curl\Curl;

class CustomCurl extends Curl
{
	public function __construct()
	{
		parent::__construct();

		$this->setOpt(CURLOPT_FOLLOWLOCATION, true);
		$this->setOpt(CURLOPT_SSL_VERIFYHOST, false);
		$this->setOpt(CURLOPT_SSL_VERIFYPEER, false);
		$this->setOpt(CURLOPT_HEADER, false);
	}

	public function getXpath($url)
	{
		$this->get($url);

		if ($this->error || $this->isError())
		{
			throw new \Exception($this->error_message);
		}

		libxml_use_internal_errors(true);

		$document = new \DOMDocument();
		$document->loadHTML($this->response);
		return new \DOMXPath($document);
	}
}