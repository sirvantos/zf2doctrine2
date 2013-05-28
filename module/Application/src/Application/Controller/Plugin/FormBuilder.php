<?php
	/**
	* @namespace
	*/
	namespace Application\Controller\Plugin;
	
	use 
		Zend\Validator\Digits,
		Zend\Form\Annotation\AnnotationBuilder,
		Zend\Form\Form,
		Zend\Mvc\Controller\Plugin\AbstractPlugin,
		Zend\EventManager\EventManagerInterface,
		Zend\EventManager\EventManagerAwareInterface,
		Doctrine\ORM\EntityManager;
	
	final class NoEntityException extends \RuntimeException {}
	
	/**
	* Time utils
	*/
	final class FormBuilder extends AbstractPlugin implements EventManagerAwareInterface
	{
		/**
		 * @var EventManagerInterface 
		 */
		private $eventManager = null;
		
		/**
		 * @param Object $entity entity name
		 * @param Integer $id entity id
		 * @return \Zend\Form\Form
		 */
		public function build($entity, $id = null)
		{
			$em = $this->getController()->getServiceLocator()->get('em');
			
			$digit = new Digits();
			
			if ($id && !$digit->isValid($id))
				throw new \RuntimeException('Wrong id type, id should be digit');
			
			$repo = $em->getRepository(get_class($entity));
			
			if ($id) {
				if (!$entity = $repo->findById($id)) {
					throw new NoEntityException('No entity for id ' . $id);
				}
			}
			
			$builder = new AnnotationBuilder($em);
			
			$form = $builder->createForm($entity);
			
			$form->bind($entity);
			
			$result = $this->eventManager->trigger(
				'postCreateForm', 
				$this, 
				array('form' => $form), 
				function ($r) {return $r instanceof Form;}
			);
			
			return $form;
		}
		
		/**
		 * @param EventManagerInterface $eventManager
		 * @return FormBuilder
		 */
		public function setEventManager(EventManagerInterface $eventManager) 
		{
			$eventManager->setIdentifiers(array(__CLASS__, get_class($this)));
			
			$this->eventManager = $eventManager;
			
			return $this;
		}
		
		/**
		 * @return EventManagerInterface
		 */
		public function getEventManager() 
		{
			return $this->eventManager;
		}
	}