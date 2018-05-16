<?php

declare(strict_types=1);

namespace Umber\Common\Exception\Aware;

use Umber\Common\Exception\ExceptionMessageHelper;

use RuntimeException;
use Throwable;

/**
 * A runtime exception aware of a canonical message.
 *
 * Canonical messages are strings that can be read by machine and accurately compared in logic.
 * This also provides a method of which the message can be translated.
 */
abstract class CanonicalAwareRuntimeException extends RuntimeException
{
    /** @var string */
    private $canonical;

    /** @var string[] */
    private $prefix = [];

    /**
     * Resolve a canonical string and return a translation message.
     *
     * @return string[]
     */
    abstract public static function message(): array;

    /**
     * {@inheritdoc}
     *
     * @param string[] $parameters
     */
    public function __construct(string $canonical, array $parameters, int $code = 0, ?Throwable $previous = null)
    {
        $parts = $this->prefix;
        $parts[] = $canonical;

        $this->canonical = implode('.', $parts);

        $message = static::message();

        if (count($parameters) > 0) {
            $message = ExceptionMessageHelper::translate($message, $parameters);
        }

        parent::__construct($message, $code, $previous);
    }

    /**
     * Return the canonical name.
     */
    public function getCanonical(): string
    {
        return $this->canonical;
    }

    /**
     * Set a canonical prefix segment.
     */
    protected function setPrefixSegment(string $segment): void
    {
        $this->prefix[] = $segment;
    }
}
