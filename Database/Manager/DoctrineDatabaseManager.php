<?php

declare(strict_types=1);

namespace Umber\Common\Database\Manager;

use Umber\Common\Authentication\AuthenticationInterface;
use Umber\Common\Database\DatabaseManagerInterface;
use Umber\Common\Database\EntityRepositoryInterface;
use Umber\Common\Database\Pagination\PaginatorFactoryInterface;
use Umber\Common\Database\Repository\AbstractEntityRepository;

use Symfony\Bridge\Doctrine\RegistryInterface;

use Doctrine\ORM\EntityManagerInterface;

/**
 * A doctrine database manager.
 */
final class DoctrineDatabaseManager implements DatabaseManagerInterface
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var PaginatorFactoryInterface */
    private $paginatorFactory;

    /** @var AuthenticationInterface */
    private $authentication;

    public function __construct(
        RegistryInterface $registry,
        PaginatorFactoryInterface $paginatorFactory,
        AuthenticationInterface $authentication
    ) {
        $this->em = $registry->getManager();
        $this->paginatorFactory = $paginatorFactory;
        $this->authentication = $authentication;
    }

    /**
     * Return the entity manager.
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->em;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function getRepository(string $entity): EntityRepositoryInterface
    {
        $repository = $this->em->getRepository($entity);

        if (!$repository instanceof EntityRepositoryInterface) {
            throw new \Exception('entity repository interface missing');
        }

        if ($repository instanceof AbstractEntityRepository) {
            $repository->setPaginatorFactory($this->paginatorFactory);
            $repository->setAuthentication($this->authentication);
        }

        return $repository;
    }
}
