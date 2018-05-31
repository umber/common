<?php

declare(strict_types=1);

namespace Umber\Common\Exception\Hint;

interface CanonicalAwareExceptionInterface
{
    /**
     * Return the canonical string for the exception.
     */
    public static function getCanonicalCode(): string;
}
