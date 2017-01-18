<?php
/**
 * Created by: STAGIAIRE
 * the 18/01/2017
 */

namespace Ulule;

class Projects
{
	protected $url;

	public function __construct($url)
	{
		$this->url = $url;
	}

	public function build()
	{
		echo 'parsing: '.$this->url.PHP_EOL;

		$curl  = new CustomCurl();
		$xpath = $curl->getXpath($this->url);

		/**
		 * @var \DOMElement[] $items
		 */
		$items = $xpath->query("//div[contains(concat(' ', normalize-space(@class), ' '), ' title ')]/a");

		foreach ($items as $item)
		{
			$project = new Project($item->getAttribute('href'));
			$project->build();
		}
	}
}