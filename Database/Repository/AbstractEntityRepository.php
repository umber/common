<?php

declare(strict_types=1);

namespace Umber\Common\Database\Repository;

use Umber\Common\Authentication\AuthenticationStorageInterface;
use Umber\Common\Database\Pagination\PaginatorFactoryInterface;

use Doctrine\ORM\EntityRepository;

abstract class AbstractEntityRepository extends EntityRepository
{
    protected const SORT_ASC = 'ASC';
    protected const SORT_DESC = 'DESC';

    /** @var PaginatorFactoryInterface */
    private $paginatorFactory;

    /** @var AuthenticationStorageInterface */
    private $authenticationStorage;

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
    final public function setAuthenticationStorage(AuthenticationStorageInterface $authenticationStorage): void
    {
        $this->authenticationStorage = $authenticationStorage;
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
    protected function getAuthenticationStorage(): AuthenticationStorageInterface
    {
        if (!$this->authenticationStorage instanceof AuthenticationStorageInterface) {
            throw new \Exception('repository missing authentication');
        }

        return $this->authenticationStorage;
    }
}
