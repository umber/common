<?php

namespace Umber\Common\Tests\Model\Authentication;

use Symfony\Component\Security\Core\User\UserInterface as SymfonyUserInterface;
use Umber\Common\Authentication\Framework\SymfonyUserTrait;
use Umber\Common\Authentication\Prototype\UserInterface as CommonUserInterface;

/**
 * A user test model.
 *
 * @internal
 */
final class UserTestModel implements CommonUserInterface, SymfonyUserInterface
{
    use SymfonyUserTrait;

    /**
     * {@inheritdoc}
     */
    public function getEmail(): string
    {
        return 'some@email.com';
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthorisationRoles(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthorisationPermissions(): array
    {
        return [];
    }
}
