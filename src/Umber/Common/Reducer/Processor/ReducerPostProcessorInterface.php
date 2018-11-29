<?php

declare(strict_types=1);

namespace Umber\Common\Reducer\Processor;

use Umber\Common\Reducer\Context\ReducerContextInterface;
use Umber\Common\Reducer\ReducerInterface;
use Umber\Common\Reducer\Type\ResolvedTypeInterface;

interface ReducerPostProcessorInterface
{
    public function supports(ResolvedTypeInterface $type): bool;

    /**
     * @param mixed $handled
     *
     * @return mixed
     */
    public function process($handled, ReducerInterface $reducer, ReducerContextInterface $context);
}
