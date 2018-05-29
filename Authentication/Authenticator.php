<?php

declare(strict_types=1);

namespace Umber\Common\Authentication;

use Umber\Common\Authentication\Authorisation\User\UserAuthorisation;
use Umber\Common\Authentication\Method\AuthenticationHeaderInterface;
use Umber\Common\Authentication\Prototype\UserInterface;
use Umber\Common\Authentication\Resolver\UserResolverInterface;

final class Authenticator
{
    private $authentication;
    private $resolver;

    public function __construct(
        AuthenticationStorageInterface $authentication,
        UserResolverInterface $resolver
    ) {
        $this->authentication = $authentication;
        $this->resolver = $resolver;
    }

    /**
     *
     * @throws \Exception
     */
    public function authenticate(AuthenticationHeaderInterface $header): void
    {
        $user = $this->resolver->resolve($header);

        if ($user === null) {
            throw new \Exception('missing user');
        }

        $authorisation = new UserAuthorisation($user);

        $this->authentication->authorise($authorisation);
    }

    /**
     * @throws \Exception
     */
    public function getUser(): UserInterface
    {
        if (!$this->isAuthenticated()) {
            throw new \Exception('not authenticated');
        }

        return $this->authentication->getUser();
    }

    public function isAuthenticated(): bool
    {
        return $this->authentication->isAuthenticated();
    }
}
