<?php

declare(strict_types=1);

namespace Umber\Common\Framework\Symfony\Bundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * {@inheritdoc}
 */
final class ObjectReducerHandlerCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $registry = $container->getDefinition('umber.common.reducer.registry');

        foreach ($container->findTaggedServiceIds('object.reducer') as $id => $data) {
            $registry->addMethodCall('register', [
                new Reference($id),
            ]);
        }
    }
}
