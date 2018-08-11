<?php

declare(strict_types=1);

namespace Umber\Common\Form\Handler;

use Umber\Common\Exception\Form\FormValidationException;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

/**
 * A custom basic form handler.
 */
final class FormHandler implements FormHandlerInterface
{
    private $factory;

    public function __construct(FormFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(string $type, array $payload, $data = null, array $options = [], bool $missing = true): FormInterface
    {
        $form = $this->create($type, $data, $options);
        $form->submit($payload, $missing);

        if (!$form->isValid()) {
            throw FormValidationException::create($form);
        }

        return $form;
    }

    /**
     * Create the given form with options.
     *
     * @param mixed $data
     * @param mixed[] $options #FormOption
     */
    private function create(string $type, $data = null, array $options = []): FormInterface
    {
        // A form name must remain empty as with Symfony the form name is the root element with data.
        // In the case where data is coming from a request (or API) we want to form to apply to the root.
        // See Symfony Form code as it has a little check for this use case.
        $name = '';

        $builder = $this->factory->createNamedBuilder($name, $type, $data, $options);
        $form = $builder->getForm();

        return $form;
    }
}
