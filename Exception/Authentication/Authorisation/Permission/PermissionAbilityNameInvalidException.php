<?php

declare(strict_types=1);

namespace Umber\Common\Exception\Authentication\Authorisation\Permission;

use Umber\Common\Exception\Aware\CanonicalAwareRuntimeException;

/**
 * {@inheritdoc}
 */
final class PermissionAbilityNameInvalidException extends CanonicalAwareRuntimeException
{
    public const E_PERMISSION_ABILITY_NAME_INVALID = 'permission.ability_name_invalid';

    /**
     * @return PermissionAbilityNameInvalidException
     */
    public static function create(string $scope, string $ability): self
    {
        return new self(self::E_PERMISSION_ABILITY_NAME_INVALID, [
            'scope' => $scope,
            'ability' => $ability,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function message(): array
    {
        return [
            'A permission ability should only contain alphabetic characters and hyphens or underscores.',
            'The permission ability provided ("{{ability}}") is invalid for scope "{{scope}}".',
        ];
    }
}
