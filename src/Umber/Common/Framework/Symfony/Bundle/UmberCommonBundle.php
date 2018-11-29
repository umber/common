<?php

declare(strict_types=1);

namespace Umber\Common\Framework\Symfony\Bundle;

use Umber\Common\Framework\Symfony\Bundle\DependencyInjection\Compiler\ObjectReducerHandlerCompilerPass;
use Umber\Common\Framework\Symfony\Bundle\DependencyInjection\UmberCommonExtension;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * {@inheritdoc}
 */
final class UmberCommonBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new UmberCommonExtension();
    }

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ObjectReducerHandlerCompilerPass());
    }
}
