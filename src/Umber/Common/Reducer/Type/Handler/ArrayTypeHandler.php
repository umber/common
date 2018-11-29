<?php

declare(strict_types=1);

namespace Umber\Common\Reducer\Type\Handler;

use Umber\Common\Reducer\Context\ReducerContextInterface;
use Umber\Common\Reducer\ReducerInterface;
use Umber\Common\Reducer\Type\ResolvedTypeInterface;
use Umber\Common\Reducer\Type\TypeHandlerInterface;
use Umber\Common\Reducer\Type\TypeHandlerReducerAwareInterface;

final class ArrayTypeHandler implements TypeHandlerInterface, TypeHandlerReducerAwareInterface
{
    /** @var ReducerInterface */
    private $reducer;

    /**
     * {@inheritdoc}
     */
    public function setReducer(ReducerInterface $reducer): void
    {
        $this->reducer = $reducer;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(ResolvedTypeInterface $type): bool
    {
        return $type->getInternalType() === 'array';
    }

    /**
     * {@inheritdoc}
     */
    public function handle($input, ResolvedTypeInterface $type, ReducerContextInterface $context)
    {
        $serialized = [];

        foreach ($input as $key => $value) {
            $serialized[$key] = $this->reducer->reduce($value, $context->clone());
        }

        return $serialized;
    }
}
