<?php

declare(strict_types=1);

namespace Umber\Common\Exception\Database;

use Umber\Common\Database\EntityInterface;
use Umber\Common\Exception\AbstractMessageRuntimeException;

/**
 * {@inheritdoc}
 */
final class EntityHasNoDomainModelException extends AbstractMessageRuntimeException
{
    /**
     * @return EntityHasNoDomainModelException
     */
    public static function create(EntityInterface $entity): self
    {
        return new self([
            'entity' => get_class($entity),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function message(): array
    {
        return [
            'The entity "{{entity}}" does not have a domain model implemented.',
        ];
    }
}
