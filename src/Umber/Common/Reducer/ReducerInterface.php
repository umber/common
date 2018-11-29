<?php

declare(strict_types=1);

namespace Umber\Common\Reducer;

use Umber\Common\Reducer\Context\ReducerContextInterface;
use Umber\Common\Reducer\Processor\ReducerPostProcessorInterface;
use Umber\Common\Reducer\Type\TypeHandlerInterface;

interface ReducerInterface
{
    public function registerTypeHandler(TypeHandlerInterface $handler): void;
    public function registerReducerProcessor(ReducerPostProcessorInterface $handler): void;

    public function enableMaxDepthCheck(int $depth): void;

    /**
     * @param mixed $input
     *
     * @return mixed
     */
    public function reduce($input, ReducerContextInterface $context);

    public function clone(): ReducerInterface;
}
