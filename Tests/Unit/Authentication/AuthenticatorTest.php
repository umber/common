<?php

declare(strict_types=1);

namespace Umber\Common\Tests\Unit\Authentication;

use Umber\Common\Authentication\Authenticator;
use Umber\Common\Authentication\Authorisation\Builder\Resolver\AuthorisationHierarchyResolverInterface;
use Umber\Common\Authentication\Method\Header\AuthorisationHeader;
use Umber\Common\Authentication\Prototype\UserInterface;
use Umber\Common\Authentication\Resolver\Credential\CredentialInterface;
use Umber\Common\Authentication\Resolver\Credential\User\UserCredentialInterface;
use Umber\Common\Authentication\Resolver\CredentialResolverInterface;
use Umber\Common\Authentication\Storage\CredentialStorageInterface;
use Umber\Common\Tests\Fixture\Authentication\AuthorisationHierarchyFixture;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * {@inheritdoc}
 */
final class AuthenticatorTest extends TestCase
{
    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authenticator
     *
     * @throws \ReflectionException
     */
    public function withNotAuthenticatedNotAuthenticated(): void
    {
        /** @var AuthorisationHierarchyResolverInterface|MockObject $authorisationHierarchyResolver */
        $authorisationHierarchyResolver = $this->createMock(AuthorisationHierarchyResolverInterface::class);

        /** @var CredentialResolverInterface|MockObject $credentialResolver */
        $credentialResolver = $this->createMock(CredentialResolverInterface::class);

        /** @var CredentialStorageInterface|MockObject $credentialStorage */
        $credentialStorage = $this->createMock(CredentialStorageInterface::class);
        $credentialStorage->expects(self::once())
            ->method('isAuthenticated')
            ->willReturn(false);

        $authenticator = new Authenticator(
            $authorisationHierarchyResolver,
            $credentialResolver,
            $credentialStorage
        );

        self::assertFalse($authenticator->isAuthenticated());
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authenticator
     *
     * @throws \ReflectionException
     */
    public function withStorageAuthenticatedGetUser(): void
    {
        /** @var UserInterface|MockObject $user */
        $user = $this->createMock(UserInterface::class);

        /** @var AuthorisationHierarchyResolverInterface|MockObject $authorisationHierarchyResolver */
        $authorisationHierarchyResolver = $this->createMock(AuthorisationHierarchyResolverInterface::class);

        /** @var CredentialResolverInterface|MockObject $credentialResolver */
        $credentialResolver = $this->createMock(CredentialResolverInterface::class);

        /** @var CredentialStorageInterface|MockObject $credentialStorage */
        $credentialStorage = $this->createMock(CredentialStorageInterface::class);
        $credentialStorage->expects(self::once())
            ->method('getUser')
            ->willReturn($user);

        $authenticator = new Authenticator(
            $authorisationHierarchyResolver,
            $credentialResolver,
            $credentialStorage
        );

        self::assertSame($user, $authenticator->getUser());
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authenticator
     *
     * @throws \ReflectionException
     */
    public function canAuthenticateTokenWithCredentials(): void
    {
        /** @var AuthorisationHierarchyResolverInterface|MockObject $authorisationHierarchyResolver */
        $authorisationHierarchyResolver = $this->createMock(AuthorisationHierarchyResolverInterface::class);
        $authorisationHierarchyResolver->expects(self::once())
            ->method('resolve')
            ->willReturn(
                AuthorisationHierarchyFixture::create()
            );

        /** @var CredentialInterface|MockObject $credentials */
        $credentials = $this->createMock(CredentialInterface::class);
        $credentials->expects(self::once())
            ->method('getAuthorisationRoles')
            ->willReturn([]);

        $credentials->expects(self::once())
            ->method('getAuthorisationPermissions')
            ->willReturn([]);

        /** @var CredentialResolverInterface|MockObject $credentialResolver */
        $credentialResolver = $this->createMock(CredentialResolverInterface::class);
        $credentialResolver->expects(self::once())
            ->method('resolve')
            ->willReturn($credentials);

        /** @var CredentialStorageInterface|MockObject $credentialStorage */
        $credentialStorage = $this->createMock(CredentialStorageInterface::class);
        $credentialStorage->expects(self::once())
            ->method('authorise');

        $authenticator = new Authenticator(
            $authorisationHierarchyResolver,
            $credentialResolver,
            $credentialStorage
        );

        $authenticator->authenticate(new AuthorisationHeader('bearer', 'some-value'));
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authenticator
     *
     * @throws \ReflectionException
     */
    public function canAuthenticateTokenWithUserCredentials(): void
    {
        /** @var AuthorisationHierarchyResolverInterface|MockObject $authorisationHierarchyResolver */
        $authorisationHierarchyResolver = $this->createMock(AuthorisationHierarchyResolverInterface::class);
        $authorisationHierarchyResolver->expects(self::once())
            ->method('resolve')
            ->willReturn(
                AuthorisationHierarchyFixture::create()
            );

        /** @var UserCredentialInterface|MockObject $credentials */
        $credentials = $this->createMock(UserCredentialInterface::class);
        $credentials->expects(self::never())
            ->method('getUser');

        $credentials->expects(self::once())
            ->method('getAuthorisationRoles')
            ->willReturn([]);

        $credentials->expects(self::once())
            ->method('getAuthorisationPermissions')
            ->willReturn([]);

        /** @var CredentialResolverInterface|MockObject $credentialResolver */
        $credentialResolver = $this->createMock(CredentialResolverInterface::class);
        $credentialResolver->expects(self::once())
            ->method('resolve')
            ->willReturn($credentials);

        /** @var CredentialStorageInterface|MockObject $credentialStorage */
        $credentialStorage = $this->createMock(CredentialStorageInterface::class);
        $credentialStorage->expects(self::once())
            ->method('authorise');

        $authenticator = new Authenticator(
            $authorisationHierarchyResolver,
            $credentialResolver,
            $credentialStorage
        );

        $authenticator->authenticate(new AuthorisationHeader('bearer', 'some-value'));
    }
}
