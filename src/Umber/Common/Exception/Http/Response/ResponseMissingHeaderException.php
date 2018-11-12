<?php

declare(strict_types=1);

namespace Umber\Common\Exception\Http\Response;

use Umber\Exception\Message\AbstractMessageRuntimeException;

/**
 * An exception thrown when a response does not have a http header when requested.
 */
final class ResponseMissingHeaderException extends AbstractMessageRuntimeException
{
    /**
     * @return ResponseMissingHeaderException
     */
    public static function create(string $name): self
    {
        return new self([
            'name' => $name,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function message(): array
    {
        return [
            'The current response does not have the header by name "{{name}}".',
            'Please make sure that a response was set with this header before hand.',
            'To check for header by name make use of the "hasHeader()" method against the response.',
        ];
    }
}
