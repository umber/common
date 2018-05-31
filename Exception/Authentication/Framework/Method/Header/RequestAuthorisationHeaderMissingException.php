<?php

declare(strict_types=1);

namespace Umber\Common\Exception\Authentication\Framework\Method\Header;

use Umber\Common\Exception\AbstractRuntimeException;

/**
 * {@inheritdoc}
 */
final class RequestAuthorisationHeaderMissingException extends AbstractRuntimeException
{
    /**
     * @return RequestAuthorisationHeaderMissingException
     */
    public static function create(): self
    {
        return new self([]);
    }

    /**
     * {@inheritdoc}
     */
    public static function getMessageTemplate(): array
    {
        return [
            'The authorisation header is missing from the request.',
        ];
    }
}
