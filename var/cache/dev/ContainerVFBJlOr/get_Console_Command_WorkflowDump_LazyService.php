<?php

namespace ContainerVFBJlOr;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_Console_Command_WorkflowDump_LazyService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.console.command.workflow_dump.lazy' shared service.
     *
     * @return \Symfony\Component\Console\Command\LazyCommand
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/console/Command/Command.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/console/Command/LazyCommand.php';

        return $container->privates['.console.command.workflow_dump.lazy'] = new \Symfony\Component\Console\Command\LazyCommand('workflow:dump', [], 'Dump a workflow', false, function () use ($container): \Symfony\Bundle\FrameworkBundle\Command\WorkflowDumpCommand {
            return ($container->privates['console.command.workflow_dump'] ?? $container->load('getConsole_Command_WorkflowDumpService'));
        });
    }
}
