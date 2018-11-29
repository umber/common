<?php

declare(strict_types=1);

namespace Umber\Common\Reducer;

use Umber\Common\Reducer\Context\ReducerContextInterface;
use Umber\Common\Reducer\Processor\ReducerPostProcessorInterface;
use Umber\Common\Reducer\Type\Resolver\TypeResolverInterface;
use Umber\Common\Reducer\Type\TypeHandlerInterface;
use Umber\Common\Reducer\Type\TypeHandlerReducerAwareInterface;

use RuntimeException;

/**
 * {@inheritdoc}
 */
final class Reducer implements ReducerInterface
{
    private $type;

    /** @var TypeHandlerInterface[] */
    private $handlers = [];

    /** @var ReducerPostProcessorInterface[] */
    private $processors = [];

    public function __construct(TypeResolverInterface $type)
    {
        $this->type = $type;
    }

    /**
     * {@inheritdoc}
     */
    public function registerTypeHandler(TypeHandlerInterface $handler): void
    {
        $this->handlers[] = $handler;

        if (!($handler instanceof TypeHandlerReducerAwareInterface)) {
            return;
        }

        $handler->setReducer($this);
    }

    /**
     * {@inheritdoc}
     */
    public function registerReducerProcessor(ReducerPostProcessorInterface $processor): void
    {
        $this->processors[] = $processor;
    }

    /**
     * {@inheritdoc}
     */
    public function enableMaxDepthCheck(int $depth): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function reduce($input, ReducerContextInterface $context)
    {
        $type = $this->type->resolve($input);

        foreach ($this->handlers as $handler) {
            if (!$handler->supports($type)) {
                continue;
            }

            $handled = $handler->handle($input, $type, $context);
            $processed = $this->process($handled, $context);

            return $processed;
        }

        throw new RuntimeException('no type handler');
    }

    /**
     * {@inheritdoc}
     */
    public function clone(): ReducerInterface
    {
        $reducer = new Reducer($this->type);
        $reducer->handlers = $this->handlers;
        $reducer->processors = $this->processors;

        return $reducer;
    }

    /**
     * @param mixed $handled
     *
     * @return mixed
     */
    private function process($handled, ReducerContextInterface $context)
    {
        $type = $this->type->resolve($handled);

        foreach ($this->processors as $processor) {
            if (!$processor->supports($type)) {
                continue;
            }

            $handled = $processor->process($handled, $this, $context);
        }

        return $handled;
    }
}
