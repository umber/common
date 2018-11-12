<?php

declare(strict_types=1);

namespace Umber\Common\Database;

/**
 * A factory for creating object repositories.
 */
interface EntityRepositoryFactoryInterface
{
    /**
     * Create a repository for the given entity.
     */
    public function create(string $entity): EntityRepositoryInterface;
}
