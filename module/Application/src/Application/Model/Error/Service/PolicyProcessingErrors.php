<?php
	namespace Application\Model\Error\Service;

	use Zend\EventManager\Event,
		Zend\Log\Logger, 
		Application\Model\Error\Logger\Convert2Exception;

	class PolicyProcessingErrors
	{
		/**
		 * @var \Zend\Log\Logger
		 */
		private $logger = null;


		public function __construct(Logger $logger)
		{
			$this->logger = $logger;
		}
		
		/**
		 * @param \Zend\EventManager\Event $e
		 * @return \Application\Model\Error\Service\PolicyProcessingErrors
		 */
		public function init(Event $e)
		{
			Logger::registerErrorHandler(new Convert2Exception());
			
			$logger = $this->logger;
			
			$e->getApplication()->getEventManager()->attach(
				\Zend\Mvc\Application::ERROR_EXCEPTION, function (Event $e) use ($logger) {
					$logger->log(Logger::CRIT, $e->getParam('exception'));
				}
			);
			
			$e->getApplication()->getEventManager()->attach(
				\Zend\Mvc\MvcEvent::EVENT_RENDER_ERROR, function (Event $e) use ($logger) {
					$logger->log(Logger::CRIT, $e->getParam('exception'));
				}
			);
			
			$e->getApplication()->getEventManager()->attach(
				\Zend\Mvc\MvcEvent::EVENT_DISPATCH_ERROR, function (Event $e) use ($logger) {
					$logger->log(Logger::CRIT, $e->getParam('exception'));
				}
			);
			
			return $this;
		}
	}
