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
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly AuthorizationService $authorizationService)
    {
    }

    public function getCurrentUser(): User
    {
        $symfonyUser = $this->security->getUser();
        assert($symfonyUser !== null);

        $user = new User();
        $user->setIdentifier($symfonyUser->getUserIdentifier());

        // All roles defined in the bundle config for which their expression evaluates to true get added
        $configRoles = [];
        foreach ($this->authorizationService->getRoleNames() as $name) {
            if ($this->authorizationService->isGrantedRole($name)) {
                $configRoles[] = $name;
            }
        }

        $userRolesRequestedEvent = new UserRolesRequestedEvent($user->getIdentifier());
        $this->eventDispatcher->dispatch($userRolesRequestedEvent);

        // First Symfony roles, then config roles, finally event roles
        $user->setRoles(array_merge(array_merge($symfonyUser->getRoles(), $configRoles), $userRolesRequestedEvent->getUserRolesToAdd()));

        return $user;
    }
}
