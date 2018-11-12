<?php

declare(strict_types=1);

namespace Umber\Common\Database\Manager;

use Umber\Common\Database\DatabaseManagerInterface;
use Umber\Common\Database\EntityRepositoryFactoryInterface;
use Umber\Common\Database\EntityRepositoryInterface;

use Symfony\Bridge\Doctrine\RegistryInterface;

use Doctrine\ORM\EntityManagerInterface;

/**
 * A doctrine database manager.
 */
final class DoctrineDatabaseManager implements DatabaseManagerInterface
{
    private $registry;
    private $entityRepositoryFactory;

    public function __construct(
        RegistryInterface $registry,
        EntityRepositoryFactoryInterface $entityRepositoryFactory
    ) {
        $this->registry = $registry;
        $this->entityRepositoryFactory = $entityRepositoryFactory;
    }

    /**
     * Return the entity manager.
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->registry->getEntityManager();
    }

    /**
     * {@inheritdoc}
     */
    public function getRepository(string $entity): EntityRepositoryInterface
    {
        $repository = $this->entityRepositoryFactory->create($entity);

        return $repository;
    }
}
