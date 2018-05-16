<?php

declare(strict_types=1);

namespace Umber\Common\Exception\Authentication\Authorisation\Role;

use Umber\Common\Exception\Aware\CanonicalAwareRuntimeException;

/**
 * {@inheritdoc}
 */
final class RoleNameInvalidException extends CanonicalAwareRuntimeException
{
    public const E_ROLE_NAME_INVALID = 'role.name_invalid';

    /**
     * @return RoleNameInvalidException
     */
    public static function create(string $role): self
    {
        return new self(self::E_ROLE_NAME_INVALID, [
            'name' => $role,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function message(): array
    {
        return [
            'A role name should only contain alphabetic characters and hyphens or underscores.',
            'The role name provided ("{{name}}") is invalid.',
        ];
    }
}
