<?php
	namespace AdminTest\Controller;

	use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

	class AuthControllerTest extends AbstractHttpControllerTestCase
	{
		public function setUp()
		{
			$this->setApplicationConfig(include 'TestConfig.php.dist');
			
			parent::setUp();
		}
		
		public function testIndexActionCanBeAccessed()
		{
			$this->dispatch('/admin/auth');
			$this->assertRedirect();
			
			$this->assertRedirectTo('/admin/auth/login');
			
			$this->reset();
			
			$this->dispatch('/admin/auth/login');
			
			$this->assertModuleName('admin');
			$this->assertControllerName('Admin\Controller\Auth');
			$this->assertControllerClass('AuthController');
			$this->assertActionName('login');
		}
	}