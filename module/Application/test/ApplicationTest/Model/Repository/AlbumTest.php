<?php

	/*
	 * To change this template, choose Tools | Templates
	 * and open the template in the editor.
	 */
	use 
		Zend\Db\TableGateway\TableGateway,
		Application\Bootstrap,
		Application\Model\Entity\Album,
		Application\Model\Entity\Artist;

	/**
	 * Description of ClientTest
	 *
	 * @author sirvantos
	 */
	class AlbumTest extends PHPUnit_Framework_TestCase 
	{
		private $repo	= null;
		private $addedIds	= array();
		
		public function setUp()
		{
			$this->em = Bootstrap::getServiceManager()->get('em');
		}
		
		public function tearDown()
		{
			$qb = $this->em->createQueryBuilder();
			
			if ($this->addedIds) {
				$qb->
					delete('Application\Model\Entity\Album', 'a')->
					andWhere($qb->expr()->in('a.id', ':ids'))->
					setParameter(':ids', $this->addedIds)->
					getQuery()->
					execute();
			}
		}
		
		public function testAddAlbum()
		{
			$a = new Album();
			
			$this->em->persist($a->setTitle('The Wall')->setLength(60));
			
			$a = new Album();
			
			$this->em->persist($a->setTitle('Цветы')->setLength(110));
			
			$a = new Album();
			
			$this->em->persist($a->setTitle('Коверти')->setLength(110));
			
			$this->em->flush();
		}
		
		public function testAddArtist()
		{
			
		}
	}