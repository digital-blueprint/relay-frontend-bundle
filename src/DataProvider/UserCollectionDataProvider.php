<?php

declare(strict_types=1);

namespace Dbp\Relay\FrontendBundle\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use Dbp\Relay\FrontendBundle\Entity\User;
use Dbp\Relay\FrontendBundle\Service\FrontendUserProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class UserCollectionDataProvider extends AbstractController implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $userProvider;

    public function __construct(FrontendUserProvider $userProvider)
    {
        $this->userProvider = $userProvider;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return User::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->userProvider->getCurrentUser();

        return [$user];
    }
}
