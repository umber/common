<?php

declare(strict_types=1);

namespace Umber\Common\Form\Handler;

use Umber\Common\Exception\Form\FormValidationException;

use Symfony\Component\Form\FormInterface;

/**
 * A slightly extended (but simplified) form handler.
 */
interface FormHandlerInterface
{
    /**
     * Create and handle the submission of a form.
     *
     * @param mixed[] $payload
     * @param mixed $data
     * @param mixed[] $options
     *
     * @throws FormValidationException When the form fails validation.
     */
    public function handle(string $type, array $payload, $data = null, array $options = [], bool $missing = true): FormInterface;
}
