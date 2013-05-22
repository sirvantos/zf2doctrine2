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
		Admin\Acl\UserMapper;	

	return array(
		'service_manager' => array(
			'factories'	=> array(
				'navigation'			=> 'Zend\Navigation\Service\DefaultNavigationFactory',
				'admin_navigation'		=> 'Admin\Service\Factory\AdminNavigationFactory',
				'zfcuser_user_mapper'	=> function ($sm) {
					return new UserMapper($sm->get('em'));
				}
			)
		),
		
		'navigation' => array(
			// The DefaultNavigationFactory we configured in (1) uses 'default' as the sitemap key
			'admin' => array(
				// And finally, here is where we define our page hierarchy
			   array(
					'label'		=> 'Menu',
					'class'		=> 'nav-header',
					'uri'		=> '#'
			   ),
			   array(
					'label'			=> 'Users',
					'controller'	=> 'Admin\Controller\User',
					'action'		=> 'list',
					//controller/ because bjy-authorize store controller guards in such format
					'resource'		=> 'controller/Admin\Controller\User'
				)
			),
		),
	);