<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
	use 
		Application\Model\Error\Service\PolicyProcessingErrors,
		Zend\Db\ResultSet\ResultSet, 
		Zend\Db\TableGateway\TableGateway;	

	return array(
		'service_manager' => array(
			'aliases'	=> array('em' => 'Doctrine\ORM\EntityManager'),
			'factories'	=> array(
				'PolicyProcessingErrors' => function ($sm) 
				{
					$em = $sm->get('Application')->getEventManager();

					$ppe = new PolicyProcessingErrors($sm->get('logger'));
					
					$em->attach(
						\Zend\Mvc\MvcEvent::EVENT_ROUTE,  array($ppe, 'init'), 
						10000000
					);

					return $ppe;
				},
				'zfcuser_user_mapper' => function ($sm) {
					//$options = $sm->get('zfcuser_module_options');
					//$mapper = new Mapper\User();
					//$mapper->setDbAdapter($sm->get('zfcuser_zend_db_adapter'));
					//$entityClass = $options->getUserEntityClass();
					//$mapper->setEntityPrototype(new $entityClass);
					//$mapper->setHydrator(new Mapper\UserHydrator());
					//$mapper->setTableName($options->getTableName());
					
					$sm->get('em')->getRepository('Application\Model\Entity\SystemUser');

					return $mapper;
				}
			)
		)
	);