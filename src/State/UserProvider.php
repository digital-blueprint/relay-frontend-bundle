<?php

declare(strict_types=1);

namespace Dbp\Relay\FrontendBundle\State;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Dbp\Relay\FrontendBundle\Entity\User;
use Dbp\Relay\FrontendBundle\Service\FrontendUserProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @implements ProviderInterface<User>
 */
class UserProvider extends AbstractController implements ProviderInterface
{
    /**
     * @var FrontendUserProvider
     */
    private $userProvider;

    public function __construct(FrontendUserProvider $userProvider)
    {
        $this->userProvider = $userProvider;
    }

    /**
     * @return User|iterable<User>
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = [])
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->userProvider->getCurrentUser();
        if ($operation instanceof CollectionOperationInterface) {
            return [$user];
        } else {
            if ($user->getIdentifier() !== $uriVariables['identifier']) {
                throw new NotFoundHttpException();
            }

            return $user;
        }
    }
}
