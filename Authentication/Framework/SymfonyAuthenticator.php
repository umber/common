<?php

declare(strict_types=1);

namespace Umber\Common\Authentication\Framework;

use Umber\Common\Authentication\Authenticator;
use Umber\Common\Authentication\Framework\Method\Header\RequestAuthorisationHeader;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;

/**
 * {@inheritdoc}
 */
final class SymfonyAuthenticator implements SimplePreAuthenticatorInterface
{
    private $authenticator;

    public function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsToken(TokenInterface $token, $provider)
    {
        return ($token instanceof PreAuthenticatedToken)
            && ($token->getProviderKey() === $provider);
    }

    /**
     * {@inheritdoc}
     */
    public function createToken(Request $request, $provider)
    {
        $header = new RequestAuthorisationHeader($request);

        $this->authenticator->authenticate($header);

        return new PreAuthenticatedToken(
            $header->getType(),
            $header->getValue(),
            $provider
        );
    }

    /**
     * {@inheritdoc}
     */
    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $provider)
    {
        $user = $this->authenticator->getUser();

        return new PreAuthenticatedToken(
            $user,
            $token->getCredentials(),
            $provider,
            $user->getRoles()
        );
    }
}
