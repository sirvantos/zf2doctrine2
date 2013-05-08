<?php
	namespace Application\Model\Entity;
	
	use 
		Application\Utility\Time as TimeUtil,
		Admin\Acl\Acl,
		BjyAuthorize\Provider\Role\ProviderInterface,
		ZfcUser\Entity\UserInterface,
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
	class SystemUser implements UserInterface, ProviderInterface {
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
		protected $firstName;
		
		/** @ORM\Column(name="last_name",type="string", length=128, nullable=true) */
		protected $lastName;
		
		/**
		* @var int
		*/
		protected $state;
		
		/**
		* @var \Doctrine\Common\Collections\Collection
		* @ORM\ManyToMany(targetEntity="Application\Model\Entity\Role")
		* @ORM\JoinTable(name="user_role_linker",
		*      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
		*      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
		* )
		*/
		protected $roles;
		
		/** @ORM\Column(type="datetime", nullable=false) */
		protected $created;
		
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
		 * @param Integer $id
		 * @return \Application\Model\Entity\SystemUser
		 */
		public function setId($id)
		{
			$this->id = $id;
			
			return $this;
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
		public function getFirstName() 
		{
			return $this->firstName;
		}

		/**
		 * @param String $firstName
		 * @return \Application\Model\Entity\SystemUser
		 */
		public function setFirstName($firstName) 
		{
			$this->firstName = $firstName;
			
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
		
		public function getDisplayName() 
		{
			return $this->getFirstName() . ' ' . $this->getLastName();
		}
		
		public function setDisplayName($displayName)
		{
			throw new \RuntimeException(__METHOD__ . ' is not invokeable');
		}
		
		/**
		* Get role.
		*
		* @return array
		*/
		public function getRoles()
		{
			return $this->roles->getValues();
		}
		
		/**
		* Add a role to the user.
		*
		* @param Role $role
		*
		* @return \Application\Model\Entity\SystemUser
		*/
		public function addRole($role)
		{
			$this->roles[] = $role;
			
			return $this;
		}
		
		 /**
		* Get state.
		*
		* @return int
		*/
		public function getState()
		{
			return $this->state;
		}

	   /**
		* Set state.
		*
		* @param int $state
		*
		* @return \Application\Model\Entity\SystemUser
		*/
		public function setState($state)
		{
			$this->state = $state;
			
			return $this;
		}
		
		/**
		 * @return \DateTime
		 */
		public function getCreated() 
		{
			return new \DateTime ($this->created);
		}
	}