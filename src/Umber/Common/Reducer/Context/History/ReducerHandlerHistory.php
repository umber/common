<?php

declare(strict_types=1);

namespace Umber\Common\Reducer\Context\History;

use Umber\Common\Reducer\Handler\ReducerHandlerInterface;

final class ReducerHandlerHistory
{
    private $parent;
    private $handleres = [];

    public function __construct(?ReducerHandlerHistory $parent = null)
    {
        $this->parent = $parent;
    }

    public function has(string $handler): bool
    {
        if (in_array($handler, $this->handleres)) {
            return true;
        }

        if (!($this->parent instanceof ReducerHandlerHistory)) {
            return false;
        }

        return $this->parent->has($handler);
    }

    public function add(ReducerHandlerInterface $handler): void
    {
        $this->handleres[] = get_class($handler);
    }
}
