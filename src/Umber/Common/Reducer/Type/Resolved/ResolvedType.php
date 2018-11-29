<?php

declare(strict_types=1);

namespace Umber\Common\Reducer\Type\Resolved;

use Umber\Common\Reducer\Type\ResolvedTypeInterface;

/**
 * {@inheritdoc}
 */
final class ResolvedType implements ResolvedTypeInterface
{
    private $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    /**
     * {@inheritdoc}
     */
    public function getInternalType(): string
    {
        return $this->type;
    }
}
