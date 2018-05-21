<?php

declare(strict_types=1);

namespace Umber\Common\Database;

interface DatabaseManagerInterface
{
    public function getRepository(string $entity): EntityRepositoryInterface;
}
