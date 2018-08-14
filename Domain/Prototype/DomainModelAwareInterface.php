<?php

namespace Umber\Common\Domain\Prototype;

use Umber\Common\Domain\DomainModelInterface;

/**
 * Make an object aware of its domain model.
 */
interface DomainModelAwareInterface
{
    /**
     * Return the domain model for this entity.
     */
    public function getDomainModel(): DomainModelInterface;
}
