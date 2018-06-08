<?php

declare(strict_types=1);

namespace Umber\Common\Tests\Unit\Authentication\Authorisation\Credential;

use Umber\Common\Authentication\Authorisation\Credential\CredentialAwareAuthorisation;
use Umber\Common\Authentication\Authorisation\Permission;
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
        /** @var CredentialInterface|MockObject $credentials */
        $credentials = $this->createMock(CredentialInterface::class);
        $credentials->expects(self::once())
            ->method('getAuthorisationRoles')
            ->willReturn([]);

        $credentials->expects(self::once())
            ->method('getAuthorisationPermissions')
            ->willReturn([]);

        $hierarchy = AuthorisationHierarchyFixture::create();
        $authorisation = new CredentialAwareAuthorisation($credentials, $hierarchy);

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
        /** @var CredentialInterface|MockObject $credentials */
        $credentials = $this->createMock(CredentialInterface::class);
        $credentials->expects(self::once())
            ->method('getAuthorisationRoles')
            ->willReturn([
                'manager',
                'admin',
            ]);

        $credentials->expects(self::once())
            ->method('getAuthorisationPermissions')
            ->willReturn([]);

        $hierarchy = AuthorisationHierarchyFixture::create();
        $authorisation = new CredentialAwareAuthorisation($credentials, $hierarchy);

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
        /** @var CredentialInterface|MockObject $credentials */
        $credentials = $this->createMock(CredentialInterface::class);
        $credentials->expects(self::once())
            ->method('getAuthorisationRoles')
            ->willReturn([
                'manager',
                'admin',
            ]);

        $credentials->expects(self::once())
            ->method('getAuthorisationPermissions')
            ->willReturn([]);

        $hierarchy = AuthorisationHierarchyFixture::create();
        $authorisation = new CredentialAwareAuthorisation($credentials, $hierarchy);

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
        /** @var CredentialInterface|MockObject $credentials */
        $credentials = $this->createMock(CredentialInterface::class);
        $credentials->expects(self::once())
            ->method('getAuthorisationRoles')
            ->willReturn([]);

        $credentials->expects(self::once())
            ->method('getAuthorisationPermissions')
            ->willReturn([
                'product:view',
                'blog:view',
            ]);

        $hierarchy = AuthorisationHierarchyFixture::create();
        $authorisation = new CredentialAwareAuthorisation($credentials, $hierarchy);

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
        /** @var CredentialInterface|MockObject $credentials */
        $credentials = $this->createMock(CredentialInterface::class);
        $credentials->expects(self::once())
            ->method('getAuthorisationRoles')
            ->willReturn([]);

        $credentials->expects(self::once())
            ->method('getAuthorisationPermissions')
            ->willReturn([
                'product:view',
                'blog:view',
            ]);

        $hierarchy = AuthorisationHierarchyFixture::create();
        $authorisation = new CredentialAwareAuthorisation($credentials, $hierarchy);

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
        /** @var CredentialInterface|MockObject $credentials */
        $credentials = $this->createMock(CredentialInterface::class);
        $credentials->expects(self::once())
            ->method('getAuthorisationRoles')
            ->willReturn([
                'manager',
            ]);

        $credentials->expects(self::once())
            ->method('getAuthorisationPermissions')
            ->willReturn([]);

        $hierarchy = AuthorisationHierarchyFixture::create();
        $authorisation = new CredentialAwareAuthorisation($credentials, $hierarchy);

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
        /** @var CredentialInterface|MockObject $credentials */
        $credentials = $this->createMock(CredentialInterface::class);
        $credentials->expects(self::once())
            ->method('getAuthorisationRoles')
            ->willReturn([
                'manager',
            ]);

        $credentials->expects(self::once())
            ->method('getAuthorisationPermissions')
            ->willReturn([]);

        $hierarchy = AuthorisationHierarchyFixture::create();
        $authorisation = new CredentialAwareAuthorisation($credentials, $hierarchy);

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
        /** @var CredentialInterface|MockObject $credentials */
        $credentials = $this->createMock(CredentialInterface::class);
        $credentials->expects(self::once())
            ->method('getAuthorisationRoles')
            ->willReturn([
                'manager',
            ]);

        $credentials->expects(self::once())
            ->method('getAuthorisationPermissions')
            ->willReturn([
                'product:view',
            ]);

        $hierarchy = AuthorisationHierarchyFixture::create();
        $authorisation = new CredentialAwareAuthorisation($credentials, $hierarchy);

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
