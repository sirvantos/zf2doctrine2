<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Form;

use 
	Admin\Form\BaseForm,
	Admin\Form\Filter\Login as LoginFilter;

/**
 * Description of Login
 *
 * @author sirvantos
 */
class Login extends BaseForm 
{
	/**
	 * @param String $name
	 * @return \Admin\Form\Login
	 */
	public static function create($name)
	{
		$self = new self();
		
		$self->setInputFilter(new LoginFilter());
		
		return $self;
	}
	
	/**
	 * @return \Admin\Form\Login
	 */
	public function init()
    {
		parent::init();
		
		$this->add(array(
            'name' => 'email',
            'type' => 'Zend\Form\Element\Email',
            'options' => array(
                'label' => 'Email:',
            ),
        ));
		
		$this->add(array(
            'name' => 'password',
            'type' => 'Zend\Form\Element\Password',
            'options' => array(
                'label' => 'Password:',
            ),
        ));
		
		$this->add(array(
			'name' => 'send',
			'type' => 'Zend\Form\Element\Submit',
			'attributes' => array(
				'type'  => 'submit',
				'value' => 'Submit'
			),
		));
		
		return $this;
	}
}