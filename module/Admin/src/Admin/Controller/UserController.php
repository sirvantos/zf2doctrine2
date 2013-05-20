<?php
	/**
	 * @namespace
	 */
	namespace Admin\Controller;

	/**
	 * @uses Application\Controller\AbstractController
	 * @uses Zend\View\Model\ViewModel
	 */
	use 
		Zend\Mvc\Controller\AbstractActionController,
		Zend\View\Model\ViewModel;

	/**
	 * Default admin controller
	 *
	 * @category Admin
	 * @package  Admin/Acl
	 */
	final class UserController extends AbstractActionController
	{
		public function listAction()
		{
			echo '11111';exit;
		}
	}