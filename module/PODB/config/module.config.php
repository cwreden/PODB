<?php
/**
 *
 */
return array(
    'router' => array(
        'routes' => array(
            'api_v1_event' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/v1/user[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'PODB\Controller\User',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            'PODB\Repository\User' => 'PODB\Repository\UserRepository',
        ),
//
//      Alternative zum Invokable:
//      Dies hätte den Vorteil, dass der EntitiyManager von aussen injiziert wird => In UserRepository den EnitityManager im Konstruktor dann setzten
//        'factories' => array(
//            'UserRepo' => function ($serviceManager) {
//                    $entityManager = $serviceManager->get('Doctrine\ORM\EntityManager');
//                    return new \PODB\Repository\UserRepository($entityManager);
//                }
//        )
    ),
    'controllers' => array(
        'invokables' => array(
            'PODB\Controller\User' => 'PODB\Controller\UserController',
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
