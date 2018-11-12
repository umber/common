<?php

declare(strict_types=1);

namespace Umber\Common\Database;

/**
 * A factory for creating objects that can interface with the database.
 */
interface EntityFactoryInterface
{
    /**
     * {@inheritdoc}
     *
     * @return EntityInterface
     */
    public function create();
}
