<?php

declare(strict_types=1);

namespace Umber\Common\Reducer\Processor\Delegate;

use Umber\Common\Reducer\Context\ReducerContextInterface;
use Umber\Common\Reducer\ReducerInterface;

final class DelegateConfiguration
{
    /** @var null|int */
    private $depth;

    /** @var string[] */
    private $groups = [];

    public function depth(int $depth): self
    {
        $this->depth = $depth;

        return $this;
    }

    /**
     * @param string[] $groups
     */
    public function groups(array $groups): self
    {
        $this->groups = $groups;

        return $this;
    }

    /**
     * Normalise the configuration in-line with the context given.
     */
    public function normalise(ReducerContextInterface $context): void
    {
        if ($this->depth !== null) {
            $depth = $context->getCurrentDepth() + $this->depth;
            $this->depth = $depth;
        }

        if (count($this->groups) !== 0) {
            return;
        }

        $this->groups = []; // fix
    }

    /**
     * Configure the given reducer.
     */
    public function configure(ReducerInterface $reducer, ReducerContextInterface $context): void
    {
        if ($this->depth !== null) {
            $reducer->enableMaxDepthCheck($this->depth);
        }

        if (count($this->groups) <= 0) {
            return;
        }

        $context->setGroups($this->groups);
    }
}
