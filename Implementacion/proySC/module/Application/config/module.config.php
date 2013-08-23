<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Application;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable;
use Application\Authentication\Db\AuthDao;
use Application\Authentication\Db\Adapter;

use Application\Login\DirPais\Select as DirPaisSelect;
use Application\Login\PerDocTipo\Select as PerDocTipoSelect;
use EnterpriseSolutions\Db\Dao;

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        	'login' => array(
        				'type'    => 'segment',
        				'options' => array(
        						'route'    => '/login[/][:action][/:id]',
        						'constraints' => array(
        								'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
        								'id'     => '[0-9]+',
        						),
        						'defaults' => array(
        								'controller' => 'Application\Controller\Login',
        								'action'     => 'index',
        						),
        				),
        	),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
            'AuthService' => function($sm) {
            	$authServiceManager = new AuthenticationService();
            	// Use 'someNamespace' instead of 'Zend_Auth'
            
            	//$authServiceManager->setStorage(new SessionStorage('sapientia_alumnos'));
            
            	$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            	$authDao = new AuthDao($dbAdapter);
            	$passwordEncoder = function($password){
            		return md5(trim($password));
            	};
            	$authAdapter = new Adapter($authDao,$passwordEncoder);
            	$authServiceManager->setAdapter($authAdapter);
            	//$authAdapter = new DbTable($dbAdapter);
            	//$authAdapter->setTableName('usuarios')
            	//            ->setIdentityColumn('username')
            	//            ->setCredentialColumn('password');
            	//$authServiceManager->setAdapter($authAdapter);
            	return $authServiceManager;
            },
            'DirPaisDao' => function ($sm) {
            	$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            	$select = new DirPaisSelect($dbAdapter);
            	return new Dao($select);
            },
            'PerDocTipoDao' => function ($sm) {
            	$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            	$select = new PerDocTipoSelect($dbAdapter);
            	return new Dao($select);
            },
            'Identidad' => function($sm){
            	$authService = $sm->get('AuthService');
            	return $authService->getIdentity();
            }
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
        	'Application\Controller\Login' => 'Application\Controller\LoginController'
        ),
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'SubmitParams' => 'EnterpriseSolutions\Controller\Plugin\SubmitParams'
        )
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
        		'ViewJsonStrategy',
        ),
    ),
);
