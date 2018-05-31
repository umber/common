<?php

declare(strict_types=1);

namespace Umber\Common\Tests\Model\Authentication;

use Umber\Common\Authentication\Framework\SymfonyUserTrait;
use Umber\Common\Authentication\Prototype\UserInterface as CommonUserInterface;

use Symfony\Component\Security\Core\User\UserInterface as SymfonyUserInterface;

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
