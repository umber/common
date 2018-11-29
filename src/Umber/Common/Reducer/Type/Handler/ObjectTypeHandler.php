<?php

declare(strict_types=1);

namespace Umber\Common\Reducer\Type\Handler;

use Umber\Common\Database\EntityInterface;
use Umber\Common\Prototype\Column\PublicIdentityAwareInterface;
use Umber\Common\Reducer\Context\ReducerContextInterface;
use Umber\Common\Reducer\Handler\ReducerHandlerContext;
use Umber\Common\Reducer\Registry\ReducerHandlerRegistry;
use Umber\Common\Reducer\Type\Resolved\ObjectResolvedType;
use Umber\Common\Reducer\Type\ResolvedTypeInterface;
use Umber\Common\Reducer\Type\TypeHandlerInterface;

use Traversable;

final class ObjectTypeHandler implements TypeHandlerInterface
{
    private $registry;

    public function __construct(ReducerHandlerRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(ResolvedTypeInterface $type): bool
    {
        return $type instanceof ObjectResolvedType;
    }

    /**
     * {@inheritdoc}
     *
     * @param ObjectResolvedType $type
     */
    public function handle($input, ResolvedTypeInterface $type, ReducerContextInterface $context)
    {
        $hash = spl_object_hash($input);

        if ($context->getObjectHistory()->has($hash)) {
            $data = [
                '$repetition' => true,
            ];

            if ($input instanceof EntityInterface && $input instanceof PublicIdentityAwareInterface) {
                $data['id'] = $input->getPublicId();
            }

            return $data;
        }

        $class = $type->getClassName();
        $handler = $this->registry->find($class);

        $context->getObjectHistory()->add($hash);
        $context->getReducerHandlerHistory()->add($handler);

        $reducerHandlerContext = new ReducerHandlerContext($context);

        $reduced = $handler->reduce($input, $reducerHandlerContext);

        if ($reduced instanceof Traversable) {
            $reduced = iterator_to_array($reduced);
        }

        return $reduced;
    }
}
