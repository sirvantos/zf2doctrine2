<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use 
	Application\Model\Listener\NavigationAclInit,
	Zend\Mvc\ModuleRouteListener,
	Zend\Mvc\MvcEvent;

class Module
{
   public function onBootstrap(MvcEvent $e)
    {
		$mainSm = $e->getApplication()->getServiceManager();
	   
		$mainSm->get('translator');
		
		$eventManager        = $e->getApplication()->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);
		
		$e->getApplication()->getServiceManager()->get('PolicyProcessingErrors');
		$e->getApplication()->getEventManager()->attach(new NavigationAclInit());
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
            )
        );
    }
}