<?php
	/**
	 * @namespace
	 */
	namespace Admin\Acl;

	/**
	 * @uses Zend\Acl\Acl
	 * @uses Zend\Acl\Role\GenericRole
	 * @uses Zend\Acl\Resource\GenericResource
	 */
	use Zend\Permissions\Acl\Acl as ZendAcl,
		Zend\Permissions\Acl\Role\GenericRole as Role,
		Zend\Permissions\Acl\Resource\GenericResource as Resource;

	/**
	 * Class to handle Acl
	 *
	 * This class is for loading ACL defined in a config
	 *
	 * @category Admin
	 * @package  Admin/Acl
	 */
	final class Acl extends ZendAcl 
	{
		const ROLE_GUEST	= 'guest';
		const ROLE_MEMBER	= 'member';
		const ROLE_ADMIN	= 'admin';
		
		const TYPE_GUEST	= 0;
		const TYPE_MEMBER	= 1;
		const TYPE_ADMIN	= 2;
		
		public static $rolesTypes = array(
			self::ROLE_GUEST	=> self::TYPE_GUEST,
			self::ROLE_MEMBER	=> self::TYPE_MEMBER,
			self::ROLE_ADMIN	=> self::TYPE_ADMIN
		);
		
		public static function getTypeByRole($role)
		{
			if (!isset(self::$rolesTypes[$role]))
				throw new \RuntimeException(
					'Knows nothing about ' . $role .' role'
				);
			
			return self::$rolesTypes[$role];
		}
		
		public static function getRoleByType($type)
		{
			$types = array_flip(self::$rolesTypes);
			
			if (!isset($types[$type]))
				throw new \RuntimeException(
					'Knows nothing about ' . $type . ' type'
				);
			
			return $types[$type];
		}
		
		/**
		 * Constructor
		 *
		 * @param array $config
		 * @return void
		 * @throws \Exception
		 */
		public function __construct($config)
		{
			if (!isset($config['acl']['roles']) || !isset($config['acl']['resources'])) {
				throw new \RuntimeException('Invalid ACL Config found');
			}

			$roles = $config['acl']['roles'];
			
			if (!isset($roles[self::ROLE_GUEST])) 
				$roles[self::ROLE_GUEST] = null;

			$this->_addRoles($roles)->_addResources($config['acl']['resources']);
		}

		/**
		 * Adds Roles to ACL
		 *
		 * @param array $roles
		 * @return Admin\Acl
		 */
		protected function _addRoles($roles)
		{
			foreach ($roles as $name => $parent) {
				if (!$this->hasRole($name)) {
					if (empty($parent)) {
						$parent = array();
					} else {
						$parent = explode(',', $parent);
					}

					$this->addRole(new Role($name), $parent);
				}
			}

			return $this;
		}

		/**
		 * Adds Resources to ACL
		 *
		 * @param $resources
		 * @return Admin\Acl
		 * @throws \Exception
		 */
		protected function _addResources($resources)
		{
			foreach ($resources as $permission => $modules) {
				foreach ($modules as $module => $controllers) {
					if ($module == 'all') {
						$module = null;
					} else {
						if (!$this->hasResource($module)) {
							$this->addResource(new Resource($module));
						}
					}

					foreach ($controllers as $controller => $role) {
						if ($controller == 'all') {
							$controller = null;
						}

						if ($permission == 'allow') {
							$this->allow($role, $module, $controller);
						} elseif ($permission == 'deny') {
							$this->deny($role, $module, $controller);
						} else {
							throw new \Exception('No valid permission defined: ' . $permission);
						}
					}
				}
			}

			return $this;
		}
	}