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
		Doctrine\ORM\EntityManager;

	/**
	 * Class for User Authentication
	 *
	 * Handles Auth Adapter and Auth Service to check Identity
	 *
	 * @category   Admin
	 * @package    Admin\Controller\Plugin
	*/

	final class AuthenticationService extends ZendAuthService 
	{
		/**
		 * @var Logger 
		 */
		private $logger;
		
		/**
		 * @var EntityManager
		 */
		private $em;

		public function getIdentityObj()
		{
			if ($this->hasIdentity()) {
				try {
					return $this->loadIdentityObj($this->getIdentityObj());
				} catch (\RuntimeException $e)  {
					$this->logger->log($e);
				}
			}
			
			return null;
		}
		
		public function setLogger(Logger $logger)
		{
			$this->logger = $logger;
			
			return $this;
		}
		
		public function setEntityManager(EntityManager $entityManager)
		{
			$this->em = $entityManager;
			
			return $this;
		}
		
		private function loadIdentityObj($id)
		{
			$repo = $this->em->getRepository(
				'Application\Model\Entity\SystemUser'
			);
			
			if ($obj = $repo->findOneById($id))
				return $obj;
			else
				throw \RuntimeException(
					'Knows nothing about entity with id >>' . $id . '<<'
				);
		}
	}