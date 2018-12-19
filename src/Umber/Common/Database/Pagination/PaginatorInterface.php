<?php

declare(strict_types=1);

namespace Umber\Common\Database\Pagination;

interface PaginatorInterface
{
    public function getResultPerPageCount(): int;

    public function getResultSetCount(): int;

    public function getResultTotalCount(): int;

    public function getPageTotalCount(): int;

    public function getCurrentPageNumber(): int;

    /**
     * @return mixed[]
     */
    public function asArray(): array;
}
