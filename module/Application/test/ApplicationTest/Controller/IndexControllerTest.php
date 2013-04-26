<?php
	namespace ApplicationTest\Controller;

	use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

	class AuthControllerTest extends AbstractHttpControllerTestCase
	{
		public function setUp()
		{
			$this->setApplicationConfig(
				//include '../../../config/application.config.php'
				include 'TestConfig.php.dist'
			);
			
			parent::setUp();
		}
		
		public function testIndexActionCanBeAccessed()
		{
			$this->dispatch('index/auth');
			$this->assertResponseStatusCode(200);

			$this->assertModuleName('Album');
			$this->assertControllerName('Album\Controller\Album');
			$this->assertControllerClass('AlbumController');
			$this->assertMatchedRouteName('album');
		}
	}