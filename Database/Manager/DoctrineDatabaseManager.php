<?php

declare(strict_types=1);

namespace Umber\Common\Database\Manager;

use Umber\Common\Authentication\AuthenticationStorageInterface;
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
    private $entityManager;

    /** @var PaginatorFactoryInterface */
    private $paginatorFactory;

    /** @var AuthenticationStorageInterface */
    private $authenticationStorage;

    public function __construct(
        RegistryInterface $registry,
        PaginatorFactoryInterface $paginatorFactory,
        AuthenticationStorageInterface $authenticationStorage
    ) {
        $this->entityManager = $registry->getManager();
        $this->paginatorFactory = $paginatorFactory;
        $this->authenticationStorage = $authenticationStorage;
    }

    /**
     * Return the entity manager.
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function getRepository(string $entity): EntityRepositoryInterface
    {
        $repository = $this->entityManager->getRepository($entity);

        if (!$repository instanceof EntityRepositoryInterface) {
            throw new \Exception('entity repository interface missing');
        }

        if ($repository instanceof AbstractEntityRepository) {
            $repository->setPaginatorFactory($this->paginatorFactory);
            $repository->setAuthenticationStorage($this->authenticationStorage);
        }

        return $repository;
    }
}
