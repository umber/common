<?php

declare(strict_types=1);

namespace Umber\Common\Authentication\Authorisation\User;

use Umber\Common\Authentication\Authorisation\Authorisation;
use Umber\Common\Authentication\Authorisation\Builder\AuthorisationHierarchy;
use Umber\Common\Authentication\Prototype\UserInterface;

/**
 * {@inheritdoc}
 */
final class UserAuthorisation implements UserAuthorisationInterface
{
    private $user;
    private $authorisation;

    public function __construct(AuthorisationHierarchy $hierarchy, UserInterface $user)
    {
        $this->user = $user;

        $this->authorisation = new Authorisation(
            $hierarchy,
            $user->getAuthorisationRoles(),
            $user->getAuthorisationPermissions()
        );
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
