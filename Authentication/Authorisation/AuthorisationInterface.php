<?php

declare(strict_types=1);

namespace Umber\Common\Authentication\Authorisation;

interface AuthorisationInterface
{
    /**
     * @return RoleInterface[]
     */
    public function getRoles(): array;

    public function hasRole(string $role): bool;

    /**
     * @return PermissionInterface[]
     */
    public function getPermissions(): array;

    public function hasPermission(string $scope, string $attribute): bool;

    /**
     * @return PermissionInterface[]
     */
    public function getPassivePermissions(): array;
}
