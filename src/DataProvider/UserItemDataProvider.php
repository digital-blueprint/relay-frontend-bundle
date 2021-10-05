<?php

declare(strict_types=1);

namespace Dbp\Relay\FrontendBundle\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use Dbp\Relay\FrontendBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class UserItemDataProvider extends AbstractController implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    public function __construct()
    {
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return User::class === $resourceClass;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?User
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return null;
    }
}
