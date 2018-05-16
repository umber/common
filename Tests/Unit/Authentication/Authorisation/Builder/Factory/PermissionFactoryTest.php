<?php

declare(strict_types=1);

namespace Umber\Common\Tests\Unit\Authentication\Authorisation\Builder\Factory;

use Umber\Common\Authentication\Authorisation\Builder\Factory\PermissionFactory;
use Umber\Common\Authentication\Authorisation\Permission;
use Umber\Common\Exception\Authentication\Authorisation\Permission\PermissionSerialisationNameInvalidException;
use Umber\Common\Exception\ExceptionMessageHelper;

use PHPUnit\Framework\TestCase;

/**
 * {@inheritdoc}
 *
 * @covers \Umber\Common\Authentication\Authorisation\Builder\Factory\PermissionFactory
 */
final class PermissionFactoryTest extends TestCase
{
    /**
     * @test
     *
     * @group unit
     * @group authentication
     */
    public function canCreatePermission(): void
    {
        $permission = (new PermissionFactory())->create('product', ['view']);

        self::assertInstanceOf(Permission::class, $permission);
        self::assertEquals('product', $permission->getScope());
        self::assertEquals(['view'], $permission->getAbilities());
    }
    /**
     * @test
     *
     * @group unit
     * @group authentication
     */
    public function canCreatePermissionFromString(): void
    {
        $permission = (new PermissionFactory())->createFromString('product:view');

        self::assertInstanceOf(Permission::class, $permission);
        self::assertEquals('product', $permission->getScope());
        self::assertEquals(['view'], $permission->getAbilities());
    }
    /**
     * @test
     *
     * @group unit
     * @group authentication
     */
    public function withPermissionStringInvalidThrow(): void
    {
        self::expectException(PermissionSerialisationNameInvalidException::class);
        self::expectExceptionMessage(
            ExceptionMessageHelper::translate(
                PermissionSerialisationNameInvalidException::message(),
                ['permission' => 'product/view']
            )
        );

        (new PermissionFactory())->createFromString('product/view');
    }
}
