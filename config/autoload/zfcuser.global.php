<?php
	return array(
		'zfcuser' => array(
			'user_entity_class'				=> 'Application/Model/Entity/SystemUser',
			'use_registration_form_captcha' => true,
			'login_redirect_route'			=> 'admin/user-list'
		)
	);