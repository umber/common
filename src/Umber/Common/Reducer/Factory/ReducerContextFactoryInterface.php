<?php

declare(strict_types=1);

namespace Umber\Common\Reducer\Factory;

use Umber\Common\Reducer\Context\ReducerContextInterface;

interface ReducerContextFactoryInterface
{
    public function create(): ReducerContextInterface;
}
