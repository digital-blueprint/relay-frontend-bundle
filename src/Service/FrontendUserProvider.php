<?php

declare(strict_types=1);

namespace Dbp\Relay\FrontendBundle\Service;

use Dbp\Relay\FrontendBundle\Entity\User;
use Symfony\Component\Security\Core\Security;

class FrontendUserProvider
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function getCurrentUser(): User
    {
        $symfonyUser = $this->security->getUser();
        assert($symfonyUser !== null);
        $user = new User();
        $user->setIdentifier($symfonyUser->getUserIdentifier());
        $user->setRoles($symfonyUser->getRoles());

        return $user;
    }
}
