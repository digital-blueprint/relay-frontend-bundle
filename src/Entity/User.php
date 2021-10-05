<?php

declare(strict_types=1);

namespace Dbp\Relay\FrontendBundle\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     collectionOperations={
 *         "get" = {
 *             "path" = "/frontend/users",
 *             "openapi_context" = {
 *                 "tags" = {"Frontend"},
 *             },
 *         }
 *     },
 *     itemOperations={
 *         "get" = {
 *             "path" = "/frontend/users/{identifier}",
 *             "openapi_context" = {
 *                 "tags" = {"Frontend"},
 *             },
 *         }
 *     },
 *     iri="https://schema.org/Thing",
 *     shortName="FrontendUser",
 *     normalizationContext={
 *         "groups" = {"FrontendUser:output"},
 *         "jsonld_embed_context" = true
 *     },
 *     denormalizationContext={
 *         "groups" = {"FrontendUser:input"},
 *         "jsonld_embed_context" = true
 *     }
 * )
 */
class User
{
    /**
     * @ApiProperty(identifier=true)
     */
    private $identifier;

    /**
     * @Groups({"FrontendUser:output"})
     *
     * @var string[]
     */
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
