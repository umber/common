<?php

declare(strict_types=1);

namespace Umber\Common\Tests\Unit\Authentication;

use Umber\Common\Authentication\Authenticator;
use Umber\Common\Authentication\Authorisation\Builder\Resolver\AuthorisationHierarchyResolverInterface;
use Umber\Common\Authentication\Method\Header\AuthorisationHeader;
use Umber\Common\Authentication\Resolver\Credential\CredentialInterface;
use Umber\Common\Authentication\Resolver\CredentialResolverInterface;
use Umber\Common\Authentication\Storage\CredentialStorageInterface;
use Umber\Common\Tests\Fixture\Authentication\AuthorisationHierarchyFixture;
use Umber\Common\Tests\Model\Authentication\UserTestModel;

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
    public function canAuthenticateToken(): void
    {
        $user = new UserTestModel();

        /** @var AuthorisationHierarchyResolverInterface|MockObject $authorisationHierarchyResolver */
        $authorisationHierarchyResolver = $this->createMock(AuthorisationHierarchyResolverInterface::class);
        $authorisationHierarchyResolver->expects(self::once())
            ->method('resolve')
            ->willReturn(
                AuthorisationHierarchyFixture::create()
            );

        /** @var CredentialInterface|MockObject $credential */
        $credential = $this->createMock(CredentialInterface::class);
        $credential->expects(self::once())
            ->method('getUser')
            ->willReturn($user);

        /** @var CredentialResolverInterface|MockObject $credentialResolver */
        $credentialResolver = $this->createMock(CredentialResolverInterface::class);
        $credentialResolver->expects(self::once())
            ->method('resolve')
            ->willReturn($credential);

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
