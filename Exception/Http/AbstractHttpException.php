<?php

declare(strict_types=1);

namespace Umber\Common\Exception\Http;

use Umber\Common\Exception\Aware\CanonicalAwareRuntimeException;

use Throwable;

/**
 * {@inheritdoc}
 */
abstract class AbstractHttpException extends CanonicalAwareRuntimeException
{
    private $statusCode;

    /**
     * {@inheritdoc}
     */
    public function __construct(string $canonical, $parameters, int $statusCode, ?Throwable $previous = null)
    {
        parent::__construct($canonical, $parameters, 0, $previous);

        $this->statusCode = $statusCode;
    }

    /**
     * Return the HTTP status code.
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
