<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Form\Filter;

use 
	Zend\InputFilter\InputFilter, 
	Zend\Validator\Hostname;

/**
 * Description of Login
 *
 * @author sirvantos
 */
class Login extends InputFilter
{
	public function __construct() 
	{
		$this->
			add(array('name' => 'email',
				'required' => true,
				'validators' => array(
					array(
						'name' => 'StringLength',
						'options' => array('max' => 128),
					),
					array(
						'name' => 'EmailAddress',
						'options' => array(
							'allow' => Hostname::ALLOW_DNS,
							'domain' => true,
						),
					),
				),
				'filters' => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags')
				)
			))->add(array('name' => 'password',
				'required' => true,
				'validators' => array(
					array(
						'name' => 'StringLength',
						'options' => array('max' => 32),
					)
				),
				'filters' => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags')
				)
			));
	}
}