<?php

declare(strict_types=1);

namespace Umber\Common\Reducer\Context;

use Umber\Common\Reducer\Context\History\ObjectHistory;
use Umber\Common\Reducer\Context\History\ReducerHandlerHistory;

interface ReducerContextInterface
{
    public function getCurrentDepth(): int;

    public function hasGroups(): bool;

    /**
     * @return string[]
     */
    public function getGroups(): array;

    /**
     * @param string[] $groups
     */
    public function setGroups(array $groups): void;

    public function hasGroup(string $group): bool;

    public function getObjectHistory(): ObjectHistory;

    public function getReducerHandlerHistory(): ReducerHandlerHistory;

    public function clone(): ReducerContextInterface;
}
