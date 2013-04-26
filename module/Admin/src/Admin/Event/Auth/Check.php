<?php
/**
 * @namespace 
 */
namespace Admin\Event\Auth;

/**
 * @uses Zend\Mvc\MvcEvent
 * @uses Admin\Acl\Authentication
 * @uses Admin\Acl
 */
use Zend\Mvc\MvcEvent as MvcEvent,
	Zend\Authentication\Adapter\DbTable,
	Zend\Authentication\AuthenticationService,
	Zend\Http\Response,
	Admin\Acl\Authentication,
	Admin\Acl\Acl;

/**
 * Authentication Event Handler Class
 *
 * This Event Handles Authentication
 *
 * @category  Admin
 * @package   Admin\Event
 * @todo rename class to Check
 */
final class Check
{
	/**
	 * @var UserAuthentication
	 */
	protected $_userAuth = null;

	/**
	 * @var UserAuthentication
	 */
	protected $_aclClass = null;

	/**
	 * preDispatch Event Handler
	 *
	 * @param \Zend\Mvc\MvcEvent $event
	 * @throws \Exception
	 */
	public function preDispatch(MvcEvent $event)
	{
		$userAuth = $this->getUserAuthenticationPlugin();
		
		$acl = $this->getAcl();
		
		$role = Acl::ROLE_GUEST;
		
		if ($userAuth->hasIdentity()) {
			
			$em = $event->getApplication()->getServiceManager()->get('em');
			
			$userObj = 
				$em->
					getRepository('Application\Model\Entity\SystemUser')->
					findOneById($userAuth->getIdentity());
			
			if (!$userObj) {
				//@TODO: add warning message to log
			} else {
				//$role = $userObj->getRole();
			}
		}
		
		$this->initNavigation($role);
		
		$routeMatch		= $event->getRouteMatch();
		
		$parts = explode("\\", $routeMatch->getParam('controller'));
		
		$module		= strtolower($parts[0]);
		$controller = strtolower($parts[2]);
		
		if (!$acl->hasResource($module)) {
			throw new \Exception('Resource ' . $module . ' not defined');
		}

		if (!$acl->isAllowed($role, $module, $controller)) {
			$response = $event->getResponse();
			
			if ($module == 'admin') {
				$response->getHeaders()->addHeaderLine('Location', '/admin/auth/login');
			} else {
				$response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
				$response->setContent(json_encode(
					array(
						'type'		=> 'Error',
						'message'	=> 'User unauthorized',
					)
				));
			}
			
			$response->setStatusCode(Response::STATUS_CODE_401);
			$response->send();
			exit;
		}
	}

	/**
	 * Gets Authentication Plugin
	 *
	 * @return \User\Controller\Plugin\UserAuthentication
	 */
	public function getUserAuthenticationPlugin()
	{
		if ($this->_userAuth === null) {
			$this->_userAuth = new Authentication();
			$this->_userAuth->setAuthService(new AuthenticationService());
		}

		return $this->_userAuth;
	}

	/**
	 * Sets ACL Class
	 *
	 * @param \User\Acl\Acl $aclClass
	 * @return Check
	 */
	public function setAcl(Acl $aclClass)
	{
		$this->_aclClass = $aclClass;

		return $this;
	}

	/**
	 * Gets ACL Class
	 *
	 * @return \User\Acl\Acl
	 */
	public function getAcl()
	{
		if ($this->_aclClass === null) {
			$this->_aclClass = new Acl(array());
		}

		return $this->_aclClass;
	}
	
	private function initNavigation($role)
	{
		\Zend\View\Helper\Navigation::setDefaultAcl($this->getAcl());
		\Zend\View\Helper\Navigation::setDefaultRole($role);
		
		return $this;
	}
}