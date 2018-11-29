<?php

declare(strict_types=1);

namespace Umber\Common\Reducer\Handler;

use Traversable;

interface ReducerHandlerInterface
{
    /**
     * Return all the classes this handler supports for reducing.
     *
     * @return Traversable|string[]
     */
    public function supports(): Traversable;

    /**
     * Reduce the object.
     *
     * @param mixed $object
     *
     * @return mixed
     */
    public function reduce($object, ReducerHandlerContext $context);
}
