<?php

namespace ContainerVFBJlOr;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_OB6va3bService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.OB6va3b' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.OB6va3b'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'sousEntiteRepository' => ['privates', 'App\\Repository\\Entite\\SousEntiteRepository', 'getSousEntiteRepositoryService', true],
        ], [
            'sousEntiteRepository' => 'App\\Repository\\Entite\\SousEntiteRepository',
        ]);
    }
}
