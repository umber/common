<?php

declare(strict_types=1);

namespace Umber\Common\Exception\Authentication\Authorisation\Builder\Hierarchy;

use Umber\Common\Exception\Authentication\Authorisation\Builder\AbstractAuthorisationRoleHierarchyException;

/**
 * {@inheritdoc}
 */
final class PermissionAbilityNotFoundException extends AbstractAuthorisationRoleHierarchyException
{
    public const E_PERMISSION_ABILITY_NOT_FOUND = 'permission_ability_not_found';

    /**
     * @return DuplicateRoleException
     */
    public static function create(string $scope, string $ability): self
    {
        return new self(self::E_PERMISSION_ABILITY_NOT_FOUND, [
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
            'The permission ability "{{ability}}" was not found against the scope "{{scope}}".',
        ];
    }
}
