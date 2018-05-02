<?php

declare(strict_types=1);

namespace Umber\Common\Prototype\Column;

/**
 * Object becomes aware of public identity.
 *
 * @see PublicIdentityAwareInterface
 */
trait PublicIdentityAwareTrait
{
    /** @var string */
    protected $uuid;

    /**
     * {@inheritdoc}
     *
     * @see PublicIdentityAwareInterface
     */
    public function getPublicId(): string
    {
        return $this->uuid;
    }

    /**
     * {@inheritdoc}
     *
     * @see PublicIdentityAwareInterface
     */
    public function hasPublicId(): bool
    {
        return $this->uuid !== null;
    }

    /**
     * {@inheritdoc}
     *
     * @see PublicIdentityAwareInterface
     */
    public function setPublicId(string $uuid): void
    {
        $this->uuid = $uuid;
    }
}
