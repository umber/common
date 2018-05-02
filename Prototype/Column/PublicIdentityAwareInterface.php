<?php

declare(strict_types=1);

namespace Umber\Common\Prototype\Column;

interface PublicIdentityAwareInterface
{
    /**
     * Return the public identity.
     */
    public function getPublicId(): string;

    /**
     * Check the public identity is set.
     */
    public function hasPublicId(): bool;

    /**
     * Set the public identity.
     */
    public function setPublicId(string $id): void;
}
