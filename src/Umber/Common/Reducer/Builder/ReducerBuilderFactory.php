<?php

declare(strict_types=1);

namespace Umber\Common\Reducer\Builder;

use Umber\Common\Reducer\Factory\ReducerContextFactoryInterface;
use Umber\Common\Reducer\Factory\ReducerFactoryInterface;

final class ReducerBuilderFactory
{
    private $reducer;
    private $context;

    public function __construct(ReducerFactoryInterface $reducer, ReducerContextFactoryInterface $context)
    {
        $this->reducer = $reducer;
        $this->context = $context;
    }

    public function create(): ReducerBuilder
    {
        $reducer = $this->reducer->create();
        $context = $this->context->create();

        $builder = new ReducerBuilder($reducer, $context);

        return $builder;
    }
}
