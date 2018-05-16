<?php

declare(strict_types=1);

namespace Umber\Common\Database\Pagination;

interface PaginatorInterface
{
    /**
     * @return mixed[]
     */
    public function asArray(): array;
}
