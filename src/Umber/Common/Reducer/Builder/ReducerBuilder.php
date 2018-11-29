<?php

declare(strict_types=1);

namespace Umber\Common\Reducer\Builder;

use Umber\Common\Reducer\Context\ReducerContextInterface;
use Umber\Common\Reducer\ReducerInterface;

final class ReducerBuilder
{
    private $reducer;
    private $context;

    public function __construct(ReducerInterface $reducer, ReducerContextInterface $context)
    {
        $this->reducer = $reducer;
        $this->context = $context;
    }

    public function depth(int $depth): self
    {
        $this->reducer->enableMaxDepthCheck($depth);

        return $this;
    }

    /**
     * @param string[] $groups
     */
    public function groups(array $groups): self
    {
        $this->context->setGroups($groups);

        return $this;
    }

    /**
     * @param mixed $input
     *
     * @return mixed
     */
    public function reduce($input)
    {
        $reduced = $this->reducer->reduce($input, $this->context);

        return $reduced;
    }
}
