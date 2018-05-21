<?php

declare(strict_types=1);

namespace Umber\Common\Database\Pagination;

use Umber\Common\Database\Pagination\Adapter\QueryBuilderPaginatorAdapter;

use Symfony\Component\HttpFoundation\RequestStack;

use Doctrine\ORM\QueryBuilder;

use Pagerfanta\Adapter\AdapterInterface;

class PaginatorFactory implements PaginatorFactoryInterface
{
    private $requestStack;
    private $page;
    private $limit;

    public function __construct(RequestStack $requestStack, int $page, int $limit)
    {
        $this->requestStack = $requestStack;
        $this->page = $page;
        $this->limit = $limit;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function create(AdapterInterface $adapter, ?int $page = null, ?int $limit = null): PaginatorInterface
    {
        $request = $this->requestStack->getCurrentRequest();

        $pageRequested = $request->query->get('page', 0);
        if (!is_numeric($pageRequested)) {
            throw new \Exception('invalid pagination page');
        }

        $limitRequested = $request->query->get('limit', 0);
        if (!is_numeric($limitRequested)) {
            throw new \Exception('invalid pagination limit');
        }

        $paginator = new Paginator($adapter);
        $paginator->setCurrentPage($pageRequested ?: $page ?: $this->page);
        $paginator->setMaxPerPage($limitRequested ?: $limit ?: $this->limit);

        return $paginator;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function createForQueryBuilder(QueryBuilder $qb, ?int $page = null, ?int $limit = null): PaginatorInterface
    {
        $adapter = new QueryBuilderPaginatorAdapter($qb);

        return $this->create($adapter, $page, $limit);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function recreateForQueryBuilder(PaginatorInterface $paginator, QueryBuilder $qb): PaginatorInterface
    {
        $adapter = new QueryBuilderPaginatorAdapter($qb);

        return $this->create(
            $adapter,
            $paginator->getCurrentPageNumber(),
            $paginator->getResultPerPageCount()
        );
    }
}
