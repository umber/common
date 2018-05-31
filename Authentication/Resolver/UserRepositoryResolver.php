<?php

declare(strict_types=1);

namespace Umber\Common\Authentication\Resolver;

use Umber\Common\Authentication\Method\AuthenticationHeaderInterface;
use Umber\Common\Authentication\Prototype\UserInterface;
use Umber\Common\Authentication\Prototype\UserRepositoryInterface;

/**
 * {@inheritdoc}
 */
final class UserRepositoryResolver implements UserResolverInterface
{
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(AuthenticationHeaderInterface $header): ?UserInterface
    {
        switch ($header->getType()) {
            case AuthenticationHeaderInterface::TYPE_EMAIL:
                return $this->repository->findOneByEmail($header->getValue());

            default:
                throw new \Exception('unsupported header type');
        }
    }
}
