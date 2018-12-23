<?php

declare(strict_types=1);

namespace Umber\Common\Exception;

final class ExceptionMessage
{
    /**
     * Translate an exception message with parameters.
     *
     * @param string[]|string $message
     * @param mixed[] $parameters
     */
    public static function translate($message, array $parameters = []): string
    {
        $message = is_array($message)
            ? implode(' ', $message)
            : $message;

        $translations = [];

        foreach ($parameters as $key => $value) {
            if (is_string($value) && ($value === '')) {
                $value = '{empty-string}';
            }

            $translations[sprintf('{{%s}}', $key)] = $value;
        }

        return strtr($message, $translations);
    }
}
