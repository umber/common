<?php

declare(strict_types=1);

namespace Umber\Common\Exception\Authentication\Authorisation\Builder\Hierarchy;

use Umber\Common\Exception\Authentication\Authorisation\Builder\AbstractAuthorisationRoleHierarchyException;

/**
 * {@inheritdoc}
 */
final class PermissionScopeNotFoundException extends AbstractAuthorisationRoleHierarchyException
{
    public const E_PERMISSION_SCOPE_NOT_FOUND = 'permission_scope_not_found';

    /**
     * @return DuplicateRoleException
     */
    public static function create(string $scope): self
    {
        return new self(self::E_PERMISSION_SCOPE_NOT_FOUND, [
            'scope' => $scope,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function message(): array
    {
        return [
            'The permission scope "{{scope}}" was not found.',
        ];
    }
}
