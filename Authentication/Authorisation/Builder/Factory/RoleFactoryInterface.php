<?php

declare(strict_types=1);

namespace Umber\Common\Authentication\Authorisation\Builder\Factory;

use Umber\Common\Authentication\Authorisation\PermissionInterface;
use Umber\Common\Authentication\Authorisation\RoleInterface;

/**
 * A role factory for creating role instances.
 */
interface RoleFactoryInterface
{
    /**
     * Create a role instance.
     *
     * @param PermissionInterface[] $permissions
     */
    public function create(string $role, array $permissions): RoleInterface;
}
