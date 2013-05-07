<?php
	namespace Admin\Acl;
	
	use 
		BjyAuthorize\Provider\Identity\ProviderInterface,
		ZfcUser\Service\User,
		Zend\Permissions\Acl\Role\RoleInterface,
		BjyAuthorize\Exception\InvalidRoleException,
		Doctrine\ORM\EntityRepository;
	
	/**
	 * Description of UserRoles
	 *
	 * @author sirvantos
	 */
	class UserRoles implements ProviderInterface
	{
		/**
		 * @var Doctrine\ORM\EntityRepository
		 */
		private $repository = null;
		
		/**
		 * @var ZfcUser\Service\User 
		 */
		private $userService = null;
		
		public function __construct(EntityRepository $repository, User $userService) 
		{
			$this->repository	= $repository;
			$this->userService	= $userService;
		}
		
		public function getIdentityRoles()
		{
			$authService = $this->userService->getAuthService();

			if (!$authService->hasIdentity()) 
				return array($this->getDefaultRole());
			
			$roles = array();
			
			foreach ($authService->getIdentity()->getRoles() as $role) {
				$roles[] = $role->getId();
			}
			
			return $roles;
		}
		
		/**
		* @return string|\Zend\Permissions\Acl\Role\RoleInterface
		*/
		public function getDefaultRole()
		{
			return $this->defaultRole;
		}

	   /**
		* @param string|\Zend\Permissions\Acl\Role\RoleInterface $defaultRole
		*
		* @throws \BjyAuthorize\Exception\InvalidRoleException
	    * 
	    * @return UserRoles
		*/
		public function setDefaultRole($defaultRole)
		{
			if ( ! ($defaultRole instanceof RoleInterface || is_string($defaultRole))) {
				throw InvalidRoleException::invalidRoleInstance($defaultRole);
			}

			$this->defaultRole = $defaultRole;
			
			return $this;
		}
	}