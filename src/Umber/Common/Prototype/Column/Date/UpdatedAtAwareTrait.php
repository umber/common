<?php

declare(strict_types=1);

namespace Umber\Common\Prototype\Column\Date;

use DateTimeInterface;

/**
 * Object becomes aware of its updated date.
 *
 * @mixin UpdatedAtAwareInterface
 */
trait UpdatedAtAwareTrait
{
    /** @var DateTimeInterface */
    protected $updatedAt;

    /**
     * {@inheritdoc}
     *
     * @see UpdatedAtAwareInterface::getUpdatedAt()
     */
    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * {@inheritdoc}
     *
     * @see UpdatedAtAwareInterface::setUpdatedAt()
     */
    public function setUpdatedAt(DateTimeInterface $updated): void
    {
        $this->updatedAt = $updated;
    }
}
