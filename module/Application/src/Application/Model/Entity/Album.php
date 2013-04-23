<?php
	namespace Application\Model\Entity;
	use Doctrine\ORM\Mapping as ORM;
	
	/** 
	 * @ORM\Entity 
	 * @ORM\Table(name="album")
	 */
	
	class Album {
		/**
		* @ORM\Id
		* @ORM\GeneratedValue(strategy="AUTO")
		* @ORM\Column(columnDefinition="integer unsigned")
		*/
		protected $id;

		/** @ORM\Column(type="string", length=32) */
		protected $artist;
		
		/** @ORM\Column(type="string", length=32) */
		protected $title;

		public function getId() 
		{
			return $this->id;
		}
		
		/**
		 * @return String
		 */
		public function getArtist() 
		{
			return $this->artist;
		}

		/**
		 * @param type $artist
		 * @return \Application\Entity\User
		 */
		public function setArtist($artist) 
		{
			$this->artist = $artist;
			
			return $this;
		}

		/**
		 * @return String
		 */
		public function getTitle() 
		{
			return $this->title;
		}

		/**
		 * @param String $title
		 * @return \Application\Model\Entity\User
		 */
		public function setTitle($title) 
		{
			$this->title = $title;
			
			return $this;
		}
	}