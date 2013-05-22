<?php
	namespace Application\Model\Listener;
	
	use 
		Application\Model\Error\Logger\Convert2Exception,
		Zend\Log\Logger,
		Zend\Mvc\Application,
		Zend\ServiceManager\ServiceManager,
		Zend\Mvc\MvcEvent,
		Zend\EventManager\Event,
		Zend\EventManager\ListenerAggregateInterface,
		Zend\EventManager\EventManagerInterface;
	
	/**
	 * Description of PolicyProcessingErrors
	 *
	 * @author sirvantos
	 */
	final class PolicyProcessingErrors implements ListenerAggregateInterface
	{
		/**
		 * @var Array
		 */
		private $listeners = array();
		
		/**
		 * @var \Zend\Log\Logger
		 */
		private $logger = null;


		public function __construct(Logger $logger)
		{
			$this->logger = $logger;
		}
		
		/**
		* Attach to an event manager
		*
		* @param  EventManagerInterface $events
		* @return void
		*/
	   public function attach(EventManagerInterface $events)
	   {
			Logger::registerErrorHandler(new Convert2Exception());
			
			$logger = $this->logger;
			
			$this->listeners[] = $events->attach(
				Application::ERROR_EXCEPTION, function (Event $e) use ($logger) {
					$logger->log(Logger::CRIT, $e->getParam('exception'));
				}
			);
			
			$this->listeners[] = $events->attach(
				MvcEvent::EVENT_RENDER_ERROR, function (Event $e) use ($logger) {
					$logger->log(Logger::CRIT, $e->getParam('exception'));
				}
			);
			
			$this->listeners[] = $events->attach(
				MvcEvent::EVENT_DISPATCH_ERROR, function (Event $e) use ($logger) {
					$logger->log(Logger::CRIT, $e->getParam('exception'));
				}
			);
			
			return $this;
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
	}