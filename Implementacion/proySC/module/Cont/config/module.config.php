<?php

namespace Cont;

return array(
    'router' => array(
        'routes' => array(
            'cont' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/cont',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Cont\Controller',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action]]',
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
    'controllers' => array(
        'invokables' => array(
            'Cont\Controller\Moneda'           => 'Cont\Controller\MonedaController',
            'Cont\Controller\MonedaConversion' => 'Cont\Controller\MonedaConversionController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __NAMESPACE__ => __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__),
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ => __NAMESPACE__ . '_driver',
                ),
            ),
        ),
    ),
);