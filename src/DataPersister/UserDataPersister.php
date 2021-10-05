<?php

declare(strict_types=1);

namespace Dbp\Relay\FrontendBundle\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Dbp\Relay\FrontendBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserDataPersister extends AbstractController implements DataPersisterInterface
{
    public function __construct()
    {
    }

    public function supports($data): bool
    {
        return $data instanceof User;
    }

    public function persist($data)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
    }

    public function remove($data)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
    }
}
