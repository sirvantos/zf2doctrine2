<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Form;

use Zend\Form\Form;

/**
 * Description of Login
 *
 * @author sirvantos
 */
class BaseForm extends Form 
{
	const DEFAULT_FORM_NAME = '';
	
	public function __construct($name = '', Array $options = array()) 
	{
		parent::__construct($name, $options);
		
		$this->init();
	}
	
	/**
	 * @return \Admin\Form\BaseForm
	 */
	public function init()
    {
		if ($name = $this->getName()) 
		{
			$this->setName($name);
		} else {
			$this->setName(self::DEFAULT_FORM_NAME);
		}
		
		return $this;
	}
}