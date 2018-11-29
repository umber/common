<?php

declare(strict_types=1);

namespace Umber\Common\Reducer\Factory;

use Umber\Common\Reducer\Context\History\ObjectHistory;
use Umber\Common\Reducer\Context\History\ReducerHandlerHistory;
use Umber\Common\Reducer\Context\ReducerContext;
use Umber\Common\Reducer\Context\ReducerContextInterface;

/**
 * {@inheritdoc}
 */
final class ReducerContextFactory implements ReducerContextFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(): ReducerContextInterface
    {
        $context = new ReducerContext(
            0,
            new ObjectHistory(),
            new ReducerHandlerHistory()
        );

        return $context;
    }
}
