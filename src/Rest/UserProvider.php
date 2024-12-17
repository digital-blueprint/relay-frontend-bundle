<?php

declare(strict_types=1);

namespace Dbp\Relay\FrontendBundle\Rest;

use Dbp\Relay\CoreBundle\Rest\AbstractDataProvider;
use Dbp\Relay\FrontendBundle\Entity\User;
use Dbp\Relay\FrontendBundle\Service\FrontendUserProvider;

/**
 * @internal
 *
 * @extends  AbstractDataProvider<User>
 */
class UserProvider extends AbstractDataProvider
{
    public function __construct(private readonly FrontendUserProvider $userProvider)
    {
    }

    protected function getItemById(string $id, array $filters = [], array $options = []): ?object
    {
        $currentUser = $this->userProvider->getCurrentUser();

        return $currentUser->getIdentifier() === $id ? $currentUser : null;
    }

    protected function getPage(int $currentPageNumber, int $maxNumItemsPerPage, array $filters = [], array $options = []): array
    {
        return [$this->userProvider->getCurrentUser()];
    }
}
