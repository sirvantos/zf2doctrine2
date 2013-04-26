<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Form\Filter;

use 
	Application\Model\Entity\News as NewsEntity,
	Zend\InputFilter\InputFilter, 
	Zend\Validator\Hostname;

/**
 * Description of Login
 *
 * @author sirvantos
 */
class News extends InputFilter
{
	public function __construct() 
	{
		$this->
			add(array(
				'name'			=> 'title',
				'required'		=> true,
				'validators'	=> array(
					array(
						'name'		=> 'StringLength',
						'options'	=> array('max' => 128),
					)
				),
				'filters' => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags')
				)
			))->add(array(
				'name'			=> 'headline',
				'required'		=> false,
				'validators'	=> array(
					array(
						'name'		=> 'StringLength',
						'options'	=> array('max' => 128),
					)
				),
				'filters' => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags')
				)
			))->add(array(
				'name'			=> 'body',
				'required'		=> true,
				'validators'	=> array(
					array(
						'name'		=> 'StringLength',
						'options'	=> array('max' => 64000)
					)
				)
			))->add(array(
				'name'			=> 'keywords',
				'required'		=> false,
				'validators'	=> array(
					array(
						'name'		=> 'StringLength',
						'options'	=> array('max' => 255)
					)
				),
				'filters' => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags')
				)
			//TODO: add datetime check
			))->add(array(
				'name'			=> 'publish_date',
				'required'		=> true,
				'validators'	=> array(
					//array('name' => 'Date')
				),
				'filters' => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags')
				)
			))->add(array(
				'name'			=> 'type',
				'required'		=> true,
				'validators'	=> array(
					array(
						'name'		=> 'InArray',
						'options'	=> array(
							'haystack' => NewsEntity::getTypes()
						)
					)
				),
				'filters' => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags')
				)
			));
	}
}