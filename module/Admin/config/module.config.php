<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
	'di' => array(
		'instance' => array(
			'alias' => array(
				'user' => 'User\Controller\UserController'
			),
			'user' => array(
				'parameters' => array(
					'broker' => 'Zend\Mvc\Controller\PluginBroker'
				)
			),
			'Admin\Acl\Acl' => array(
				'parameters' => array(
					'config' => include __DIR__ . '/acl.config.php'
				)
			),
			'Admin\Event\Auth\Check' => array(
				'parameters' => array(
					'userAuthenticationPlugin' => 'Admin\Acl\Authentication',
					'aclClass'                 => 'Admin\Acl\Acl'
				)
			)
		),
	),
	'service_manager' => array(
        'factories' => array(
            'navigation'	=> 'Zend\Navigation\Service\DefaultNavigationFactory',
            'authService'	=> function () {
				return new Zend\Authentication\AuthenticationService();
			}
        ),
    ),
	'controllers' => array(
        'invokables' => array(
            'Admin\Controller\News'	=> 'Admin\Controller\NewsController',
            'Admin\Controller\Auth'	=> 'Admin\Controller\AuthController'
        ),
    ),
	'controller_plugins' => array(
		'invokables' => array(
			'auth' => 'Admin\Controller\Plugin\Auth',
			'news' => 'Admin\Controller\Plugin\News'
		)
	),
	'view_manager' => array(
		'template_path_stack' => array(
			'admin' => __DIR__ . '/../view',
		)
	),
	// The following section is new and should be added to your file
	'router' => array(
		'routes' => array(
			'admin' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/admin',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller'    => 'News',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[/[:controller[/[:action]]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    )
                )
            ),
		)
	)
);