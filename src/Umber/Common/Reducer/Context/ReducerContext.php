<?php

declare(strict_types=1);

namespace Umber\Common\Reducer\Context;

use Umber\Common\Reducer\Context\History\ObjectHistory;
use Umber\Common\Reducer\Context\History\ReducerHandlerHistory;

/**
 * {@inheritdoc}
 */
final class ReducerContext implements ReducerContextInterface
{
    private $depth;
    private $objectHistory;
    private $reducerHandlerHistory;

    /** @var string[] */
    private $groups = [];

    public function __construct(
        int $depth,
        ObjectHistory $objectHistory,
        ReducerHandlerHistory $reducerHandlerHistory
    ) {
        $this->depth = $depth;
        $this->objectHistory = $objectHistory;
        $this->reducerHandlerHistory = $reducerHandlerHistory;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentDepth(): int
    {
        return $this->depth;
    }

    /**
     * {@inheritdoc}
     */
    public function hasGroups(): bool
    {
        return count($this->groups) > 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getGroups(): array
    {
        return $this->groups;
    }

    /**
     * {@inheritdoc}
     */
    public function setGroups(array $groups): void
    {
        $this->groups = $groups;
    }

    /**
     * {@inheritdoc}
     */
    public function hasGroup(string $group): bool
    {
        return in_array($group, $this->groups);
    }

    /**
     * {@inheritdoc}
     */
    public function getObjectHistory(): ObjectHistory
    {
        return $this->objectHistory;
    }

    /**
     * {@inheritdoc}
     */
    public function getReducerHandlerHistory(): ReducerHandlerHistory
    {
        return $this->reducerHandlerHistory;
    }

    /**
     * {@inheritdoc}
     */
    public function clone(): ReducerContextInterface
    {
        $depth = $this->depth + 1;

        $objectHistory = new ObjectHistory($this->objectHistory);
        $reducerHandlerHistory = new ReducerHandlerHistory($this->reducerHandlerHistory);

        $clone = new ReducerContext(
            $depth,
            $objectHistory,
            $reducerHandlerHistory
        );

        $clone->groups = $this->groups;

        return $clone;
    }
}
