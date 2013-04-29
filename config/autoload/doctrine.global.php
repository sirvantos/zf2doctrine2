<?php
	return array(
		'doctrine' => array(
			'driver' => array(
				'application_entities' => array(
					'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
					'cache' => 'array',
					'paths' => array(__DIR__ . '/../../module/Application/src/')
				),
				'orm_default' => array(
					'drivers' => array(
						'Application\Model\Entity' => 'application_entities'
					)
				)
			),
			'authentication' => array(
				'orm_default'	=> array(
					'objectManager'			=> 'Doctrine\ORM\EntityManager',
					'identityClass'			=> 'Application\Model\Entity\SystemUser',
					'identityProperty'		=> 'email',
					'credentialProperty'	=> 'password',
					'credentialCallable'	=> 'Application\Model\Entity\SystemUser::hashPassword'
				)
			),
			// Configuration details for the ORM.
			// See http://docs.doctrine-project.org/en/latest/reference/configuration.html
			'configuration' => array(
				// Configuration for service `doctrine.configuration.orm_default` service
				'orm_default' => array(
					// metadata cache instance to use. The retrieved service name will
					// be `doctrine.cache.$thisSetting`
					'metadata_cache'    => 'memcached',

					// DQL queries parsing cache instance to use. The retrieved service
					// name will be `doctrine.cache.$thisSetting`
					'query_cache'       => 'memcached',

					// ResultSet cache to use.  The retrieved service name will be
					// `doctrine.cache.$thisSetting`
					'result_cache'      => 'memcached'
				)
			)
		)
	);