<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Form;

use 
	Admin\Form\BaseForm,
	Admin\Form\Filter\User as UserFilter;

/**
 * Description of UserCriteria
 *
 * @author sirvantos
 */
class UserCriteria extends BaseForm 
{
	public function __construct($name = '', array $options = array()) 
	{
		parent::__construct($name, $options);
		
		$this->setInputFilter(new UserFilter());
	}
	
	/**
	 * @return UserCriteria
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
            'name' => 'username',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Text:',
            ),
        ));
		
		$this->add(array(
            'name' => 'firstName',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'First name:',
            ),
        ));
		
		$this->add(array(
            'name' => 'lastName',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Last name:',
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