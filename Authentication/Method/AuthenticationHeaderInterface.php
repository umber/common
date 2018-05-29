<?php

declare(strict_types=1);

namespace Umber\Common\Authentication\Method;

interface AuthenticationHeaderInterface
{
    /**
     * Return the authorisation type.
     */
    public function getType(): string;

    /**
     * Create a string representation.
     */
    public function getValue(): string;

    /**
     * Convert to string.
     */
    public function toString(): string;
}
