<?php
	namespace Admin\Service\Factory;
	
	use Zend\Navigation\Service\AbstractNavigationFactory;
	
	/**
	 * Default navigation factory.
	 */
	final class AdminNavigationFactory extends AbstractNavigationFactory
	{
		/**
		 * @return string
		 */
		protected function getName()
		{
			return 'admin';
		}
	}