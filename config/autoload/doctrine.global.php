<?php
	return array(
		'doctrine' => array(
			'driver' => array(
				'application_entities' => array(
					'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
					'cache' => 'array',
					'paths' => array(__DIR__ . '/../src/Application/Model/Entity')
				),
				'orm_default' => array(
					'drivers' => array(
						'Application\Model\Entity' => 'application_entities'
					)
				)
			),
			'authentication' => array(
				'doctrineAdapter'		=> array(
					'objectManager'			=> 'Doctrine\ORM\EntityManager',
					'identityClass'			=> 'Application\Model\Entity\SystemUser',
					'identityProperty'		=> 'username',
					'credentialProperty'	=> 'password',
					'credentialCallable'	=> 'Application\Model\Entity\SystemUser::hashPassword'
				)
			)
		)
	);