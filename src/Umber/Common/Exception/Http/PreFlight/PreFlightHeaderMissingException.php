<?php

declare(strict_types=1);

namespace Umber\Common\Exception\Http\PreFlight;

use Umber\Exception\Message\AbstractMessageRuntimeException;

/**
 * An exception thrown when a pre-flight header is missing.
 */
final class PreFlightHeaderMissingException extends AbstractMessageRuntimeException
{
    /**
     * @return PreFlightHeaderMissingException
     */
    public static function create(string $header): self
    {
        return new self([
            'header' => $header,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function message(): array
    {
        return [
            'When using the "OPTIONS" method you must provide all required pre-flight headers.',
            'Expected the header "{{header}}" to be present.',
        ];
    }
}
