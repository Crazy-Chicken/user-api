<?php

declare(strict_types=1);

namespace UserApi\CoreBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use UserApi\CoreBundle\DependencyInjection\CompilerPass\CoreCompilerPass;

class CoreBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new CoreCompilerPass());
    }
}
