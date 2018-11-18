<?php

declare(strict_types=1);

namespace Umber\Common\Exception;

use RuntimeException;
use Throwable;

abstract class AbstractMessageRuntimeException extends RuntimeException
{
    /**
     * Return the message template.
     *
     * @return string[]
     */
    abstract public static function message(): array;

    /**
     * {@inheritdoc}
     *
     * @param mixed[] $parameters
     */
    public function __construct(array $parameters, ?int $code = null, ?Throwable $previous = null)
    {
        $message = static::message();
        $message = ExceptionMessage::translate($message, $parameters);

        parent::__construct($message, $code ?? 0, $previous);
    }
}
