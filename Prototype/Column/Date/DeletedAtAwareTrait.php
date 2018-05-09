<?php

declare(strict_types=1);

namespace Umber\Common\Prototype\Column\Date;

use DateTimeInterface;

/**
 * Object becomes aware of its deleted date.
 *
 * @mixin DeletedAtAwareInterface
 */
trait DeletedAtAwareTrait
{
    /** @var DateTimeInterface */
    protected $deletedAt;

    /**
     * {@inheritdoc}
     *
     * @see DeletedAtAwareInterface::getDeletedAt()
     */
    public function getDeletedAt(): DateTimeInterface
    {
        return $this->deletedAt;
    }

    /**
     * {@inheritdoc}
     *
     * @see DeletedAtAwareInterface::setDeletedAt()
     */
    public function setDeletedAt(DateTimeInterface $deleted): void
    {
        $this->deletedAt = $deleted;
    }

    /**
     * {@inheritdoc}
     *
     * @see DeletedAtAwareInterface::setNotDeleted()
     */
    public function setNotDeleted(): void
    {
        $this->deletedAt = null;
    }

    /**
     * {@inheritdoc}
     *
     * @see DeletedAtAwareInterface::isDeleted()
     */
    public function isDeleted(): bool
    {
        return $this->deletedAt !== null;
    }
}
