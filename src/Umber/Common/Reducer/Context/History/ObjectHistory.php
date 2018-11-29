<?php

declare(strict_types=1);

namespace Umber\Common\Reducer\Context\History;

final class ObjectHistory
{
    private $parent;
    private $hashes = [];

    public function __construct(?ObjectHistory $parent = null)
    {
        $this->parent = $parent;
    }

    public function has(string $hash): bool
    {
        if (in_array($hash, $this->hashes)) {
            return true;
        }

        if (!($this->parent instanceof ObjectHistory)) {
            return false;
        }

        return $this->parent->has($hash);
    }

    public function add(string $hash): void
    {
        $this->hashes[] = $hash;
    }
}
