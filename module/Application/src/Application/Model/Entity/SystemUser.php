<?php
	namespace Application\Model\Entity;
	
	use 
		Application\Utility\Time as TimeUtil,
		Admin\Acl\Acl,
		Doctrine\ORM\Mapping as ORM, 
		Doctrine\Common\Collections\ArrayCollection;
	
	/** 
	 * @ORM\Entity(repositoryClass="Application\Model\Repository\SystemUser") 
	 * @ORM\HasLifecycleCallbacks  
	 * @ORM\Table(
	 *		name="system_user", 
	 *		indexes = {
	 *			@ORM\Index(name="system_user_email_password_idx", columns={"email", "password"})
	 *		}
	 *)
	 */
	class SystemUser {
		/**
		* @ORM\Id
		* @ORM\GeneratedValue(strategy="AUTO")
		* @ORM\Column(type="integer")
		*/
		protected $id;

		/** @ORM\Column(type="string", length=128, nullable=false, unique=true) */
		protected $email;
		
		/** @ORM\Column(type="string", length=128, nullable=false) */
		protected $password;
		
		/** @ORM\Column(type="string", length=128, nullable=false, unique=true) */
		protected $username;
		
		/** @ORM\Column(name="first_name", type="string", length=128, nullable=true) */
		protected $fisrtName;
		
		/** @ORM\Column(name="last_name",type="string", length=128, nullable=true) */
		protected $lastName;
		
		/** @ORM\Column(name="role",type="string", length=16, nullable=false) */
		protected $role = Acl::ROLE_GUEST;
		
		/** @ORM\Column(type="datetime", nullable=false) */
		protected $created;
		
		public static function hashPassword($entity, $credentialValue)
		{
			return crypt($credentialValue, $entity->getPassword());
		}
		
		/** @ORM\PrePersist */
		public function setCreatedTime()
		{
			$this->created = TimeUtil::makeCurrentDate();
		}
		
		public function getId() 
		{
			return $this->id;
		}
		
		/**
		 * @return String
		 */
		public function getEmail() 
		{
			return $this->email;
		}

		/**
		 * @param String $email
		 * @return \Application\Model\Entity\SystemUser
		 */
		public function setEmail($email) 
		{
			$this->email = $email;
			
			return $this;
		}

		/**
		 * @return String
		 */
		public function getPassword() 
		{
			return $this->password;
		}

		/**
		 * @param String $password
		 * @return \Application\Model\Entity\SystemUser
		 */
		public function setPassword($password) 
		{
			$this->password = $password;
			
			return $this;
		}

		/**
		 * @return String
		 */
		public function getUsername() 
		{
			return $this->username;
		}

		/**
		 * @param type String
		 * @return \Application\Model\Entity\SystemUser
		 */
		public function setUsername($username) 
		{
			$this->username = $username;
			
			return $this;
		}

		/**
		 * @return String
		 */
		public function getFisrtName() 
		{
			return $this->fisrtName;
		}

		/**
		 * @param String $fisrtName
		 * @return \Application\Model\Entity\SystemUser
		 */
		public function setFisrtName($fisrtName) 
		{
			$this->fisrtName = $fisrtName;
			
			return $this;
		}

		/**
		 * @return String
		 */
		public function getLastName() 
		{
			return $this->lastName;
		}

		/**
		 * @param String $lastName
		 * @return \Application\Model\Entity\SystemUser
		 */
		public function setLastName($lastName) 
		{
			$this->lastName = $lastName;
			
			return $this;
		}
		
		/**
		 * @param String $role
		 * @return \Application\Model\Entity\SystemUser
		 */
		public function setRole($role)
		{
			$this->role = $role;
			
			return $this;
		}

		/**
		 * @return String
		 */
		public function getRole()
		{
			return $this->role;
		}
		
		/**
		 * @return \DateTime
		 */
		public function getCreated() 
		{
			return new \DateTime ($this->created);
		}
	}