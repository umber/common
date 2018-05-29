<?php

declare(strict_types=1);

namespace Umber\Common\Authentication\Prototype;

use Umber\Common\Authentication\Authorisation\PermissionInterface;
use Umber\Common\Authentication\Authorisation\RoleInterface;

interface UserInterface
{
    public function getEmail(): string;

    /**
     * @return string[]
     */
    public function getAuthorisationRoles(): array;

    /**
     * @return string[]
     */
    public function getAuthorisationPermissions(): array;

    /**
     * @param RoleInterface[] $roles
     * @param PermissionInterface[] $permissions
     */
//    public function setAuthorisationDetails(array $roles, array $permissions): void;
}
