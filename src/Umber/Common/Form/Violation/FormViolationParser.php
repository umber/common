<?php

declare(strict_types=1);

namespace Umber\Common\Form\Violation;

use Symfony\Component\Form\FormInterface;

final class FormViolationParser
{
    /**
     * Reduce the form errors to an array where the key is dot notation and errors within.
     *
     * @return string[]
     */
    public static function reduce(FormInterface $form, ?string $parent = null): array
    {
        $errors = [];

        foreach ($form as $key => $child) {
            /** @var FormInterface $child */

            if ($parent === null) {
                $name = $key;
            } else {
                $name = implode('.', [$parent, $key]);
            }

            foreach ($child->getErrors() as $error) {
                $errors[$name][] = $error->getMessage();
            }

            if (count($child) <= 0) {
                continue;
            }

            $childErrors = self::reduce($child, $name);

            foreach ($childErrors as $childErrorKey => $childError) {
                if (isset($errors[$childErrorKey])) {
                    continue;
                }

                $errors[$childErrorKey] = $childError;
            }
        }

        $parent = $parent ?: '@form';
        foreach ($form->getErrors() as $error) {
            $errors[$parent][] = $error->getMessage();
        }

        return $errors;
    }
}
