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
			
			$data = array();
			
			if ($request->isPost()) {
				$form->setData($request->getPost());
			} else {
				$form->setData($request->getQuery());
			}
			
			$form->isValid();
			
			return array(
				'userForm'		=> $form,
				'paginator'		=> $this->user()->getUsersPaginator($form)
			);
		}
	}