<?php

declare(strict_types=1);

namespace Umber\Common\Exception\Authentication\Authorisation\Builder\Hierarchy;

use Umber\Common\Exception\Authentication\Authorisation\Builder\AbstractAuthorisationRoleHierarchyException;

/**
 * {@inheritdoc}
 */
final class PermissionMissingAbilitiesException extends AbstractAuthorisationRoleHierarchyException
{
    public const E_PERMISSION_MISSING_ABILITIES = 'permission_missing_abilities';

    /**
     * @return DuplicateRoleException
     */
    public static function create(string $scope): self
    {
        return new self(self::E_PERMISSION_MISSING_ABILITIES, [
            'scope' => $scope,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function message(): array
    {
        return [
            'The hierarchy expects that all permissions come with at least one ability.',
            'The permission scope "{{scope}}" has no abilities assigned to it so is considered useless.',
        ];
    }
}
