<?php

declare(strict_types=1);

namespace Umber\Common\Authentication;

use Umber\Common\Authentication\Authorisation\AuthorisationInterface;
use Umber\Common\Authentication\Authorisation\User\UserAuthorisationInterface;
use Umber\Common\Authentication\Prototype\UserInterface;

interface AuthenticationStorageInterface
{
    /**
     * Provide the authorisation information.
     */
    public function authorise(UserAuthorisationInterface $authorisation): void;

    public function getUser(): UserInterface;

    public function getAuthorisation(): AuthorisationInterface;

    public function isAuthenticated(): bool;
}
