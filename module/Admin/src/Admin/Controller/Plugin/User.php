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
			
			$role = new \Application\Model\Entity\Role();
			$role->setId($systemUser->getRoleId());
			
			$systemUser->addRole($role);
			
			$em->persist($systemUser);
			$em->persist($role);
			$em->flush();
			
			return $this;
		}
		
		public function updateUser()
		{
			
		}
		
		public function deleteUser()
		{
			
		}
		
		/**
		 * @return Form
		 */
		public function getUserForm()
		{
			$em = 
				$this->
					getController()->
						getServiceLocator()->
							get('em');
			
			$builder = new AnnotationBuilder($em);
			
			$su = new SystemUser();
			
			$filter = new \Application\Form\Filter\User(
				$em->getRepository('Application\Model\Entity\SystemUser')
			);
			
			$userForm = $builder->createForm(
				$su->setInputFilter($filter->remove('passwordConfirmation'))
			);
			
			$userForm->
				setHydrator(new \Zend\Stdlib\Hydrator\ClassMethods())->
				bind($su);
			
			$list = $em->getRepository('Application\Model\Entity\Role')->findAll();
			
			$options					= array();
			$options['empty_option']	= 'Please check the role';
			$options['value_options']	= array();
			
			foreach ($list as $role) {
				$options['value_options'][$role->getId()] = $role->getRoleId();
			}
			
			$userForm->get('roles')->setOptions($options)->setValue('');
			
			return $userForm;
		}
	}