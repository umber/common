<?php

declare(strict_types=1);

namespace Umber\Common\Tests\Unit\Authentication\Authorisation\Builder;

use Umber\Common\Authentication\Authorisation\Builder\AuthorisationHierarchy;
use Umber\Common\Authentication\Authorisation\Builder\Factory\PermissionFactory;
use Umber\Common\Authentication\Authorisation\Builder\Factory\RoleFactory;
use Umber\Common\Authentication\Authorisation\Permission;
use Umber\Common\Authentication\Authorisation\Role;
use Umber\Common\Exception\Authentication\Authorisation\Builder\Hierarchy\DuplicatePermissionScopeException;
use Umber\Common\Exception\Authentication\Authorisation\Builder\Hierarchy\DuplicateRoleException;
use Umber\Common\Exception\Authentication\Authorisation\Builder\Hierarchy\PermissionAbilityNotFoundException;
use Umber\Common\Exception\Authentication\Authorisation\Builder\Hierarchy\PermissionMissingAbilitiesException;
use Umber\Common\Exception\Authentication\Authorisation\Builder\Hierarchy\PermissionScopeNotFoundException;
use Umber\Common\Exception\Authentication\Authorisation\Builder\Hierarchy\RoleNotFoundException;
use Umber\Common\Exception\ExceptionMessageHelper;

use PHPUnit\Framework\TestCase;

/**
 * {@inheritdoc}
 */
final class AuthorisationHierarchyTest extends TestCase
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
     *
     * @covers \Umber\Common\Authentication\Authorisation\Builder\AuthorisationHierarchy
     */
    public function canGetEmptyRoles(): void
    {
        self::assertEquals([], $this->hierarchy->getRoles());
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Builder\AuthorisationHierarchy
     */
    public function canGetEmptyPermissions(): void
    {
        self::assertEquals([], $this->hierarchy->getPermissions());
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Builder\AuthorisationHierarchy
     */
    public function canNotFindMissingRole(): void
    {
        self::assertFalse($this->hierarchy->hasRole('admin'));
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Builder\AuthorisationHierarchy
     */
    public function canNotFindMissingPermission(): void
    {
        self::assertFalse($this->hierarchy->hasPermission('product'));
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Builder\AuthorisationHierarchy
     * @covers \Umber\Common\Exception\Authentication\Authorisation\Builder\AbstractAuthorisationRoleHierarchyException
     * @covers \Umber\Common\Exception\Authentication\Authorisation\Builder\Hierarchy\RoleNotFoundException
     */
    public function whenGetRoleMissingThrow(): void
    {
        self::expectException(RoleNotFoundException::class);
        self::expectExceptionMessage(
            ExceptionMessageHelper::translate(
                RoleNotFoundException::message(),
                ['name' => 'admin']
            )
        );

        $this->hierarchy->getRole('admin');
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Builder\AuthorisationHierarchy
     * @covers \Umber\Common\Exception\Authentication\Authorisation\Builder\AbstractAuthorisationRoleHierarchyException
     * @covers \Umber\Common\Exception\Authentication\Authorisation\Builder\Hierarchy\PermissionScopeNotFoundException
     */
    public function whenGetPermissionMissingThrow(): void
    {
        self::expectException(PermissionScopeNotFoundException::class);
        self::expectExceptionMessage(
            ExceptionMessageHelper::translate(
                PermissionScopeNotFoundException::message(),
                ['scope' => 'product']
            )
        );

        $this->hierarchy->getPermission('product');
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Builder\AuthorisationHierarchy
     * @covers \Umber\Common\Exception\Authentication\Authorisation\Builder\AbstractAuthorisationRoleHierarchyException
     * @covers \Umber\Common\Exception\Authentication\Authorisation\Builder\Hierarchy\PermissionMissingAbilitiesException
     */
    public function whenCreatePermissionEmptyAbilitiesThrow(): void
    {
        self::expectException(PermissionMissingAbilitiesException::class);
        self::expectExceptionMessage(
            ExceptionMessageHelper::translate(
                PermissionMissingAbilitiesException::message(),
                ['scope' => 'product']
            )
        );

        $this->hierarchy->addPermission('product', []);
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Builder\AuthorisationHierarchy
     */
    public function canCreatePermission(): void
    {
        $this->hierarchy->addPermission('product', ['view']);

        $expected = [
            new Permission('product', ['view']),
        ];

        self::assertEquals($expected, $this->hierarchy->getPermissions());
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Builder\AuthorisationHierarchy
     * @covers \Umber\Common\Exception\Authentication\Authorisation\Builder\AbstractAuthorisationRoleHierarchyException
     * @covers \Umber\Common\Exception\Authentication\Authorisation\Builder\Hierarchy\DuplicatePermissionScopeException
     */
    public function whenCreatingDuplicatePermissionThrow(): void
    {
        self::expectException(DuplicatePermissionScopeException::class);
        self::expectExceptionMessage(
            ExceptionMessageHelper::translate(
                DuplicatePermissionScopeException::message(),
                ['scope' => 'product']
            )
        );

        $this->hierarchy->addPermission('product', ['view']);
        $this->hierarchy->addPermission('product', ['view']);
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Builder\AuthorisationHierarchy
     */
    public function canCheckHasNewPermission(): void
    {
        $this->hierarchy->addPermission('product', ['view']);

        self::assertTrue($this->hierarchy->hasPermission('product'));
        self::assertFalse($this->hierarchy->hasPermission('blog'));
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Builder\AuthorisationHierarchy
     */
    public function canGetPermissionByScope(): void
    {
        $this->hierarchy->addPermission('product', ['view']);

        $expected = new Permission('product', ['view']);

        self::assertEquals($expected, $this->hierarchy->getPermission('product'));
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Builder\AuthorisationHierarchy
     * @covers \Umber\Common\Exception\Authentication\Authorisation\Builder\AbstractAuthorisationRoleHierarchyException
     * @covers \Umber\Common\Exception\Authentication\Authorisation\Builder\Hierarchy\PermissionScopeNotFoundException
     */
    public function whenGetPermissionAbilityMissingScope(): void
    {
        self::expectException(PermissionScopeNotFoundException::class);
        self::expectExceptionMessage(
            ExceptionMessageHelper::translate(
                PermissionScopeNotFoundException::message(),
                ['scope' => 'product']
            )
        );

        $this->hierarchy->getPermissionAbility('product', 'view');
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Builder\AuthorisationHierarchy
     * @covers \Umber\Common\Exception\Authentication\Authorisation\Builder\AbstractAuthorisationRoleHierarchyException
     * @covers \Umber\Common\Exception\Authentication\Authorisation\Builder\Hierarchy\PermissionAbilityNotFoundException
     */
    public function whenGetPermissionAbilityMissingPermissionAbility(): void
    {
        $this->hierarchy->addPermission('product', ['create']);

        self::expectException(PermissionAbilityNotFoundException::class);
        self::expectExceptionMessage(
            ExceptionMessageHelper::translate(
                PermissionAbilityNotFoundException::message(),
                [
                    'scope' => 'product',
                    'ability' => 'view',
                ]
            )
        );

        $this->hierarchy->getPermissionAbility('product', 'view');
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Builder\AuthorisationHierarchy
     */
    public function canGetPermissionAbility(): void
    {
        $this->hierarchy->addPermission('product', [
            'view',
            'create',
            'delete',
        ]);

        $expected = new Permission('product', ['create']);

        self::assertEquals($expected, $this->hierarchy->getPermissionAbility('product', 'create'));
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Builder\AuthorisationHierarchy
     */
    public function canCreateEmptyRoles(): void
    {
        $this->hierarchy->addRole('manager', [], []);
        $this->hierarchy->addRole('admin', [], []);

        $expected = [
            new Role('manager', []),
            new Role('admin', []),
        ];

        self::assertEquals($expected, $this->hierarchy->getRoles());
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Builder\AuthorisationHierarchy
     * @covers \Umber\Common\Exception\Authentication\Authorisation\Builder\AbstractAuthorisationRoleHierarchyException
     * @covers \Umber\Common\Exception\Authentication\Authorisation\Builder\Hierarchy\DuplicateRoleException
     */
    public function whenCreatingDuplicateRoleThrow(): void
    {
        self::expectException(DuplicateRoleException::class);
        self::expectExceptionMessage(
            ExceptionMessageHelper::translate(
                DuplicateRoleException::message(),
                ['name' => 'manager']
            )
        );

        $this->hierarchy->addRole('manager', [], []);
        $this->hierarchy->addRole('manager', [], []);
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Builder\AuthorisationHierarchy
     * @covers \Umber\Common\Exception\Authentication\Authorisation\Builder\AbstractAuthorisationRoleHierarchyException
     * @covers \Umber\Common\Exception\Authentication\Authorisation\Builder\Hierarchy\PermissionScopeNotFoundException
     */
    public function whenRoleWithMissingPermissionThrow(): void
    {
        self::expectException(PermissionScopeNotFoundException::class);
        self::expectExceptionMessage(
            ExceptionMessageHelper::translate(
                PermissionScopeNotFoundException::message(),
                ['scope' => 'product']
            )
        );

        $this->hierarchy->addRole('manager', [], ['product:view']);
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Builder\AuthorisationHierarchy
     * @covers \Umber\Common\Exception\Authentication\Authorisation\Builder\AbstractAuthorisationRoleHierarchyException
     * @covers \Umber\Common\Exception\Authentication\Authorisation\Builder\Hierarchy\PermissionScopeNotFoundException
     */
    public function whenRoleWithMissingPermissionAbilityThrow(): void
    {
        self::expectException(PermissionScopeNotFoundException::class);
        self::expectExceptionMessage(
            ExceptionMessageHelper::translate(
                PermissionScopeNotFoundException::message(),
                ['scope' => 'product']
            )
        );

        $this->hierarchy->addRole('manager', [], ['product:view']);
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Builder\AuthorisationHierarchy
     */
    public function canCreateBasicRolesWithPermissions(): void
    {
        $this->hierarchy->addPermission('product', [
            'view',
            'create',
        ]);

        $this->hierarchy->addRole('manager', [], ['product:view']);

        $expected = [
            new Role('manager', [
                new Permission('product', [
                    'view',
                ]),
            ]),
        ];

        self::assertEquals($expected, $this->hierarchy->getRoles());
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Builder\AuthorisationHierarchy
     */
    public function canCheckRoleByName(): void
    {
        $this->hierarchy->addPermission('product', [
            'view',
            'create',
        ]);

        $this->hierarchy->addRole('manager', [], ['product:view']);

        self::assertTrue($this->hierarchy->hasRole('manager'));
        self::assertFalse($this->hierarchy->hasRole('admin'));
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Builder\AuthorisationHierarchy
     */
    public function canGetRoleByName(): void
    {
        $this->hierarchy->addPermission('product', [
            'view',
            'create',
        ]);

        $this->hierarchy->addRole('manager', [], ['product:view']);

        $expected = new Role('manager', [
            new Permission('product', [
                'view',
            ]),
        ]);

        self::assertEquals($expected, $this->hierarchy->getRole('manager'));
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Builder\AuthorisationHierarchy
     */
    public function canResolveInheritedRolePermissions(): void
    {
        $this->hierarchy->addPermission('product', [
            'view',
            'create',
        ]);

        $this->hierarchy->addPermission('blog', [
            'view',
            'create',
            'delete',
        ]);

        $this->hierarchy->addRole('manager', [], ['product:view']);
        $this->hierarchy->addRole('admin', ['manager'], []);

        $expected = new Role('admin', [
            new Permission('product', [
                'view',
            ]),
        ]);

        self::assertEquals($expected, $this->hierarchy->getRole('admin'));
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Builder\AuthorisationHierarchy
     */
    public function canResolveInheritedRolePermissionsWithOwnPermissions(): void
    {
        $this->hierarchy->addPermission('product', [
            'view',
            'create',
        ]);

        $this->hierarchy->addPermission('blog', [
            'view',
            'create',
            'delete',
        ]);

        $this->hierarchy->addRole('manager', [], ['product:view']);
        $this->hierarchy->addRole('admin', ['manager'], [
            'blog:view',
            'blog:create',
        ]);

        $expected = new Role('admin', [
            new Permission('blog', [
                'create',
                'view',
            ]),
            new Permission('product', [
                'view',
            ]),
        ]);

        self::assertEquals($expected, $this->hierarchy->getRole('admin'));
    }
}