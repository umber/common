<?php

declare(strict_types=1);

namespace Umber\Common\Reducer\Type\Handler;

use Umber\Common\Reducer\Context\ReducerContextInterface;
use Umber\Common\Reducer\Type\ResolvedTypeInterface;
use Umber\Common\Reducer\Type\TypeHandlerInterface;

/**
 * A type handler for basic values.
 */
final class BasicValueTypeHandler implements TypeHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function supports(ResolvedTypeInterface $type): bool
    {
        $accepted = [
            'string',
            'integer',
            'boolean',
            'null',
        ];

        return in_array($type->getInternalType(), $accepted);
    }

    /**
     * {@inheritdoc}
     */
    public function handle($input, ResolvedTypeInterface $type, ReducerContextInterface $context)
    {
        return $input;
    }
}
