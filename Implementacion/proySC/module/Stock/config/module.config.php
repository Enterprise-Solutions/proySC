<?php

namespace Stock;

return array(
    'router' => array(
        'routes' => array(
            'stock' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/stock',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Stock\Controller',
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
            'Stock\Controller\Articulo' => 'Stock\Controller\ArticuloController',
            'Stock\Controller\Combos'   => 'Stock\Controller\CombosController',
        	'Stock\Controller\Marca'   => 'Stock\Controller\MarcaController',
        	'Stock\Controller\Categoria'   => 'Stock\Controller\CategoriaController',
        	'Stock\Controller\GarantiaTipo'   => 'Stock\Controller\GarantiaTipoController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __NAMESPACE__ => __DIR__ . '/../view',
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
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'),
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                ),
            ),
        ),
    ),
);