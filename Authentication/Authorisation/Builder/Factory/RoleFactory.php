<?php

declare(strict_types=1);

namespace Umber\Common\Authentication\Authorisation\Builder\Factory;

use Umber\Common\Authentication\Authorisation\Role;
use Umber\Common\Authentication\Authorisation\RoleInterface;

/**
 * {@inheritdoc}
 */
final class RoleFactory implements RoleFactoryInterface
{
    /**
     * {@inheritdoc}
     *
     * @return Role
     */
    public function create(string $role, array $permissions): RoleInterface
    {
        return new Role($role, array_values($permissions));
    }
}
