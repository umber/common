<?php

declare(strict_types=1);

namespace Umber\Common\Database;

use Umber\Common\Domain\Prototype\DomainModelAwareInterface;

/**
 * Object can interface with the database.
 */
interface EntityInterface extends DomainModelAwareInterface
{
    /**
     * A factory method for creating instances of an entity.
     */
    public static function create(): EntityInterface;
}
