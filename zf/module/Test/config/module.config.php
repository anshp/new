<?php
return array(
    'view_manager' => array(
        'template_path_stack' => array(
            'Test' => __DIR__ . '/../view'
        ),
    ),
    'router' => array(
        'routes' => array(
            'Test-hello-world' => array(
                'type'    => 'Literal',
                    'options' => array(
                    'route' => '/',
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
            'Test-bye-world' => array(
                'type'    => 'Literal',
                    'options' => array(
                    'route' => '/bye/world',
                    'defaults' => array(
                        'controller' => 'Test\Controller\Bye',
                        'action'     => 'world',
                    ),
                ),
            ),
            'Test-message-hello' => array(
                'type'    => 'Literal',
                    'options' => array(
                    'route' => '/message/hello',
                    'defaults' => array(
                        'controller' => 'Test\Controller\Message',
                        'action'     => 'hello',
                    ),
                ),
            ),
            'Test-message-bye' => array(
                'type'    => 'Literal',
                    'options' => array(
                    'route' => '/message/bye',
                    'defaults' => array(
                        'controller' => 'Test\Controller\Message',
                        'action'     => 'bye',
                    ),
                ),
            ),
            'Test-message-other' => array(
                'type'    => 'Literal',
                    'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'Test\Controller\Message',
                        'action'     => 'hello',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Test\Controller\Hello' => 'Test\Controller\HelloController',
            'Test\Controller\Other' => 'Test\Controller\OtherController',
            'Test\Controller\Bye' => 'Test\Controller\ByeController',
            'Test\Controller\Message' => 'Test\Controller\MessageController',
        ),
    ),
);