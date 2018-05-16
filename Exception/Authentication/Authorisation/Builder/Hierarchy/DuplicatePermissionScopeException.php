<?php

declare(strict_types=1);

namespace Umber\Common\Exception\Authentication\Authorisation\Builder\Hierarchy;

use Umber\Common\Exception\Authentication\Authorisation\Builder\AbstractAuthorisationRoleHierarchyException;

/**
 * {@inheritdoc}
 */
final class DuplicatePermissionScopeException extends AbstractAuthorisationRoleHierarchyException
{
    public const E_DUPLICATE_PERMISSION_SCOPE = 'duplicate_permission_scope';

    /**
     * @return DuplicateRoleException
     */
    public static function create(string $scope): self
    {
        return new self(self::E_DUPLICATE_PERMISSION_SCOPE, [
            'scope' => $scope,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function message(): array
    {
        return [
            'The hierarchy cannot contain duplicate permission scopes.',
            'The permission scope "{{scope}}" has already been defined and cannot be overwritten or merged.',
        ];
    }
}
