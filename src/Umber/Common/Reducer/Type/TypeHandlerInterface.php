<?php

declare(strict_types=1);

namespace Umber\Common\Reducer\Type;

use Umber\Common\Reducer\Context\ReducerContextInterface;

interface TypeHandlerInterface
{
    public function supports(ResolvedTypeInterface $type): bool;

    /**
     * @param mixed $input
     *
     * @return mixed
     */
    public function handle($input, ResolvedTypeInterface $type, ReducerContextInterface $context);
}
