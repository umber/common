<?php

declare(strict_types=1);

namespace Umber\Common\Authentication\Storage;

use Umber\Common\Authentication\Authorisation\Credential\CredentialAwareAuthorisationInterface;
use Umber\Common\Authentication\Prototype\UserInterface;
use Umber\Common\Exception\Authentication\UnauthorisedException;

/**
 * A credentials storage.
 */
interface CredentialStorageInterface
{
    /**
     * Authorise credentials.
     */
    public function authorise(CredentialAwareAuthorisationInterface $authorisation): void;

    /**
     * Return the user authorisation.
     *
     * @throws UnauthorisedException When the user is not authenticated.
     */
    public function getAuthorisation(): CredentialAwareAuthorisationInterface;

    /**
     * Return the authenticated user.
     *
     * @throws UnauthorisedException When the user is not authenticated.
     */
    public function getUser(): UserInterface;

    /**
     * Check if a user has been authenticated.
     */
    public function isAuthenticated(): bool;
}
