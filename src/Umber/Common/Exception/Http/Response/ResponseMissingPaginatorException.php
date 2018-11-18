<?php

declare(strict_types=1);

namespace Umber\Common\Exception\Http\Response;

use Umber\Common\Exception\AbstractMessageRuntimeException;

/**
 * An exception thrown when a response does not have a pagination when requested.
 */
final class ResponseMissingPaginatorException extends AbstractMessageRuntimeException
{
    /**
     * @return ResponseMissingPaginatorException
     */
    public static function create(): self
    {
        return new self([]);
    }

    /**
     * {@inheritdoc}
     */
    public static function message(): array
    {
        return [
            'The current response does not have a paginator.',
            'Please make sure that a paginator was set before hand.',
            'To check for paginator make use of the "hasPaginator()" method against the response.',
        ];
    }
}
