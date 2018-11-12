<?php

declare(strict_types=1);

namespace Umber\Common\Database\Pagination;

use Doctrine\ORM\QueryBuilder;

use Exception;
use Pagerfanta\Adapter\AdapterInterface;

interface PaginatorFactoryInterface
{
    /**
     * Create a paginator for the given adapter.
     *
     * @throws Exception
     */
    public function create(AdapterInterface $adapter, ?int $page = null, ?int $limit = null): PaginatorInterface;

    /**
     * Create a paginator for the given query builder.
     */
    public function createForQueryBuilder(QueryBuilder $qb, ?int $page = null, ?int $limit = null): PaginatorInterface;

    /**
     * Recreate a paginator with a new query builder.
     */
    public function recreateForQueryBuilder(PaginatorInterface $paginator, QueryBuilder $qb): PaginatorInterface;
}
