<?php

declare(strict_types=1);

namespace Dbp\Relay\FrontendBundle\Service;

use Dbp\Relay\CoreBundle\API\UserSessionInterface;
use Dbp\Relay\FrontendBundle\Entity\User;

class FrontendUserProvider
{
    private $userSession;

    public function __construct(UserSessionInterface $userSession)
    {
        $this->userSession = $userSession;
    }

    public function getCurrentUser(): User
    {
        $user = new User();
        $user->setIdentifier($this->userSession->getUserIdentifier());
        $user->setRoles($this->userSession->getUserRoles());

        return $user;
    }
}
