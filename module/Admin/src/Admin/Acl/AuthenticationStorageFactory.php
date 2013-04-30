<?php
	namespace Admin\Acl;

	use 
		DoctrineModule\Service\AbstractFactory, 
		Zend\ServiceManager\ServiceLocatorInterface;

	/**
	 * Factory to create authentication storage object.
	 *
	 * @license MIT
	 * @link    http://www.doctrine-project.org/
	 * @since   0.1.0
	 * @author  Tim Roediger <superdweebie@gmail.com>
	 */
	class AuthenticationStorageFactory extends AbstractFactory
	{
		/**
		 *
		 * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
		 * @return \DoctrineModule\Authentication\Adapter\DoctrineObjectRepository
		 */
		public function createService(ServiceLocatorInterface $serviceLocator)
		{
			$options = $this->getOptions($serviceLocator, 'authentication');
			if (is_string($options->getObjectManager())) {
				$options->setObjectManager($serviceLocator->get($options->getObjectManager()));
			}
			return new ObjectRepository($options);
		}

		public function getOptionsClass()
		{
			return 'DoctrineModule\Options\Authentication';
		}
	}