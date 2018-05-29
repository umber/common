<?php

namespace Umber\Common\Tests\Fixture\Authentication;

use Umber\Common\Authentication\Authorisation\Builder\AuthorisationHierarchy;
use Umber\Common\Authentication\Authorisation\Builder\Factory\PermissionFactory;
use Umber\Common\Authentication\Authorisation\Builder\Factory\RoleFactory;

final class AuthorisationHierarchyFixture
{
    public static function create(): AuthorisationHierarchy
    {
        $hierarchy = new AuthorisationHierarchy(
            new RoleFactory(),
            new PermissionFactory()
        );

        $hierarchy->addPermission('product', [
            'view',
            'create',
        ]);

        $hierarchy->addPermission('blog', [
            'view',
            'create',
            'delete',
        ]);

        $hierarchy->addRole('manager', [], [
            'product:view',
            'product:create',
            'blog:view',
        ]);

        $hierarchy->addRole('admin', ['manager'], [
            'blog:view',
            'blog:create',
        ]);

        return $hierarchy;
    }
}
