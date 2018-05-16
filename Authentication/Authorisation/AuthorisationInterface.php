<?php

declare(strict_types=1);

namespace Umber\Common\Authentication\Authorisation;

interface AuthorisationInterface
{
    /**
     * {@inheritdoc}
     *
     * @return RoleInterface[]
     */
    public function getRoles(): array;

    public function hasRole(string $role): bool;

    /**
     * {@inheritdoc}
     *
     * @return PermissionInterface[]
     */
    public function getPermissions(): array;

    public function hasPermission(string $scope, string $attribute): bool;

    /**
     * {@inheritdoc}
     *
     * @return PermissionInterface[]
     */
    public function getPassivePermissions(): array;
}
