<?php
	namespace Admin\Controller\Plugin;
	
	use 
		DoctrineORMModule\Form\Annotation\AnnotationBuilder,
		DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator,
		Application\Model\Entity\SystemUser,
		DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as Adapter,
		Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator,
		Zend\Paginator\Paginator,
		Zend\Form\Form,
		Zend\Mvc\Controller\Plugin\AbstractPlugin;
	
	/**
	 * Description of User
	 *
	 * @author sirvantos
	 */
	final class User extends AbstractPlugin 
	{
		public function getUsersPaginator(Form $form)
		{
			$systemUser = 
				$this->
					getController()->
						getServiceLocator()->
							get('em')->
								getRepository('Application\Model\Entity\SystemUser');
			
			return new Paginator(
				new Adapter(
					new DoctrinePaginator(
						$systemUser->makePaginationQueryByCriteria($form->getData())
					)
				)
			);
		}
		
		public function addUser(Form $form)
		{
			$em = 
				$this->
					getController()->
						getServiceLocator()->
							get('em');
			
			$systemUser = $form->getObject();
			
			$role = $em->getReference(
				'Application\Model\Entity\Role', $systemUser->getRoleId()
			);
			
			$systemUser->addRole($em->merge($role));
			
			$em->persist($systemUser);
			$em->flush();
			
			return $this;
		}
		
		public function updateUser(Form $form)
		{
			
		}
		
		public function deleteUser()
		{
			
		}
	}