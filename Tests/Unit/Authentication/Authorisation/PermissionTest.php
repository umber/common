<?php

declare(strict_types=1);

namespace Umber\Common\Tests\Unit\Authentication\Authorisation;

use Umber\Common\Authentication\Authorisation\Permission;
use Umber\Common\Exception\Authentication\Authorisation\Permission\PermissionAbilityNameInvalidException;
use Umber\Common\Exception\Authentication\Authorisation\Permission\PermissionScopeNameInvalidException;
use Umber\Common\Exception\ExceptionMessageHelper;

use PHPUnit\Framework\TestCase;

/**
 * {@inheritdoc}
 *
 * @covers \Umber\Common\Authentication\Authorisation\Permission
 */
final class PermissionTest extends TestCase
{
    /**
     * @test
     *
     * @group unit
     * @group authentication
     */
    public function checkBasicUsage(): void
    {
        $permission = new Permission('permission-name', []);

        self::assertEquals('permission-name', $permission->getScope());
        self::assertEquals([], $permission->getAbilities());
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     */
    public function withUpperCaseLowerCase(): void
    {
        $permission = new Permission('Permission-NAME-here', []);

        self::assertEquals('permission-name-here', $permission->getScope());
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     */
    public function withUpperCaseAbilityLowerCase(): void
    {
        $permission = new Permission('permission-name', [
            'UPPER-CASE',
        ]);

        self::assertEquals('permission-name', $permission->getScope());
        self::assertEquals(['upper-case'], $permission->getAbilities());
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     */
    public function withWildcardAbilityRemoveOtherAbilities(): void
    {
        $permission = new Permission('permission-name', [
            'view',
            Permission::WILDCARD,
            'create',
        ]);

        self::assertEquals('permission-name', $permission->getScope());
        self::assertEquals([Permission::WILDCARD], $permission->getAbilities());
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     */
    public function checkWithAbilities(): void
    {
        $permission = new Permission('permission-name', [
            'view',
            'create',
        ]);

        $expected = [
            'view',
            'create',
        ];

        self::assertEquals($expected, $permission->getAbilities());
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     */
    public function canCheckAbilityMissing(): void
    {
        $permission = new Permission('permission-name', [
            'view',
            'create',
        ]);

        self::assertFalse($permission->hasAbility('delete'));
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     */
    public function canCheckAbilityFound(): void
    {
        $permission = new Permission('permission-name', [
            'view',
            'create',
        ]);

        self::assertTrue($permission->hasAbility('view'));
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     */
    public function canCheckAbilityWildcard(): void
    {
        $permission = new Permission('permission-name', [
            Permission::WILDCARD,
        ]);

        self::assertTrue($permission->hasAbility('view'));
    }

    /**
     * @return string[][]
     */
    public function provideWithInvalidPermissionNameThrow(): array
    {
        return [
            ['has.dot'],
            ['has/slash'],
            ['question?'],
            ['??'],
            ['01123'],

            ['-starting-with-hyphen'],
            ['ending-with-hyphen-'],

            ['_starting_with_underscore'],
            ['ending_with_underscore_'],
        ];
    }

    /**
     * @test
     * @dataProvider provideWithInvalidPermissionNameThrow
     *
     * @group unit
     * @group authentication
     */
    public function withInvalidPermissionNameThrow(string $scope): void
    {
        self::expectException(PermissionScopeNameInvalidException::class);
        self::expectExceptionMessage(
            ExceptionMessageHelper::translate(
                PermissionScopeNameInvalidException::message(),
                ['scope' => $scope]
            )
        );

        new Permission($scope, []);
    }

    /**
     * @return string[][]
     */
    public function provideWithValidNameAllow(): array
    {
        return [
            ['word'],
            ['with-hyphen'],
            ['WITH_UNDERSCORE'],
            ['Com-COMBINATION_tON'],
        ];
    }

    /**
     * @test
     * @dataProvider provideWithValidNameAllow
     *
     * @group unit
     * @group authentication
     */
    public function withValidNameAllow(string $name): void
    {
        $permission = new Permission($name, []);

        self::assertEquals(strtolower($name), $permission->getScope());
    }

    /**
     * @return string[][]
     */
    public function provideWithInvalidPermissionAbilityThrow(): array
    {
        return [
            ['has.dot'],
            ['has/slash'],
            ['question?'],
            ['??'],
            ['01123'],

            ['-starting-with-hyphen'],
            ['ending-with-hyphen-'],

            ['_starting_with_underscore'],
            ['ending_with_underscore_'],
        ];
    }

    /**
     * @test
     * @dataProvider provideWithInvalidPermissionAbilityThrow
     *
     * @group unit
     * @group authentication
     */
    public function withInvalidPermissionAbilityThrow(string $ability): void
    {
        self::expectException(PermissionAbilityNameInvalidException::class);
        self::expectExceptionMessage(
            ExceptionMessageHelper::translate(
                PermissionAbilityNameInvalidException::message(),
                [
                    'scope' => 'permission-name',
                    'ability' => $ability,
                ]
            )
        );

        new Permission('permission-name', [$ability]);
    }

    /**
     * @return string[][]
     */
    public function provideWithValidPermissionAbilityAllow(): array
    {
        return [
            ['word'],
            ['with-hyphen'],
            ['WITH_UNDERSCORE'],
            ['Com-COMBINATION_tON'],
        ];
    }

    /**
     * @test
     * @dataProvider provideWithValidPermissionAbilityAllow
     *
     * @group unit
     * @group authentication
     */
    public function withValidPermissionAbilityAllow(string $ability): void
    {
        $permission = new Permission('permission-name', [$ability]);

        self::assertEquals(strtolower($ability), $permission->getAbilities()[0]);
    }
}
