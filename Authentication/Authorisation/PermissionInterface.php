<?php

declare(strict_types=1);

namespace Umber\Common\Authentication\Authorisation;

interface PermissionInterface
{
    public const WILDCARD = '*';

    public function getScope(): string;

    /**
     * @return RoleInterface[]
     */
//    public function getParentRoles(): array;

    /**
     * @return string[]
     */
    public function getAbilities(): array;

    public function hasAbility(string $ability): bool;
}
