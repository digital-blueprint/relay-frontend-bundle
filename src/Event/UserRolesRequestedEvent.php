<?php

declare(strict_types=1);

namespace Dbp\Relay\FrontendBundle\Event;

class UserRolesRequestedEvent
{
    private array $userRolesToAdd = [];

    public function __construct(private readonly string $userIdentifier)
    {
    }

    public function addUserRoles(array $userRolesToAdd): void
    {
        $this->userRolesToAdd = array_merge($this->userRolesToAdd, $userRolesToAdd);
    }

    public function getUserIdentifier(): string
    {
        return $this->userIdentifier;
    }

    public function getUserRolesToAdd(): array
    {
        return $this->userRolesToAdd;
    }
}
