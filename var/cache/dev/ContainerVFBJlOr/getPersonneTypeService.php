<?php

namespace ContainerVFBJlOr;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getPersonneTypeService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'App\Form\Interlocuteur\PersonneType' shared autowired service.
     *
     * @return \App\Form\Interlocuteur\PersonneType
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/form/FormTypeInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/form/AbstractType.php';
        include_once \dirname(__DIR__, 4).'/src/Form/Interlocuteur/PersonneType.php';

        return $container->privates['App\\Form\\Interlocuteur\\PersonneType'] = new \App\Form\Interlocuteur\PersonneType();
    }
}
