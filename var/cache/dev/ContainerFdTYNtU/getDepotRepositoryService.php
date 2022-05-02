<?php

namespace ContainerFdTYNtU;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getDepotRepositoryService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'App\Repository\Entite\DepotRepository' shared autowired service.
     *
     * @return \App\Repository\Entite\DepotRepository
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/src/Persistence/ObjectRepository.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/collections/lib/Doctrine/Common/Collections/Selectable.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityRepository.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/doctrine-bundle/Repository/ServiceEntityRepositoryInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/doctrine-bundle/Repository/ServiceEntityRepository.php';
        include_once \dirname(__DIR__, 4).'/src/Repository/Entite/DepotRepository.php';

        return $container->privates['App\\Repository\\Entite\\DepotRepository'] = new \App\Repository\Entite\DepotRepository(($container->services['doctrine'] ?? $container->getDoctrineService()));
    }
}
