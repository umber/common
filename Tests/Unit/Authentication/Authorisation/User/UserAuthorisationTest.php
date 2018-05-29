<?php

declare(strict_types=1);

namespace Umber\Common\Tests\Unit\Authentication\Authorisation\User;

use Umber\Common\Authentication\Authorisation\Permission;
use Umber\Common\Authentication\Authorisation\User\UserAuthorisation;
use Umber\Common\Authentication\Prototype\UserInterface;
use Umber\Common\Tests\Fixture\Authentication\AuthorisationHierarchyFixture;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * {@inheritdoc}
 */
final class UserAuthorisationTest extends TestCase
{
    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\User\UserAuthorisation
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

        $hierarchy = AuthorisationHierarchyFixture::create();
        $authorisation = new UserAuthorisation($hierarchy, $user);

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
     * @covers \Umber\Common\Authentication\Authorisation\User\UserAuthorisation
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

        $hierarchy = AuthorisationHierarchyFixture::create();
        $authorisation = new UserAuthorisation($hierarchy, $user);

        self::assertFalse($authorisation->hasRole('system'));
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\User\UserAuthorisation
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

        $hierarchy = AuthorisationHierarchyFixture::create();
        $authorisation = new UserAuthorisation($hierarchy, $user);

        self::assertTrue($authorisation->hasRole('manager'));
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\User\UserAuthorisation
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

        $hierarchy = AuthorisationHierarchyFixture::create();
        $authorisation = new UserAuthorisation($hierarchy, $user);

        self::assertFalse($authorisation->hasPermission('user', 'view'));
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\User\UserAuthorisation
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

        $hierarchy = AuthorisationHierarchyFixture::create();
        $authorisation = new UserAuthorisation($hierarchy, $user);

        self::assertTrue($authorisation->hasPermission('product', 'view'));
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\User\UserAuthorisation
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

        $hierarchy = AuthorisationHierarchyFixture::create();
        $authorisation = new UserAuthorisation($hierarchy, $user);

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
     * @covers \Umber\Common\Authentication\Authorisation\User\UserAuthorisation
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

        $hierarchy = AuthorisationHierarchyFixture::create();
        $authorisation = new UserAuthorisation($hierarchy, $user);

        self::assertTrue($authorisation->hasPermission('product', 'view'));
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\User\UserAuthorisation
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

        $hierarchy = AuthorisationHierarchyFixture::create();
        $authorisation = new UserAuthorisation($hierarchy, $user);

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
