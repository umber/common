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
     *
     * @throws \Exception
     */
    public function authorise(AuthorisationInterface $authorisation): void
    {
        $this->authorisation = $authorisation;

        if ($authorisation instanceof UserAuthorisationInterface) {
            $this->user = $authorisation->getUser();
        }

        throw new \Exception('cannot resolve user');
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

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return $this->authorisation->getRoles();
    }

    /**
     * @return string[]
     */
    public function getPermissions(): array
    {
        return $this->authorisation->getPermissions();
    }
}
