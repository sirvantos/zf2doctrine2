<?php
	/**
	 * @namespace
	 */
	namespace Admin\Controller\Plugin;
	
	/**
	 * @uses Application\Controller\AbstractController
	 * @uses Zend\View\Model\ViewModel
	 */
	use 
		Zend\Mvc\Controller\Plugin\AbstractPlugin, 
		Admin\Form\News as NewsForm;
	
	/**
	 * Description of Auth
	 *
	 * @author sirvantos
	 */
	final class News extends AbstractPlugin
	{
		public function add(NewsForm $newsForm)
		{
			$result = false;
			
			$c = $this->getController();
			$r = $c->getRequest();
			
			$res = 
				$c->
					getServiceLocator()->
						get('newsTable')->
							insert(array());
			
			if (
				$r->isPost() 
				&&  $newsForm->setData($r->getPost())->isValid()
			)  {
				
			}
			
			return $result;
		}
		
		public function edit(NewsForm $newsForm)
		{
			$result = false;
			
			return $result;
		}
		
		public function delete(NewsForm $newsForm)
		{
			$result = false;
			
			return $result;
		}
	}