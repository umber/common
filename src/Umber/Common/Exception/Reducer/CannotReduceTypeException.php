<?php

declare(strict_types=1);

namespace Umber\Common\Exception\Reducer;

use RuntimeException;

final class CannotReduceTypeException extends RuntimeException
{
    /**
     * @return CannotReduceTypeException
     */
    public static function create(string $type): self
    {
        return new self(implode(' ', [
            sprintf('Cannot reduce type "%s".', $type),
            'There is no handler registered for this type.',
        ]));
    }
}
