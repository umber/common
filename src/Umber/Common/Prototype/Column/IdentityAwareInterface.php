<?php

declare(strict_types=1);

namespace Umber\Common\Prototype\Column;

/**
 * Object should be aware of identity.
 */
interface IdentityAwareInterface
{
    /**
     * Return the identity.
     */
    public function getId(): int;

    /**
     * Check the identity is set.
     */
    public function hasId(): bool;
}
