<?php

declare(strict_types=1);

namespace Umber\Common\Authentication\Resolver\Credential\User;

use Umber\Common\Authentication\Prototype\UserInterface;
use Umber\Common\Authentication\Resolver\Credential\CredentialInterface;

/**
 * A credential implementation that is a pass-through for user instances.
 */
final class UserCredential implements CredentialInterface
{
    private $user;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    /**
     * {@inheritdoc}
     */
    public function getUser(): UserInterface
    {
        return $this->user;
    }
}
