<?php

declare(strict_types=1);

namespace Umber\Common\Utility;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use RuntimeException;
use Traversable;

/**
 * A collection helper.
 */
final class CollectionHelper
{
    /**
     * Create a collection from various traversable's.
     *
     * @param mixed[]|Traversable|iterable $traversable
     *
     * @return Collection|mixed[]
     */
    public static function create($traversable): Collection
    {
        if ($traversable instanceof Collection) {
            return $traversable;
        }

        if ($traversable instanceof Traversable) {
            return iterator_to_array($traversable);
        }

        if (is_array($traversable)) {
            return new ArrayCollection($traversable);
        }

        throw new RuntimeException('Input not traversable enough');
    }
}
