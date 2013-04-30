<?php
	/**
	 * @namespace
	 */
	namespace Admin\Acl;

	/**
	 * @uses Zend\Mvc\Controller\Plugin\AbstractPlugin
	 * @uses Zend\Authentication\AuthenticationService
	 * @uses Zend\Authentication\Adapter\DbTable
	 */
	use 
		Zend\Authentication\AuthenticationService as ZendAuthService,
		Zend\Log\Logger,
		DoctrineModule\Authentication\Storage\ObjectRepository as BaseObjectRepository;

	/**
	 * Class for User Authentication
	 *
	 * Handles Auth Adapter and Auth Service to check Identity
	 *
	 * @category   Admin
	 * @package    Admin\Acl
	*/
	final class ObjectRepository extends BaseObjectRepository 
	{
		/**
		* This function assumes that the storage only contains identifier values (which is the case if
		* the ObjectRepository authentication adapter is used).
		*
		* @return null|object
		*/
	   public function read()
	   {
		   if (($identity = $this->options->getStorage()->read())) {
			   return $this->options->getObjectRepository()->findById($identity['id']);
		   }

		   return null;
	   }
	}