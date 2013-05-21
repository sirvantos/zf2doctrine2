<?php
	namespace Admin\Model\Listener;
	
	use 
		Zend\Mvc\MvcEvent,
		Zend\EventManager\SharedListenerAggregateInterface,
		Zend\EventManager\SharedEventManagerInterface;
	
	/**
	 * Description of AclNavigationInit
	 *
	 * @author sirvantos
	 */
	final class AdminLayoutInit implements SharedListenerAggregateInterface
	{
		/**
		 * @var Array
		 */
		private $listeners = array();
		
		/**
		  * Attach one or more listeners
		  *
		  * Implementors may add an optional $priority argument; the SharedEventManager
		  * implementation will pass this to the aggregate.
		  *
		  * @param SharedEventManagerInterface $events
		  */
		public function attachShared(SharedEventManagerInterface $events)
		{
			$this->listeners['Admin'] = 
				$events->attach('Admin', MvcEvent::EVENT_DISPATCH, function($e) {
					// This event will only be fired when an ActionController under the MyModule namespace is dispatched.
					$controller = $e->getTarget();
					$controller->layout('layout/admin');
				}, 1000);
		}
		

		/**
		 * Detach all previously attached listeners
		 *
		 * @param SharedEventManagerInterface $events
		 */
		public function detachShared(SharedEventManagerInterface $events)
		{
			foreach ($this->listeners as $index => $listener) {
			   if ($events->detach($index, $listener)) {
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
			
		}
	}