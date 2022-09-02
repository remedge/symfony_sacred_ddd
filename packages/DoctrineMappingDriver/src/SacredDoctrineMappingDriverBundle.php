<?php

declare(strict_types=1);

namespace Sacred\Packages\DoctrineMappingDriver;

use Sacred\Packages\DoctrineMappingDriver\DependencyInjection\Compiler\MappingConfiguratorCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SacredDoctrineMappingDriverBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new MappingConfiguratorCompilerPass());
    }
}
