<?php

declare(strict_types=1);

namespace Umber\Common\Prototype\Column\Date;

use Umber\Common\Prototype\Hint\DateAwareHintInterface;

use DateTimeInterface;

/**
 * Object should be aware of the date it was deleted at.
 */
interface DeletedAtAwareInterface extends DateAwareHintInterface
{
    /**
     * Return the date deleted at.
     */
    public function getDeletedAt(): DateTimeInterface;

    /**
     * Set the date deleted at.
     */
    public function setDeletedAt(DateTimeInterface $deleted): void;

    /**
     * Set the object as not deleted.
     */
    public function setNotDeleted(): void;

    /**
     * Check if the object has a deleted date.
     */
    public function isDeleted(): bool;
}
