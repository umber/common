<?php

declare(strict_types=1);

namespace Umber\Common\Reducer\Type\Resolver;

use Umber\Common\Reducer\Type\ResolvedTypeInterface;

interface TypeResolverInterface
{
    /**
     * Return the type of a given variable.
     *
     * @param mixed $input
     */
    public function resolve($input): ResolvedTypeInterface;
}
