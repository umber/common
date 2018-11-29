<?php

declare(strict_types=1);

namespace Umber\Common\Reducer\Type\Resolved;

use Umber\Common\Reducer\Type\ResolvedTypeInterface;

/**
 * {@inheritdoc}
 */
final class ObjectResolvedType implements ResolvedTypeInterface
{
    private $type;
    private $class;

    public function __construct(string $type, string $class)
    {
        $this->type = $type;
        $this->class = $class;
    }

    /**
     * {@inheritdoc}
     */
    public function getInternalType(): string
    {
        return $this->type;
    }

    /**
     * Return the class name.
     */
    public function getClassName(): string
    {
        return $this->class;
    }
}
