<?php
/**
 *
 */
return array(
    'router' => array(
        'routes' => array(
            'user' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/user[/:id]',
                    'defaults' => array(
                        'controller' => 'PODB\Controller\User',
                        'action' => 'getList',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'PODB\Controller\User' => 'PODB\Controller\UserController'
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'application_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/PODB/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'PODB\Entity' => 'application_entities'
                )
            )
        )
    ),
    'view_manager' => array( //Add this config
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);