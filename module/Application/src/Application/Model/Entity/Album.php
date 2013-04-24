<?php
	namespace Application\Model\Entity;
	
	use 
		Doctrine\ORM\Mapping as ORM, 
		Doctrine\Common\Collections\ArrayCollection;
	
	/** 
	 * @ORM\Entity 
	 * @ORM\Table(
	 *		name="album", 
	 *		indexes = {
	 *			@ORM\Index(name="album_title_idx", columns={"title"}), 
	 *			@ORM\Index(name="album_length_idx", columns={"length"})
	 *		}
	 *)
	 */
	class Album {
		/**
		* @ORM\Id
		* @ORM\GeneratedValue(strategy="AUTO")
		* @ORM\Column(columnDefinition="integer unsigned")
		*/
		protected $id;

		/** @ORM\Column(type="string", length=32, nullable=false) */
		protected $title;
		
		/** @ORM\Column(columnDefinition="smallint unsigned", nullable=false) */
		protected $length;
		
		/** 
		 * @ORM\ManyToMany(targetEntity="Artist") 
		 * @ORM\JoinTable(
		 *		name="album_artist",
		 *		joinColumns={@ORM\JoinColumn(name="album_id", referencedColumnName="id")},
		 *		inverseJoinColumns={@ORM\JoinColumn(name="artist_id", referencedColumnName="id")}
		 * )
		 */
		protected $artists;
		
		public function __construct() 
		{
			$this->artists = new ArrayCollection();
		}
		
		public function getId() 
		{
			return $this->id;
		}
		
		/**
		 * @return String
		 */
		public function getLength() 
		{
			return $this->length;
		}

		/**
		 * @param type $artist
		 * @return \Application\Entity\User
		 */
		public function setLength($length) 
		{
			$this->length = $length;
			
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
		
		/**
		 * @param \Doctrine\Common\Collections\ArrayCollection $artists
		 * @return \Application\Model\Entity\Album
		 */
		public function setArtists(ArrayCollection $artists)
		{
			$this->artists = $artists;
			
			return $this;
		}
		
		/**
		 * @return Doctrine\Common\Collections\ArrayCollection
		 */
		public function getArtists()
		{
			return $this->artists;
		}
	}