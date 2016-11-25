<?php
/**
 * Created by: STAGIAIRE
 * the 25/11/2016
 */

namespace Application\test\ApplicationTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class ProjectControllerTest extends AbstractHttpControllerTestCase
{
	public function setUp()
	{
		$this->setApplicationConfig(
			include __DIR__.'/../../../../../config/application.config.php'
		);
		parent::setUp();
	}

	public function testIndexActionCanBeAccessed()
	{
		$this->dispatch('/project');

		$this->assertModuleName('Application');
	}
}