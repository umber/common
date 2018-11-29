<?php

declare(strict_types=1);

namespace Umber\Common\Reducer\Handler;

use Umber\Common\Reducer\Context\History\ObjectHistory;
use Umber\Common\Reducer\Context\History\ReducerHandlerHistory;
use Umber\Common\Reducer\Context\ReducerContextInterface;
use Umber\Common\Reducer\Processor\Delegate\DelegateConfiguration;
use Umber\Common\Reducer\Processor\Delegate\DelegateReducer;

use RuntimeException;

/**
 * {@inheritdoc}
 */
final class ReducerHandlerContext implements ReducerContextInterface
{
    private $context;

    public function __construct(ReducerContextInterface $context)
    {
        $this->context = $context;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentDepth(): int
    {
        return $this->context->getCurrentDepth();
    }

    /**
     * {@inheritdoc}
     */
    public function hasGroups(): bool
    {
        return $this->context->hasGroups();
    }

    /**
     * {@inheritdoc}
     */
    public function getGroups(): array
    {
        return $this->context->getGroups();
    }

    /**
     * {@inheritdoc}
     */
    public function setGroups(array $groups): void
    {
        throw new RuntimeException('You cannot set groups here.');
    }

    /**
     * {@inheritdoc}
     */
    public function hasGroup(string $group): bool
    {
        return $this->context->hasGroup($group);
    }

    /**
     * {@inheritdoc}
     */
    public function getObjectHistory(): ObjectHistory
    {
        return $this->context->getObjectHistory();
    }

    /**
     * {@inheritdoc}
     */
    public function getReducerHandlerHistory(): ReducerHandlerHistory
    {
        return $this->context->getReducerHandlerHistory();
    }

    /**
     * {@inheritdoc}
     */
    public function clone(): ReducerContextInterface
    {
        return $this->context->clone();
    }

    /**
     * Reduce this property in a delegated context.
     */
    public function delegate(callable $delegate): DelegateReducer
    {
        return new DelegateReducer($delegate);
    }

    /**
     * Reduce this property in a shallow (delegated) context
     *
     * @param mixed $input
     *
     * @return mixed
     */
    public function shallow($input)
    {
        return $this->delegate(function (DelegateConfiguration $configuration) use ($input) {
            $configuration->depth(1);

            return $input;
        });
    }

    /**
     * Reduce the given object.
     *
     * @param mixed $object
     *
     * @return mixed
     *
     * @deprecated
     */
    public function reduce($object)
    {
        throw new RuntimeException('nah');
    }
}
