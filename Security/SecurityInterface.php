<?php

declare(strict_types=1);

namespace Umber\Common\Security;

use Umber\Common\Database\EntityInterface;

interface SecurityInterface
{
    public function isGranted(EntityInterface $entity, string $permission): bool;
}
