<?php

declare(strict_types=1);

namespace Umber\Common\Authentication;

use Umber\Common\Authentication\Prototype\UserInterface;

interface AuthenticationInterface
{
    public function populate(UserInterface $user): void;

    public function getUser(): UserInterface;

    /**
     * @return string[]
     */
    public function getRoles(): array;

    /**
     * @return string[]
     */
    public function getPermissions(): array;

    public function isAuthenticated(): bool;
}
