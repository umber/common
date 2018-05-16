<?php

declare(strict_types=1);

namespace Umber\Common\Tests\Unit\Authentication\Authorisation\Builder\Factory;

use Umber\Common\Authentication\Authorisation\Builder\Factory\RoleFactory;
use Umber\Common\Authentication\Authorisation\Permission;
use Umber\Common\Authentication\Authorisation\Role;

use PHPUnit\Framework\TestCase;

/**
 * {@inheritdoc}
 *
 * @covers \Umber\Common\Authentication\Authorisation\Builder\Factory\RoleFactory
 */
final class RoleFactoryTest extends TestCase
{
    /**
     * @test
     *
     * @group unit
     * @group authentication
     */
    public function canCreateEmptyRole(): void
    {
        $role = (new RoleFactory())->create('manager', []);

        self::assertInstanceOf(Role::class, $role);
        self::assertEquals('manager', $role->getName());
        self::assertEquals([], $role->getPassivePermissions());
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     */
    public function canCreateWithPassivePermissions(): void
    {
        $permission = new Permission('product', ['view', 'create']);

        $role = (new RoleFactory())->create('manager', [
            $permission,
        ]);

        self::assertInstanceOf(Role::class, $role);
        self::assertEquals('manager', $role->getName());

        $expected = [
            $permission,
        ];

        self::assertEquals($expected, $role->getPassivePermissions());
    }
}
