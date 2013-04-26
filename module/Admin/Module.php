<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin;

use 
	Admin\Event\Auth\Check,
	Zend\Mvc\ModuleRouteListener,
	Zend\Mvc\MvcEvent;

class Module
{
	public function onBootstrap(MvcEvent $e)
	{
		$sm = $e->getTarget()->getServiceManager();
		
		$check = $sm->get('DI')->get('Admin\Event\Auth\Check');
		
		$e->
			getApplication()->
				getEventManager()->
					attach(
						\Zend\Mvc\MvcEvent::EVENT_ROUTE,
						array($check, 'preDispatch'),
						//should after invoke all matches
						0
					);
		
		$sharedEvents = $e->getApplication()->getEventManager()->getSharedManager();
        
		$sharedEvents->attach(__NAMESPACE__, 'dispatch', function($e) {
            // This event will only be fired when an ActionController under the MyModule namespace is dispatched.
            $controller = $e->getTarget();
            $controller->layout('layout/admin');
        }, 100);
	}

	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}

	 public function getAutoloaderConfig()
	 {
		 return array(
			 'Zend\Loader\StandardAutoloader' => array(
				 'namespaces' => array(
					 __NAMESPACE__	=> __DIR__ . '/src/' . __NAMESPACE__
				 ),
			 ),
		 );
	 }
}