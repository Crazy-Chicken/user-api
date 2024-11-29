<?php

declare(strict_types=1);

namespace UserApi\CoreBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CoreCompilerPass implements CompilerPassInterface
{
    public const ENTITY_MANAGER_AWARE_TAG = 'user_api.entity_manager.aware';

    public function process(ContainerBuilder $container): void
    {
        $entityManagerAwareServices = $container->findTaggedServiceIds(self::ENTITY_MANAGER_AWARE_TAG);

        foreach ($entityManagerAwareServices as $serviceId => $tags) {
            $def = $container->getDefinition($serviceId);
            $def->clearTag(self::ENTITY_MANAGER_AWARE_TAG);
            $def->addMethodCall('setEntityManager', [new Reference('user_api.entity_manager')]);
        }
    }
}
