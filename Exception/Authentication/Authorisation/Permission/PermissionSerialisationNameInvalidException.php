<?php

declare(strict_types=1);

namespace Umber\Common\Exception\Authentication\Authorisation\Permission;

use Umber\Common\Exception\Aware\CanonicalAwareRuntimeException;

/**
 * {@inheritdoc}
 */
final class PermissionSerialisationNameInvalidException extends CanonicalAwareRuntimeException
{
    public const E_PERMISSION_SERIALISATION_NAME_INVALID = 'permission.permission_serialisation_name_invalid';

    /**
     * @return PermissionSerialisationNameInvalidException
     */
    public static function create(string $permission): self
    {
        return new self(self::E_PERMISSION_SERIALISATION_NAME_INVALID, [
            'permission' => $permission,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function message(): array
    {
        return [
            'A transportable permission name should contain its ability.',
            'This is done using the format "permission:ability".',
            'Multiple abilities are possible through multiple entries of the same name.',
            'The permission given ("{{permission}}") is invalid.',
        ];
    }
}
