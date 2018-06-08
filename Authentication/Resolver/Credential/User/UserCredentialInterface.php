<?php

declare(strict_types=1);

namespace Umber\Common\Authentication\Resolver\Credential\User;

use Umber\Common\Authentication\Prototype\UserInterface;
use Umber\Common\Authentication\Resolver\Credential\CredentialInterface;

/**
 * Resolved user credentials.
 */
interface UserCredentialInterface extends CredentialInterface
{
    /**
     * Return the resolved user.
     */
    public function getUser(): UserInterface;
}
