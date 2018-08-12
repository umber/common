<?php

declare(strict_types=1);

namespace Umber\Common\Exception\Exception;

use Umber\Common\Database\EntityInterface;
use Umber\Common\Exception\AbstractRuntimeException;

/**
 * {@inheritdoc}
 */
final class EntityHasNoDomainModelException extends AbstractRuntimeException
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
    public static function getMessageTemplate(): array
    {
        return [
            'The entity "{{entity}}" does not have a domain model implemented.',
        ];
    }
}
