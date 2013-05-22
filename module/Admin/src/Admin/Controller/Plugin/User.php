<?php
	namespace Admin\Controller\Plugin;
	
	use 
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
		
		public function addUser()
		{
			
		}
		
		public function updateUser()
		{
			
		}
		
		public function deleteUser()
		{
			
		}
	}