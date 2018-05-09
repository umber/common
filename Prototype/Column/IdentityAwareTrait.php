<?php

declare(strict_types=1);

namespace Umber\Common\Prototype\Column;

/**
 * Object becomes aware of identity.
 *
 * @mixin IdentityAwareInterface
 */
trait IdentityAwareTrait
{
    /** @var int */
    protected $id;

    /**
     * {@inheritdoc}
     *
     * @see IdentityAwareInterface::getId()
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     *
     * @see IdentityAwareInterface::hasId()
     */
    public function hasId(): bool
    {
        return $this->id !== null;
    }
}
