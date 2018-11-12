<?php

declare(strict_types=1);

namespace Umber\Common\Serializer;

interface SerializerInterface
{
    /**
     * {@inheritdoc}
     *
     * @param string|array $data
     * @param string[] $groups
     *
     * @return array
     */
    public function serialize($data, array $groups): array;
}
