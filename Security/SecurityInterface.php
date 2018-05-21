<?php

declare(strict_types=1);

namespace Umber\Common\Security;

use Umber\Common\Database\EntityInterface;

interface SecurityInterface
{
    /**
     * Check if the permission is granted against the given entity.
     */
    public function isGranted(EntityInterface $entity, string $permission): void;
}
