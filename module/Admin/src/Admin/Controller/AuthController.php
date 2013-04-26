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
		Zend\Mvc\Controller\AbstractActionController,
		Zend\View\Model\ViewModel,
		Admin\Form\Login as LoginForm;

	/**
	 * Default admin controller
	 *
	 * @category Admin
	 * @package  Admin/Acl
	 */
	final class AuthController extends AbstractActionController
	{
		public function indexAction()
		{
			if ($this->identity()) {
				$this->
					redirect()->
						toRoute(
							'admin/default', 
							array('controller' => 'auth', 'action' => 'logout')
						);
			} else {
				$this->
					redirect()->
						toRoute(
							'admin/default', 
							array('controller' => 'auth', 'action' => 'login')
						);
			}
		}
		
		public function loginAction()
		{
			$request = $this->getRequest();
			
			$form = LoginForm::create('loginForm');
			
			$res = $this->auth()->login($form);
			
			if ($res === true)
				$this->
					redirect()->
						toRoute('admin/default', array('controller' => 'news'));
			
			return new ViewModel(array('loginForm' => $form, 'result' => $res));
		}
		
		public function logoutAction()
		{
			$this->auth()->logout();
			
			$this->
				redirect()->
					toRoute(
						'admin/default', 
						array('controller' => 'auth', 'action' => 'login')
					);
		}
	}