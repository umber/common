<?php

declare(strict_types=1);

namespace Umber\Common\Authentication\Authorisation\Credential;

use Umber\Common\Authentication\Authorisation\Authorisation;
use Umber\Common\Authentication\Authorisation\Builder\AuthorisationHierarchy;
use Umber\Common\Authentication\Prototype\UserInterface;
use Umber\Common\Authentication\Resolver\Credential\CredentialInterface;

/**
 * {@inheritdoc}
 */
final class CredentialAwareAuthorisation implements CredentialAwareAuthorisationInterface
{
    private $credentials;
    private $authorisation;

    public function __construct(CredentialInterface $credentials, AuthorisationHierarchy $hierarchy)
    {
        $this->credentials = $credentials;

        $user = $credentials->getUser();

        $this->authorisation = new Authorisation(
            $user->getAuthorisationRoles(),
            $user->getAuthorisationPermissions(),
            $hierarchy
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentials(): CredentialInterface
    {
        return $this->credentials;
    }

    /**
     * {@inheritdoc}
     */
    public function getUser(): UserInterface
    {
        return $this->credentials->getUser();
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles(): array
    {
        return $this->authorisation->getRoles();
    }

    /**
     * {@inheritdoc}
     */
    public function hasRole(string $role): bool
    {
        return $this->authorisation->hasRole($role);
    }

    /**
     * {@inheritdoc}
     */
    public function getPermissions(): array
    {
        return $this->authorisation->getPermissions();
    }

    /**
     * {@inheritdoc}
     */
    public function hasPermission(string $scope, string $attribute): bool
    {
        return $this->authorisation->hasPermission($scope, $attribute);
    }

    /**
     * {@inheritdoc}
     */
    public function getPassivePermissions(): array
    {
        return $this->authorisation->getPassivePermissions();
    }
}
