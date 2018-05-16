<?php

declare(strict_types=1);

namespace Umber\Common\Tests\Unit\Authentication\Authorisation\Builder;

use Umber\Common\Authentication\Authorisation\Builder\AuthorisationBuilder;
use Umber\Common\Authentication\Authorisation\Builder\AuthorisationHierarchy;
use Umber\Common\Authentication\Authorisation\Builder\Factory\PermissionFactory;
use Umber\Common\Authentication\Authorisation\Builder\Factory\RoleFactory;
use Umber\Common\Authentication\Authorisation\Permission;
use Umber\Common\Authentication\Authorisation\Role;
use Umber\Common\Authentication\Prototype\UserInterface;
use Umber\Common\Exception\Authentication\Authorisation\Builder\Hierarchy\RoleNotFoundException;
use Umber\Common\Exception\Authentication\Authorisation\Permission\PermissionSerialisationNameInvalidException;
use Umber\Common\Exception\ExceptionMessageHelper;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * {@inheritdoc}
 *
 * @covers \Umber\Common\Authentication\Authorisation\Builder\AuthorisationBuilder
 */
final class AuthorisationBuilderTest extends TestCase
{
    /** @var AuthorisationHierarchy */
    private $hierarchy;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        $this->hierarchy = new AuthorisationHierarchy(
            new RoleFactory(),
            new PermissionFactory()
        );
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     */
    public function createEmptyAuthorisation(): void
    {
        $rawRoles = [];
        $rawPermissions = [];

        $authorisation = AuthorisationBuilder::create($rawRoles, $rawPermissions, $this->hierarchy);

        $roles = [];
        $permissions = [];

        self::assertEquals($roles, $authorisation->getRoles());
        self::assertEquals($permissions, $authorisation->getPermissions());
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     */
    public function createAuthorisationEmptyHierarchyThrows(): void
    {
        $rawRoles = [
            'manager',
        ];

        $rawPermissions = [
            'product:*',
        ];

        self::expectException(RoleNotFoundException::class);
        self::expectExceptionMessage(
            ExceptionMessageHelper::translate(
                RoleNotFoundException::message(),
                ['name' => 'manager']
            )
        );

        AuthorisationBuilder::create($rawRoles, $rawPermissions, $this->hierarchy);
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     */
    public function whenPermissionNameMissingAbilityThrow(): void
    {
        $permissions = [
            'product',
        ];

        self::expectException(PermissionSerialisationNameInvalidException::class);
        self::expectExceptionMessage(
            ExceptionMessageHelper::translate(
                PermissionSerialisationNameInvalidException::message(),
                ['permission' => $permissions[0]]
            )
        );

        AuthorisationBuilder::create([], $permissions, $this->hierarchy);
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     */
    public function canConstructRoleWithPassivePermissionsFromHierarchy(): void
    {
        $this->hierarchy->addPermission('product', [
            'view',
            'create',
            'delete',
        ]);

        $this->hierarchy->addPermission('blog', [
            'view',
            'create',
            'delete',
        ]);

        $this->hierarchy->addRole('manager', [], [
            'product:view',
            'product:create',
            'blog:view',
        ]);

        $this->hierarchy->addRole('admin', [], [
            'blog:create',
        ]);

        $rawRoles = [
            'manager',
        ];

        $authorisation = AuthorisationBuilder::create($rawRoles, [], $this->hierarchy);

        $permissionA = new Permission('product', [
            'create',
            'view',
        ]);

        $permissionB = new Permission('blog', [
            'view',
        ]);

        $expectedRoles = [
            new Role('manager', [
                $permissionB,
                $permissionA,
            ]),
        ];

        $expectedPermissions = [
            $permissionB,
            $permissionA,
        ];

        self::assertEquals($expectedRoles, $authorisation->getRoles());
        self::assertEquals([], $authorisation->getPermissions());
        self::assertEquals($expectedPermissions, $authorisation->getPassivePermissions());
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     */
    public function canBuildFromUser(): void
    {
        $this->hierarchy->addPermission('product', [
            'view',
            'create',
            'delete',
        ]);

        $this->hierarchy->addPermission('blog', [
            'view',
            'create',
            'delete',
        ]);

        $this->hierarchy->addRole('manager', [], [
            'product:view',
            'product:create',
            'blog:view',
        ]);

        $this->hierarchy->addRole('admin', [], [
            'blog:create',
        ]);

        /** @var UserInterface|MockObject $user */
        $user = $this->createMock(UserInterface::class);
        $user->expects(self::once())
            ->method('getRoles')
            ->willReturn([
                'manager',
            ]);

        $user->expects(self::once())
            ->method('getPermissions')
            ->willReturn([
                'blog:view',
            ]);

        $authorisation = AuthorisationBuilder::createFromUser($user, $this->hierarchy);

        $expected = [
            new Permission('blog', ['view']),
            new Permission('product', ['create', 'view']),
        ];

        self::assertEquals($expected, $authorisation->getPassivePermissions());
    }
}
