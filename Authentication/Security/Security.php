<?php

declare(strict_types=1);

namespace Umber\Common\Authentication\Security;

use Umber\Common\Authentication\AuthenticationStorageInterface;
use Umber\Common\Database\EntityInterface;

use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

/**
 * {@inheritdoc}
 */
final class Security implements SecurityInterface
{
    private $authentication;
    private $checker;

    public function __construct(
        AuthenticationStorageInterface $authentication,
        AuthorizationChecker $checker
    ) {
        $this->authentication = $authentication;
        $this->checker = $checker;
    }

    /**
     * {@inheritdoc}
     */
    public function hasPermission(string $scope, string $ability): void
    {
        $authorisation = $this->authentication->getAuthorisation();
        $state = $authorisation->hasPermission($scope, $ability);

        if ($state === true) {
            return;
        }

        throw new \Exception('no permission');
    }

    /**
     * {@inheritdoc}
     */
    public function isGranted(EntityInterface $entity, string ...$abilities): void
    {
        $state = $this->checker->isGranted($abilities, $entity);

        if ($state === true) {
            return;
        }

        throw new \Exception('no permission');
    }
}
