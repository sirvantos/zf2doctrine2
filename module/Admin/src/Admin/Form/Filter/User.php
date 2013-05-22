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
 * Description of User
 *
 * @author sirvantos
 */
class User extends InputFilter
{
	public function __construct() 
	{
		$this->
			add(array('name' => 'email',
				'required' => false,
				'validators' => array(
					array(
						'name' => 'StringLength',
						'options' => array('max' => 128),
					)
				),
				'filters' => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags')
				)
			))->add(array('name' => 'username',
				'required' => false,
				'validators' => array(
					array(
						'name' => 'StringLength',
						'options' => array('max' => 128),
					)
				),
				'filters' => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags')
				)
			))->add(array('name' => 'firstName',
				'required' => false,
				'validators' => array(
					array(
						'name' => 'StringLength',
						'options' => array('max' => 128),
					)
				),
				'filters' => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags')
				)
			))->add(array('name' => 'lastName',
				'required' => false,
				'validators' => array(
					array(
						'name' => 'StringLength',
						'options' => array('max' => 128),
					)
				),
				'filters' => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags')
				)
			));
	}
}