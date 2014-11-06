<?php
 return array(
     'controllers' => array(
         'invokables' => array(
             'Employee\Controller\Employee' => 'Employee\Controller\EmployeeController',
         ),
     ),
     'router' => array(
         'routes' => array(
             'employee' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/[employee][/][:action][/][:emp]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'emp' => '[a-zA-Z][a-zA-Z0-9_-]*',
                     ),
                     'defaults' => array(
                         'controller' => 'Employee\Controller\Employee',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),
     'view_manager' => array(
         'template_path_stack' => array(
             'employee' => __DIR__ . '/../view',
         ),
     ),
 );