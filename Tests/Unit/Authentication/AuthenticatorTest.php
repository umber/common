<?php

namespace Umber\Common\Tests\Unit\Authentication;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Umber\Common\Authentication\AuthenticationStorageInterface;
use Umber\Common\Authentication\Authenticator;
use Umber\Common\Authentication\Authorisation\Builder\Resolver\AuthorisationHierarchyResolverInterface;
use Umber\Common\Authentication\Method\Header\AuthorisationHeader;
use Umber\Common\Authentication\Resolver\UserResolverInterface;
use Umber\Common\Tests\Fixture\Authentication\AuthorisationHierarchyFixture;
use Umber\Common\Tests\Model\Authentication\UserTestModel;

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
    public function canAuthenticateToken(): void
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
        $authenticator->authenticate(new AuthorisationHeader('bearer', 'some-value'));

    }
}
