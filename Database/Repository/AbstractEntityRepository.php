<?php

declare(strict_types=1);

namespace Umber\Common\Database\Repository;

use Umber\Common\Authentication\AuthenticationInterface;
use Umber\Common\Database\Pagination\PaginatorFactoryInterface;

use Doctrine\ORM\EntityRepository;

abstract class AbstractEntityRepository extends EntityRepository
{
    protected const SORT_ASC = 'ASC';
    protected const SORT_DESC = 'DESC';

    /** @var PaginatorFactoryInterface */
    private $paginatorFactory;

    /** @var AuthenticationInterface */
    private $authentication;

    /**
     * Set the paginator helper factory.
     */
    final public function setPaginatorFactory(PaginatorFactoryInterface $paginatorFactory): void
    {
        $this->paginatorFactory = $paginatorFactory;
    }

    /**
     * Set the authentication storage helper.
     */
    final public function setAuthentication(AuthenticationInterface $authentication): void
    {
        $this->authentication = $authentication;
    }

    /**
     * Return the paginator factory helper.
     *
     * @throws \Exception
     */
    protected function getPaginatorFactory(): PaginatorFactoryInterface
    {
        if (!$this->paginatorFactory instanceof PaginatorFactoryInterface) {
            throw new \Exception('repository missing paginator factory');
        }

        return $this->paginatorFactory;
    }

    /**
     * Return the authentication storage.
     *
     * @throws \Exception
     */
    protected function getAuthentication(): AuthenticationInterface
    {
        if (!$this->authentication instanceof AuthenticationInterface) {
            throw new \Exception('repository missing authentication');
        }

        return $this->authentication;
    }
}
