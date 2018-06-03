<?php

declare(strict_types=1);

namespace Umber\Common\Authentication;

use Umber\Common\Authentication\Authorisation\Builder\Resolver\AuthorisationHierarchyResolverInterface;
use Umber\Common\Authentication\Authorisation\User\UserAuthorisation;
use Umber\Common\Authentication\Method\AuthenticationHeaderInterface;
use Umber\Common\Authentication\Prototype\UserInterface;
use Umber\Common\Authentication\Resolver\UserResolverInterface;
use Umber\Common\Exception\Authentication\UnauthorisedException;

final class Authenticator
{
    private $authenticationStorage;
    private $authorisationHierarchyResolver;
    private $userResolver;

    public function __construct(
        AuthenticationStorageInterface $authenticationStorage,
        AuthorisationHierarchyResolverInterface $authorisationHierarchyResolver,
        UserResolverInterface $userResolver
    ) {
        $this->authenticationStorage = $authenticationStorage;
        $this->authorisationHierarchyResolver = $authorisationHierarchyResolver;
        $this->userResolver = $userResolver;
    }

    /**
     *
     * @throws \Exception
     */
    public function authenticate(AuthenticationHeaderInterface $header): void
    {
        $user = $this->userResolver->resolve($header);

        if ($user === null) {
            throw UnauthorisedException::create();
        }

        $hierarchy = $this->authorisationHierarchyResolver->resolve();

        $authorisation = new UserAuthorisation($hierarchy, $user);

        $this->authenticationStorage->authorise($authorisation);
    }

    /**
     * @throws \Exception
     */
    public function getUser(): UserInterface
    {
        if (!$this->isAuthenticated()) {
            throw new \Exception('not authenticated');
        }

        return $this->authenticationStorage->getUser();
    }

    public function isAuthenticated(): bool
    {
        return $this->authenticationStorage->isAuthenticated();
    }
}
