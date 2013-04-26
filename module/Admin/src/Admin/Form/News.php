<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Form;

use 
	Admin\Form\BaseForm,
	Application\Model\Entity\News as NewsEntity,
	Admin\Form\Filter\News as NewsFilter;

/**
 * Description of Login
 *
 * @author sirvantos
 */
class News extends BaseForm 
{
	/**
	 * @param String $name
	 * @return \Admin\Form\News
	 */
	public static function create($name)
	{
		$self = new self();
		
		$self->setInputFilter(new NewsFilter());
		
		return $self;
	}
	
	/**
	 * @return \Admin\Form\News
	 */
	public function init()
    {
		parent::init();
		
		$this->add(array(
            'name' => 'title',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Title:',
            ),
        ));
		
		$this->add(array(
            'name' => 'body',
            'type' => 'Zend\Form\Element\Textarea',
            'options' => array(
                'label' => 'Body:',
            ),
			'attributes' => array(
				'class' => 'tinymce'
			)
        ));
		
		$this->add(array(
            'name' => 'keywords',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Keywords:',
            ),
        ));
		
		$this->add(array(
            'name' => 'publish_date',
            'type' => 'Zend\Form\Element\DateTime',
            'options' => array(
                'label' => 'Publish date:',
            )
        ));
		
		$this->add(array(
            'name' => 'headline',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Headline:',
            ),
        ));
		
		$this->add(array(
            'name'			=> 'type',
            'type'			=> 'Zend\Form\Element\Select',
            'attributes'	=> array(
				'options' => NewsEntity::getTypeNames()
			),
			'options' => array(
                'label' => 'Type:',
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