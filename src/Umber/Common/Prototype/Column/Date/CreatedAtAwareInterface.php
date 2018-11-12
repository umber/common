<?php

declare(strict_types=1);

namespace Umber\Common\Prototype\Column\Date;

use Umber\Common\Prototype\Hint\DateAwareHintInterface;

use DateTimeInterface;

/**
 * Object should be aware of the date it was created at.
 */
interface CreatedAtAwareInterface extends DateAwareHintInterface
{
    /**
     * Return the date created at.
     */
    public function getCreatedAt(): DateTimeInterface;

    /**
     * Set the date created at.
     */
    public function setCreatedAt(DateTimeInterface $created): void;
}
