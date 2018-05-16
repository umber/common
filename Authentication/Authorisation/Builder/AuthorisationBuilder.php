<?php

declare(strict_types=1);

namespace Umber\Common\Authentication\Authorisation\Builder;

use Umber\Common\Authentication\Authorisation\Authorisation;
use Umber\Common\Authentication\Authorisation\RoleInterface;
use Umber\Common\Authentication\Prototype\UserInterface;

/**
 * Build authorisation instances from simple string values.
 */
final class AuthorisationBuilder
{
    /**
     * Create an authorisation instance from the given authorisation details.
     *
     * @param string[] $roles
     * @param string[] $permissions
     */
    public static function create(
        array $roles,
        array $permissions,
        AuthorisationHierarchy $hierarchy
    ): Authorisation {
        return new Authorisation(
            self::createRoles($hierarchy, $roles),
            self::createPermissions($hierarchy, $permissions)
        );
    }

    /**
     * Create an authorisation instance from the given users authorisation details.
     */
    public static function createFromUser(
        UserInterface $user,
        AuthorisationHierarchy $hierarchy
    ): Authorisation {
        return self::create(
            $user->getRoles(),
            $user->getPermissions(),
            $hierarchy
        );
    }

    /**
     * Create roles from the serialised forms given.
     *
     * @param string[] $roles
     *
     * @return RoleInterface[]
     */
    private static function createRoles(AuthorisationHierarchy $hierarchy, array $roles): array
    {
        $constructed = [];

        foreach ($roles as $role) {
            $constructed[] = $hierarchy->getRole($role);
        }

        return $constructed;
    }

    /**
     * Create permissions from the serialised forms given.
     *
     * @param string[] $permissions
     *
     * @return RoleInterface[]
     */
    private static function createPermissions(AuthorisationHierarchy $hierarchy, array $permissions): array
    {
        return $hierarchy->getPermissionsByArray($permissions);
    }
}
