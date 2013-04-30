<?php
	namespace Admin\Acl;
	
	use 
		DoctrineModule\Service\AbstractFactory,
		Zend\ServiceManager\ServiceLocatorInterface,
		Zend\Authentication\AuthenticationService;
	
	/**
	 * Auth factory
	 *
	 * @author sirvantos
	 */
	final class AuthenticationServiceFactory extends AbstractFactory
	{
		/**
		*
		* @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
		* @return AuthenticationService
		*/
	   public function createService(ServiceLocatorInterface $serviceLocator)
	   {
		   return new AuthenticationService(
			   $serviceLocator->get('authenticationStorage'),
			   $serviceLocator->get('doctrine.authenticationadapter.' . $this->getName())
		   );
	   }

	   public function getOptionsClass()
	   {}
	}