<?php

declare(strict_types=1);

namespace Dbp\Relay\FrontendBundle\Service;

use Dbp\Relay\FrontendBundle\Entity\User;
use Dbp\Relay\FrontendBundle\Event\UserRolesRequestedEvent;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @internal
 */
class FrontendUserProvider
{
    public function __construct(
        private readonly Security $security,
        private readonly EventDispatcherInterface $eventDispatcher)
    {
    }

    public function getCurrentUser(): User
    {
        $symfonyUser = $this->security->getUser();
        assert($symfonyUser !== null);

        $user = new User();
        $user->setIdentifier($symfonyUser->getUserIdentifier());

        $userRolesRequestedEvent = new UserRolesRequestedEvent($user->getIdentifier());
        $this->eventDispatcher->dispatch($userRolesRequestedEvent);

        $user->setRoles(array_merge($symfonyUser->getRoles(), $userRolesRequestedEvent->getUserRolesToAdd()));

        return $user;
    }
}
