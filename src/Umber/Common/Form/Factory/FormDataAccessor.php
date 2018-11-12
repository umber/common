<?php

declare(strict_types=1);

namespace Umber\Common\Form\Factory;

use Symfony\Component\PropertyAccess\PropertyAccessor;

use TypeError;

/**
 * {@inheritdoc}
 */
final class FormDataAccessor extends PropertyAccessor
{
    /**
     * {@inheritdoc}
     *
     * Override to catch type errors when trying to set null.
     */
    public function setValue(&$objectOrArray, $propertyPath, $value)
    {
        try {
            parent::setValue($objectOrArray, $propertyPath, $value);
        } catch (TypeError $exception) {
            return;
        }
    }

    /**
     * {@inheritdoc}
     *
     * Override to catch type errors when the return value of a getter is not respecting its type hint. In this
     * case we assume the value is null and return.
     */
    public function getValue($objectOrArray, $propertyPath)
    {
        try {
            return parent::getValue($objectOrArray, $propertyPath);
        } catch (TypeError $exception) {
            return null;
        }
    }
}
