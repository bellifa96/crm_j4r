<?php

namespace ContainerVFBJlOr;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_CCRUbZgService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.cCRUbZg' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.cCRUbZg'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'typeFichier' => ['privates', '.errored..service_locator.cCRUbZg.App\\Entity\\Ged\\TypeFichier', NULL, 'Cannot autowire service ".service_locator.cCRUbZg": it references class "App\\Entity\\Ged\\TypeFichier" but no such service exists.'],
            'typeFichierRepository' => ['privates', 'App\\Repository\\Ged\\TypeFichierRepository', 'getTypeFichierRepositoryService', true],
        ], [
            'typeFichier' => 'App\\Entity\\Ged\\TypeFichier',
            'typeFichierRepository' => 'App\\Repository\\Ged\\TypeFichierRepository',
        ]);
    }
}
