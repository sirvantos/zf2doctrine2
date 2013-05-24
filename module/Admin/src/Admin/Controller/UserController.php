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
			
			return array(
				'userForm'		=> $form,
				'paginator'		=> $this->user()->getUsersPaginator($form)
			);
		}
		
		public function addAction()
		{
			$request = $this->getRequest();
			
			$userForm = $this->user()->getUserForm();
			
			if ($request->isPost()) {
				if ($userForm->setData($request->getPost())->isValid()) {
					$this->user()->addUser($userForm);
					
					$this->redirect()->toRoute('admin/user-list');
				}
			}
			
			return array('userForm' => $userForm);
		}
	}