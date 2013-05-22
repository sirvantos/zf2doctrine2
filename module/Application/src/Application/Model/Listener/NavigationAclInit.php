<?php
	namespace Application\Model\Listener;
	
	use 
		Zend\ServiceManager\ServiceManager,
		Zend\Mvc\MvcEvent,
		Zend\View\Helper\Navigation,
		Zend\EventManager\ListenerAggregateInterface,
		Zend\EventManager\EventManagerInterface;
	
	/**
	 * Description of AclNavigationInit
	 *
	 * @author sirvantos
	 */
	final class NavigationAclInit implements ListenerAggregateInterface
	{
		/**
		 * @var Array
		 */
		private $listeners = array();
		
		/**
		* Attach to an event manager
		*
		* @param  EventManagerInterface $events
		* @return void
		*/
	   public function attach(EventManagerInterface $events)
	   {
			$this->listeners[] = $events->attach(
				MvcEvent::EVENT_DISPATCH, array($this, 'init'), -1000
			);
	   }
	   
	   /**
		* Detach all our listeners from the event manager
		*
		* @param  EventManagerInterface $events
		* @return void
		*/
	   public function detach(EventManagerInterface $events)
	   {
		   foreach ($this->listeners as $index => $listener) {
			   if ($events->detach($listener)) {
				   unset($this->listeners[$index]);
			   }
		   }
	   }
	   
		/**
		 * @param  MvcEvent $e
		 * @return null|Router\RouteMatch
		 */
		public function init($e)
		{
			$serviceManager = $e->getApplication()->getServiceManager();

			Navigation::setDefaultAcl(
				$serviceManager->get('BjyAuthorize\Service\Authorize')->getAcl()
			);

			Navigation::setDefaultRole($this->getTopRole($serviceManager));
		}
		
		private function getTopRole(ServiceManager $sm)
		{
			$roleId = 'guest';
			
			$as = $sm->get('zfcuser_auth_service');
			
			if (
				$as->hasIdentity() 
				&& ($roles = $childRoles = $as->getIdentity()->getRoles())
			) {
				
				$foundRole = null;
				
				foreach ($roles as $role) {
					
					$foundRole = $role;	
				
					foreach ($childRoles as $childRole) {
						if ($foundRole->getId() == $childRole->getParent()) {
							$foundRole = null;
							continue 2;
						}
					}
					
					if ($foundRole) {
						$roleId = $foundRole->getRoleId();
						break;
					}
				}
			}
			
			return $roleId;
		}
	}