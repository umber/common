<?php

declare(strict_types=1);

namespace Umber\Common\Tests\Unit\Authentication\Storage;

use Umber\Common\Authentication\Authorisation\Credential\CredentialAwareAuthorisationInterface;
use Umber\Common\Authentication\Prototype\UserInterface;
use Umber\Common\Authentication\Storage\CredentialStorage;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * {@inheritdoc}
 */
final class CredentialStorageTest extends TestCase
{
    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Storage\CredentialStorage
     */
    public function canUnderstandIsAuthenticated(): void
    {
        $storage = new CredentialStorage();

        self::assertFalse($storage->isAuthenticated());
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Storage\CredentialStorage
     *
     * @throws \ReflectionException
     */
    public function canAuthorise(): void
    {
        /** @var CredentialAwareAuthorisationInterface|MockObject $authorisation */
        $authorisation = $this->createMock(CredentialAwareAuthorisationInterface::class);
        $authorisation->expects(self::never())
            ->method('getUser');

        $storage = new CredentialStorage();
        $storage->authorise($authorisation);

        self::assertTrue($storage->isAuthenticated());
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Storage\CredentialStorage
     *
     * @throws \ReflectionException
     */
    public function canAuthoriseGetUser(): void
    {
        /** @var UserInterface|MockObject $user */
        $user = $this->createMock(UserInterface::class);

        /** @var CredentialAwareAuthorisationInterface|MockObject $authorisation */
        $authorisation = $this->createMock(CredentialAwareAuthorisationInterface::class);
        $authorisation->expects(self::once())
            ->method('getUser')
            ->willReturn($user);

        $storage = new CredentialStorage();
        $storage->authorise($authorisation);

        self::assertSame($user, $storage->getUser());
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Storage\CredentialStorage
     *
     * @throws \ReflectionException
     */
    public function canProxyAuthenticationMethods(): void
    {
        /** @var UserInterface|MockObject $user */
        $user = $this->createMock(UserInterface::class);

        /** @var CredentialAwareAuthorisationInterface|MockObject $authorisation */
        $authorisation = $this->createMock(CredentialAwareAuthorisationInterface::class);
        $authorisation->expects(self::once())
            ->method('getUser')
            ->willReturn($user);

        $storage = new CredentialStorage();
        $storage->authorise($authorisation);

        self::assertSame($authorisation, $storage->getAuthorisation());
        self::assertSame($user, $storage->getUser());
    }
}
