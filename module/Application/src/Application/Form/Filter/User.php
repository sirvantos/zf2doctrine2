<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Form\Filter;

use 
	Doctrine\ORM\EntityRepository,
	DoctrineModule\Validator\ObjectExists,
	DoctrineModule\Validator\NoObjectExists,
	Zend\InputFilter\InputFilter, 
	Zend\Validator\Hostname;

/**
 * Description of User
 *
 * @author sirvantos
 */
class User extends InputFilter
{
	private $userRepository			= null;
	
	public function __construct(EntityRepository $repository) 
	{
		$this->
			add(array('name' => 'id',
				'required' => true,
				'validators' => array(
					array('name' => 'Digits'),
					array(
						'name' => 'DoctrineModule\Validator\ObjectExists',
						'options' => array(
							'object_repository' => $repository,
							'messages'			=> array(
								ObjectExists::ERROR_NO_OBJECT_FOUND => 
									'Wrong id'
							),
							'fields'			=> 'id'
						),
					),
				),
				'filters' => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags')
				)
			))->add(array('name' => 'email',
				'required' => true,
				'validators' => array(
					array(
						'name' => 'StringLength',
						'options' => array('max' => 128),
					),
					array(
						'name' => 'EmailAddress',
						'options' => array(
							'domain' => false
						),
					),
					array(
						'name' => 'DoctrineModule\Validator\NoObjectExists',
						'options' => array(
							'object_repository' => $repository,
							'messages'			=> array(
								NoObjectExists::ERROR_OBJECT_FOUND => 
									'Such email already exists'
							),
							'fields'			=> 'email'
						),
					)
				),
				'filters' => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags')
				)
			))->add(array('name' => 'username',
				'required' => true,
				'validators' => array(
					array(
						'name' => 'StringLength',
						'options' => array('max' => 128),
					),
					array(
						'name' => 'DoctrineModule\Validator\NoObjectExists',
						'options' => array(
							'object_repository' => $repository,
							'messages'			=> array(
								NoObjectExists::ERROR_OBJECT_FOUND => 
									'Such username already exists'
							),
							'fields'			=> 'username',
						),
					)
				),
				'filters' => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags')
				)
			))->add(array('name' => 'firstName',
				'required' => true,
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
			))->add(array('name' => 'password',
				'required'		=> true,
				'validators'	=> array(
					array(
						'name' => 'StringLength',
						'options' => array(
							'min' => 6,
							'max' => 12,
						)
					)
				),
				'filters' => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags')
				)
			))->add(array('name' => 'lastName',
				'required' => true,
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
			))->add(array('name' => 'roles',
				'required'		=> true,
				'validators'	=> array(),
				'filters' => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags')
				)
			))->add(array('name' => 'passwordConfirmation',
				'required'		=> true,
				'validators'	=> array(
					array(
						'name' => 'StringLength',
						'options' =>  array(
							'min' => 6,
							'max' => 12,
						),
						'name'		=> 'Identical',
						'options'	=> array(
							'token' => 'password', // name of first password field
						)
					)
				),
				'filters' => array(
					array('name' => 'StringTrim'),
					array('name' => 'StripTags')
				)
			));
	}
	
	/**
	 * @param EntityRepository $repository
	 * @return User
	 */
	public function setUserRepository(EntityRepository $repository)
	{
		$this->userRepository = $repository;
		
		return $this;
	}
	
	/**
	 * @return EntityRepository
	 */
	public function getUserRepository()
	{
		return $this->userRepository;
	}
}