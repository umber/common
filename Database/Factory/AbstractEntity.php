<?php

declare(strict_types=1);

namespace Umber\Common\Database\Factory;

use Umber\Common\Database\EntityInterface;

/**
 * A abstract implementation that can optionally used for entity interfaces.
 */
abstract class AbstractEntity implements EntityInterface
{
    /**
     * {@inheritdoc}
     */
    final public static function create(): EntityInterface
    {
        return new static();
    }

    /**
     * The constructor should only ever be used to initialise collections, defaults should
     * be set through a factory instance. Initialise the entity with dependencies that might
     * be required for type hints.
     *
     * For example initialise doctrine collections so getters will not throw.
     *
     * @internal
     */
    public function __construct()
    {
    }
}
