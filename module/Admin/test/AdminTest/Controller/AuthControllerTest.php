<?php
	namespace AdminTest\Controller;

	use 
		Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase,
		DoctrineModule\Authentication\Adapter\ObjectRepository AS ObjectRepositoryAdapter,
		Zend\Authentication\AuthenticationService,
		Application\Model\Entity\SystemUser;

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
			
			$this->assertResponseStatusCode(200);
		}
		
		public function testAuthorizationSuccessed()
		{
			$postData = array(
				'email'		=> 'sirvantos@gmail.com', 
				'password'	=> 'qwerty'
			);
			
			$this->prepareAuthEnv($postData);
			
			$this->dispatch('/admin/auth/login', 'POST', $postData);
			
			$this->assertRedirectTo('/admin/news');
		}
		
		public function testAuthorizationFails()
		{
			$postData = array(
				'email'		=> 'sirvantos@gmail.com', 
				'password'	=> 'qwerty111'
			);
			
			$this->prepareAuthEnv($postData);
			
			$this->dispatch('/admin/auth/login', 'POST', $postData);
			
			$this->assertNotRedirect();
			
			$this->assertXpathQueryContentContains(
				'//body[@id="body"]//div[@class="error"]/text()', 
				'Wrong password or email'
			);
		}
		
		/**
		 * @return \AdminTest\Controller\AuthControllerTest
		 */
		private function prepareAuthEnv(Array $env)
		{
			$systemUser = new SystemUser();
			
			$systemUser->
				setEmail('sirvantos@gmail.com')->
				setFisrtName('Vlad')->
				setLastName('Alt')->
				setUsername('sirvantos')->
				setPassword(crypt('qwerty'));
			
			$objectRepository =  $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
			$method = 
				$objectRepository->
					expects($this->exactly(1))->
					method('findOneBy')->
					with($this->equalTo(array('email' => $env['email'])))->
					will($this->returnValue($systemUser));

			$objectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
			$objectManager->
				expects($this->exactly(1))->
				method('getRepository')->
				with($this->equalTo('Application\Model\Entity\SystemUser'))->
				will($this->returnValue($objectRepository));

			$adapter = new ObjectRepositoryAdapter();
			$adapter->setOptions(array(
				'object_manager'		=> $objectManager,
				'identity_class'		=> 'Application\Model\Entity\SystemUser',
				'credential_property'	=> 'password',
				'identity_property'		=> 'email',
				'credential_callable'	=> 'Application\Model\Entity\SystemUser::hashPassword'
			));

			$adapter->setIdentityValue('sirvantos@gmail.com');
			$adapter->setCredentialValue('qwerty');
			
			$serviceManager = $this->getApplicationServiceLocator();
			$serviceManager->setAllowOverride(true);
			$serviceManager->setService(
				'authService', 
				new AuthenticationService(
					$serviceManager->get('doctrine.authenticationstorage.orm_default'),
					$adapter
				)	
			);
			
			return $this;
		}
	}