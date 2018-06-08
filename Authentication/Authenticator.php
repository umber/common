<?php

declare(strict_types=1);

namespace Umber\Common\Authentication;

use Umber\Common\Authentication\Authorisation\Builder\Resolver\AuthorisationHierarchyResolverInterface;
use Umber\Common\Authentication\Authorisation\Credential\CredentialAwareAuthorisation;
use Umber\Common\Authentication\Prototype\UserInterface;
use Umber\Common\Authentication\Resolver\CredentialResolverInterface;
use Umber\Common\Authentication\Storage\CredentialStorageInterface;
use Umber\Common\Exception\Authentication\Resolver\CannotResolveAuthenticatedUserException;
use Umber\Common\Exception\Authentication\Resolver\CannotResolveAuthenticationMethodException;
use Umber\Common\Exception\Authentication\Resolver\UnsupportedAuthenticationMethodException;
use Umber\Common\Exception\Authentication\UnauthorisedException;

/**
 * An authenticator for resolving and storing user credentials.
 */
final class Authenticator
{
    private $authorisationHierarchyResolver;
    private $credentialResolver;
    private $credentialStorage;

    public function __construct(
        AuthorisationHierarchyResolverInterface $authorisationHierarchyResolver,
        CredentialResolverInterface $credentialResolver,
        CredentialStorageInterface $credentialStorage
    ) {
        $this->authorisationHierarchyResolver = $authorisationHierarchyResolver;
        $this->credentialResolver = $credentialResolver;
        $this->credentialStorage = $credentialStorage;
    }

    /**
     * Attempt to authenticate using the given authentication method.
     *
     * @throws UnauthorisedException When the user cannot be resolved.
     */
    public function authenticate(AuthenticationMethodInterface $method): void
    {
        try {
            $credentials = $this->credentialResolver->resolve($method);
        } catch (CannotResolveAuthenticationMethodException $exception) {
            throw UnauthorisedException::create($exception);
        } catch (UnsupportedAuthenticationMethodException $exception) {
            throw UnauthorisedException::create($exception);
        }

        $hierarchy = $this->authorisationHierarchyResolver->resolve();
        $authorisation = new CredentialAwareAuthorisation($credentials, $hierarchy);

        $this->credentialStorage->authorise($authorisation);
    }

    /**
     * Returns the current authenticated user.
     *
     * @throws UnauthorisedException When the user has not been authenticated.
     * @throws CannotResolveAuthenticatedUserException When the user is not resolved with the credentials.
     */
    public function getUser(): UserInterface
    {
        return $this->credentialStorage->getUser();
    }

    /**
     * Check if a user has been authenticated.
     */
    public function isAuthenticated(): bool
    {
        return $this->credentialStorage->isAuthenticated();
    }
}
