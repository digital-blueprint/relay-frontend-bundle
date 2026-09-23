<?php

declare(strict_types=1);

namespace Dbp\Relay\FrontendBundle\Tests;

use Dbp\Relay\CoreBundle\TestUtils\CoreTestKernelTrait;
use Dbp\Relay\FrontendBundle\DbpRelayFrontendBundle;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use CoreTestKernelTrait;

    protected function registerAdditionalBundles(): iterable
    {
        yield new DbpRelayFrontendBundle();
    }

    protected function configureAdditionalContainer(ContainerConfigurator $container): void
    {
        $container->services()->set(TestUserRolesRequestedEventSubscriber::class)->public()->autoconfigure()->autowire();
    }
}
