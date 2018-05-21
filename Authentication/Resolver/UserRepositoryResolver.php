<?php

declare(strict_types=1);

namespace Umber\Common\Authentication\Resolver;

use Umber\Common\Authentication\Method\AuthenticationHeaderInterface;
use Umber\Common\Authentication\Prototype\UserInterface;
use Umber\Common\Authentication\Prototype\UserRepositoryInterface;

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
            case 'Email':
                return $this->repository->findOneByEmail($header->getValue());
        }
    }
}
