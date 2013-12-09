<?php

return array(
    'router' => array(
        'routes' => array(
            'api_v1_user' => array(
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
            'api_v1_language' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/v1/language[/:id]',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'PODB\Controller\Language',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            'PODB\Repository\User' => 'PODB\Repository\UserRepository',
            'PODB\Repository\Project' => 'PODB\Repository\ProjectRepository',
            'PODB\Repository\Language' => 'PODB\Repository\LanguageRepository',
            'PODB\Repository\PODomain' => 'PODB\Repository\PODomainRepository',
            'PODB\Repository\PODataset' => 'PODB\Repository\PODatasetRepository',
            'PODB\Repository\Translation' => 'PODB\Repository\TranslationRepository',
        ),
//        'aliases' => array(
//            'podb_user_mapper' => 'PODB\Repository\UserRepository',
//        ),
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
            'PODB\Controller\Project' => 'PODB\Controller\ProjectController',
            'PODB\Controller\Language' => 'PODB\Controller\LanguageController',
            'PODB\Controller\PODomain' => 'PODB\Controller\PODomainController',
            'PODB\Controller\PODataset' => 'PODB\Controller\PODatasetController',
            'PODB\Controller\Translation' => 'PODB\Controller\TranslationController',
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
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
