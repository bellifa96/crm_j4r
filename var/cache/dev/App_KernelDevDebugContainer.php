<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerWbawLf6\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerWbawLf6/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerWbawLf6.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerWbawLf6\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerWbawLf6\App_KernelDevDebugContainer([
    'container.build_hash' => 'WbawLf6',
    'container.build_id' => 'a75c9007',
    'container.build_time' => 1651654209,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerWbawLf6');
