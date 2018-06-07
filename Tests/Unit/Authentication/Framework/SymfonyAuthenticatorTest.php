<?php

declare(strict_types=1);

namespace Umber\Common\Tests\Unit\Authentication\Framework;

use Umber\Common\Authentication\Authenticator;
use Umber\Common\Authentication\Authorisation\Builder\Resolver\AuthorisationHierarchyResolverInterface;
use Umber\Common\Authentication\Framework\Method\Header\RequestAuthorisationHeader;
use Umber\Common\Authentication\Framework\SymfonyAuthenticator;
use Umber\Common\Authentication\Resolver\Credential\User\UserCredential;
use Umber\Common\Authentication\Resolver\CredentialResolverInterface;
use Umber\Common\Authentication\Storage\CredentialStorageInterface;
use Umber\Common\Tests\Fixture\Authentication\AuthorisationHierarchyFixture;
use Umber\Common\Tests\Model\Authentication\UserTestModel;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * {@inheritdoc}
 */
final class SymfonyAuthenticatorTest extends TestCase
{
    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Framework\SymfonyAuthenticator
     *
     * @throws \ReflectionException
     */
    public function withInvalidTokenNoSupport(): void
    {
        /** @var AuthorisationHierarchyResolverInterface|MockObject $authorisationHierarchyResolver */
        $authorisationHierarchyResolver = $this->createMock(AuthorisationHierarchyResolverInterface::class);

        /** @var CredentialResolverInterface|MockObject $credentialResolver */
        $credentialResolver = $this->createMock(CredentialResolverInterface::class);

        /** @var CredentialStorageInterface|MockObject $credentialStorage */
        $credentialStorage = $this->createMock(CredentialStorageInterface::class);

        $authenticator = new Authenticator(
            $authorisationHierarchyResolver,
            $credentialResolver,
            $credentialStorage
        );

        $symfony = new SymfonyAuthenticator($authenticator);

        /** @var TokenInterface|MockObject $token */
        $token = $this->createMock(TokenInterface::class);

        self::assertFalse($symfony->supportsToken($token, 'provider'));
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Framework\SymfonyAuthenticator
     *
     * @throws \ReflectionException
     */
    public function canSupportPreAuthenticatedTokenOnly(): void
    {
        /** @var AuthorisationHierarchyResolverInterface|MockObject $authorisationHierarchyResolver */
        $authorisationHierarchyResolver = $this->createMock(AuthorisationHierarchyResolverInterface::class);
        $authorisationHierarchyResolver->expects(self::never())
            ->method('resolve');

        /** @var CredentialResolverInterface|MockObject $credentialResolver */
        $credentialResolver = $this->createMock(CredentialResolverInterface::class);
        $credentialResolver->expects(self::never())
            ->method('resolve');

        /** @var CredentialStorageInterface|MockObject $credentialStorage */
        $credentialStorage = $this->createMock(CredentialStorageInterface::class);

        $authenticator = new Authenticator(
            $authorisationHierarchyResolver,
            $credentialResolver,
            $credentialStorage
        );

        $symfony = new SymfonyAuthenticator($authenticator);

        $token = new PreAuthenticatedToken(
            'user',
            'credentials',
            'provider',
            []
        );

        self::assertTrue($symfony->supportsToken($token, 'provider'));
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Framework\SymfonyAuthenticator
     *
     * @throws \ReflectionException
     */
    public function canCreatePreAuthenticatedToken(): void
    {
        $user = new UserTestModel();

        /** @var AuthorisationHierarchyResolverInterface|MockObject $authorisationHierarchyResolver */
        $authorisationHierarchyResolver = $this->createMock(AuthorisationHierarchyResolverInterface::class);
        $authorisationHierarchyResolver->expects(self::once())
            ->method('resolve')
            ->willReturn(
                AuthorisationHierarchyFixture::create()
            );

        /** @var CredentialResolverInterface|MockObject $credentialResolver */
        $credentialResolver = $this->createMock(CredentialResolverInterface::class);
        $credentialResolver->expects(self::once())
            ->method('resolve')
            ->willReturn(
                new UserCredential($user)
            );

        /** @var CredentialStorageInterface|MockObject $credentialStorage */
        $credentialStorage = $this->createMock(CredentialStorageInterface::class);
        $credentialStorage->expects(self::once())
            ->method('authorise');

        $authenticator = new Authenticator(
            $authorisationHierarchyResolver,
            $credentialResolver,
            $credentialStorage
        );

        $symfony = new SymfonyAuthenticator($authenticator);

        $request = new Request();
        $request->headers->set(RequestAuthorisationHeader::AUTHORISATION_HEADER, 'Bearer some-value');

        $token = $symfony->createToken($request, 'provider');

        self::assertInstanceOf(PreAuthenticatedToken::class, $token);
        self::assertEquals('provider', $token->getProviderKey());
        self::assertEquals('some-value', $token->getCredentials());
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Framework\SymfonyAuthenticator
     *
     * @throws \ReflectionException
     */
    public function canAuthenticateToken(): void
    {
        $user = new UserTestModel();

        /** @var AuthorisationHierarchyResolverInterface|MockObject $authorisationHierarchyResolver */
        $authorisationHierarchyResolver = $this->createMock(AuthorisationHierarchyResolverInterface::class);
        $authorisationHierarchyResolver->expects(self::never())
            ->method('resolve');

        /** @var CredentialResolverInterface|MockObject $credentialResolver */
        $credentialResolver = $this->createMock(CredentialResolverInterface::class);
        $credentialResolver->expects(self::never())
            ->method('resolve');

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

        $symfony = new SymfonyAuthenticator($authenticator);

        /** @var UserProviderInterface|MockObject $userProvider */
        $userProvider = $this->createMock(UserProviderInterface::class);

        $token = new PreAuthenticatedToken(
            'user',
            'credentials',
            'provider',
            []
        );

        $token = $symfony->authenticateToken($token, $userProvider, 'provider');

        self::assertInstanceOf(PreAuthenticatedToken::class, $token);
        self::assertEquals('provider', $token->getProviderKey());
        self::assertEquals('credentials', $token->getCredentials());
        self::assertSame($user, $token->getUser());
    }
}
