<?php

declare(strict_types=1);

namespace Umber\Common\Authentication\Resolver;

use Umber\Common\Authentication\AuthenticationMethodInterface;
use Umber\Common\Authentication\Resolver\Credential\CredentialInterface;
use Umber\Common\Exception\Authentication\Resolver\CannotResolveAuthenticationMethodException;
use Umber\Common\Exception\Authentication\Resolver\UnsupportedAuthenticationMethodException;

/**
 * A credentials resolver.
 */
interface CredentialResolverInterface
{
    /**
     * Attempt to resolve all user data for the authentication method provided.
     *
     * @throws CannotResolveAuthenticationMethodException When the resolve fails.
     * @throws UnsupportedAuthenticationMethodException When the authentication method is not supported.
     */
    public function resolve(AuthenticationMethodInterface $method): CredentialInterface;
}
