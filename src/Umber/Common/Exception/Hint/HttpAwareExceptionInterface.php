<?php

declare(strict_types=1);

namespace Umber\Common\Exception\Hint;

interface HttpAwareExceptionInterface
{
    /**
     * Return the HTTP status code.
     */
    public static function getStatusCode(): int;
}
