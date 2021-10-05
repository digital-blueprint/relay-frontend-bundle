<?php

declare(strict_types=1);

namespace Dbp\Relay\FrontendBundle\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use Dbp\Relay\FrontendBundle\Entity\User;
use Dbp\Relay\FrontendBundle\Service\FrontendUserProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class UserItemDataProvider extends AbstractController implements ItemDataProviderInterface, RestrictedDataProviderInterface
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

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?User
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->userProvider->getCurrentUser();
        if ($user->getIdentifier() !== $id) {
            throw new NotFoundHttpException();
        }

        return $user;
    }
}
