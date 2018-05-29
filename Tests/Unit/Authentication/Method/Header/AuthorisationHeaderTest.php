<?php

declare(strict_types=1);

namespace Umber\Common\Tests\Unit\Authentication\Method\Header;

use Umber\Common\Authentication\Method\Header\AuthorisationHeader;

use PHPUnit\Framework\TestCase;

/**
 * {@inheritdoc}
 */
final class AuthorisationHeaderTest extends TestCase
{
    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Method\Header\AuthorisationHeader
     */
    public function canConstructBasic(): void
    {
        $header = new AuthorisationHeader('some-type', 'some-value');

        self::assertEquals('some-type', $header->getType());
        self::assertEquals('some-value', $header->getValue());
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Method\Header\AuthorisationHeader
     */
    public function canHandleTypeCase(): void
    {
        $header = new AuthorisationHeader('BEARer', 'SomeValueHERE');

        self::assertEquals('bearer', $header->getType());
        self::assertEquals('SomeValueHERE', $header->getValue());
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Method\Header\AuthorisationHeader
     */
    public function canCastString(): void
    {
        $header = new AuthorisationHeader('bearer', 'some-value');

        $expected = 'Bearer some-value';

        self::assertEquals($expected, (string) $header);
    }
}
