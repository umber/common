<?php

declare(strict_types=1);

namespace Umber\Common\Exception\Authentication\Framework\Method\Header;

use Umber\Common\Exception\Aware\CanonicalAwareRuntimeException;

/**
 * {@inheritdoc}
 */
final class RequestAuthorisationHeaderMissingException extends CanonicalAwareRuntimeException
{
    public const E_AUTHORISATION_HEADER_MISSING = 'authentication.method.header.missing_authorisation_header';

    /**
     * @return RequestAuthorisationHeaderMissingException
     */
    public static function create(): self
    {
        return new self(self::E_AUTHORISATION_HEADER_MISSING, []);
    }

    /**
     * {@inheritdoc}
     */
    public static function message(): array
    {
        return [
            'The authorisation header is missing from the request.',
        ];
    }
}
