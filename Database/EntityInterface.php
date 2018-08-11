<?php

declare(strict_types=1);

namespace Umber\Common\Database;

/**
 * Object can interface with the database.
 */
interface EntityInterface
{
    /**
     * A factory method for creating instances of an entity.
     */
    public static function create(): EntityInterface;
}
