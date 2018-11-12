<?php

declare(strict_types=1);

namespace Umber\Common\Database\Pagination;

use Pagerfanta\Pagerfanta;

class Paginator extends Pagerfanta implements PaginatorInterface
{
    public function getResultPerPageCount(): int
    {
        return $this->getMaxPerPage();
    }

    public function getCurrentPageNumber(): int
    {
        return $this->getCurrentPage();
    }

    public function getResultTotalCount(): int
    {
        return $this->getNbResults();
    }

    public function getResultSetCount(): int
    {
        return count($this->asArray());
    }

    public function getPageTotalCount(): int
    {
        return $this->getNbPages();
    }

    /**
     * @return mixed[]
     */
    public function asArray(): array
    {
        return $this->getIterator()->getArrayCopy();
    }
}
