<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

use Admin\Acl\UserRoles;

return array(
	'di' => array(
		'instance' => array(
			'alias' => array(),
		),
	),
	'service_manager' => array(
        'aliases' => array(),
		'factories' => array(
			'Admin\Acl\UserRoles' => function ($sm) {
				$ur = new UserRoles(
					$sm->
						get('em')->
							getRepository(
								'Application\Model\Entity\SystemUser'
							),
					
					$sm->get('zfcuser_user_service')
				);
				
				$config = $sm->get('BjyAuthorize\Config');
				
				return $ur->setDefaultRole($config['default_role']);
			}
		)
    ),
	'controllers' => array(
        'invokables' => array( 
            'Admin\Controller\User'	=> 'Admin\Controller\UserController'
        ),
    ),
	'controller_plugins' => array(
		'invokables' => array(
			'auth' => 'Admin\Controller\Plugin\User'
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
                    ),
					'user-list' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/user/list',
                            'constraints' => array(
                                'id'     => '[0-9]+'
                            ),
                            'defaults' => array(
								'controller'    => 'Admin\Controller\User',
								'action'        => 'list'
							),
                        ),
                    ),
					'user-edit' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/user/edit/:id',
                            'constraints' => array(
                                'id'     => '[0-9]+'
                            ),
                            'defaults' => array(
								'controller'    => 'Admin\Controller\User',
								'action'        => 'edit'
							),
                        ),
                    ),
					'user-delete' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/user/delete/:id',
                            'constraints' => array(
                                'id'     => '[0-9]+'
                            ),
                            'defaults' => array(
								'controller'    => 'Admin\Controller\User',
								'action'        => 'delete'
							),
                        ),
                    ),
                ),
            ),
		)
	),
	'navigation' => array(
        // The DefaultNavigationFactory we configured in (1) uses 'default' as the sitemap key
        'default' => array(
            // And finally, here is where we define our page hierarchy
           'news' => array(
                'label'			=> 'News',
                'controller'	=> 'news',
                'action'		=> 'index',
				'resource'		=> 'admin',
				'privilege'		=> 'news',
            ),
			'login' => array(
                'label'			=> 'Login',
                'controller'	=> 'auth',
                'action'		=> 'login',
				'resource'		=> 'admin',
				'privilege'		=> 'auth',
            ),
        ),
    ),
);