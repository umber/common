<?php

declare(strict_types=1);

namespace Umber\Common\Authentication\Authorisation;

interface RoleInterface
{
    public function getName(): string;

    /**
     * @return PermissionInterface[]
     */
    public function getPassivePermissions(): array;
}
