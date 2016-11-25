<?php
/**
 * Created by: STAGIAIRE
 * the 25/11/2016
 */

namespace Application\Util;


use Zend\Http\PhpEnvironment\Request;

class UrlForwarderTest extends \PHPUnit_Framework_TestCase
{
	public function testGetSet()
	{
		$request = new Request();

		$currentUrl = 'http://www.site.com/directory/page.php?p1=v1&p2=v2';
		$target     = 'http://www.test.com/test/test.php?param1=value1&param2=value2';

		$request->setUri($currentUrl);

		$parsedUrl = UrlForwarder::storeTargetInUrl($request, $target);

		$this->assertEquals($target, UrlForwarder::getTargetFromUrl($parsedUrl));
	}
}
