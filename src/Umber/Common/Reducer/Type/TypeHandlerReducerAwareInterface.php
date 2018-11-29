<?php

declare(strict_types=1);

namespace Umber\Common\Reducer\Type;

use Umber\Common\Reducer\ReducerInterface;

interface TypeHandlerReducerAwareInterface
{
    public function setReducer(ReducerInterface $reducer): void;
}
