<?php

declare(strict_types=1);

namespace Umber\Common\Framework\Symfony;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

use Exception;
use ReflectionObject;

/**
 * An abstract extension that helps setup your extension just right.
 */
abstract class AbstractExtension extends Extension
{
    /**
     * Return all the configuration files to load.
     *
     * These configuration files belong in the standard symfony configuration directory.
     *
     * @return string[]
     */
    abstract protected function configs(): array;

    /**
     * {@inheritdoc}
     *
     * @throws Exception When a loader has an error.
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $this->loadAllConfigFiles($container);
    }

    /**
     * Handle the loading of bundle configuration service files.
     *
     * @throws Exception When a loader has an error.
     */
    final protected function loadAllConfigFiles(ContainerBuilder $container): void
    {
        $directory = dirname((new ReflectionObject($this))->getFileName());
        $directory = realpath(sprintf('%s/../Resources/config/services', $directory));

        $loader = new YamlFileLoader($container, new FileLocator($directory));

        foreach ($this->configs() as $config) {
            $loader->load(sprintf('%s.yaml', $config));
        }
    }
}
