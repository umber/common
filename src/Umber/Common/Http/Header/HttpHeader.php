<?php

declare(strict_types=1);

namespace Umber\Common\Http\Header;

/**
 * A simple HTTP header.
 */
final class HttpHeader implements HttpHeaderInterface
{
    private $name;
    private $value;
    private $exposed;

    public function __construct(string $name, string $value, bool $exposed = true)
    {
        $this->name = $name;
        $this->value = $value;
        $this->exposed = $exposed;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->name;
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
    public function isExposed(): bool
    {
        return $this->exposed;
    }
}
