<?php

declare(strict_types=1);

namespace Umber\Common\Exception\Authentication\Authorisation\Permission;

use Umber\Common\Exception\Aware\CanonicalAwareRuntimeException;

/**
 * {@inheritdoc}
 */
final class PermissionScopeNameInvalidException extends CanonicalAwareRuntimeException
{
    public const E_PERMISSION_SCOPE_NAME_INVALID = 'permission.scope_name_invalid';

    /**
     * @return PermissionScopeNameInvalidException
     */
    public static function create(string $scope): self
    {
        return new self(self::E_PERMISSION_SCOPE_NAME_INVALID, [
            'scope' => $scope,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function message(): array
    {
        return [
            'A permission scope name should only contain alphabetic characters and hyphens or underscores.',
            'The permission scope name provided ("{{scope}}") is invalid.',
        ];
    }
}
