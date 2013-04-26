<?php
/**
 * @namespace
 */
namespace Admin\Acl;

/**
 * @uses Zend\Mvc\Controller\Plugin\AbstractPlugin
 * @uses Zend\Authentication\AuthenticationService
 * @uses Zend\Authentication\Adapter\DbTable
 */
use Zend\Authentication\AuthenticationService,
    Zend\Authentication\Adapter\AbstractAdapter as AuthAbstractAdapter;

/**
 * Class for User Authentication
 *
 * Handles Auth Adapter and Auth Service to check Identity
 *
 * @category   Admin
 * @package    Admin\Controller\Plugin
 */
class Authentication
{
    /**
     * @var AuthAdapter
     */
    protected $_authAdapter = null;

    /**
     * @var AuthenticationService
     */
    protected $_authService = null;

    /**
     * Check if Identity is present
     *
     * @return bool
     */
    public function hasIdentity()
    {
        return $this->getAuthService()->hasIdentity();
    }

    /**
     * Return current Identity
     *
     * @return mixed|null
     */
    public function getIdentity()
    {
        return $this->getAuthService()->getIdentity();
    }

	/**
     * Sets Auth Service
     *
     * @param \Zend\Authentication\AuthenticationService $authService
     * @return Authentication
     */
    public function setAuthService(AuthenticationService $authService)
    {
        $this->_authService = $authService;
		
        return $this;
    }

    /**
     * Gets Auth Service
     *
     * @return \Zend\Authentication\AuthenticationService
     */
    public function getAuthService()
    {
       return $this->_authService;
    }
}