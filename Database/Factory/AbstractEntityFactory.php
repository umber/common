<?php

declare(strict_types=1);

namespace Umber\Common\Database\Factory;

use Umber\Common\Database\EntityFactoryInterface;
use Umber\Common\Database\EntityInterface;
use Umber\Common\Factory\Date\DateTimeFactoryInterface;
use Umber\Common\Prototype\Column\Date\CreatedAtAwareInterface;
use Umber\Common\Prototype\Column\Date\DeletedAtAwareInterface;
use Umber\Common\Prototype\Column\Date\UpdatedAtAwareInterface;
use Umber\Common\Prototype\Hint\DateAwareHintInterface;

/**
 * An abstraction for the entity factory interface.
 *
 * @see EntityFactoryInterface
 */
abstract class AbstractEntityFactory implements EntityFactoryInterface
{
    private $class;
    private $dateTimeFactory;

    public function __construct(string $class, DateTimeFactoryInterface $dateTimeFactory)
    {
        $this->class = $class;
        $this->dateTimeFactory = $dateTimeFactory;
    }

    /**
     * Return the entity class.
     */
    final public function getEntityClass(): string
    {
        return $this->class;
    }

    /**
     * Construct (and optionally prepare) an instance of the class.
     */
    final protected function construct(bool $prepare): EntityInterface
    {
        $class = $this->getEntityClass();

        /** @var EntityInterface $entity */
        $entity = new $class();

        if ($prepare) {
            $this->prepare($entity);
        }

        return $entity;
    }

    /**
     * Return the date time factory.
     */
    final protected function getDateTimeFactory(): DateTimeFactoryInterface
    {
        return $this->dateTimeFactory;
    }

    /**
     * Prepare a newly constructed entity.
     *
     * This method should be used to set defaults within an entity.
     */
    protected function prepare(EntityInterface $entity): void
    {
        $this->prepareDateAwareHint($entity);
    }

    /**
     * Prepare a newly constructed entity that has a date aware hinting.
     */
    protected function prepareDateAwareHint(EntityInterface $entity): void
    {
        if (!$entity instanceof DateAwareHintInterface) {
            return;
        }

        //  The current date, provided by factory for mocking.
        $now = $this->dateTimeFactory->create();

        if ($entity instanceof CreatedAtAwareInterface) {
            $entity->setCreatedAt($now);
        }

        if ($entity instanceof UpdatedAtAwareInterface) {
            $entity->setUpdatedAt($now);
        }

        if (!($entity instanceof DeletedAtAwareInterface)) {
            return;
        }

        $entity->setNotDeleted();
    }
}
