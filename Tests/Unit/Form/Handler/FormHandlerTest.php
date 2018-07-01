<?php

declare(strict_types=1);

namespace Umber\Common\Tests\Unit\Form\Handler;

use Umber\Common\Exception\Form\FormValidationException;
use Umber\Common\Form\Handler\FormHandler;
use Umber\Common\Test\AbstractFormTypeTestCase;
use Umber\Common\Tests\Fixture\Form\Type\UmberTestType;

/**
 * {@inheritdoc}
 */
final class FormHandlerTest extends AbstractFormTypeTestCase
{
    /**
     * @test
     *
     * @group unit
     * @group form
     *
     * @covers \Umber\Common\Form\Handler\FormHandler
     * @covers \Umber\Common\Exception\Form\FormValidationException
     */
    public function withFormValidationErrorsThrow(): void
    {
        $payload = [];

        $handler = new FormHandler($this->factory);

        self::expectException(FormValidationException::class);

        $handler->handle(UmberTestType::class, $payload);
    }

    /**
     * @test
     *
     * @group unit
     * @group form
     *
     * @covers \Umber\Common\Form\Handler\FormHandler
     */
    public function withValidPayloadReturnForm(): void
    {
        $payload = [
            'foo' => 'foo',
            'bar' => 'bar',
        ];

        $handler = new FormHandler($this->factory);

        $form = $handler->handle(UmberTestType::class, $payload);

        self::assertEquals($payload, $form->getData());
    }
}
