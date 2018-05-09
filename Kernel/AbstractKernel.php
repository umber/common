<?php

declare(strict_types=1);

namespace Umber\Common\Kernel;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as SymfonyKernel;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RouteCollectionBuilder;

/**
 * An abstract kernel that setups up symfony just right.
 */
abstract class AbstractKernel extends SymfonyKernel
{
    public const EXTENSIONS = '{xml,yml}';

    /**
     * Return the configuration directory.
     */
    public function getConfigDir(): string
    {
        return sprintf('%s/config', $this->getProjectDir());
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheDir(): string
    {
        return sprintf('%s/var/cache/%s', $this->getProjectDir(), $this->getEnvironment());
    }

    /**
     * {@inheritdoc}
     */
    public function getLogDir(): string
    {
        return sprintf('%s/var/log', $this->getProjectDir());
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(function (ContainerBuilder $container) use ($loader): void {
            $root = $this->getConfigDir();

            $container->setParameter('container.dumper.inline_class_loader', true);
            $container->loadFromExtension('framework', [
                'router' => [
                    'resource' => 'kernel:routes',
                    'type' => 'service',
                ],
            ]);

            /**
             * Load common services consistently per root directory.
             *
             * @param string $root
             *
             * @throws \Exception due to loader failing.
             */
            $services = function (string $root) use ($loader): void {
                $loader->load(sprintf('%s/{parameters}.%s', $root, self::EXTENSIONS), 'glob');
                $loader->load(sprintf('%s/{parameters}.env.%s', $root, self::EXTENSIONS), 'glob');
                $loader->load(sprintf('%s/{services}.%s', $root, self::EXTENSIONS), 'glob');
                $loader->load(sprintf('%s/{packages}/*.%s', $root, self::EXTENSIONS), 'glob');
            };

            $services($root);
            $services(sprintf('%s/{environments}/{%s}', $root, $this->getEnvironment()));

            $container->addObjectResource($this);
        });
    }

    /**
     * @internal
     */
    public function routes(LoaderInterface $loader): RouteCollection
    {
        $collection = new RouteCollectionBuilder($loader);
        $root = $this->getConfigDir();

        /**
         * Load common routes consistently per root directory.
         *
         * @param string $root
         *
         * @throws \Exception due to loader failing.
         */
        $routes = function (string $root) use ($collection): void {
            $collection->import(sprintf('%s/routes/*.%s', $root, self::EXTENSIONS, 'glob'));
        };

        $routes($root);
        $routes(sprintf('%s/environments/%s', $root, $this->getEnvironment()));

        return $collection->build();
    }
}
