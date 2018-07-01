<?php

declare(strict_types=1);

namespace Umber\Common\Tests\Unit\Form\Handler\Request;

use Umber\Common\Exception\Form\FormValidationException;
use Umber\Common\Form\Handler\FormHandler;
use Umber\Common\Form\Handler\Request\RequestFormHandler;
use Umber\Common\Test\AbstractFormTypeTestCase;
use Umber\Common\Tests\Fixture\Form\Type\UmberTestType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

use PHPUnit\Framework\MockObject\MockObject;

/**
 * {@inheritdoc}
 */
final class RequestFormHandlerTest extends AbstractFormTypeTestCase
{
    /**
     * @test
     *
     * @group unit
     * @group form
     *
     * @covers \Umber\Common\Form\Handler\Request\RequestFormHandler
     * @covers \Umber\Common\Exception\Form\FormValidationException
     */
    public function withGivenRequestPayloadFormValidationErrorsThrow(): void
    {
        $payload = [];

        /** @var Request|MockObject $request */
        $request = $this->createMock(Request::class);
        $request->expects(self::once())
            ->method('getContent')
            ->willReturn(json_encode($payload));

        /** @var RequestStack|MockObject $stack */
        $stack = $this->createMock(RequestStack::class);

        $handler = new FormHandler($this->factory);
        $handler = new RequestFormHandler($handler, $stack);

        self::expectException(FormValidationException::class);

        $handler->handleRequest($request, UmberTestType::class);
    }

    /**
     * @test
     *
     * @group unit
     * @group form
     *
     * @covers \Umber\Common\Form\Handler\Request\RequestFormHandler
     */
    public function withGivenRequestPayloadValidReturnForm(): void
    {
        $payload = [
            'foo' => 'foo',
            'bar' => 'bar',
        ];

        /** @var Request|MockObject $request */
        $request = $this->createMock(Request::class);
        $request->expects(self::once())
            ->method('getContent')
            ->willReturn(json_encode($payload));

        /** @var RequestStack|MockObject $stack */
        $stack = $this->createMock(RequestStack::class);

        $handler = new FormHandler($this->factory);
        $handler = new RequestFormHandler($handler, $stack);

        $form = $handler->handleRequest($request, UmberTestType::class);

        self::assertEquals($payload, $form->getData());
    }


    /**
     * @test
     *
     * @group unit
     * @group form
     *
     * @covers \Umber\Common\Form\Handler\Request\RequestFormHandler
     * @covers \Umber\Common\Exception\Form\FormValidationException
     */
    public function withCurrentRequestPayloadFormValidationErrorsThrow(): void
    {
        $payload = [];

        /** @var Request|MockObject $request */
        $request = $this->createMock(Request::class);
        $request->expects(self::once())
            ->method('getContent')
            ->willReturn(json_encode($payload));

        /** @var RequestStack|MockObject $stack */
        $stack = $this->createMock(RequestStack::class);
        $stack->expects(self::once())
            ->method('getCurrentRequest')
            ->willReturn($request);

        $handler = new FormHandler($this->factory);
        $handler = new RequestFormHandler($handler, $stack);

        self::expectException(FormValidationException::class);

        $handler->handleCurrentRequest(UmberTestType::class);
    }

    /**
     * @test
     *
     * @group unit
     * @group form
     *
     * @covers \Umber\Common\Form\Handler\Request\RequestFormHandler
     */
    public function withCurrentRequestPayloadValidReturnForm(): void
    {
        $payload = [
            'foo' => 'foo',
            'bar' => 'bar',
        ];

        /** @var Request|MockObject $request */
        $request = $this->createMock(Request::class);
        $request->expects(self::once())
            ->method('getContent')
            ->willReturn(json_encode($payload));

        /** @var RequestStack|MockObject $stack */
        $stack = $this->createMock(RequestStack::class);
        $stack->expects(self::once())
            ->method('getCurrentRequest')
            ->willReturn($request);

        $handler = new FormHandler($this->factory);
        $handler = new RequestFormHandler($handler, $stack);

        $form = $handler->handleCurrentRequest(UmberTestType::class);

        self::assertEquals($payload, $form->getData());
    }
}
