<?php
	/**
	 * @namespace
	 */
	namespace Admin\Controller\Plugin;
	
	/**
	 * @uses Application\Controller\AbstractController
	 * @uses Zend\View\Model\ViewModel
	 */
	use 
		Zend\Mvc\Controller\Plugin\AbstractPlugin, 
		Admin\Form\Login as LoginForm;;
	
	/**
	 * Description of Auth
	 *
	 * @author sirvantos
	 */
	final class Auth extends AbstractPlugin
	{
		public function login(\Admin\Form\Login $loginForm)
		{
			$c = $this->getController();
			
			$request = $c->getRequest();
			
			$result = false;
			
			if (
				$request->isPost()
				&& $loginForm->setData($request->getPost())->isValid()
			) {
				$res = 
					$c->
						getServiceLocator()->
							get('systemUserTable')->
								authenticate(
									$loginForm->get('email')->getValue(), 
									$loginForm->get('password')->getValue()
								);
				
				if ($res->isValid()) {
					$result = true;
				}
			} elseif (!$request->isPost())  {
				$result = null;
			}
			
			return $result;
		}
		
		public function logout()
		{
			$c = $this->getController();
			
			if ($c->identity()) {
				$as = $c->getServiceLocator()->get('authService');
				
				if (!$as) 
					throw new \RuntimeException(
						'Knows nothing about authService'
					);
				
				$as->clearIdentity();
			}
			
			return $this;
		}
	}