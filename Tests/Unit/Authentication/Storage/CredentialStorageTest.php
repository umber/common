<?php

declare(strict_types=1);

namespace Umber\Common\Tests\Unit\Authentication\Storage;

use Umber\Common\Authentication\Authorisation\Credential\CredentialAwareAuthorisationInterface;
use Umber\Common\Authentication\Prototype\UserInterface;
use Umber\Common\Authentication\Resolver\Credential\CredentialInterface;
use Umber\Common\Authentication\Resolver\Credential\User\UserCredentialInterface;
use Umber\Common\Authentication\Storage\CredentialStorage;
use Umber\Common\Exception\Authentication\Resolver\CannotResolveAuthenticatedUserException;
use Umber\Common\Exception\Authentication\UnauthorisedException;

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
    public function withFreshInstanceNotAuthenticated(): void
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
     */
    public function withFreshInstanceCannotGetCredentials(): void
    {
        $storage = new CredentialStorage();

        self::expectException(UnauthorisedException::class);

        $storage->getCredentials();
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Storage\CredentialStorage
     */
    public function withFreshInstanceCannotGetAuthorisation(): void
    {
        $storage = new CredentialStorage();

        self::expectException(UnauthorisedException::class);

        $storage->getAuthorisation();
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Storage\CredentialStorage
     */
    public function withFreshInstanceCannotGetUser(): void
    {
        $storage = new CredentialStorage();

        self::expectException(UnauthorisedException::class);

        $storage->getUser();
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
            ->method('getCredentials');

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
    public function canAuthoriseGetCredentials(): void
    {
        /** @var CredentialInterface|MockObject $credentials */
        $credentials = $this->createMock(CredentialInterface::class);

        /** @var CredentialAwareAuthorisationInterface|MockObject $authorisation */
        $authorisation = $this->createMock(CredentialAwareAuthorisationInterface::class);
        $authorisation->expects(self::once())
            ->method('getCredentials')
            ->willReturn($credentials);

        $storage = new CredentialStorage();
        $storage->authorise($authorisation);

        self::assertSame($credentials, $storage->getCredentials());
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
    public function canAuthoriseGetAuthorisation(): void
    {
        /** @var CredentialAwareAuthorisationInterface|MockObject $authorisation */
        $authorisation = $this->createMock(CredentialAwareAuthorisationInterface::class);
        $authorisation->expects(self::never())
            ->method('getCredentials');

        $storage = new CredentialStorage();
        $storage->authorise($authorisation);

        self::assertSame($authorisation, $storage->getAuthorisation());
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
    public function withBasicAuthorisationCannotGetUser(): void
    {
        /** @var CredentialInterface|MockObject $credentials */
        $credentials = $this->createMock(CredentialInterface::class);

        /** @var CredentialAwareAuthorisationInterface|MockObject $authorisation */
        $authorisation = $this->createMock(CredentialAwareAuthorisationInterface::class);
        $authorisation->expects(self::once())
            ->method('getCredentials')
            ->willReturn($credentials);

        $storage = new CredentialStorage();
        $storage->authorise($authorisation);

        self::expectException(CannotResolveAuthenticatedUserException::class);

        $storage->getUser();
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
    public function withUserCredentialsCanGetUser(): void
    {
        /** @var UserInterface|MockObject $user */
        $user = $this->createMock(UserInterface::class);

        /** @var UserCredentialInterface|MockObject $credentials */
        $credentials = $this->createMock(UserCredentialInterface::class);
        $credentials->expects(self::once())
            ->method('getUser')
            ->willReturn($user);

        /** @var CredentialAwareAuthorisationInterface|MockObject $authorisation */
        $authorisation = $this->createMock(CredentialAwareAuthorisationInterface::class);
        $authorisation->expects(self::once())
            ->method('getCredentials')
            ->willReturn($credentials);

        $storage = new CredentialStorage();
        $storage->authorise($authorisation);

        self::assertSame($user, $storage->getUser());
    }
}
