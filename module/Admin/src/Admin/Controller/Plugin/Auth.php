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
		DoctrineModule\Service\Authentication\AdapterFactory,
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
				$sl = $c->getServiceLocator();
				
				$doctrineAdapterFactory = new AdapterFactory('doctrineAdapter');
				
				$sl->
					get('authService')->
						getAdapter()->
							setIdentityValue(
								$loginForm->get('email')->getValue()
							)->
							setCredentialValue(
								$loginForm->get('password')->getValue()
							);
				
				$result = $sl->get('authService')->authenticate()->isValid();
				
			} elseif (!$request->isPost())  {
				$result = null;
			}
			
			return $result;
		}
		
		public function logout()
		{
			return $this;
		}
	}