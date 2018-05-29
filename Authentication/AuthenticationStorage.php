<?php

declare(strict_types=1);

namespace Umber\Common\Authentication;

use Umber\Common\Authentication\Authorisation\AuthorisationInterface;
use Umber\Common\Authentication\Authorisation\User\UserAuthorisationInterface;
use Umber\Common\Authentication\Prototype\UserInterface;

final class AuthenticationStorage implements AuthenticationStorageInterface
{
    /** @var AuthorisationInterface|null */
    private $authorisation;

    /** @var UserInterface|null */
    private $user;

    /**
     * {@inheritdoc}
     */
    public function authorise(UserAuthorisationInterface $authorisation): void
    {
        $this->authorisation = $authorisation;
        $this->user = $authorisation->getUser();
    }

    /**
     * {@inheritdoc}
     */
    public function getUser(): UserInterface
    {
        return $this->user;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthorisation(): AuthorisationInterface
    {
        return $this->authorisation;
    }

    /**
     * {@inheritdoc}
     */
    public function isAuthenticated(): bool
    {
        return $this->user !== null;
    }
}
