<?php

declare(strict_types=1);

namespace Umber\Common\Tests\Unit\Authentication\Authorisation\Credential;

use Umber\Common\Authentication\Authorisation\Credential\CredentialAwareAuthorisation;
use Umber\Common\Authentication\Authorisation\Permission;
use Umber\Common\Authentication\Prototype\UserInterface;
use Umber\Common\Authentication\Resolver\Credential\CredentialInterface;
use Umber\Common\Tests\Fixture\Authentication\AuthorisationHierarchyFixture;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * {@inheritdoc}
 */
final class CredentialAwareAuthorisationTest extends TestCase
{
    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Credential\CredentialAwareAuthorisation
     *
     * @throws \ReflectionException
     */
    public function checkBasicUsage(): void
    {
        /** @var UserInterface|MockObject $user */
        $user = $this->createMock(UserInterface::class);
        $user->expects(self::once())
            ->method('getAuthorisationRoles')
            ->willReturn([]);

        $user->expects(self::once())
            ->method('getAuthorisationPermissions')
            ->willReturn([]);

        /** @var CredentialInterface|MockObject $credential */
        $credential = $this->createMock(CredentialInterface::class);
        $credential->expects(self::exactly(2))
            ->method('getUser')
            ->willReturn($user);

        $hierarchy = AuthorisationHierarchyFixture::create();
        $authorisation = new CredentialAwareAuthorisation($credential, $hierarchy);

        self::assertSame($user, $authorisation->getUser());
        self::assertEquals([], $authorisation->getRoles());
        self::assertEquals([], $authorisation->getPermissions());
        self::assertEquals([], $authorisation->getPassivePermissions());
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Credential\CredentialAwareAuthorisation
     *
     * @throws \ReflectionException
     */
    public function canCheckHasRoleMissing(): void
    {
        /** @var UserInterface|MockObject $user */
        $user = $this->createMock(UserInterface::class);
        $user->expects(self::once())
            ->method('getAuthorisationRoles')
            ->willReturn([
                'manager',
                'admin',
            ]);

        $user->expects(self::once())
            ->method('getAuthorisationPermissions')
            ->willReturn([]);

        /** @var CredentialInterface|MockObject $credential */
        $credential = $this->createMock(CredentialInterface::class);
        $credential->expects(self::once())
            ->method('getUser')
            ->willReturn($user);

        $hierarchy = AuthorisationHierarchyFixture::create();
        $authorisation = new CredentialAwareAuthorisation($credential, $hierarchy);

        self::assertFalse($authorisation->hasRole('system'));
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Credential\CredentialAwareAuthorisation
     *
     * @throws \ReflectionException
     */
    public function canCheckHasRoleFound(): void
    {
        /** @var UserInterface|MockObject $user */
        $user = $this->createMock(UserInterface::class);
        $user->expects(self::once())
            ->method('getAuthorisationRoles')
            ->willReturn([
                'manager',
                'admin',
            ]);

        $user->expects(self::once())
            ->method('getAuthorisationPermissions')
            ->willReturn([]);

        /** @var CredentialInterface|MockObject $credential */
        $credential = $this->createMock(CredentialInterface::class);
        $credential->expects(self::once())
            ->method('getUser')
            ->willReturn($user);

        $hierarchy = AuthorisationHierarchyFixture::create();
        $authorisation = new CredentialAwareAuthorisation($credential, $hierarchy);

        self::assertTrue($authorisation->hasRole('manager'));
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Credential\CredentialAwareAuthorisation
     *
     * @throws \ReflectionException
     */
    public function canCheckHasPermissionMissing(): void
    {
        /** @var UserInterface|MockObject $user */
        $user = $this->createMock(UserInterface::class);
        $user->expects(self::once())
            ->method('getAuthorisationRoles')
            ->willReturn([]);

        $user->expects(self::once())
            ->method('getAuthorisationPermissions')
            ->willReturn([
                'product:view',
                'blog:view',
            ]);

        /** @var CredentialInterface|MockObject $credential */
        $credential = $this->createMock(CredentialInterface::class);
        $credential->expects(self::once())
            ->method('getUser')
            ->willReturn($user);

        $hierarchy = AuthorisationHierarchyFixture::create();
        $authorisation = new CredentialAwareAuthorisation($credential, $hierarchy);

        self::assertFalse($authorisation->hasPermission('user', 'view'));
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Credential\CredentialAwareAuthorisation
     *
     * @throws \ReflectionException
     */
    public function canCheckHasPermissionFound(): void
    {
        /** @var UserInterface|MockObject $user */
        $user = $this->createMock(UserInterface::class);
        $user->expects(self::once())
            ->method('getAuthorisationRoles')
            ->willReturn([]);

        $user->expects(self::once())
            ->method('getAuthorisationPermissions')
            ->willReturn([
                'product:view',
                'blog:view',
            ]);

        /** @var CredentialInterface|MockObject $credential */
        $credential = $this->createMock(CredentialInterface::class);
        $credential->expects(self::once())
            ->method('getUser')
            ->willReturn($user);

        $hierarchy = AuthorisationHierarchyFixture::create();
        $authorisation = new CredentialAwareAuthorisation($credential, $hierarchy);

        self::assertTrue($authorisation->hasPermission('product', 'view'));
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Credential\CredentialAwareAuthorisation
     *
     * @throws \ReflectionException
     */
    public function canGetPassivePermissions(): void
    {
        /** @var UserInterface|MockObject $user */
        $user = $this->createMock(UserInterface::class);
        $user->expects(self::once())
            ->method('getAuthorisationRoles')
            ->willReturn([
                'manager',
            ]);

        $user->expects(self::once())
            ->method('getAuthorisationPermissions')
            ->willReturn([]);

        /** @var CredentialInterface|MockObject $credential */
        $credential = $this->createMock(CredentialInterface::class);
        $credential->expects(self::once())
            ->method('getUser')
            ->willReturn($user);

        $hierarchy = AuthorisationHierarchyFixture::create();
        $authorisation = new CredentialAwareAuthorisation($credential, $hierarchy);

        $expected = [
            new Permission('blog', ['view']),
            new Permission('product', ['create', 'view']),
        ];

        self::assertEquals($expected, $authorisation->getPassivePermissions());
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Credential\CredentialAwareAuthorisation
     *
     * @throws \ReflectionException
     */
    public function canCheckHasPassivePermission(): void
    {
        /** @var UserInterface|MockObject $user */
        $user = $this->createMock(UserInterface::class);
        $user->expects(self::once())
            ->method('getAuthorisationRoles')
            ->willReturn([
                'manager',
            ]);

        $user->expects(self::once())
            ->method('getAuthorisationPermissions')
            ->willReturn([]);

        /** @var CredentialInterface|MockObject $credential */
        $credential = $this->createMock(CredentialInterface::class);
        $credential->expects(self::once())
            ->method('getUser')
            ->willReturn($user);

        $hierarchy = AuthorisationHierarchyFixture::create();
        $authorisation = new CredentialAwareAuthorisation($credential, $hierarchy);

        self::assertTrue($authorisation->hasPermission('product', 'view'));
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Credential\CredentialAwareAuthorisation
     *
     * @throws \ReflectionException
     */
    public function canExpandRolePassivePermissions(): void
    {
        /** @var UserInterface|MockObject $user */
        $user = $this->createMock(UserInterface::class);
        $user->expects(self::once())
            ->method('getAuthorisationRoles')
            ->willReturn([
                'manager',
            ]);

        $user->expects(self::once())
            ->method('getAuthorisationPermissions')
            ->willReturn([
                'product:view',
            ]);

        /** @var CredentialInterface|MockObject $credential */
        $credential = $this->createMock(CredentialInterface::class);
        $credential->expects(self::once())
            ->method('getUser')
            ->willReturn($user);

        $hierarchy = AuthorisationHierarchyFixture::create();
        $authorisation = new CredentialAwareAuthorisation($credential, $hierarchy);

        $permissions = [
            new Permission('product', ['view']),
        ];

        $passive = [
            new Permission('blog', ['view']),
            new Permission('product', ['create', 'view']),
        ];

        self::assertEquals($permissions, $authorisation->getPermissions());
        self::assertEquals($passive, $authorisation->getPassivePermissions());
    }
}
