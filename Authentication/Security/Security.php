<?php

declare(strict_types=1);

namespace Umber\Common\Authentication\Security;

use Umber\Common\Authentication\AuthenticationStorageInterface;
use Umber\Common\Authentication\Security\Entity\AuthorisationCheckerInterface;
use Umber\Common\Database\EntityInterface;
use Umber\Common\Exception\Authentication\PermissionDeniedException;

/**
 * {@inheritdoc}
 */
final class Security implements SecurityInterface
{
    private $authentication;
    private $checker;

    public function __construct(
        AuthenticationStorageInterface $authentication,
        AuthorisationCheckerInterface $checker
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

        throw PermissionDeniedException::create();
    }

    /**
     * {@inheritdoc}
     */
    public function isGranted(EntityInterface $entity, string ...$abilities): void
    {
        $state = $this->checker->check($entity, $abilities);

        if ($state === true) {
            return;
        }

        throw PermissionDeniedException::create();
    }
}
