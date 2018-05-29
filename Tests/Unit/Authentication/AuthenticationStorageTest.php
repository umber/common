<?php

declare(strict_types=1);

namespace Umber\Common\Tests\Unit\Authentication;

use Umber\Common\Authentication\AuthenticationStorage;
use Umber\Common\Authentication\Authorisation\User\UserAuthorisationInterface;
use Umber\Common\Authentication\Prototype\UserInterface;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * {@inheritdoc}
 */
final class AuthenticationStorageTest extends TestCase
{
    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\AuthenticationStorage
     */
    public function canUnderstandIsAuthenticated(): void
    {
        $storage = new AuthenticationStorage();

        self::assertFalse($storage->isAuthenticated());
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\AuthenticationStorage
     *
     * @throws \ReflectionException
     */
    public function canAuthoriseAuthenticationStorage(): void
    {
        /** @var UserInterface|MockObject $user */
        $user = $this->createMock(UserInterface::class);

        /** @var UserAuthorisationInterface|MockObject $authorisation */
        $authorisation = $this->createMock(UserAuthorisationInterface::class);
        $authorisation->expects(self::once())
            ->method('getUser')
            ->willReturn($user);

        $storage = new AuthenticationStorage();
        $storage->authorise($authorisation);

        self::assertTrue($storage->isAuthenticated());
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\AuthenticationStorage
     *
     * @throws \ReflectionException
     */
    public function canProxyAuthenticationMethods(): void
    {
        /** @var UserInterface|MockObject $user */
        $user = $this->createMock(UserInterface::class);

        /** @var UserAuthorisationInterface|MockObject $authorisation */
        $authorisation = $this->createMock(UserAuthorisationInterface::class);
        $authorisation->expects(self::once())
            ->method('getUser')
            ->willReturn($user);

        $storage = new AuthenticationStorage();
        $storage->authorise($authorisation);

        self::assertSame($authorisation, $storage->getAuthorisation());
        self::assertSame($user, $storage->getUser());
    }
}
