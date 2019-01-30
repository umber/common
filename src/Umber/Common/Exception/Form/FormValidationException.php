<?php

declare(strict_types=1);

namespace Umber\Common\Exception\Form;

use Umber\Common\Exception\AbstractMessageRuntimeException;

use Umber\Http\Hint\HttpAwareExceptionInterface;
use Umber\Http\Hint\HttpCanonicalAwareExceptionInterface;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

use Throwable;

/**
 * A form validation failure exception.
 */
final class FormValidationException extends AbstractMessageRuntimeException implements
    HttpCanonicalAwareExceptionInterface,
    HttpAwareExceptionInterface
{
    private $form;

    /**
     * @return FormValidationException
     */
    public static function create(FormInterface $form): self
    {
        return new self($form);
    }

    /**
     * {@inheritdoc}
     */
    public static function message(): array
    {
        return [
            'A form failed validation.',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function getCanonicalCode(): string
    {
        return 'http.request.payload.validation';
    }

    /**
     * {@inheritdoc}
     */
    public static function getStatusCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

    public function __construct(FormInterface $form, ?Throwable $previous = null)
    {
        parent::__construct([], 0, $previous);

        $this->form = $form;
    }

    /**
     * Return the form that failed validation.
     */
    public function getForm(): FormInterface
    {
        return $this->form;
    }
}
