<?php
	namespace Application\Model\Entity;
	use Doctrine\ORM\Mapping as ORM;
	
	/** 
	 * @ORM\Entity(repositoryClass="Application\Model\Repository\Artist") 
	 * @ORM\Table(
	 *	name="artist", 
	 *	indexes = {
	 *		@ORM\Index(name="artist_name_idx", columns={"name"}), 
	 *		@ORM\Index(name="artist_birthday_idx", columns={"birthday"})}
	 *)
	 */
	class Artist {
		/**
		* @ORM\Id
		* @ORM\GeneratedValue(strategy="AUTO")
		* @ORM\Column(type="integer")
		*/
		protected $id;

		/** @ORM\Column(type="string", length=32, nullable=false) */
		protected $name;
		
		/** @ORM\Column(type="datetime", nullable=false) */
		protected $birthday;
		
		public function getId() 
		{
			return $this->id;
		}
		
		/**
		 * @return String
		 */
		public function getName() 
		{
			return $this->name;
		}

		/**
		 * @param type $name
		 * @return \Application\Entity\Artist
		 */
		public function setName($name) 
		{
			$this->name = $name;
			
			return $this;
		}

		/**
		 * @return \DateTime
		 */
		public function getBirthday() 
		{
			return $this->birthday;
		}

		/**
		 * @param String $title
		 * @return \Application\Model\Entity\Artist
		 */
		public function setBirthday(\DateTime $birthday) 
		{
			$this->birthday = $birthday;
			
			return $this;
		}
	}