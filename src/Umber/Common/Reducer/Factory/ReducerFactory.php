<?php

declare(strict_types=1);

namespace Umber\Common\Reducer\Factory;

use Umber\Common\Reducer\Processor\Delegate\DelegateReducerProcessor;
use Umber\Common\Reducer\Reducer;
use Umber\Common\Reducer\ReducerInterface;
use Umber\Common\Reducer\Registry\ReducerHandlerRegistry;
use Umber\Common\Reducer\Type\Handler\ArrayTypeHandler;
use Umber\Common\Reducer\Type\Handler\BasicValueTypeHandler;
use Umber\Common\Reducer\Type\Handler\ObjectTypeHandler;
use Umber\Common\Reducer\Type\Resolver\TypeResolverInterface;

/**
 * {@inheritdoc}
 */
final class ReducerFactory implements ReducerFactoryInterface
{
    private $type;
    private $registry;

    public function __construct(TypeResolverInterface $type, ReducerHandlerRegistry $registry)
    {
        $this->type = $type;
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public function create(): ReducerInterface
    {
        $reducer = new Reducer($this->type);

        $reducer->registerTypeHandler(new BasicValueTypeHandler());
        $reducer->registerTypeHandler(new ArrayTypeHandler());
        $reducer->registerTypeHandler(new ObjectTypeHandler($this->registry));

        $reducer->registerReducerProcessor(new DelegateReducerProcessor());

        return $reducer;
    }
}
