<?php

declare(strict_types=1);

namespace Umber\Common\Authentication\Method\Header;

use Umber\Common\Authentication\Method\AuthenticationHeaderInterface;

final class AuthorisationHeader implements AuthenticationHeaderInterface
{
    private $type;
    private $value;

    public function __construct(string $type, string $value)
    {
        $this->type = $type;
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
     * Convert to string.
     */
    public function toString(): string
    {
        return sprintf('%s %s', $this->type, $this->value);
    }
}
