<?php
	namespace Admin\Acl;
	
	use 
		DoctrineModule\Service\AbstractFactory, 
		Zend\ServiceManager\ServiceLocatorInterface;
	
	/**
	 * Auth factory
	 *
	 * @author sirvantos
	 */
	final class AuthenticationFactory extends AbstractFactory
	{
		/**
		*
		* @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
		* @return AuthenticationService
		*/
	   public function createService(ServiceLocatorInterface $serviceLocator)
	   {
		   $as =  new AuthenticationService(
			   $serviceLocator->get('doctrine.authenticationstorage.' . $this->getName()),
			   $serviceLocator->get('doctrine.authenticationadapter.' . $this->getName())
		   );
		   
		   $as->
				setLogger($serviceLocator->get('logger'))->
				setEntityManager($serviceLocator->get('em'));
		   
		   return $as;
	   }

	   public function getOptionsClass()
	   {}
	}
