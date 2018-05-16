<?php

declare(strict_types=1);

namespace Umber\Common\Authentication\Prototype;

use Umber\Common\Authentication\Authorisation\PermissionInterface;
use Umber\Common\Authentication\Authorisation\RoleInterface;

interface UserInterface
{
    public function getEmail(): string;

    /**
     * @return RoleInterface[]
     */
    public function getRoles(): array;

    /**
     * @return PermissionInterface[]
     */
    public function getPermissions(): array;

    /**
     * @param RoleInterface[] $roles
     * @param PermissionInterface[] $permissions
     */
//    public function setAuthorisationDetails(array $roles, array $permissions): void;
}
