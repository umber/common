<?php

declare(strict_types=1);

namespace Umber\Common\Tests\Unit\Authentication\Authorisation;

use Umber\Common\Authentication\Authorisation\Authorisation;
use Umber\Common\Authentication\Authorisation\Permission;
use Umber\Common\Authentication\Authorisation\Role;

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
        $authorisation = new Authorisation([], []);

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
            new Role('manager', []),
            new Role('admin', []),
        ];

        $authorisation = new Authorisation($roles, []);

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
            new Role('manager', []),
            new Role('admin', []),
        ];

        $authorisation = new Authorisation($roles, []);

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
            new Permission('product', ['view']),
            new Permission('blog', ['view']),
        ];

        $authorisation = new Authorisation([], $permissions);

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
            new Permission('product', ['view']),
            new Permission('blog', ['view']),
        ];

        $authorisation = new Authorisation([], $permissions);

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
            new Role('manager', [
                new Permission('product', ['create', 'view']),
                new Permission('blog', ['view']),
            ]),
        ];

        $authorisation = new Authorisation($roles, []);

        $expected = [
            new Permission('product', ['create', 'view']),
            new Permission('blog', ['view']),
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
            new Role('manager', [
                new Permission('product', ['create', 'view']),
                new Permission('blog', ['view']),
            ]),
        ];

        $authorisation = new Authorisation($roles, []);

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
            new Role('manager', [
                new Permission('product', ['view']),
                new Permission('blog', ['view']),
            ]),
        ];

        $permissions = [
            new Permission('product', ['view']),
            new Permission('user', ['view']),
        ];

        $authorisation = new Authorisation($roles, $permissions);

        $expected = [
            new Permission('product', ['view']),
            new Permission('blog', ['view']),
        ];

        self::assertEquals($permissions, $authorisation->getPermissions());
        self::assertEquals($expected, $authorisation->getPassivePermissions());
    }
}
