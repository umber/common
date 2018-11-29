<?php

declare(strict_types=1);

namespace Umber\Common\Reducer\Factory;

use Umber\Common\Reducer\ReducerInterface;

interface ReducerFactoryInterface
{
    public function create(): ReducerInterface;
}
