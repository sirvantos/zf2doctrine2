<?php
	namespace Admin\Acl;
	
	use 
		ZfcUser\Mapper\UserInterface,
		Doctrine\ORM\EntityManager,
		Doctrine\ORM\EntityRepository,
		Application\Model\Entity\SystemUser;
	
	/**
	 * Description of UserMapper
	 *
	 * @author sirvantos
	 */
	final class UserMapper implements UserInterface
	{
		/**
		 * @var EntityManager
		 */
		private $em = null;
		
		/**
		 * @var EntityRepository
		 */
		private $repo = null;
		
		public function __construct(EntityManager $em) 
		{
			$this->em	= $em;
			$this->repo	= $em->getRepository(
				'Application\Model\Entity\SystemUser'
			);
		}
		
		/**
		 * @param Integer Email
		 * @return Application\Model\Entity\SystemUser
		 */
		public function findByEmail($email)
		{
			return $this->repo->findByEmail($email);
		}
		
		public function findByUsername($username)
		{
			throw new \RuntimeException(__METHOD__ . ' is not implemented');
		}
		
		/**
		 * @param Integer $id
		 * @return Application\Model\Entity\SystemUser
		 */
		public function findById($id)
		{
			return $this->repo->findById($id);
		}
		
		/**
		 * @param SystemUser $user
		 * @return Admin\Acl\UserMapper
		 */
		public function insert($user)
		{
			$this->em->persist($user);
			
			$this->em->flush();
			
			return $this;
		}
		
		/**
		 * @param SystemUser $user
		 * @return Admin\Acl\UserMapper
		 */
		public function update($user)
		{
			$this->em->persist($user);
			
			$this->em->flush();
			
			return $this;
		}
	}