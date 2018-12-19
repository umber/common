<?php

declare(strict_types=1);

namespace Umber\Common\Serializer;

use Umber\Reducer\Builder\ReducerBuilderFactory;

/**
 * A serializer using the reducer.
 */
final class ReducerSerializer implements SerializerInterface
{
    private $factory;

    public function __construct(ReducerBuilderFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize($data, array $groups): array
    {
        $reduced = $this->factory->create()
            ->groups($groups)
            ->reduce($data);

        return $reduced;
    }
}
