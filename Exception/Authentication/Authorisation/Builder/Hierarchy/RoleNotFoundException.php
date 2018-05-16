<?php

declare(strict_types=1);

namespace Umber\Common\Exception\Authentication\Authorisation\Builder\Hierarchy;

use Umber\Common\Exception\Authentication\Authorisation\Builder\AbstractAuthorisationRoleHierarchyException;

/**
 * {@inheritdoc}
 */
final class RoleNotFoundException extends AbstractAuthorisationRoleHierarchyException
{
    public const E_ROLE_NOT_FOUND = 'role_not_found';

    /**
     * @return DuplicateRoleException
     */
    public static function create(string $role): self
    {
        return new self(self::E_ROLE_NOT_FOUND, [
            'name' => $role,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function message(): array
    {
        return [
            'The role "{{name}}" was not found.',
        ];
    }
}
