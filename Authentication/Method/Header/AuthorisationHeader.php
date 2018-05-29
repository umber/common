<?php

declare(strict_types=1);

namespace Umber\Common\Authentication\Method\Header;

use Umber\Common\Authentication\Method\AuthenticationHeaderInterface;

/**
 * {@inheritdoc}
 */
final class AuthorisationHeader implements AuthenticationHeaderInterface
{
    private $type;
    private $value;

    public function __construct(string $type, string $value)
    {
        $this->type = strtolower($type);
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return sprintf('%s %s', ucwords($this->type), $this->value);
    }

    /**
     * Magic conversion to string.
     */
    public function __toString()
    {
        return $this->toString();
    }
}
