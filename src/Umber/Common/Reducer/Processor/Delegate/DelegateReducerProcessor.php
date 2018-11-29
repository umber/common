<?php

declare(strict_types=1);

namespace Umber\Common\Reducer\Processor\Delegate;

use Umber\Common\Reducer\Context\ReducerContextInterface;
use Umber\Common\Reducer\Processor\ReducerPostProcessorInterface;
use Umber\Common\Reducer\ReducerInterface;
use Umber\Common\Reducer\Type\ResolvedTypeInterface;

/**
 * {@inheritdoc}
 */
final class DelegateReducerProcessor implements ReducerPostProcessorInterface
{
    /**
     * {@inheritdoc}
     */
    public function supports(ResolvedTypeInterface $type): bool
    {
        return $type->getInternalType() === 'array';
    }

    /**
     * {@inheritdoc}
     *
     * @param mixed[] $handled
     */
    public function process($handled, ReducerInterface $reducer, ReducerContextInterface $context)
    {
        foreach ($handled as $index => $value) {
            if (!($value instanceof DelegateReducer)) {
                continue;
            }

            $clone = $context->clone();
            $clone->setGroups([]);

            $handled[$index] = $value->process(
                $reducer->clone(),
                $clone
            );
        }

        return $handled;
    }
}
