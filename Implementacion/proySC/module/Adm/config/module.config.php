<?php
namespace Adm;
return array(
    'controllers' => array(
        'invokables' => array(
        	'Adm\Controller\Usuario' => 'Adm\Controller\UsuarioController'	
        ),
    ),
    'router' => array(
        'routes' => array(
            'adm' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/adm',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                       '__NAMESPACE__' => 'Adm\Controller',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
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
    'view_manager' => array(
        'template_path_stack' => array(
            'adm' => __DIR__ . '/../view',
        ),
    	'strategies' => array(
    				'ViewJsonStrategy',
        ),
    ),
		'doctrine' => array(
				'driver' => array(
						__NAMESPACE__ . '_driver' => array(
						'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
						'cache' => 'array',
						'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__)
				),
				'orm_default' => array(
						'drivers' => array(
						//__NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
						__NAMESPACE__ => __NAMESPACE__ . '_driver'
		)
		)
		)
		)
);
