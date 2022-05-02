<?php

namespace ContainerVFBJlOr;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getFichierControllerService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'App\Controller\Ged\FichierController' shared autowired service.
     *
     * @return \App\Controller\Ged\FichierController
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/framework-bundle/Controller/AbstractController.php';
        include_once \dirname(__DIR__, 4).'/src/Controller/Ged/FichierController.php';

        $container->services['App\\Controller\\Ged\\FichierController'] = $instance = new \App\Controller\Ged\FichierController();

        $instance->setContainer(($container->privates['.service_locator.jIxfAsi'] ?? $container->load('get_ServiceLocator_JIxfAsiService'))->withContext('App\\Controller\\Ged\\FichierController', $container));

        return $instance;
    }
}
