<?php

declare(strict_types=1);

namespace Dbp\Relay\FrontendBundle\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Dbp\Relay\FrontendBundle\Rest\UserProvider;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'FrontendUser',
    types: ['http://schema.org/Thing'],
    operations: [
        new Get(
            uriTemplate: '/frontend/users/{identifier}',
            openapiContext: [
                'tags' => ['Frontend'],
            ],
            provider: UserProvider::class
        ),
        new GetCollection(
            uriTemplate: '/frontend/users',
            openapiContext: [
                'tags' => ['Frontend'],
            ],
            provider: UserProvider::class
        ),
    ],
    normalizationContext: [
        'groups' => ['FrontendUser:output'],
        'jsonld_embed_context' => true,
    ],
)]
class User
{
    #[ApiProperty(identifier: true)]
    private string $identifier = '';

    /**
     * @var string[]
     */
    #[Groups(['FrontendUser:output'])]
    private array $roles;

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
