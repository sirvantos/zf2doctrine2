<?php

	/*
	 * To change this template, choose Tools | Templates
	 * and open the template in the editor.
	 */
	use 
		Zend\Db\TableGateway\TableGateway,
		Application\Bootstrap,
		Doctrine\Common\Collections\ArrayCollection,
		Application\Model\Entity\Album,
		Application\Model\Entity\Artist;

	/**
	 * Description of ClientTest
	 *
	 * @author sirvantos
	 */
	class AlbumTest extends PHPUnit_Framework_TestCase 
	{
		/**
		 * @var \Doctrine\ORM\EntityManager 
		 */
		private $repo		= null;
		
		private $addedIds	= array();
		
		public function setUp()
		{
			$this->em = Bootstrap::getServiceManager()->get('em');
			
			$a1 = new Album();
			
			$this->em->persist($a1->setTitle('The Wall')->setLength(60));
			
			$a2 = new Album();
			
			$this->em->persist($a2->setTitle('Цветы')->setLength(110));
			
			$a3 = new Album();
			
			$this->em->persist($a3->setTitle('Коверти')->setLength(110));
			
			$at1 = new Artist();
			
			$this->em->persist($at1->setName('Sting')->setBirthday(new DateTime('1972-03-02')));
			
			$at2 = new Artist();
			
			$this->em->persist($at2->setName('Василиев')->setBirthday(new DateTime('1972-03-02')));
			
			$at3 = new Artist();
			
			$this->em->persist($at3->setName('Позитив')->setBirthday(new DateTime('1972-03-02')));
			
			$collection = new ArrayCollection();
			
			$collection->add($at1);
			$collection->add($at2);
			$collection->add($at3);
			
			$a2->setArtists($collection);
			
			$this->em->flush();
			
			$this->addedIds['album'][] = $a1->getId();
			$this->addedIds['album'][] = $a2->getId();
			$this->addedIds['album'][] = $a3->getId();
			
			$this->addedIds['artist'][] = $at1->getId();
			$this->addedIds['artist'][] = $at2->getId();
			$this->addedIds['artist'][] = $at3->getId();
		}
		
		public function tearDown()
		{
			$qb = $this->em->createQueryBuilder();
			
			if (isset($this->addedIds['album'])) {
				$qb->
					delete('Application\Model\Entity\Album', 'a')->
					andWhere($qb->expr()->in('a.id', ':ids'))->
					setParameter(':ids', $this->addedIds['album'])->
					getQuery()->
					execute();
			}
			
			$qb = $this->em->createQueryBuilder();
			
			if (isset($this->addedIds['artist'])) {
				$qb->
					delete('Application\Model\Entity\Artist', 'a')->
					andWhere($qb->expr()->in('a.id', ':ids'))->
					setParameter(':ids', $this->addedIds['artist'])->
					getQuery()->
					execute();
			}
		}
		
		public function testAddAlbum()
		{
			var_dump($this->addedIds);
		}
		
		public function testAddArtist()
		{
			
		}
	}