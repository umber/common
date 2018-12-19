<?php

declare(strict_types=1);

namespace Umber\Common\Domain;

use Umber\Database\EntityInterface;

/**
 * A domain model that operates on database entities.
 */
interface DomainModelInterface
{
    /**
     * Return the subject being operated on.
     */
    public function getSubject(): EntityInterface;
}
