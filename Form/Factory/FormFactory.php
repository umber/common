<?php

declare(strict_types=1);

namespace Umber\Common\Form\Factory;

use Symfony\Component\Form\Extension\Core\DataMapper\PropertyPathMapper;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormFactory as SymfonyFormFactory;

/**
 * A custom form factory for enforcing defaults.
 */
final class FormFactory extends SymfonyFormFactory
{
    /**
     * Defaults that are applied to all forms created.
     *
     * @var string[]|bool[]
     */
    private $defaults = [
        'error_bubbling' => false, //  Error bubbling is disabled so each form has its own error.
    ];

    /**
     * {@inheritdoc}
     *
     * Injecting the custom form data accessor to all forms and set form defaults.
     */
    public function createNamedBuilder($name, $type = FormType::class, $data = null, array $options = [])
    {
        $options = array_merge($options, $this->defaults);

        $mapper = new PropertyPathMapper(new FormDataAccessor());

        $builder = parent::createNamedBuilder($name, $type, $data, $options);
        $builder->setDataMapper($mapper);

        return $builder;
    }
}
