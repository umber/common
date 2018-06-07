<?php

declare(strict_types=1);

namespace Umber\Common\Authentication\Storage;

use Umber\Common\Authentication\Authorisation\Credential\CredentialAwareAuthorisationInterface;
use Umber\Common\Authentication\Prototype\UserInterface;
use Umber\Common\Exception\Authentication\UnauthorisedException;

/**
 * {@inheritdoc}
 */
final class CredentialStorage implements CredentialStorageInterface
{
    /** @var CredentialAwareAuthorisationInterface|null */
    private $authorisation;

    /**
     * {@inheritdoc}
     */
    public function authorise(CredentialAwareAuthorisationInterface $authorisation): void
    {
        $this->authorisation = $authorisation;
    }

    /**
     * {@inheritdoc}
     */
    public function getUser(): UserInterface
    {
        if ($this->isAuthenticated() === false) {
            throw UnauthorisedException::create();
        }

        return $this->authorisation->getUser();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthorisation(): CredentialAwareAuthorisationInterface
    {
        if ($this->isAuthenticated() === false) {
            throw UnauthorisedException::create();
        }

        return $this->authorisation;
    }

    /**
     * {@inheritdoc}
     */
    public function isAuthenticated(): bool
    {
        return $this->authorisation !== null;
    }
}
