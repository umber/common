<?php

namespace Umber\Common\Tests\Unit\Authentication\Framework;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Umber\Common\Authentication\AuthenticationStorage;
use Umber\Common\Authentication\AuthenticationStorageInterface;
use Umber\Common\Authentication\Authenticator;
use Umber\Common\Authentication\Authorisation\Builder\Resolver\AuthorisationHierarchyResolverInterface;
use Umber\Common\Authentication\Framework\Method\Header\RequestAuthorisationHeader;
use Umber\Common\Authentication\Framework\SymfonyAuthenticator;
use Umber\Common\Authentication\Framework\SymfonyUserTrait;
use Umber\Common\Authentication\Prototype\UserInterface;
use Umber\Common\Authentication\Resolver\UserRepositoryResolver;
use Umber\Common\Authentication\Resolver\UserResolverInterface;
use Umber\Common\Tests\Fixture\Authentication\AuthorisationHierarchyFixture;
use Umber\Common\Tests\Model\Authentication\UserTestModel;

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
        /** @var UserResolverInterface|MockObject $userResolver */
        $userResolver = $this->createMock(UserResolverInterface::class);

        /** @var AuthorisationHierarchyResolverInterface|MockObject $authorisationHierarchyResolver */
        $authorisationHierarchyResolver = $this->createMock(AuthorisationHierarchyResolverInterface::class);

        /** @var AuthenticationStorageInterface|MockObject $storage */
        $storage = $this->createMock(AuthenticationStorageInterface::class);

        $authenticator = new Authenticator($storage, $authorisationHierarchyResolver, $userResolver);
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
        /** @var UserResolverInterface|MockObject $userResolver */
        $userResolver = $this->createMock(UserResolverInterface::class);
        $userResolver->expects(self::never())
            ->method('resolve');

        /** @var AuthorisationHierarchyResolverInterface|MockObject $authorisationHierarchyResolver */
        $authorisationHierarchyResolver = $this->createMock(AuthorisationHierarchyResolverInterface::class);
        $authorisationHierarchyResolver->expects(self::never())
            ->method('resolve');

        /** @var AuthenticationStorageInterface|MockObject $storage */
        $storage = $this->createMock(AuthenticationStorageInterface::class);

        $authenticator = new Authenticator($storage, $authorisationHierarchyResolver, $userResolver);
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

        /** @var UserResolverInterface|MockObject $userResolver */
        $userResolver = $this->createMock(UserResolverInterface::class);
        $userResolver->expects(self::once())
            ->method('resolve')
            ->willReturn($user);

        /** @var AuthorisationHierarchyResolverInterface|MockObject $authorisationHierarchyResolver */
        $authorisationHierarchyResolver = $this->createMock(AuthorisationHierarchyResolverInterface::class);
        $authorisationHierarchyResolver->expects(self::once())
            ->method('resolve')
            ->willReturn(
                AuthorisationHierarchyFixture::create()
            );

        /** @var AuthenticationStorageInterface|MockObject $storage */
        $storage = $this->createMock(AuthenticationStorageInterface::class);
        $storage->expects(self::once())
            ->method('authorise');

        $authenticator = new Authenticator($storage, $authorisationHierarchyResolver, $userResolver);
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

        /** @var UserResolverInterface|MockObject $userResolver */
        $userResolver = $this->createMock(UserResolverInterface::class);
        $userResolver->expects(self::never())
            ->method('resolve');

        /** @var AuthorisationHierarchyResolverInterface|MockObject $authorisationHierarchyResolver */
        $authorisationHierarchyResolver = $this->createMock(AuthorisationHierarchyResolverInterface::class);
        $authorisationHierarchyResolver->expects(self::never())
            ->method('resolve');

        /** @var AuthenticationStorageInterface|MockObject $storage */
        $storage = $this->createMock(AuthenticationStorageInterface::class);
        $storage->expects(self::once())
            ->method('getUser')
            ->willReturn($user);

        $storage->expects(self::once())
            ->method('isAuthenticated')
            ->willReturn(true);

        $authenticator = new Authenticator($storage, $authorisationHierarchyResolver, $userResolver);
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
