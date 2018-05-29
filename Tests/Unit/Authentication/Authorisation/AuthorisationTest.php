<?php

declare(strict_types=1);

namespace Umber\Common\Tests\Unit\Authentication\Authorisation;

use Umber\Common\Authentication\Authorisation\Authorisation;
use Umber\Common\Authentication\Authorisation\Permission;
use Umber\Common\Tests\Fixture\Authentication\AuthorisationHierarchyFixture;

use PHPUnit\Framework\TestCase;

/**
 * {@inheritdoc}
 */
final class AuthorisationTest extends TestCase
{
    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Authorisation
     */
    public function checkBasicUsage(): void
    {
        $hierarchy = AuthorisationHierarchyFixture::create();
        $authorisation = new Authorisation($hierarchy, [], []);

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
     * @covers \Umber\Common\Authentication\Authorisation\Authorisation
     */
    public function canCheckHasRoleMissing(): void
    {
        $roles = [
            'manager',
            'admin',
        ];

        $hierarchy = AuthorisationHierarchyFixture::create();
        $authorisation = new Authorisation($hierarchy, $roles, []);

        self::assertFalse($authorisation->hasRole('system'));
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Authorisation
     */
    public function canCheckHasRoleFound(): void
    {
        $roles = [
            'manager',
            'admin',
        ];

        $hierarchy = AuthorisationHierarchyFixture::create();
        $authorisation = new Authorisation($hierarchy, $roles, []);

        self::assertTrue($authorisation->hasRole('manager'));
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Authorisation
     */
    public function canCheckHasPermissionMissing(): void
    {
        $permissions = [
            'product:view',
            'blog:view',
        ];

        $hierarchy = AuthorisationHierarchyFixture::create();
        $authorisation = new Authorisation($hierarchy, [], $permissions);

        self::assertFalse($authorisation->hasPermission('user', 'view'));
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Authorisation
     */
    public function canCheckHasPermissionFound(): void
    {
        $permissions = [
            'product:view',
            'blog:view',
        ];

        $hierarchy = AuthorisationHierarchyFixture::create();
        $authorisation = new Authorisation($hierarchy, [], $permissions);

        self::assertTrue($authorisation->hasPermission('product', 'view'));
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Authorisation
     */
    public function canGetPassivePermissions(): void
    {
        $roles = [
            'manager',
        ];

        $hierarchy = AuthorisationHierarchyFixture::create();
        $authorisation = new Authorisation($hierarchy, $roles, []);

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
     * @covers \Umber\Common\Authentication\Authorisation\Authorisation
     */
    public function canCheckHasPassivePermission(): void
    {
        $roles = [
            'manager',
        ];

        $hierarchy = AuthorisationHierarchyFixture::create();
        $authorisation = new Authorisation($hierarchy, $roles, []);

        self::assertTrue($authorisation->hasPermission('product', 'view'));
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Authorisation\Authorisation
     */
    public function canExpandRolePassivePermissions(): void
    {
        $roles = [
            'manager',
        ];

        $permissions = [
            'product:view',
        ];

        $hierarchy = AuthorisationHierarchyFixture::create();
        $authorisation = new Authorisation($hierarchy, $roles, $permissions);

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
