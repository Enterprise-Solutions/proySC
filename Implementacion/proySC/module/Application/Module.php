<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Application\Authentication\AuthenticationListener;
use EnterpriseSolutions\Exceptions\Listener as ExceptionListener;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
    	date_default_timezone_set('America/Asuncion');
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        //$authListener = new AuthenticationListener();
        //$authListener->attach($eventManager);
        
        $exceptionListener = new ExceptionListener();
        $exceptionListener->attach($eventManager);
    }
    
    public function getViewHelperConfig()
    {
        return array(
            'invokables' => array(
                'logged_user' => 'Application\View\Helper\LoggedUser',
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                	'EnterpriseSolutions' => __DIR__ . '/../../vendor/EnterpriseSolutions'
                ),
            ),
        );
    }
}
