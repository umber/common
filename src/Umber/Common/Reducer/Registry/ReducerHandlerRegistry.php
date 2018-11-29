<?php

declare(strict_types=1);

namespace Umber\Common\Reducer\Registry;

use Umber\Common\Exception\Reducer\CannotReduceTypeException;
use Umber\Common\Reducer\Handler\ReducerHandlerInterface;

final class ReducerHandlerRegistry
{
    /** @var ReducerHandlerInterface[] */
    private $registry = [];

    public function register(ReducerHandlerInterface $handler): void
    {
        $supported = $handler->supports();

        foreach ($supported as $class) {
            $this->registry[$class] = $handler;
        }
    }

    public function find(string $type): ReducerHandlerInterface
    {
        if (isset($this->registry[$type])) {
            return $this->registry[$type];
        }

        throw CannotReduceTypeException::create($type);
    }
}
