<?php

namespace Stock;

return array(
    'router' => array(
        'routes' => array(
            'stock' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/stock[/][:action][/:id]',
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
    'controllers' => array(
        'invokables' => array(
            'Stock\Controller\ArticuloTipo' => 'Stock\Controller\ArticuloTipoController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Stock' => __DIR__ . '/../view',
        ),
    ),
);