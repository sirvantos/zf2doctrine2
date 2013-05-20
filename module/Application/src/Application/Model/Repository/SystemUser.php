<?php
	namespace Application\Model\Repository;

	use 
		Application\Utility\Cache,
		Application\Model\CacheManageable,
		DoctrineModule\Authentication\Adapter\ObjectRepository,
		Doctrine\ORM\Query\Expr,
		Doctrine\ORM\EntityRepository;

	/**
	 * SystemUser
	 *
	 * This class was generated by the Doctrine ORM. Add your own custom
	 * repository methods below.
	 */
	final class SystemUser extends EntityRepository implements CacheManageable
	{
		/**
		 * @param Integer $id
		 * @return Application\Model\Entity\SystemUser
		 */
		public function findById($id)
		{
			$qb = $this->makeSelectQuery();
			
			$query = 
				$qb->
					where('u.id = :id')->
					setParameter(':id', $id)->
					getQuery();
			
			Cache::setCacheForQuery(
				$query, 
				array(
					'meta'		=> $this->getClassMetadata(), 
					//'method'	=> __FUNCTION__, 
					'args'		=> array('id' => $id)
				)
			);
			
			return $query->getOneOrNullResult();
		}
		
		public function findByUsername($username)
		{
			$qb = $this->makeSelectQuery();
			
			$query =
				$qb->
					where('u.username = :username')->
					setParameter(':username', $username)->
					getQuery();
			
			Cache::setCacheForQuery(
				$query, 
				array(
					'meta'		=> $this->getClassMetadata(), 
					//'method'	=> __FUNCTION__, 
					'args'		=> array('username' => $username)
				)
			);
			
			return $query->getOneOrNullResult();
		}
		
		/**
		 * @param String $email
		 * @return Application\Model\Entity\SystemUser
		 */
		public function findByEmail($email)
		{
			$qb = $this->makeSelectQuery();
			
			$query =
				$qb->
					where('u.email = :email')->
					setParameter(':email', $email)->
					getQuery();
			
			Cache::setCacheForQuery(
				$query, 
				array(
					'meta'		=> $this->getClassMetadata(), 
					//'method'	=> __FUNCTION__, 
					'args'		=> array('email' => $email)
				)
			);
			
			return $query->getOneOrNullResult();
		}
		
		public function dropSingle($entity)
		{
			Cache::dropSingle(
				$this->_em->getConfiguration()->getResultCacheImpl(), 
				array(
					'meta'		=> $this->getClassMetadata(), 
					//'method'	=> __FUNCTION__, 
					'argsForRemove' => array(
						array(
							'args' => array('email' => $entity->getEmail())
						),
						array(
							'args' => array('username' => $entity->getUsername())
						),
						array(
							'args' => array('id' => $entity->getId())
						)
					)
				)
			);
		}
		
		public function dropLists()
		{
			
		}
		
		public function fullDrop() 
		{
			
		}
		
		/**
		 * @return Doctrine\ORM\Query
		 */
		private function makeSelectQuery()
		{
			return
				$this->
					createQueryBuilder('u')->
						select(array('u', 'r'))->
						leftJoin('u.roles', 'r');
		}
	}