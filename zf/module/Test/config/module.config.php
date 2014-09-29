<?php
return array(
    'view_manager' => array(
        'template_path_stack' => array(
            '<module-name>' => __DIR__ . '/../view'
        ),
    ),
    'router' => array(
        'routes' => array(
            'Test-hello-world' => array(
                'type'    => 'Literal',
                    'options' => array(
                    'route' => '/hello/world',
                    'defaults' => array(
                        'controller' => 'Test\Controller\Hello',
                        'action'     => 'world',
                    ),
                ),
            ),
            'Test-other-world' => array(
                'type'    => 'Literal',
                    'options' => array(
                    'route' => '/other/world',
                    'defaults' => array(
                        'controller' => 'Test\Controller\Other',
                        'action'     => 'world',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Test\Controller\Hello' => 'Test\Controller\HelloController',
            'Test\Controller\Other' => 'Test\Controller\OtherController',
        ),
    ),
);