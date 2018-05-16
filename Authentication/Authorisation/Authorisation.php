<?php

declare(strict_types=1);

namespace Umber\Common\Authentication\Authorisation;

/**
 * {@inheritdoc}
 */
final class Authorisation implements AuthorisationInterface
{
    private $roles;
    private $permissions;

    /** @var PermissionInterface[] */
    private $passivePermissions = [];

    /**
     * @param RoleInterface[] $roles
     * @param PermissionInterface[] $permissions
     */
    public function __construct(array $roles, array $permissions)
    {
        $this->roles = $roles;
        $this->permissions = $permissions;

        foreach ($roles as $role) {
            foreach ($role->getPassivePermissions() as $permission) {
                $this->passivePermissions[] = $permission;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * {@inheritdoc}
     */
    public function hasRole(string $role): bool
    {
        foreach ($this->roles as $instance) {
            if ($instance->getName() === $role) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }

    /**
     * {@inheritdoc}
     */
    public function hasPermission(string $scope, string $ability): bool
    {
        $found = null;

        foreach ($this->permissions as $permission) {
            if ($permission->getScope() === $scope) {
                $found = $permission;

                break;
            }
        }

        if ($found === null) {
            foreach ($this->passivePermissions as $permission) {
                if ($permission->getScope() === $scope) {
                    $found = $permission;

                    break;
                }
            }
        }

        if ($found === null) {
            return false;
        }

        return $found->hasAbility($ability);
    }

    /**
     * {@inheritdoc}
     */
    public function getPassivePermissions(): array
    {
        return $this->passivePermissions;
    }
}
