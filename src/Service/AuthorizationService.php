<?php

declare(strict_types=1);

namespace Dbp\Relay\FrontendBundle\Service;

use Dbp\Relay\CoreBundle\Authorization\AbstractAuthorizationService;

class AuthorizationService extends AbstractAuthorizationService
{
    public function setConfig(array $config): void
    {
        $this->setUpAccessControlPolicies($config['roles']);
    }
}
