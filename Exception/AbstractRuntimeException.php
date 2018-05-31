<?php

declare(strict_types=1);

namespace Umber\Common\Exception;

use RuntimeException;
use Throwable;

abstract class AbstractRuntimeException extends RuntimeException
{
    /**
     * Return the message template.
     *
     * @return string[]
     */
    abstract public static function getMessageTemplate(): array;

    /**
     * {@inheritdoc}
     *
     * @param string[]|int[] $parameters
     */
    public function __construct(array $parameters, ?int $code = null, ?Throwable $previous = null)
    {
        $message = static::getMessageTemplate();
        $message = ExceptionMessageHelper::translate($message, $parameters);

        parent::__construct($message, $code ?? 0, $previous);
    }
}
