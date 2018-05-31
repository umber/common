<?php

declare(strict_types=1);

namespace Umber\Common\Tests\Unit\Authentication\Framework\Method\Header;

use Umber\Common\Authentication\Framework\Method\Header\RequestAuthorisationHeader;
use Umber\Common\Exception\Authentication\Framework\Method\Header\RequestAuthorisationHeaderMissingException;
use Umber\Common\Exception\ExceptionMessageHelper;

use Symfony\Component\HttpFoundation\Request;

use PHPUnit\Framework\TestCase;

/**
 * {@inheritdoc}
 */
final class RequestAuthorisationHeaderTest extends TestCase
{
    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Framework\Method\Header\RequestAuthorisationHeader
     */
    public function canConstructBasic(): void
    {
        $request = new Request();
        $request->headers->set(RequestAuthorisationHeader::AUTHORISATION_HEADER, 'some-type some-value');

        $header = new RequestAuthorisationHeader($request);

        self::assertEquals('some-type', $header->getType());
        self::assertEquals('some-value', $header->getValue());
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Framework\Method\Header\RequestAuthorisationHeader
     */
    public function canHandleTypeCase(): void
    {
        $request = new Request();
        $request->headers->set(RequestAuthorisationHeader::AUTHORISATION_HEADER, 'Bearer SomeValueHERE');

        $header = new RequestAuthorisationHeader($request);

        self::assertEquals('bearer', $header->getType());
        self::assertEquals('SomeValueHERE', $header->getValue());
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Framework\Method\Header\RequestAuthorisationHeader
     */
    public function canCastString(): void
    {
        $request = new Request();
        $request->headers->set(RequestAuthorisationHeader::AUTHORISATION_HEADER, 'Bearer some-value');

        $header = new RequestAuthorisationHeader($request);

        $expected = 'Bearer some-value';

        self::assertEquals($expected, (string) $header);
    }

    /**
     * @test
     *
     * @group unit
     * @group authentication
     *
     * @covers \Umber\Common\Authentication\Framework\Method\Header\RequestAuthorisationHeader
     */
    public function withMissingAuthorisationHeaderThrow(): void
    {
        self::expectException(RequestAuthorisationHeaderMissingException::class);
        self::expectExceptionMessage(ExceptionMessageHelper::translate(
            RequestAuthorisationHeaderMissingException::getMessageTemplate()
        ));

        new RequestAuthorisationHeader(new Request());
    }
}
