<?php

declare(strict_types=1);

namespace Umber\Common\Exception\Authentication\Authorisation\Builder\Hierarchy;

use Umber\Common\Exception\Authentication\Authorisation\Builder\AbstractAuthorisationRoleHierarchyException;

/**
 * {@inheritdoc}
 */
final class DuplicateRoleException extends AbstractAuthorisationRoleHierarchyException
{
    public const E_DUPLICATE_ROLE = 'duplicate_role';

    /**
     * @return DuplicateRoleException
     */
    public static function create(string $name): self
    {
        return new self(self::E_DUPLICATE_ROLE, [
            'name' => $name,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function message(): array
    {
        return [
            'The hierarchy cannot contain duplicate roles.',
            'The role "{{name}}" has already been defined and cannot be overwritten or merged.',
        ];
    }
}
