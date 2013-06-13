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
                        'controller' => 'Stock\Controller\Articulo',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'articulo' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/articulo[/][:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Stock\Controller\Articulo',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                    'articulo-tipo' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/articulo-tipo[/][:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Stock\Controller\ArticuloTipo',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Stock\Controller\ArticuloTipo' => 'Stock\Controller\ArticuloTipoController',
            'Stock\Controller\Articulo'     => 'Stock\Controller\ArticuloController',
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