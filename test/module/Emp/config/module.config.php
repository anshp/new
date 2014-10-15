<?php
return array(
    'view_manager' => array(
        'template_path_stack' => array(
            'emp' => __DIR__ . '/../view'
        ),
    ),
    'router' => array(
        'routes' => array(
            'emp-hello-world' => array(
                'type'    => 'Literal',
                    'options' => array(
                    'route' => '/hello/world',
                    'defaults' => array(
                        'controller' => 'emp\Controller\Hello',
                        'action'     => 'world',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Emp\Controller\Hello' => 'Emp\Controller\HelloController',
        ),
    ),
);

