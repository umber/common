<?php

declare(strict_types=1);

namespace Umber\Common\Reducer\Type\Resolver;

use Umber\Common\Reducer\Type\Resolved\ObjectResolvedType;
use Umber\Common\Reducer\Type\Resolved\ResolvedType;
use Umber\Common\Reducer\Type\ResolvedTypeInterface;

use Doctrine\ORM\Proxy\Proxy;

use Faker\Test\Provider\Collection;
use RuntimeException;

final class TypeResolver implements TypeResolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function resolve($input): ResolvedTypeInterface
    {
        if ($input === null) {
            return new ResolvedType('null');
        }

        if (is_scalar($input)) {
            return new ResolvedType(gettype($input));
        }

        if (is_array($input)) {
            return new ResolvedType('array');
        }

        if (is_object($input)) {
            $class = get_class($input);

            if ($input instanceof Proxy) {
                $class = get_parent_class($input);
            }

            if ($input instanceof Collection) {
                return new ObjectResolvedType('array', $class);
            }

            return new ObjectResolvedType('object', $class);
        }

        throw new RuntimeException('cannot figure out the type');
    }
}
