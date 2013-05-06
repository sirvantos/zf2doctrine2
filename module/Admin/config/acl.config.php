<?php
	return array(
		'acl' => array(
			'roles' => array(
				'guest'		=> null,
				'member'	=> 'guest',
				'admin'		=> 'member',
			),
			'resources' => array(
				'allow' => array(
					'application' => array(
						'all' => 'guest'
					),
					'dkcwdzf2munee' => array(
						'all' => 'guest'
					),
					'admin' => array(
						'auth' => 'guest',
						'all'   => 'admin'
					)
				)
			)
		)
	);
