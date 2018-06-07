<?php

declare(strict_types=1);

namespace Umber\Common\Authentication\Resolver\Credential;

use Umber\Common\Authentication\Prototype\UserInterface;

/**
 * An object that contains the resolved credentials.
 */
interface CredentialInterface
{
    /**
     * Return the resolved user.
     */
    public function getUser(): UserInterface;
}
