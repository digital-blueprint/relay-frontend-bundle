<?php

declare(strict_types=1);

namespace Dbp\Relay\FrontendBundle\Entity;

use Symfony\Component\Serializer\Attribute\Groups;

class User
{
    private $identifier;

    /**
     * @var string[]
     */
    #[Groups(['FrontendUser:output'])]
    private $roles;

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles($roles): void
    {
        $this->roles = $roles;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }
}
