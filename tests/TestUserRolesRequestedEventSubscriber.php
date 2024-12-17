<?php

declare(strict_types=1);

namespace Dbp\Relay\FrontendBundle\Tests;

use Dbp\Relay\FrontendBundle\Event\UserRolesRequestedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TestUserRolesRequestedEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            UserRolesRequestedEvent::class => 'onUserRolesRequested',
        ];
    }

    public function onUserRolesRequested(UserRolesRequestedEvent $event): void
    {
        $userRolesToAdd = [];
        if ($event->getUserIdentifier() === 'admin') {
            $userRolesToAdd[] = 'ROLE_ADMIN';
        }
        if ($event->getUserIdentifier() === 'franz') {
            $userRolesToAdd[] = 'ROLE_FRANZ';
        }
        $event->addUserRoles($userRolesToAdd);
    }
}
