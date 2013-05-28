<?php
	namespace Application\Model\Entity;
	
	use 
		Application\Utility\Time as TimeUtil,
		BjyAuthorize\Provider\Role\ProviderInterface,
		ZfcUser\Entity\UserInterface,
		Doctrine\ORM\Mapping as ORM, 
		Doctrine\Common\Collections\ArrayCollection,
		Zend\Crypt\Password\Bcrypt,
		Zend\InputFilter\InputFilterAwareInterface,
		Zend\Form\Annotation,
		Zend\InputFilter\InputFilterInterface;
	
	/** 
	 * @ORM\Entity(repositoryClass="Application\Model\Repository\SystemUser") 
	 * @ORM\HasLifecycleCallbacks  
	 * @ORM\Table(
	 *		name="system_user", 
	 *		indexes = {
	 *			@ORM\Index(name="system_user_email_password_idx", columns={"email", "password"})
	 *		}
	 *)
	 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
	 */
	class SystemUser implements UserInterface, ProviderInterface, InputFilterAwareInterface 
	{
		const PASSWORD_COST = 14;
		
		/**
		* @ORM\Id
		* @ORM\GeneratedValue(strategy="IDENTITY")
		* @ORM\Column(type="integer")
		* @Annotation\Type("Zend\Form\Element\Hidden")
		* @Annotation\Attributes({"type":"hidden"})
		*/
		protected $id;

		/** 
		 * @ORM\Column(type="string", length=128, nullable=false, unique=true) 
		 * @Annotation\Type("Zend\Form\Element\Email")
		 * @Annotation\Options({"label":"Email:"})
		 */
		protected $email;
		
		/** 
		 * @ORM\Column(type="string", length=128, nullable=false) 
		 * @Annotation\Type("Zend\Form\Element\Password")
		 * @Annotation\Options({"label":"password:"})
		 */
		protected $password;
		
		/** 
		 * @ORM\Column(type="string", length=128, nullable=false, unique=true) 
		 * @Annotation\Type("Zend\Form\Element\Text")
		 * @Annotation\Options({"label":"Username:"})
		 */
		protected $username;
		
		/** 
		 * @ORM\Column(name="first_name", type="string", length=128, nullable=true) 
		 * @Annotation\Type("Zend\Form\Element\Text") 
		 * @Annotation\Options({"label":"Firstname:"})
		 */
		protected $firstName;
		
		/** 
		 * @ORM\Column(name="last_name",type="string", length=128, nullable=true) 
		 * @Annotation\Type("Zend\Form\Element\Text")
		 * @Annotation\Options({"label":"Lastname:"})
		 */
		protected $lastName;
		
		/**
		* @var int
		* @Annotation\Exclude()
		*/
		protected $state;
		
		/**
		* @var \Doctrine\Common\Collections\Collection
		* @ORM\ManyToMany(targetEntity="Application\Model\Entity\Role")
		* @ORM\JoinTable(name="user_role_linker",
		*      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
		*      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
		* )
		* @Annotation\Type("Zend\Form\Element\Select")
		* @Annotation\Options({"label":"Role:"})
		*/
		protected $roles;
		
		/** 
		 * @ORM\Column(type="datetime", nullable=false) 
		 * @Annotation\Exclude()
		 */
		protected $created;
		
		/**
		 * @var InputFilterInterface
		 * @Annotation\Exclude()  
		 */
		protected $inputFilter = null;
		
		/**
		 * @var Integer
		 * @Annotation\Exclude()  
		 */
		protected $roleId = null;


		/** @ORM\PrePersist 
		 * @return SystemUser
		 */
		public function setCreatedTime()
		{
			$this->created = TimeUtil::makeCurrentDate();
			
			return $this;
		}
		
		/** @ORM\PrePersist 
		 * @return SystemUser
		 */
		public function setHashedPassword()
		{
			$bcrypt = new Bcrypt();
			
			$this->password = 
				$bcrypt->
					setCost(self::PASSWORD_COST)->
					create($this->password);
			
			return $this;
		}
		
		public function __construct()
		{
			$this->roles = new ArrayCollection();
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
		* @return SystemUser
		*/
		public function setRoles($id)
		{
			$this->roleId = $id;
			
			return $this;
		}
		
		/**
		* Get role.
		*
		* @return SystemUser
		*/
		public function getRoleId()
		{
			return $this->roleId;
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
			$this->roles->add($role);
			
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
			return $this->created;
		}
		
		/**
		* Set input filter
		*
		* @param  InputFilterInterface $inputFilter
		* @return InputFilterAwareInterface
		*/
		public function setInputFilter(InputFilterInterface $inputFilter)
		{
			$this->inputFilter = $inputFilter;
			
			return $this;
		}

	   /**
		* Retrieve input filter
		*
		* @return InputFilterInterface
		*/
		public function getInputFilter()
		{
			return $this->inputFilter;
		}
	}