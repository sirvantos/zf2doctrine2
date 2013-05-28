<?php
	/**
	 * @namespace
	 */
	namespace Admin\Controller;

	/**
	 * @uses Application\Controller\AbstractController
	 * @uses Zend\View\Model\ViewModel
	 */
	use 
		Admin\Form\UserCriteria as UserForm,
		Zend\Mvc\Controller\AbstractActionController,
		Zend\View\Model\ViewModel;

	/**
	 * Default admin controller
	 *
	 * @category Admin
	 * @package  Admin/Acl
	 */
	final class UserController extends AbstractActionController
	{
		public function listAction()
		{
			$request = $this->getRequest();
			$form = new UserForm('userFilter');
			
			$form->setAttribute('method', 'get');
			
			$form->setData($request->getQuery())->isValid();
			
			$paginator = $this->user()->getUsersPaginator($form);
			
			$paginator->
				setItemCountPerPage(2)->
				setCurrentPageNumber($this->params()->fromRoute('page', 1));
			
			return array(
				'userForm'		=> $form,
				'paginator'		=> $paginator
			);
		}
		
		public function addAction()
		{
			$request = $this->getRequest();
			
			$this->getEventManager()->getSharedManager()->attach(
				'Application\Controller\Plugin\FormBuilder', 
				'postCreateForm', 
				array($this, 'changeForm')
			);
			
			$su = new \Application\Model\Entity\SystemUser();
			
			$filter = new \Application\Form\Filter\User(
				$this->getServiceLocator()->get('em')->getRepository(
					'Application\Model\Entity\SystemUser'
				)
			);
			
			$filter->remove('id')->remove('passwordConfirmation');
			
			$userForm = $this->formBuilder()->build(
				$su->setInputFilter($filter)
			);
			
			$userForm->remove('id');
			
			if ($request->isPost()) {
				if ($userForm->setData($request->getPost())->isValid()) {
					
					$this->user()->addUser($userForm);
					
					$this->redirect()->toRoute('admin/user-list');
				}
			}
			
			return array('userForm' => $userForm);
		}
		
		public function editAction()
		{
			$request = $this->getRequest();
			
			$this->getEventManager()->getSharedManager()->attach(
				'Application\Controller\Plugin\FormBuilder', 
				'postCreateForm', 
				array($this, 'changeForm')
			);
			
			$userForm = null;
			
			$su = new \Application\Model\Entity\SystemUser();
			
			if ($request->isPost()) {
				$userForm = $this->formBuilder()->build($su);
				
				if ($userForm->setData($request->getPost())->isValid()) {
					$this->user()->updateUser($userForm);
					
					$this->redirect()->toRoute('admin/user-list');
				}
			} else {
				$userForm = $this->formBuilder()->build(
					$su, $this->params()->fromRoute('id')
				);
			}
			
			return array('userForm' => $userForm);
		}
		
		public function changeForm($e) 
		{
			$form = $e->getParam('form');
			
			$em = $this->getServiceLocator()->get('em');
			
			$list = $em->getRepository('Application\Model\Entity\Role')->getList();
			
			$options = array();
			
			foreach ($list as $role) {
				$options[$role->getId()] = $role->getRoleId();
			}
			
			$roles =
				$form->get('roles')->
					setValueOptions($options)->
					setEmptyOption('Please check the role');
			
			$roleValue = $roles->getValue();
			
			if (is_array($roleValue) && !$roleValue) {
				$roles->setValue('');
			} elseif (is_array($roleValue)) {
				$roles->setValue($roleValue[0]->getId());
			}
			
			return $form;
		}
	}