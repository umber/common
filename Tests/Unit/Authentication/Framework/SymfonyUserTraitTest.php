<?php

namespace Umber\Common\Tests\Unit\Authentication\Framework;

use PHPUnit\Framework\TestCase;
use Umber\Common\Authentication\Framework\SymfonyUserTrait;
use Umber\Common\Authentication\Prototype\UserInterface;

/**
 * {@inheritdoc}
 */
final class SymfonyUserTraitTest extends TestCase
{
    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Framework\SymfonyUserTrait
     */
    public function canTraitWork(): void
    {
        $class = new class implements UserInterface {
            use SymfonyUserTrait;

            /**
             * {@inheritdoc}
             */
            public function getEmail(): string
            {
                return 'some@email';
            }

            /**
             * {@inheritdoc}
             */
            public function getAuthorisationRoles(): array
            {
                return [
                    'some-role-a',
                    'some-role-b',
                ];
            }

            /**
             * {@inheritdoc}
             */
            public function getAuthorisationPermissions(): array
            {
                return [
                    'permission-a',
                    'permission-b',
                    'permission-c',
                ];
            }
        };

        self::assertEquals('some@email', $class->getEmail());
        self::assertEquals('some@email', $class->getUsername());

        self::assertEquals('password', $class->getPassword());
        self::assertNull($class->getSalt());

        $roles = [
            'some-role-a',
            'some-role-b',
        ];

        self::assertEquals($roles, $class->getRoles());

        //  This will do nothing as per.
        $class->eraseCredentials();
    }
}
